<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class OrangeMoneyService
{
    private $baseUrl;
    private $merchantId;
    private $apiKey;
    private $secretKey;

    public function __construct()
    {
        $this->baseUrl = config('services.orange_money.base_url');
        $this->merchantId = config('services.orange_money.merchant_id');
        $this->apiKey = config('services.orange_money.api_key');
        $this->secretKey = config('services.orange_money.secret_key');
    }

    /**
     * Initier un paiement Orange Money
     */
    public function initiatePayment($amount, $phoneNumber, $orderId, $description = null)
    {
        try {
            // Mode test si les identifiants sont des valeurs de test
            if ($this->isTestMode()) {
                return $this->simulateTestPayment($amount, $phoneNumber, $orderId, $description);
            }

            $token = $this->getAccessToken();
            
            $payload = [
                'merchant_key' => $this->merchantId,
                'currency' => 'XOF', // Franc CFA
                'order_id' => $orderId,
                'amount' => $amount,
                'return_url' => route('paiements.callback.orange'),
                'cancel_url' => route('paiements.cancel.orange'),
                'notif_url' => route('paiements.webhook.orange'),
                'lang' => 'fr',
                'reference' => "INSCRIPTION_" . $orderId,
                'description' => $description ?? "Paiement inscription - " . $orderId,
                'customer_msisdn' => $this->formatPhoneNumber($phoneNumber)
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->post($this->baseUrl . '/webpayment/v1/paymentrequest', $payload);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'payment_token' => $data['pay_token'] ?? null,
                    'payment_url' => $data['payment_url'] ?? null,
                    'transaction_id' => $data['txnid'] ?? null,
                    'message' => 'Paiement initié avec succès'
                ];
            }

            return [
                'success' => false,
                'message' => 'Erreur lors de l\'initiation du paiement',
                'error' => $response->json()
            ];

        } catch (Exception $e) {
            Log::error('Orange Money Payment Error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Erreur technique lors du paiement',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Vérifier le statut d'un paiement
     */
    public function checkPaymentStatus($transactionId)
    {
        try {
            $token = $this->getAccessToken();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json'
            ])->get($this->baseUrl . '/webpayment/v1/transactionstatus/' . $transactionId);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'status' => $data['status'] ?? 'unknown',
                    'amount' => $data['amount'] ?? 0,
                    'transaction_id' => $data['txnid'] ?? null,
                    'message' => $data['message'] ?? 'Statut récupéré'
                ];
            }

            return [
                'success' => false,
                'message' => 'Impossible de vérifier le statut'
            ];

        } catch (Exception $e) {
            Log::error('Orange Money Status Check Error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Erreur lors de la vérification',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Obtenir un token d'accès
     */
    private function getAccessToken()
    {
        $credentials = base64_encode($this->apiKey . ':' . $this->secretKey);

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials,
            'Content-Type' => 'application/x-www-form-urlencoded'
        ])->post($this->baseUrl . '/oauth/v2/token', [
            'grant_type' => 'client_credentials'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['access_token'];
        }

        throw new Exception('Impossible d\'obtenir le token d\'accès Orange Money');
    }

    /**
     * Formater le numéro de téléphone pour Orange Money
     */
    private function formatPhoneNumber($phoneNumber)
    {
        // Supprimer tous les caractères non numériques
        $phone = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Ajouter l'indicatif pays si nécessaire (exemple pour le Sénégal)
        if (strlen($phone) === 9 && substr($phone, 0, 1) === '7') {
            $phone = '221' . $phone; // +221 pour le Sénégal
        }
        
        return $phone;
    }

    /**
     * Vérifier si on est en mode test
     */
    private function isTestMode()
    {
        return $this->merchantId === 'TEST_MERCHANT_123' || 
               $this->apiKey === 'test_api_key_456' ||
               config('services.orange_money.environment') === 'sandbox';
    }

    /**
     * Simuler un paiement pour les tests
     */
    private function simulateTestPayment($amount, $phoneNumber, $orderId, $description)
    {
        Log::info('Orange Money Test Mode - Simulating payment', [
            'amount' => $amount,
            'phone' => $phoneNumber,
            'order_id' => $orderId
        ]);

        // Simuler une URL de paiement de test
        $testPaymentUrl = route('etudiant.paiements.index') . '?test_payment=success&order_id=' . $orderId;

        return [
            'success' => true,
            'payment_token' => 'TEST_TOKEN_' . time(),
            'payment_url' => $testPaymentUrl,
            'transaction_id' => 'TEST_TXN_' . $orderId,
            'message' => 'Paiement de test initié avec succès'
        ];
    }

    /**
     * Valider la signature du webhook
     */
    public function validateWebhookSignature($payload, $signature)
    {
        $expectedSignature = hash_hmac('sha256', $payload, $this->secretKey);
        return hash_equals($expectedSignature, $signature);
    }
}
