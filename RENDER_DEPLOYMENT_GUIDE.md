# Guide de déploiement sur Render pour AssoCulture Laravel

## Prérequis

- Compte Render (https://render.com)
- Compte GitHub avec le code de l'application
- Application Laravel prête pour la production

## Étape 1 : Préparation du code

### 1.1 Vérifier la structure du projet
Assurez-vous que votre projet contient :
- `render.yaml` à la racine
- `composer.json` avec les dépendances
- `package.json` pour les assets frontend
- `.gitignore` configuré correctement

### 1.2 Mettre à jour .gitignore
```gitignore
/node_modules
/vendor
/.idea
/.vscode
/.env
/.env.backup
/storage/*.key
/storage/logs/*
/storage/framework/cache/*
/storage/framework/sessions/*
/storage/framework/views/*
/bootstrap/cache/*
Homestead.json
Homestead.yaml
npm-debug.log
yarn-error.log
```

### 1.3 Créer .env.example
```env
APP_NAME=AssoCulture
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://asso-culture-laravel.onrender.com

LOG_CHANNEL=errorlog
LOG_LEVEL=error

DB_CONNECTION=pgsql
DB_HOST=
DB_PORT=5432
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Configuration Jitsi
JITSI_URL=https://meet.jit.si
JITSI_APP_ID=
JITSI_APP_SECRET=
JITSI_PREJOIN_MINUTES=5
JITSI_POSTJOIN_MINUTES=15
```

## Étape 2 : Configuration Render

### 2.1 Créer un compte Render
1. Allez sur https://render.com
2. Créez un compte avec GitHub
3. Connectez votre compte GitHub

### 2.2 Importer le projet
1. Cliquez sur "New +"
2. Sélectionnez "Web Service"
3. Connectez votre dépôt GitHub
4. Sélectionnez le dépôt `asso_culture_laravel`
5. Render détectera automatiquement le fichier `render.yaml`

### 2.3 Configuration automatique via render.yaml
Le fichier `render.yaml` que j'ai créé configure automatiquement :

**Service Web Laravel :**
- Environnement PHP
- Commandes de build optimisées
- Variables d'environnement
- Stockage pour les fichiers

**Base de données PostgreSQL :**
- Base de données persistante
- Connexion automatique au service web

**Worker Queue :**
- Traitement des tâches en arrière-plan
- Configuration de la connexion DB

**Cron Job :**
- Exécution des tâches planifiées Laravel
- Toutes les 5 minutes

## Étape 3 : Configuration manuelle (si nécessaire)

### 3.1 Si Render ne détecte pas render.yaml
1. Créez manuellement un "Web Service"
2. Configurez les paramètres suivants :

**Build & Deploy :**
- Environment: PHP
- Build Command: `composer install --no-dev --optimize-autoloader && php artisan key:generate --force && php artisan storage:link && php artisan config:cache && php artisan route:cache && php artisan view:cache && npm install && npm run build`
- Start Command: `php artisan serve --host=0.0.0.0 --port=$PORT`

**Environment Variables :**
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-app.onrender.com
DB_CONNECTION=pgsql
DB_HOST=votre-db-host
DB_PORT=5432
DB_DATABASE=votre-db-name
DB_USERNAME=votre-db-user
DB_PASSWORD=votre-db-password
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=database
FILESYSTEM_DISK=public
JITSI_URL=https://meet.jit.si
JITSI_APP_ID=
JITSI_APP_SECRET=
JITSI_PREJOIN_MINUTES=5
JITSI_POSTJOIN_MINUTES=15
```

### 3.2 Créer la base de données
1. Cliquez sur "New +"
2. Sélectionnez "PostgreSQL"
3. Configurez :
   - Database Name: `asso_culture`
   - User: `asso_culture_user`
   - Plan: Free ou Starter

### 3.3 Créer le Worker Queue
1. Cliquez sur "New +"
2. Sélectionnez "Worker"
3. Configurez :
   - Environment: PHP
   - Build Command: `composer install --no-dev --optimize-autoloader && php artisan config:cache && php artisan route:cache`
   - Start Command: `php artisan queue:work --sleep=3 --tries=3 --max-time=3600`

### 3.4 Créer le Cron Job
1. Cliquez sur "New +"
2. Sélectionnez "Cron Job"
3. Configurez :
   - Schedule: `*/5 * * * *`
   - Command: `php artisan schedule:run`

## Étape 4 : Exécution des migrations

### 4.1 Accès SSH au service
1. Allez sur votre service web Render
2. Cliquez sur "SSH"
3. Exécutez les migrations :
```bash
php artisan migrate --force
php artisan db:seed --force
```

### 4.2 Alternative : Script de déploiement
Créez un script `deploy.sh` :
```bash
#!/bin/bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Ajoutez-le dans le build command de render.yaml :
```yaml
buildCommand: |
  composer install --no-dev --optimize-autoloader
  php artisan key:generate --force
  php artisan storage:link
  php artisan migrate --force
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  npm install
  npm run build
```

## Étape 5 : Configuration du stockage

### 5.1 Disk persistant
Render fournit un disque persistant pour le stockage. Dans `config/filesystems.php` :
```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => env('STORAGE_PATH', storage_path('app/public')),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
],
```

### 5.2 Lien symbolique
Le build command inclut déjà `php artisan storage:link` pour créer le lien symbolique.

## Étape 6 : Configuration Jitsi

### 6.1 Pour le développement (instance publique)
```env
JITSI_URL=https://meet.jit.si
JITSI_APP_ID=
JITSI_APP_SECRET=
```

### 6.2 Pour la production (instance privée)
Après avoir déployé votre instance Jitsi privée (voir guide JITSI_DEPLOYMENT_GUIDE.md) :
```env
JITSI_URL=https://votre-instance-jitsi.com
JITSI_APP_ID=echoculture
JITSI_APP_SECRET=votre-secret-généré
JITSI_PREJOIN_MINUTES=5
JITSI_POSTJOIN_MINUTES=15
```

## Étape 7 : Monitoring et Logs

### 7.1 Logs Render
- Allez sur votre service web
- Cliquez sur "Logs"
- Vérifiez les erreurs et warnings

### 7.2 Logs Laravel
```bash
# Via SSH
tail -f storage/logs/laravel.log
```

### 7.3 Monitoring de la base de données
- Allez sur votre service PostgreSQL
- Vérifiez les métriques et les connexions

## Étape 8 : Configuration du domaine personnalisé

### 8.1 Ajouter un domaine
1. Allez sur votre service web
2. Cliquez sur "Domains"
3. Ajoutez votre domaine (ex: echoculture.bj)

### 8.2 Configuration DNS
Ajoutez un enregistrement CNAME :
```
Type: CNAME
Name: www
Value: votre-app.onrender.com
```

### 8.3 SSL
Render génère automatiquement un certificat SSL avec Let's Encrypt.

## Étape 9 : Tests de déploiement

### 9.1 Test de base
1. Accédez à votre URL Render
2. Vérifiez que la page d'accueil s'affiche
3. Testez l'authentification

### 9.2 Test des réservations
1. Créez un compte apprenant
2. Réservez un cours en distanciel
3. Vérifiez que le `jitsi_room_id` est généré
4. Testez l'accès à la réunion

### 9.3 Test des uploads
1. Testez l'upload de photos (talents)
2. Vérifiez que les fichiers sont stockés correctement

## Étape 10 : Optimisation pour la production

### 10.1 Cache
```bash
# Via SSH
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 10.2 Queue
Vérifiez que le worker fonctionne :
```bash
# Via SSH
php artisan queue:work --status
```

### 10.3 Performance
- Utilisez Redis pour le cache (plan Starter)
- Configurez CDN pour les assets statiques
- Optimisez les images

## Dépannage

### Problème : Erreur de connexion DB
```bash
# Vérifiez les variables d'environnement
# Assurez-vous que la DB est créée
# Vérifiez les credentials
```

### Problème : Migrations ne s'exécutent pas
```bash
# Exécutez manuellement via SSH
php artisan migrate --force
```

### Problème : Assets ne se chargent pas
```bash
# Rebuild le projet
php artisan storage:link
npm run build
```

### Problème : Queue ne fonctionne pas
```bash
# Vérifiez le worker
# Vérifiez les logs du worker
# Redémarrez le worker
```

## Coûts Render

**Plan Free :**
- Web Service: Gratuit (avec limitations)
- PostgreSQL: Gratuit (90 jours)
- Worker: Gratuit
- Cron Job: Gratuit

**Plan Starter (Production) :**
- Web Service: ~$7/mois
- PostgreSQL: ~$7/mois
- Worker: ~$7/mois
- Total: ~$21/mois

## Alternatives

Si Render ne convient pas, vous pouvez utiliser :
- **Heroku**: Similar à Render mais plus cher
- **DigitalOcean App Platform**: Alternative économique
- **VPS personnel**: Plus flexible mais plus de configuration
- **AWS**: Pour les grandes échelles

## Sécurité

### 1. Variables d'environnement
- Ne jamais commit les secrets
- Utilisez les secrets Render
- Rotation régulière des clés

### 2. HTTPS
- Render fournit HTTPS automatique
- Forcez HTTPS dans Laravel :
```php
// AppServiceProvider.php
public function boot()
{
    if (app()->environment('production')) {
        URL::forceScheme('https');
    }
}
```

### 3. Firewall
- Configurez les règles d'accès
- Limitez l'accès à l'API
- Utilisez des rate limits

## Maintenance

### Mises à jour
```bash
# Via SSH
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Backups
- Render backup automatique PostgreSQL
- Export régulier des données
- Backup des fichiers storage

## Ressources

- Documentation Render: https://render.com/docs
- Documentation Laravel: https://laravel.com/docs
- Community Render: https://community.render.com
