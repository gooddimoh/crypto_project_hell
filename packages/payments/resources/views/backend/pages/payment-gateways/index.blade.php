@extends('backend.layouts.main')

@section('title')
    {{ __('Payment gateways') }}
@endsection

@section('content')
    @if($payment_gateways->isEmpty())
        <div class="alert alert-info" role="alert">
            {{ __('No payment gateways found.') }}
        </div>
    @else
        <table class="table table-hover table-stackable">
            <thead>
            <tr>
                <th>{{ __('ID') }}</th>
                <th>{{ __('Code') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Currency') }}</th>
                <th>{{ __('Rate') }}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($payment_gateways as $payment_gateway)
                <tr>
                    <td data-title="{{ __('ID') }}">{{ $payment_gateway->id }}</td>
                    <td data-title="{{ __('Code') }}">{{ $payment_gateway->code }}</td>
                    <td data-title="{{ __('Name') }}">{{ $payment_gateway->name }}</td>
                    <td data-title="{{ __('Currency') }}">{{ $payment_gateway->currency }}</td>
                    <td data-title="{{ __('Rate') }}">{{ $payment_gateway->rate }}</td>
                    <td class="text-right">
                        <div class="btn-group" role="group" aria-label="{{ __('Edit') }}">
                            <a href="{{ route('backend.payment-gateways.edit', array_merge(['payment-gateways' => $payment_gateway], request()->query())) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit fa-sm"></i>
                                {{ __('Edit') }}
                            </a>
                            <div class="btn-group" role="group">
                                <button id="users-action-button" type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu" aria-labelledby="users-action-button">
                                    @if($payment_gateway->code == 'coinpayments')
                                        <a class="dropdown-item" href="{{ route('backend.payment-gateways.info', array_merge(['payment-gateways' => $payment_gateway], request()->query())) }}">
                                            <i class="fas fa-info fa-sm"></i>
                                            {{ __('Info') }}
                                        </a>
                                        <a class="dropdown-item" href="{{ route('backend.payment-gateways.balance', array_merge(['payment-gateways' => $payment_gateway], request()->query())) }}">
                                            <i class="fas fa-wallet fa-sm"></i>
                                            {{ __('Balance') }}
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('backend.payment-gateways.edit', array_merge(['payment-gateways' => $payment_gateway], request()->query())) }}">
                                        <i class="fas fa-edit fa-sm"></i>
                                        {{ __('Edit') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
