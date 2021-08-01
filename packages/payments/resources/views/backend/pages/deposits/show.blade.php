@extends('backend.layouts.main')

@section('title')
    {{ __('Deposit') }} {{ $deposit->id }} :: {{ __('Info') }}
@endsection

@section('content')
    <table class="table table-hover">
        <tbody>
            <tr>
                <td>{{ __('ID') }}</td>
                <td class="text-right">{{ $deposit->id }}</td>
            </tr>
            <tr>
                <td>{{ __('External ID') }}</td>
                <td class="text-right">{{ $deposit->external_id }}</td>
            </tr>
            <tr>
                <td>{{ __('Amount') }}</td>
                <td class="text-right">{{ $deposit->amount }}</td>
            </tr>
            <tr>
                <td>{{ __('Payment amount') }}</td>
                <td class="text-right">{{ $deposit->payment_amount }}</td>
            </tr>
            <tr>
                <td>{{ __('Payment currency') }}</td>
                <td class="text-right">{{ $deposit->payment_currency }}</td>
            </tr>
            <tr>
                <td>{{ __('Method') }}</td>
                <td class="text-right">{{ $deposit->method->name }}</td>
            </tr>
            <tr>
                <td>{{ __('Status') }}</td>
                <td class="text-right">{{ $deposit->status_title }}</td>
            </tr>
            @if($deposit->parameters)
                @foreach($deposit->parameters as $key => $value)
                    <tr>
                        <td>{{ $deposit->method->keyed_parameters[$key]->name ?? $key  }}</td>
                        <td class="text-right">
                            {{ isset($deposit->method->keyed_parameters[$key]) && $deposit->method->keyed_parameters[$key]->type == 'switch' ? ($value ? __('Yes') : __('No')) : $value }}
                        </td>
                    </tr>
                @endforeach
            @endif
            @if($deposit->response)
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
                                @foreach($deposit->response as $item)
                                    <pre>{{ json_encode($item, JSON_PRETTY_PRINT) }}</pre>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <tr>
                <td>{{ __('Created') }}</td>
                <td class="text-right">{{ $deposit->created_at }}</td>
            </tr>
            <tr>
                <td>{{ __('Updated') }}</td>
                <td class="text-right">{{ $deposit->updated_at }}</td>
            </tr>
        </tbody>
    </table>
    @if($deposit->is_created && !$deposit->method->gateway)
        <h4 class="my-3">{{ __('Workflow actions') }}</h4>

        <form class="float-left mr-2" method="POST" action="{{ route('backend.deposits.cancel', $deposit) }}">
            @csrf
            <span data-balloon="{{ __('Cancel deposit request.') }}" data-balloon-pos="up">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-times"></i>
                    {{ __('Cancel') }}
                </button>
            </span>
        </form>

        <form class="mr-2" method="POST" action="{{ route('backend.deposits.complete', $deposit) }}">
            @csrf
            <span data-balloon="{{ __('Approve deposit request and add funds to user account.') }}" data-balloon-pos="up">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-double"></i>
                    {{ __('Complete') }}
                </button>
            </span>
        </form>
    @endif
    <div class="mt-3">
        <a href="{{ route('backend.deposits.index', request()->query()) }}"><i class="fas fa-long-arrow-alt-left"></i> {{ __('Back to all deposits') }}</a>
    </div>
@endsection
