<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Card Payment Gateway (PayFast by APG / Avanza Premier Payment Services).
 *
 * Implements the Premier PayFast REST API v2.3 tokenized card flow:
 *   1. POST /token                -> bearer access token (MERCHANT_ID + SECURED_KEY)
 *   2. POST /transaction/token    -> tokenize the card, trigger issuer OTP / 3-D Secure
 *   3. POST /transaction/tokenized-> charge the tokenized instrument with the OTP
 *   4. GET  /transaction/{id}     -> confirm the final settlement status
 *
 * Financial endpoints are signed with an HMAC-SHA256 `secured_hash` built from the
 * fields documented for each endpoint and signed with the onboarding signing key.
 *
     * When merchant credentials are not configured in .env, the service falls back
     * to a clearly-labelled sandbox simulation so the checkout flow remains usable
     * until live keys are added.
 */
class CardPaymentService
{
    protected string $merchantId;

    protected string $securedKey;

    protected string $hashKey;

    protected bool $isSandbox;

    protected string $baseUrl;

    public function __construct()
    {
        $this->merchantId = (string) config('services.payfast.merchant_id', '');
        $this->securedKey = (string) config('services.payfast.secured_key', '');
        $this->hashKey = (string) config('services.payfast.hash_key', '');
        $this->isSandbox = (bool) config('services.payfast.sandbox', true);

        $this->baseUrl = rtrim((string) ($this->isSandbox
            ? config('services.payfast.sandbox_url', 'https://uat.premierpayfast.com')
            : config('services.payfast.live_url', 'https://api.premierpayfast.com')), '/');
    }

    /**
     * Whether real PayFast merchant credentials are present.
     */
    public function isConfigured(): bool
    {
        return $this->merchantId !== '' && $this->securedKey !== '';
    }

    /**
     * Normalize Pakistani mobile number to 11 digits (e.g. 03XXXXXXXXX).
     */
    public function formatMobileNumber(string $phone): string
    {
        $clean = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($clean, '92') && strlen($clean) === 12) {
            $clean = '0'.substr($clean, 2);
        } elseif (str_starts_with($clean, '0092') && strlen($clean) === 14) {
            $clean = '0'.substr($clean, 4);
        }

        return $clean;
    }

    public function isValidMobile(string $phone): bool
    {
        return (bool) preg_match('/^03[0-9]{9}$/', $this->formatMobileNumber($phone));
    }

    /**
     * Parse a card expiry value (MM/YY or MM/YYYY) into month + 4-digit year.
     *
     * @return array{month:string,year:string}|array{}
     */
    public function parseExpiry(string $value): array
    {
        $value = trim($value);
        if (! preg_match('#^(\d{1,2})\s*/\s*(\d{2}|\d{4})$#', $value, $m)) {
            return [];
        }

        $month = (int) $m[1];
        if ($month < 1 || $month > 12) {
            return [];
        }

        $year = $m[2];
        if (strlen($year) === 2) {
            $year = '20'.$year;
        }

        return [
            'month' => str_pad((string) $month, 2, '0', STR_PAD_LEFT),
            'year' => $year,
        ];
    }

    /**
     * Build the HMAC-SHA256 secured_hash for a financial endpoint.
     *
     * @param  array<int,string>  $fields  Field values in the order documented for the endpoint.
     */
    public function generateSecureHash(array $fields): string
    {
        $joined = '';
        foreach ($fields as $field) {
            $joined .= (string) $field;
        }

        return hash_hmac('sha256', $joined, $this->hashKey);
    }

    /**
     * Exchange merchant credentials for a one-time bearer access token.
     */
    public function getAccessToken(): ?string
    {
        try {
            $response = Http::timeout(15)->asForm()->post("{$this->baseUrl}/token", [
                'merchant_id' => $this->merchantId,
                'secured_key' => $this->securedKey,
                'grant_type' => 'client_credentials',
                'customer_ip' => request()->ip() ?: '127.0.0.1',
            ]);

            if ($response->successful() && ! empty($response->json('token'))) {
                return (string) $response->json('token');
            }

            Log::warning('PayFast access token rejected.', [
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('PayFast access token exception: '.$e->getMessage());
        }

        return null;
    }

    /**
     * Tokenize a card and trigger the issuer OTP / 3-D Secure challenge.
     *
     * @param  array<string,mixed>  $p
     * @return array<string,mixed>
     */
    public function createTransactionToken(string $accessToken, array $p): array
    {
        $cardNumber = preg_replace('/\D/', '', (string) ($p['card_number'] ?? ''));

        $payload = [
            'merchant_user_id' => (string) $p['merchant_user_id'],
            'user_mobile_number' => (string) $p['user_mobile_number'],
            'account_type' => 'CARD',
            'card_number' => $cardNumber,
            'expiry_month' => (string) $p['expiry_month'],
            'expiry_year' => (string) $p['expiry_year'],
            'cvv' => (string) $p['cvv'],
            'basket_id' => (string) $p['basket_id'],
            'order_date' => (string) $p['order_date'],
            'txnamt' => (string) $p['txnamt'],
        ];

        $payload['secured_hash'] = $this->generateSecureHash([
            $payload['merchant_user_id'],
            $payload['user_mobile_number'],
            $payload['card_number'],
            $payload['expiry_month'],
            $payload['expiry_year'],
            $payload['cvv'],
        ]);

        return $this->postForm("{$this->baseUrl}/transaction/token", $accessToken, $payload);
    }

    /**
     * Charge a previously tokenized instrument using the customer OTP.
     *
     * @param  array<string,mixed>  $p
     * @return array<string,mixed>
     */
    public function chargeTokenized(string $accessToken, array $p): array
    {
        $payload = [
            'instrument_token' => (string) $p['instrument_token'],
            'merchant_user_id' => (string) $p['merchant_user_id'],
            'user_mobile_number' => (string) $p['user_mobile_number'],
            'basket_id' => (string) $p['basket_id'],
            'order_date' => (string) $p['order_date'],
            'txndesc' => (string) ($p['txndesc'] ?? 'FixMate Subscription'),
            'txnamt' => (string) $p['txnamt'],
        ];

        $otp = trim((string) ($p['otp'] ?? ''));
        if ($otp !== '') {
            $payload['otp'] = $otp;
        }
        if (! empty($p['transaction_id'])) {
            $payload['transaction_id'] = (string) $p['transaction_id'];
        }

        $payload['secured_hash'] = $this->generateSecureHash([
            $payload['instrument_token'],
            $payload['merchant_user_id'],
            $payload['user_mobile_number'],
            $payload['txnamt'],
            $otp,
        ]);

        return $this->postForm("{$this->baseUrl}/transaction/tokenized", $accessToken, $payload);
    }

    /**
     * Fetch the final status of a transaction.
     *
     * @return array<string,mixed>
     */
    public function getTransactionStatus(string $accessToken, string $transactionId): array
    {
        try {
            $response = Http::timeout(15)
                ->withToken($accessToken)
                ->asForm()
                ->get("{$this->baseUrl}/transaction/".urlencode($transactionId));

            return $response->json() ?? [];
        } catch (\Throwable $e) {
            Log::warning('PayFast status check exception: '.$e->getMessage());

            return [];
        }
    }

    /**
     * High-level card charge used by the subscription checkout controllers.
     *
     * Returns a uniform result array. When the gateway requires an OTP and none was
     * supplied, `otp_required` is true and the caller should persist the returned
     * `instrument_token` / `transaction_id` and prompt the customer to enter the OTP.
     *
     * @param  array<string,mixed>  $data
     * @return array<string,mixed>
     */
    public function pay(array $data): array
    {
        $amount = round((float) ($data['amount'] ?? 0), 2);
        $basketId = (string) ($data['basket_id'] ?? ('FM-CARD-'.strtoupper(Str::random(8))));
        $orderDate = date('Y-m-d');
        $txnamt = number_format($amount, 2, '.', '');
        $merchantUserId = (string) ($data['merchant_user_id'] ?? '');
        $otp = trim((string) ($data['otp'] ?? ''));

        // Sandbox / unconfigured fallback: simulate an approved settlement.
        if (! $this->isConfigured()) {
            $ref = 'PF-CARD-'.strtoupper(Str::random(10));
            Log::info('PayFast card payment simulated (sandbox / unconfigured).', [
                'basket_id' => $basketId,
                'amount' => $amount,
                'reference' => $ref,
            ]);

            return [
                'success' => true,
                'otp_required' => false,
                'transaction_reference' => $ref,
                'code' => '00',
                'message' => 'Card payment approved (PayFast sandbox).',
                'gateway' => 'PayFast Card',
            ];
        }

        $mobile = $this->formatMobileNumber((string) ($data['mobile'] ?? ''));
        if (! $this->isValidMobile($mobile)) {
            return $this->fail('A valid mobile number (03XXXXXXXXX) is required for your card 3-D Secure verification.');
        }

        $expiry = $this->parseExpiry((string) ($data['card_expiry'] ?? ''));
        if ($expiry === []) {
            return $this->fail('Please enter a valid card expiry date in MM/YY format.');
        }

        if ($merchantUserId === '') {
            $merchantUserId = $mobile;
        }

        $accessToken = $this->getAccessToken();
        if ($accessToken === null) {
            return $this->fail('Unable to authenticate with the PayFast payment gateway. Please try again later.');
        }

        $instrumentToken = (string) ($data['instrument_token'] ?? '');
        $transactionId = (string) ($data['transaction_id'] ?? '');

        if ($instrumentToken === '') {
            $tokenResponse = $this->createTransactionToken($accessToken, [
                'merchant_user_id' => $merchantUserId,
                'user_mobile_number' => $mobile,
                'card_number' => (string) ($data['card_number'] ?? ''),
                'expiry_month' => $expiry['month'],
                'expiry_year' => $expiry['year'],
                'cvv' => (string) ($data['card_cvc'] ?? ''),
                'basket_id' => $basketId,
                'order_date' => $orderDate,
                'txnamt' => $txnamt,
            ]);

            $tokenCode = (string) ($tokenResponse['status_code'] ?? ($tokenResponse['code'] ?? ''));
            $instrumentToken = (string) ($tokenResponse['instrument_token'] ?? '');
            $transactionId = (string) ($tokenResponse['transaction_id'] ?? '');

            if ($instrumentToken === '' && ! in_array($tokenCode, ['00', '79', '804', '803', '850'], true)) {
                return $this->fail($tokenResponse['status_msg'] ?? 'The card could not be processed. Please check your card details and try again.', $tokenCode);
            }

            $otpRequired = (bool) ($tokenResponse['otp_required'] ?? true);
            if ($otpRequired && $otp === '') {
                return [
                    'success' => false,
                    'otp_required' => true,
                    'instrument_token' => $instrumentToken,
                    'transaction_id' => $transactionId,
                    'code' => '804',
                    'message' => 'A verification OTP has been sent to your registered mobile number. Enter it below to authorise the payment.',
                    'gateway' => 'PayFast Card',
                ];
            }
        }

        $chargeResponse = $this->chargeTokenized($accessToken, [
            'instrument_token' => $instrumentToken,
            'merchant_user_id' => $merchantUserId,
            'user_mobile_number' => $mobile,
            'basket_id' => $basketId,
            'order_date' => $orderDate,
            'txndesc' => (string) ($data['description'] ?? 'FixMate Subscription'),
            'txnamt' => $txnamt,
            'otp' => $otp,
            'transaction_id' => $transactionId,
        ]);

        $chargeCode = (string) ($chargeResponse['status_code'] ?? ($chargeResponse['code'] ?? ''));
        if (! in_array($chargeCode, ['00', '79'], true)) {
            return $this->fail($chargeResponse['status_msg'] ?? ($chargeResponse['message'] ?? 'Card payment was declined by the issuer.'), $chargeCode);
        }

        $finalTxnId = (string) ($chargeResponse['transaction_id'] ?? $transactionId);
        if ($finalTxnId !== '') {
            $status = $this->getTransactionStatus($accessToken, $finalTxnId);
            $statusCode = (string) ($status['status_code'] ?? ($status['code'] ?? '00'));
            if (! in_array($statusCode, ['00', '79'], true)) {
                return $this->fail($status['status_msg'] ?? 'Card payment could not be confirmed. Please try again.', $statusCode);
            }
        }

        Log::info('PayFast card payment approved.', [
            'basket_id' => $basketId,
            'transaction_id' => $finalTxnId,
            'amount' => $amount,
        ]);

        return [
            'success' => true,
            'otp_required' => false,
            'transaction_reference' => $finalTxnId !== '' ? $finalTxnId : ('PF-'.strtoupper(Str::random(8))),
            'instrument_token' => $instrumentToken,
            'code' => '00',
            'message' => 'Card payment approved successfully.',
            'gateway' => 'PayFast Card',
        ];
    }

    /**
     * @param  array<string,mixed>  $payload
     * @return array<string,mixed>
     */
    protected function postForm(string $url, string $accessToken, array $payload): array
    {
        try {
            $response = Http::timeout(20)
                ->withToken($accessToken)
                ->asForm()
                ->post($url, $payload);

            return $response->json() ?? [];
        } catch (\Throwable $e) {
            Log::warning("PayFast request to {$url} failed: ".$e->getMessage());

            return [];
        }
    }

    /**
     * @return array<string,mixed>
     */
    protected function fail(string $message, string $code = ''): array
    {
        return [
            'success' => false,
            'otp_required' => false,
            'code' => $code,
            'message' => $message,
            'gateway' => 'PayFast Card',
        ];
    }
}
