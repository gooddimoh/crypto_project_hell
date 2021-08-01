@extends('backend.layouts.main')

@section('title')
    {{ __('Payment gateway') }} {{ $payment_gateway->id }} :: {{ __('Balance') }}
@endsection

@section('content')
    <table class="table table-hover table-wrap-text">
        <tbody>
            @if($data)
                @foreach($data as $key => $value)
                    <tr>
                        <td>{{ __($key) }}</td>
                        <td class="text-right">{{ $value->balancef }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="mt-3">
        <a href="{{ route('backend.payment-gateways.index') }}"><i class="fas fa-long-arrow-alt-left"></i> {{ __('Back to all payment gateways') }}</a>
    </div>
@endsection
