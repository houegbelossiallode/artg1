# Guide de déploiement d'une instance Jitsi Meet privée

## Prérequis

- **Serveur** : Ubuntu 20.04/22.04 LTS
- **Ressources minimum** : 4 CPU, 8GB RAM, 50GB SSD
- **Nom de domaine** : Un domaine configuré avec DNS (ex: meet.echoculture.bj)
- **Accès root** ou sudo sur le serveur

## Étape 1 : Préparation du serveur

### 1.1 Mise à jour du système
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y curl wget gnupg2
```

### 1.2 Configuration du nom de domaine
Assurez-vous que votre domaine pointe vers l'IP de votre serveur :
```bash
# Test DNS
ping votre-domaine.com
```

## Étape 2 : Installation de Jitsi Meet

### 2.1 Ajout du dépôt Jitsi
```bash
curl https://download.jitsi.org/jitsi-key.gpg.key | sudo sh -c 'gpg --dearmor > /usr/share/keyrings/jitsi-keyring.gpg'
echo 'deb [signed-by=/usr/share/keyrings/jitsi-keyring.gpg] https://download.jitsi.org stable/' | sudo tee /etc/apt/sources.list.d/jitsi-stable.list > /dev/null
sudo apt update
```

### 2.2 Installation des paquets
```bash
sudo apt install -y jitsi-meet
```

**Pendant l'installation :**
- Entrez votre nom de domaine : `votre-domaine.com`
- Choisissez "Generate a new self-signed certificate" (pour le test)
- Pour la production, utilisez Let's Encrypt

### 2.3 Installation du certificat SSL (Let's Encrypt)
```bash
sudo apt install -y certbot
sudo ./usr/share/jitsi-meet/scripts/install-letsencrypt-cert.sh
```

## Étape 3 : Configuration de l'authentification JWT

### 3.1 Installation de la bibliothèque Lua JWT
```bash
sudo apt install -y lua5.2 liblua5.2-dev luarocks
sudo luarocks install luajwtjitsi
```

### 3.2 Configuration de Prosody
```bash
sudo nano /etc/prosody/conf.avail/votre-domaine.com.cfg.lua
```

Remplacez la configuration par :
```lua
VirtualHost "votre-domaine.com"
    authentication = "token"
    app_id = "echoculture"
    app_secret = "GENERER_UN_SECRET_LONG_ET_ALEATOIRE_ICI"
    allow_empty_token = false
    c2s_require_encryption = true

    -- Configuration pour les invités (optionnel)
    authentication = "internal_hashed"
    
    -- Modules supplémentaires
    modules_enabled = {
        "bosh";
        "pubsub";
        "ping";
        "admin_adhoc";
        " roster";
        "register";
        "vcard";
        "private";
        "admin_telnet";
        "tls";
        "dialback";
        "saslauth";
        "turncredentials";
        "smacks";
        "carbons";
        "mam";
        "pep";
        "vcard_muc";
    }
```

### 3.3 Configuration de Jicofo
```bash
sudo nano /etc/jitsi/jicofo/jicofo.conf
```
Ajoutez dans la section `authentication` :
```yaml
authentication: {
  enabled: true
  type: JWT
  login-url: "votre-domaine.com"
}
```

### 3.4 Configuration de Jitsi Meet
```bash
sudo nano /etc/jitsi/meet/votre-domaine.com-config.js
```
Ajoutez :
```javascript
var config = {
    hosts: {
        domain: 'votre-domaine.com',
        muc: 'conference.votre-domaine.com',
    },
    // Configuration JWT
    enableUserRolesBasedOnToken: true,
    tokenAuthUrl: 'https://votre-domaine.com',
};
```

## Étape 4 : Génération du secret JWT

### 4.1 Génération d'un secret sécurisé
```bash
# Générer un secret de 64 caractères
openssl rand -base64 48
```

Copiez ce secret et utilisez-le comme `app_secret` dans la configuration Prosody.

## Étape 5 : Redémarrage des services

```bash
sudo systemctl restart prosody
sudo systemctl restart jicofo
sudo systemctl restart jitsi-videobridge2
sudo systemctl restart nginx
```

### Vérification des services
```bash
sudo systemctl status prosody
sudo systemctl status jicofo
sudo systemctl status jitsi-videobridge2
sudo systemctl status nginx
```

## Étape 6 : Configuration du pare-feu

```bash
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw allow 4443/tcp
sudo ufw allow 10000/udp
sudo ufw allow 10001/udp
sudo ufw allow 10002/udp
sudo ufw allow 5349/tcp
sudo ufw allow 5349/udp
sudo ufw enable
```

## Étape 7 : Test de l'installation

### 7.1 Test de base
Ouvrez votre navigateur et accédez à : `https://votre-domaine.com`

### 7.2 Test avec token JWT
Créez un fichier de test PHP sur votre serveur Laravel :
```php
<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;

$payload = [
    'iss' => 'echoculture',
    'aud' => 'echoculture',
    'exp' => time() + 3600,
    'sub' => 'votre-domaine.com',
    'room' => 'test-room',
    'context' => [
        'user' => [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'id' => '123',
        ],
    ],
    'moderator' => true,
];

$token = JWT::encode($payload, 'VOTRE_SECRET', 'HS256');
echo "Token: " . $token . "\n";
echo "URL: https://votre-domaine.com/test-room?jwt=" . $token;
```

## Étape 8 : Configuration Laravel

### 8.1 Ajout des variables dans `.env`
```env
JITSI_URL=https://votre-domaine.com
JITSI_APP_ID=echoculture
JITSI_APP_SECRET=VOTRE_SECRET_GENERE
JITSI_PREJOIN_MINUTES=5
JITSI_POSTJOIN_MINUTES=15
```

### 8.2 Test de réservation
1. Créez un cours en mode distanciel
2. Réservez ce cours
3. Accédez à la page de réunion via `/meeting/{reservation_id}`

## Étape 9 : Optimisation pour la production

### 9.1 Configuration de la bande passante
```bash
sudo nano /etc/jitsi/videobridge/config
```
Ajoutez :
```properties
org.jitsi.videobridge.ENABLE_STATISTICS=true
org.jitsi.videobridge.STATISTICS_INTERVAL=5000
```

### 9.2 Configuration de la qualité vidéo
```bash
sudo nano /etc/jitsi/meet/votre-domaine.com-config.js
```
```javascript
constraints: {
    video: {
        height: { ideal: 720, max: 720 },
        aspectRatio: 16 / 9,
    }
}
```

### 9.3 Configuration du nombre de participants
```bash
sudo nano /etc/jitsi/jicofo/jicofo.conf
```
```yaml
jvb: {
    brewery-jid: 'JvbBrewery@internal.auth.votre-domaine.com'
}
```

## Étape 10 : Maintenance et surveillance

### 10.1 Scripts de monitoring
```bash
# Créer un script de monitoring
sudo nano /usr/local/bin/jitsi-monitor.sh
```
```bash
#!/bin/bash
# Vérifier si les services Jitsi sont actifs
services=("prosody" "jicofo" "jitsi-videobridge2" "nginx")
for service in "${services[@]}"; do
    if ! systemctl is-active --quiet "$service"; then
        echo "$service n'est pas actif" | mail -s "Alerte Jitsi: $service down" admin@echoculture.bj
        systemctl restart "$service"
    fi
done
```

```bash
chmod +x /usr/local/bin/jitsi-monitor.sh
# Ajouter au crontab pour exécution toutes les 5 minutes
(crontab -l 2>/dev/null; echo "*/5 * * * * /usr/local/bin/jitsi-monitor.sh") | crontab -
```

### 10.2 Logs
```bash
# Logs principaux
sudo journalctl -u prosody -f
sudo journalctl -u jicofo -f
sudo journalctl -u jitsi-videobridge2 -f
sudo tail -f /var/log/nginx/error.log
```

## Dépannage

### Problème : Connexion refusée
```bash
# Vérifier le pare-feu
sudo ufw status
# Vérifier les ports ouverts
sudo netstat -tulpn | grep -E ':(80|443|4443|10000|5349)'
```

### Problème : Token JWT invalide
```bash
# Vérifier la configuration Prosody
sudo cat /etc/prosody/conf.avail/votre-domaine.com.cfg.lua
# Vérifier les logs Prosody
sudo journalctl -u prosody -n 50
```

### Problème : Audio/Video ne fonctionne pas
```bash
# Vérifier Jitsi Videobridge
sudo journalctl -u jitsi-videobridge2 -n 50
# Vérifier NAT/Traversal
sudo ufw allow 10000:20000/udp
```

## Sécurité supplémentaire

### 1. Limitation du taux de connexions
```bash
sudo nano /etc/nginx/nginx.conf
```
Ajoutez dans `http` :
```nginx
limit_req_zone $binary_remote_addr zone=jitsi:10m rate=10r/s;
limit_req zone=jitsi burst=20 nodelay;
```

### 2. Protection contre DDoS
```bash
sudo apt install -y fail2ban
sudo nano /etc/fail2ban/jail.local
```
```ini
[jitsi-auth]
enabled = true
port = 443
filter = jitsi-auth
logpath = /var/log/nginx/error.log
maxretry = 5
bantime = 3600
```

## Ressources utiles

- Documentation officielle : https://jitsi.github.io/handbook/
- Community : https://community.jitsi.org/
- GitHub : https://github.com/jitsi/jitsi-meet
