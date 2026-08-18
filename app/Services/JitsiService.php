<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class JitsiService
{
    protected $jitsiUrl;
    protected $appId;
    protected $appSecret;

    public function __construct()
    {
        $this->jitsiUrl = config('jitsi.url');
        $this->appId = config('jitsi.app_id');
        $this->appSecret = config('jitsi.app_secret');
    }

    /**
     * Génère un token JWT sécurisé pour Jitsi Meet
     */
    public function generateToken($roomName, $user, $isModerator = false)
    {
        $apiKeyId = env('JITSI_API_KEY_ID');
        $privateKeyPath = storage_path('app/jitsi_private.key');

        // Pour JaaS (8x8.vc), on DOIT utiliser la clé privée RSA avec kid
        if ($apiKeyId && str_contains($this->jitsiUrl, '8x8.vc')) {
            // Essayer d'abord depuis la variable d'environnement (pour Railway/production)
            $privateKey = env('JITSI_PRIVATE_KEY');

            // Si pas en env, essayer depuis le fichier local (pour dev local)
            if (empty($privateKey) && file_exists($privateKeyPath)) {
                $privateKey = file_get_contents($privateKeyPath);
            }

            if (empty($privateKey)) {
                throw new \Exception("Clé privée RSA manquante pour JaaS. Configurez la variable d'environnement JITSI_PRIVATE_KEY ou placez votre clé dans storage/app/jitsi_private.key");
            }

            $payload = [
                'iss' => 'chat',
                'aud' => 'jitsi',
                'exp' => now()->addHours(2)->timestamp,
                'sub' => $this->appId,
                'room' => '*',
                'context' => [
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'id' => $user->id,
                        'avatar' => $user->avatar ?? null,
                    ],
                    'features' => [
                        'livestreaming' => $isModerator,
                        'recording' => $isModerator,
                    ],
                ],
                'moderator' => $isModerator,
            ];

            // Le 4ème paramètre est le kid (Key ID) - OBLIGATOIRE pour JaaS
            return JWT::encode($payload, $privateKey, 'RS256', $apiKeyId);
        }

        // Fallback pour serveur auto-hébergé simple avec secret (HS256)
        if (empty($this->appSecret)) {
            throw new \Exception("Configuration Jitsi incomplète : ni Clé Privée RSA (JaaS) ni App Secret trouvés.");
        }

        $payload = [
            'iss' => $this->appId,
            'aud' => $this->appId,
            'exp' => now()->addHours(2)->timestamp,
            'sub' => $this->jitsiUrl,
            'room' => $roomName,
            'context' => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'id' => $user->id,
                    'avatar' => $user->avatar ?? null,
                ],
                'group' => $isModerator ? 'moderator' : 'participant',
            ],
            'moderator' => $isModerator,
        ];

        return JWT::encode($payload, $this->appSecret, 'HS256');
    }

    /**
     * Génère un nom de salle sécurisé et unique
     */
    public function generateSecureRoomName($courseId, $date, $userId, $time = '')
    {
        // Utiliser la clé unique de l'application Laravel pour sécuriser le hash
        $secret = $this->appSecret ?: config('app.key');
        return 'EchoCulture_' . $courseId . '_' . $date . '_' . hash('sha256', $userId . $courseId . $date . $time . $secret);
    }

    /**
     * Génère l'URL de réunion sécurisée
     * Utilise JWT si un secret est configuré, sinon utilise l'URL simple
     */
    public function generateMeetingUrl($roomName, $user, $isModerator = false)
    {
        $apiKeyId = env('JITSI_API_KEY_ID');

        // Si pas de secret configuré ni de clé JaaS (instance publique), utiliser l'URL simple
        if (empty($this->appSecret) && empty($apiKeyId)) {
            return rtrim($this->jitsiUrl, '/') . '/' . $roomName;
        }

        // Générer le token approprié
        $token = $this->generateToken($roomName, $user, $isModerator);

        // Pour JaaS (8x8.vc), l'URL doit inclure le tenant (AppID)
        if ($apiKeyId && str_contains($this->jitsiUrl, '8x8.vc')) {
            return rtrim($this->jitsiUrl, '/') . '/' . $this->appId . '/' . $roomName . '?jwt=' . $token;
        }

        // Sinon, utiliser JWT pour l'instance privée normale
        return rtrim($this->jitsiUrl, '/') . '/' . $roomName . '?jwt=' . $token;
    }

    /**
     * Vérifie si l'utilisateur a le droit d'accéder à la salle
     */
    public function canAccessRoom($user, $reservation)
    {
        return $reservation->user_id === $user->id ||
               $reservation->course->user_id === $user->id;
    }

    /**
     * Vérifie si le cours peut commencer
     */
    public function canStartMeeting($reservation)
    {
        $now = now();
        $meetingStart = $reservation->date_reservation . ' ' . $reservation->heure_debut;

        return $now->gte(\Carbon\Carbon::parse($meetingStart)->subMinutes(5));
    }

    /**
     * Vérifie si le cours est terminé
     */
    public function isMeetingEnded($reservation)
    {
        $now = now();
        $meetingEnd = $reservation->date_reservation . ' ' . $reservation->heure_fin;

        return $now->gt(\Carbon\Carbon::parse($meetingEnd)->addMinutes(15));
    }
}
