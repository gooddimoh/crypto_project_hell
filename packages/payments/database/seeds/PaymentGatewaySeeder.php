<?php

use Illuminate\Database\Seeder;
use Packages\Payments\Models\PaymentGateway;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentGateway::firstOrCreate(
            ['code' => 'paypal'], ['name' => 'PayPal', 'currency' => 'USD', 'rate' => 100]
        );

        PaymentGateway::firstOrCreate(
            ['code' => 'stripe'], ['name' => 'Stripe', 'currency' => 'USD', 'rate' => 100]
        );

        PaymentGateway::firstOrCreate(
            ['code' => 'coinpayments'], ['name' => 'Coinpayments', 'currency' => 'LTCT', 'rate' => 10000]
        );

        PaymentGateway::firstOrCreate(
            ['code' => 'ethereum'], ['name' => 'Ethereum', 'currency' => 'ETH', 'rate' => 10000]
        );

        PaymentGateway::firstOrCreate(
            ['code' => 'bsc'], ['name' => 'Binance Smart Chain', 'currency' => 'BNB', 'rate' => 10000]
        );
    }
}
