<?php

namespace Packages\Payments\Services;

use Omnipay\Omnipay;

class BscPaymentService extends EthereumPaymentService
{
    protected function init()
    {
        $this->omnipay = Omnipay::create('Etherscan');

        $this->omnipay->initialize([
            'api_key' => config('payments.bsc.api_key'),
            'network' => config('payments.bsc.network')
        ]);
    }

    public function createPayment(array $params): PaymentService
    {
        $this->amount = $params['amount'];
        $this->addressFrom = $params['parameters']['address'];
        $this->addressTo = config('payments.bsc.deposit_address');
        $this->isRedirect = TRUE;

        return $this;
    }

    public function getPaymentParameters(): ?array
    {
        $params = [
            'addressFrom' => $this->addressFrom,
            'addressTo' => $this->addressTo
        ];

        if (config('payments.bsc.deposit_contract')) {
            $params['contractAddress'] = config('payments.bsc.deposit_contract');
            $params['contractDecimals'] = (int) config('payments.bsc.deposit_contract_decimals');
        }

        return $params;
    }
}
