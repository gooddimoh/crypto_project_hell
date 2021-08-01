<?php

use Illuminate\Database\Seeder;
use Packages\Payments\Models\PaymentGateway;
use Packages\Payments\Models\WithdrawalMethod;

class WithdrawalMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = [
            ['code' => 'coinpayments', 'name' => 'Coinpayments', 'gateway_code' => 'coinpayments', 'parameters' =>
                [
                    [
                        'id'            => 'address',
                        'type'          => 'input',
                        'name'          => __('Address'),
                        'description'   => '',
                        'validation'    => 'required',
                        'default'       => '',
                        'system'        => TRUE
                    ],
                    [
                        'id'            => 'comment',
                        'type'          => 'textarea',
                        'name'          => __('Comment'),
                        'description'   => '',
                        'validation'    => '',
                        'default'       => ''
                    ]
                ]
            ],
            ['code' => 'wire', 'name' => 'Wire Transfer', 'parameters' =>
                [
                    [
                        'id'            => 'name',
                        'type'          => 'input',
                        'name'          => __('Name'),
                        'description'   => NULL,
                        'validation'    => 'required|min:3|max:50',
                        'default'       => NULL
                    ],
                    [
                        'id'            => 'iban',
                        'type'          => 'input',
                        'name'          => __('Bank account number'),
                        'description'   => NULL,
                        'validation'    => 'required',
                        'default'       => NULL
                    ],
                    [
                        'id'            => 'bank_code',
                        'type'          => 'input',
                        'name'          => __('Bank BIC / SWIFT code'),
                        'description'   => NULL,
                        'validation'    => 'required',
                        'default'       => NULL
                    ],
                    [
                        'id'            => 'bank_name',
                        'type'          => 'input',
                        'name'          => __('Bank name'),
                        'description'   => NULL,
                        'validation'    => 'required',
                        'default'       => NULL
                    ],
                    [
                        'id'            => 'bank_branch',
                        'type'          => 'input',
                        'name'          => __('Bank branch'),
                        'description'   => NULL,
                        'validation'    => 'required',
                        'default'       => NULL
                    ],
                    [
                        'id'            => 'bank_address',
                        'type'          => 'input',
                        'name'          => __('Bank address'),
                        'description'   => NULL,
                        'validation'    => 'required',
                        'default'       => NULL
                    ],
                    [
                        'id'            => 'comment',
                        'type'          => 'textarea',
                        'name'          => __('Comment'),
                        'description'   => NULL,
                        'validation'    => NULL,
                        'default'       => NULL
                    ]
                ]
            ],
            ['code' => 'metamask', 'name' => 'Metamask', 'gateway_code' => 'ethereum', 'parameters' =>
                [
                    [
                        'id'            => 'address',
                        'type'          => 'input',
                        'name'          => __('Address'),
                        'description'   => NULL,
                        'validation'    => 'required',
                        'default'       => NULL,
                        'system'        => TRUE
                    ]
                ]
            ],
            ['code' => 'bsc', 'name' => 'BNB (Metamask)', 'gateway_code' => 'bsc', 'parameters' =>
                [
                    [
                        'id'            => 'address',
                        'type'          => 'input',
                        'name'          => __('Address'),
                        'description'   => NULL,
                        'validation'    => 'required',
                        'default'       => NULL,
                        'system'        => TRUE
                    ]
                ]
            ],
        ];

        foreach ($methods as $method) {
            WithdrawalMethod::firstOrCreate(
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
