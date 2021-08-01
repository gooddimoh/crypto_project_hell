@extends('backend.layouts.main')

@section('title')
    {{ __('Deposit') }} {{ $deposit->id }} :: {{ __('Transaction') }}
@endsection

@section('content')
    <table class="table table-hover table-wrap-text">
        <tbody>
            @if($transaction)
                @foreach($transaction as $key => $value)
                    <tr>
                        <td>{{ __($key) }}</td>
                        <td class="text-right">{{ $value }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <div class="mt-3">
        <a href="{{ route('backend.deposits.index', request()->query()) }}"><i class="fas fa-long-arrow-alt-left"></i> {{ __('Back to all deposits') }}</a>
    </div>
@endsection
