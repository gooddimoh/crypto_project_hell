@extends('backend.layouts.main')

@section('title')
    {{ __('Widthdrawal') }} {{ $withdrawal->id }} :: {{ __('Info') }}
@endsection

@section('content')
    <table class="table table-hover">
        <tbody>
        <tr>
            <td>{{ __('ID') }}</td>
            <td class="text-right">{{ $withdrawal->id }}</td>
        </tr>
        <tr>
            <td>{{ __('External ID') }}</td>
            <td class="text-right">{{ $withdrawal->external_id }}</td>
        </tr>
        <tr>
            <td>{{ __('Amount') }}</td>
            <td class="text-right">{{ $withdrawal->amount }}</td>
        </tr>
        <tr>
            <td>{{ __('Payment amount') }}</td>
            <td class="text-right">{{ $withdrawal->payment_amount }}</td>
        </tr>
        <tr>
            <td>{{ __('Payment currency') }}</td>
            <td class="text-right">{{ $withdrawal->payment_currency }}</td>
        </tr>
        <tr>
            <td>{{ __('Method') }}</td>
            <td class="text-right">{{ $withdrawal->method->name }}</td>
        </tr>
        <tr>
            <td>{{ __('Status') }}</td>
            <td class="text-right">{{ $withdrawal->status_title }}</td>
        </tr>
            @if($withdrawal->parameters)
                @foreach($withdrawal->parameters as $key => $value)
                    <tr>
                        <td>{{ $withdrawal->method->keyed_parameters[$key]->name ?? $key  }}</td>
                        <td class="text-right">
                            {{ isset($withdrawal->method->keyed_parameters[$key]) && $withdrawal->method->keyed_parameters[$key]->type == 'switch' ? ($value ? __('Yes') : __('No')) : $value }}
                        </td>
                    </tr>
                @endforeach
            @endif
            @if($withdrawal->response)
                <tr>
                    <td>{{ __('API response') }}</td>
                    <td class="text-right">
                        <button data-toggle="modal" data-target="#response-modal" class="btn btn-link">
                            {{ __('View') }}
                        </button>
                    </td>
                </tr>
                <div class="modal fade" id="response-modal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ __('API response') }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @foreach($withdrawal->response as $item)
                                    <pre>{{ json_encode($item, JSON_PRETTY_PRINT) }}</pre>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <tr>
                <td>{{ __('Created') }}</td>
                <td class="text-right">{{ $withdrawal->created_at }}</td>
            </tr>
            <tr>
                <td>{{ __('Updated') }}</td>
                <td class="text-right">{{ $withdrawal->updated_at }}</td>
            </tr>
        </tbody>
    </table>
    @if($withdrawal->is_created)
        <h4 class="my-3">{{ __('Workflow actions') }}</h4>

        <form class="float-left mr-2" method="POST" action="{{ route('backend.withdrawals.cancel', $withdrawal) }}">
            @csrf
            <span data-balloon="{{ __('Cancel request and return funds to user account.') }}" data-balloon-pos="up">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-times"></i>
                    {{ __('Cancel') }}
                </button>
            </span>
        </form>

        @if($withdrawal->method->code == 'coinpayments')
            <form class="float-left mr-2" method="POST" action="{{ route('backend.withdrawals.send', $withdrawal) }}">
                @csrf
                <span data-balloon="{{ __('Approve request and send funds to user through API.') }}" data-balloon-pos="up">
                    <button type="submit" class="btn btn-outline-success">
                        <i class="fas fa-check"></i>
                        {{ __('Approve') }}
                    </button>
                </span>
            </form>
        @endif

        <form method="POST" action="{{ route('backend.withdrawals.complete', $withdrawal) }}">
            @csrf
            <span data-balloon="{{ __('Send funds manually and mark request as completed.') }}" data-balloon-pos="up">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-double"></i>
                    {{ __('Complete') }}
                </button>
            </span>
        </form>

        @if($withdrawal->method->code == 'metamask' && !$withdrawal->external_id)
            <div class="mt-3 mb-3">
                <div
                    id="component-container"
                    data-props="{{ json_encode(array_merge(['withdrawal' => $withdrawal], [
                        'config' => [
                            'deposit_address' => config('payments.ethereum.deposit_address'),
                            'deposit_contract' => config('payments.ethereum.deposit_contract'),
                            'deposit_contract_decimals' => config('payments.ethereum.deposit_contract_decimals'),
                        ],
                        ''
                    ])) }}"
                ></div>
            </div>
        @endif

        @if($withdrawal->method->code == 'bsc' && !$withdrawal->external_id)
            <div class="mt-3 mb-3">
                <div
                    id="component-container"
                    data-props="{{ json_encode(array_merge(['withdrawal' => $withdrawal], [
                        'config' => [
                            'deposit_address' => config('payments.bsc.deposit_address'),
                            'deposit_contract' => config('payments.bsc.deposit_contract'),
                            'deposit_contract_decimals' => config('payments.bsc.deposit_contract_decimals'),
                        ],
                        ''
                    ])) }}"
                ></div>
            </div>
        @endif
    @endif
    <div class="mt-3">
        <a href="{{ route('backend.withdrawals.index', request()->query()) }}"><i class="fas fa-long-arrow-alt-left"></i> {{ __('Back to all withdrawals') }}</a>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ mix('js/payments/admin/withdrawals/metamask.js') }}"></script>
@endpush
