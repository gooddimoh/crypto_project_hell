<?php

use Illuminate\Database\Seeder;
use Packages\Payments\Models\DepositMethod;
use Packages\Payments\Models\PaymentGateway;

class DepositMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = [
            ['code' => 'paypal', 'name' => 'PayPal', 'gateway_code' => 'paypal', 'parameters' => []],
            ['code' => 'stripe', 'name' => 'Stripe', 'gateway_code' => 'stripe', 'parameters' => [
                [
                    'id'            => 'payment_method_id',
                    'type'          => 'input',
                    'name'          => '',
                    'description'   => '',
                    'validation'    => 'required',
                    'default'       => '',
                    'system'        => TRUE
                ]
            ]],
            ['code' => 'coinpayments', 'name' => 'Coinpayments', 'gateway_code' => 'coinpayments', 'parameters' => []],
            ['code' => 'metamask', 'name' => 'MetaMask', 'gateway_code' => 'ethereum', 'parameters' => [
                [
                    'id'            => 'address',
                    'type'          => 'input',
                    'name'          => 'Address',
                    'description'   => '',
                    'validation'    => 'required',
                    'default'       => '',
                    'system'        => TRUE
                ]
            ]],
            ['code' => 'bsc', 'name' => 'BNB (MetaMask)', 'gateway_code' => 'bsc', 'parameters' => [
                [
                    'id'            => 'address',
                    'type'          => 'input',
                    'name'          => 'Address',
                    'description'   => '',
                    'validation'    => 'required',
                    'default'       => '',
                    'system'        => TRUE
                ]
            ]],
        ];

        foreach ($methods as $method) {
            DepositMethod::firstOrCreate(
                ['code' => $method['code']],
                [
                    'payment_gateway_id' => isset($method['gateway_code']) ? (PaymentGateway::where('code', $method['gateway_code'])->first()->id ?? NULL) : NULL,
                    'name' => $method['name'],
                    'enabled' => FALSE,
                    'parameters' => $method['parameters']
                ]
            );
        }
    }
}
