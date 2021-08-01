@extends('backend.layouts.main')

@section('title')
    {{ __('Payment gateway') }} {{ $payment_gateway->id }} :: {{ __('Edit') }}
@endsection

@section('content')
    <form method="POST" action="{{ route('backend.payment-gateways.update', $payment_gateway) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>{{ __('Code') }}</label>
            <input class="form-control text-muted" value="{{ $payment_gateway->code }}" readonly>
        </div>

        <div class="form-group">
            <label>{{ __('Name') }}</label>
            <input class="form-control" name="name" value="{{ $payment_gateway->name }}">
        </div>

        <div class="form-group">
            <label>{{ __('Currency') }}</label>
            <input id="currency-input" class="form-control" name="currency" value="{{ $payment_gateway->currency }}">
        </div>

        <div class="form-group">
            <label>{{ __('Rate') }}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span id="rate-text" class="input-group-text"></span>
                </div>
                <input class="form-control" name="rate" value="{{ $payment_gateway->rate }}">
                <div class="input-group-append">
                    <span class="input-group-text">{{ __('credits') }}</span>
                </div>
            </div>
            <small>
                {{ __('Amount of credits per 1 unit of the reference currency.') }}
            </small>
        </div>

        <div class="form-group">
            <label>{{ __('Created at') }}</label>
            <input class="form-control text-muted" value="{{ $payment_gateway->created_at }} ({{ $payment_gateway->created_at->diffForHumans() }})" readonly>
        </div>

        <div class="form-group">
            <label>{{ __('Updated at') }}</label>
            <input class="form-control text-muted" value="{{ $payment_gateway->updated_at }} ({{ $payment_gateway->updated_at->diffForHumans() }})" readonly>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i>
            {{ __('Save') }}
        </button>
    </form>
    <div class="mt-3">
        <a href="{{ route('backend.payment-gateways.index') }}"><i class="fas fa-long-arrow-alt-left"></i> {{ __('Back to all payment gateways') }}</a>
    </div>
@endsection

@push('scripts')
    <script>
        var currency = '{{ $payment_gateway->currency }}';
        var currencyInput = document.getElementById('currency-input');
        var rateText = document.getElementById('rate-text');

        setRateText(currency);

        currencyInput.addEventListener('input', function (e) {
            setRateText(e.target.value)
        });

        function setRateText (currency) {
            rateText.innerHTML = '1 ' + currency + ' = ';
        }
    </script>
@endpush
