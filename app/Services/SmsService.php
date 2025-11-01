<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected $client;
    protected $fromNumber;

    public function __construct()
    {
        $accountSid = config('services.twilio.account_sid');
        $authToken = config('services.twilio.auth_token');
        $this->fromNumber = config('services.twilio.from_number');

        // Si Twilio n'est pas configuré, on utilisera le log en développement
        if ($accountSid && $authToken) {
            try {
                $this->client = new Client($accountSid, $authToken);
            } catch (\Exception $e) {
                Log::warning('Twilio client initialization failed: ' . $e->getMessage());
                $this->client = null;
            }
        } else {
            $this->client = null;
        }
    }

    /**
     * Envoyer un SMS
     *
     * @param string $to Numéro de téléphone (format: +221XXXXXXXXX)
     * @param string $message Message à envoyer
     * @return bool|string Retourne true si succès, ou le message d'erreur
     */
    public function send(string $to, string $message): bool|string
    {
        // Nettoyer et formater le numéro
        $to = $this->formatPhoneNumber($to);

        // En mode développement sans Twilio configuré, logger le message
        if (!$this->client) {
            Log::info("SMS (Dev Mode) - To: {$to}, Message: {$message}");
            return true; // Simuler le succès en développement
        }

        try {
            $message = $this->client->messages->create(
                $to,
                [
                    'from' => $this->fromNumber,
                    'body' => $message
                ]
            );

            Log::info("SMS sent successfully - SID: {$message->sid}, To: {$to}");
            return true;
        } catch (\Exception $e) {
            Log::error("SMS sending failed - To: {$to}, Error: " . $e->getMessage());
            return $e->getMessage();
        }
    }

    /**
     * Envoyer un code de vérification
     *
     * @param string $to Numéro de téléphone
     * @param string $code Code à envoyer
     * @return bool|string
     */
    public function sendVerificationCode(string $to, string $code): bool|string
    {
        $message = "Votre code de vérification AgriLink est : {$code}. Valable 10 minutes. Ne partagez pas ce code.";
        return $this->send($to, $message);
    }

    /**
     * Formater le numéro de téléphone
     *
     * @param string $phone
     * @return string
     */
    protected function formatPhoneNumber(string $phone): string
    {
        // Nettoyer le numéro
        $phone = preg_replace('/\s+/', '', $phone);
        
        // Si commence par 00221, remplacer par +221
        if (strpos($phone, '00221') === 0) {
            $phone = '+221' . substr($phone, 5);
        }
        // Si commence par 221 sans +, ajouter +
        elseif (strpos($phone, '221') === 0 && strpos($phone, '+') !== 0) {
            $phone = '+' . $phone;
        }
        // Si commence juste par le numéro local (77, 78, 76, 70), ajouter +221
        elseif (preg_match('/^(77|78|76|70)\d{7}$/', $phone)) {
            $phone = '+221' . $phone;
        }

        return $phone;
    }
}

