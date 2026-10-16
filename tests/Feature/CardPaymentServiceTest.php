<?php

namespace Tests\Feature;

use App\Services\CardPaymentService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CardPaymentServiceTest extends TestCase
{
    private function configureGateway(): void
    {
        config([
            'services.payfast.merchant_id' => 'MERCHANT-1',
            'services.payfast.secured_key' => 'SECURED-1',
            'services.payfast.hash_key' => 'HASH-1',
            'services.payfast.sandbox' => true,
            'services.payfast.sandbox_url' => 'https://uat.payfast.test',
        ]);
    }

    public function test_unconfigured_gateway_simulates_successful_card_payment(): void
    {
        config([
            'services.payfast.merchant_id' => '',
            'services.payfast.secured_key' => '',
        ]);

        $result = app(CardPaymentService::class)->pay([
            'mobile' => '03001234567',
            'amount' => 1500,
            'basket_id' => 'FM-TEST-1',
            'card_number' => '4242424242424242',
            'card_expiry' => '12/28',
            'card_cvc' => '123',
        ]);

        $this->assertTrue($result['success']);
        $this->assertStringStartsWith('PF-CARD-', $result['transaction_reference']);
    }

    public function test_configured_gateway_requests_otp_then_charges_tokenized_instrument(): void
    {
        $this->configureGateway();

        Http::fake([
            '*/transaction/token' => Http::response([
                'status_code' => '00',
                'instrument_token' => 'IT-123',
                'transaction_id' => 'TX-123',
                'otp_required' => true,
            ], 200),
            '*/transaction/tokenized' => Http::response([
                'status_code' => '00',
                'transaction_id' => 'TX-123',
            ], 200),
            '*/transaction/TX-123' => Http::response(['status_code' => '00'], 200),
            '*/token' => Http::response(['token' => 'bearer-abc'], 200),
        ]);

        $service = app(CardPaymentService::class);

        $first = $service->pay([
            'mobile' => '03001234567',
            'amount' => 1500,
            'basket_id' => 'FM-TEST-2',
            'merchant_user_id' => '42',
            'card_number' => '4242424242424242',
            'card_expiry' => '12/28',
            'card_cvc' => '123',
        ]);

        $this->assertFalse($first['success']);
        $this->assertTrue($first['otp_required']);
        $this->assertSame('IT-123', $first['instrument_token']);
        $this->assertSame('TX-123', $first['transaction_id']);

        $second = $service->pay([
            'mobile' => '03001234567',
            'amount' => 1500,
            'basket_id' => 'FM-TEST-2',
            'merchant_user_id' => '42',
            'card_number' => '4242424242424242',
            'card_expiry' => '12/28',
            'card_cvc' => '123',
            'otp' => '654321',
            'instrument_token' => 'IT-123',
            'transaction_id' => 'TX-123',
        ]);

        $this->assertTrue($second['success']);
        $this->assertSame('TX-123', $second['transaction_reference']);

        Http::assertSent(fn ($request) => str_contains($request->url(), '/transaction/tokenized')
            && $request['otp'] === '654321'
            && $request['instrument_token'] === 'IT-123');
    }

    public function test_configured_gateway_declines_invalid_card(): void
    {
        $this->configureGateway();

        Http::fake([
            '*/transaction/token' => Http::response([
                'status_code' => '14',
                'status_msg' => 'Incorrect card details',
            ], 200),
            '*/token' => Http::response(['token' => 'bearer-abc'], 200),
        ]);

        $result = app(CardPaymentService::class)->pay([
            'mobile' => '03001234567',
            'amount' => 1500,
            'basket_id' => 'FM-TEST-3',
            'card_number' => '4242424242424242',
            'card_expiry' => '12/28',
            'card_cvc' => '123',
        ]);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('Incorrect card details', $result['message']);
    }

    public function test_configured_gateway_rejects_invalid_mobile(): void
    {
        $this->configureGateway();

        $result = app(CardPaymentService::class)->pay([
            'mobile' => '12345',
            'amount' => 1500,
            'basket_id' => 'FM-TEST-4',
            'card_number' => '4242424242424242',
            'card_expiry' => '12/28',
            'card_cvc' => '123',
        ]);

        $this->assertFalse($result['success']);
        $this->assertStringContainsString('valid mobile number', $result['message']);
    }

    public function test_parses_card_expiry_formats(): void
    {
        $service = app(CardPaymentService::class);

        $this->assertSame(['month' => '09', 'year' => '2027'], $service->parseExpiry('9/27'));
        $this->assertSame(['month' => '12', 'year' => '2028'], $service->parseExpiry('12/2028'));
        $this->assertSame([], $service->parseExpiry('13/27'));
        $this->assertSame([], $service->parseExpiry('not-a-date'));
    }
}
