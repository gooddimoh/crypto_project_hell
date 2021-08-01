<?php

namespace Packages\Payments\Services;

use Omnipay\Omnipay;

class EthereumPaymentService extends PaymentService
{
    protected $omnipay;
    protected $amount;
    protected $addressFrom;
    protected $addressTo;

    protected $isRedirect = FALSE;

    protected function init()
    {
        $this->omnipay = Omnipay::create('Etherscan');

        $this->omnipay->initialize([
            'api_key' => config('payments.ethereum.api_key'),
            'network' => config('payments.ethereum.network')
        ]);
    }

    public function createPayment(array $params): PaymentService
    {
        $this->amount = $params['amount'];
        $this->addressFrom = $params['parameters']['address'];
        $this->addressTo = config('payments.ethereum.deposit_address');
        $this->isRedirect = TRUE;

        return $this;
    }

    public function completePayment(array $params): PaymentService
    {
        return $this;
    }

    public function getPaymentAmount(): float
    {
        return $this->amount / $this->getPaymentGatewayRate();
    }

    public function getPaymentCurrency(): string
    {
        return $this->getPaymentGatewayCurrency();
    }

    public function getPaymentParameters(): ?array
    {
        $params = [
            'addressFrom' => $this->addressFrom,
            'addressTo' => $this->addressTo
        ];

        if (config('payments.ethereum.deposit_contract')) {
            $params['contractAddress'] = config('payments.ethereum.deposit_contract');
            $params['contractDecimals'] = (int) config('payments.ethereum.deposit_contract_decimals');
        }

        return $params;
    }

    public function fetchBalance(string $address): PaymentService
    {
        $this->response = $this->omnipay->fetchBalance(['address' => $address])->send();

        return $this;
    }

    public function fetchTokenBalance(string $address, string $contractAddress): PaymentService
    {
        $this->response = $this->omnipay->fetchTokenBalance(['address' => $address, 'contract_address' => $contractAddress])->send();

        return $this;
    }

    public function fetchTransaction(string $transactionId): PaymentService
    {
        $this->response = $this->omnipay->fetchTransaction(['transactionReference' => $transactionId])->send();

        return $this;
    }

    public function fetchWithdrawal(string $transactionId): PaymentService
    {
        $this->response = $this->omnipay->fetchTransaction(['transactionReference' => $transactionId])->send();

        return $this;
    }

    public function isResponseRedirect()
    {
        return $this->isRedirect ?: parent::isResponseRedirect();
    }

    public function getRedirectUrl(): string
    {
        return 'user.account.deposits.complete';
    }

    public function isExternalRedirect(): bool
    {
        return FALSE;
    }

    public function getTransactionReferenceParameterName(): string
    {
        return '';
    }

    public function getTransactionReference(): string
    {
        return '';
    }

    public function getCompletePaymentParameters(): array
    {
        return [];
    }

    public function getCancelPaymentParameters(): array
    {
        return [];
    }
}
