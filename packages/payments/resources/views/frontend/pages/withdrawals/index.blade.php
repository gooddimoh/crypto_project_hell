@extends('frontend.layouts.main')

@section('title')
    {{ __('Withdrawals') }}
@endsection

@section('content')
    <div class="text-center mb-3">
        <a href="{{ route('frontend.withdrawals.create') }}" class="btn btn-primary">{{ __('Withdraw') }}</a>
    </div>
    @if($withdrawals->isEmpty())
        <div class="alert alert-info" role="alert">
            {{ __('There are no withdrawals yet.') }}
        </div>
    @else
        <table class="table table-hover table-stackable">
            <thead>
            <tr>
                @component('components.tables.sortable-column', ['id' => 'method', 'sort' => $sort, 'order' => $order])
                    {{ __('Method') }}
                @endcomponent
                @component('components.tables.sortable-column', ['id' => 'amount', 'sort' => $sort, 'order' => $order, 'class' => 'text-right'])
                    {{ __('Amount') }}
                @endcomponent
                @component('components.tables.sortable-column', ['id' => 'status', 'sort' => $sort, 'order' => $order, 'class' => 'text-right'])
                    {{ __('Status') }}
                @endcomponent
                @component('components.tables.sortable-column', ['id' => 'created', 'sort' => $sort, 'order' => $order, 'class' => 'text-right'])
                    {{ __('Created') }}
                @endcomponent
                @component('components.tables.sortable-column', ['id' => 'updated', 'sort' => $sort, 'order' => $order, 'class' => 'text-right'])
                    {{ __('Updated') }}
                @endcomponent
            </tr>
            </thead>
            <tbody>
            @foreach ($withdrawals as $withdrawal)
                <tr>
                    <td data-title="{{ __('Method') }}">
                        {{ $withdrawal->method->name }}
                    </td>
                    <td data-title="{{ __('Amount') }}" class="text-right">
                        {{ $withdrawal->_amount }}
                    </td>
                    <td data-title="{{ __('Status') }}" class="text-right {{ $withdrawal->is_completed ? 'text-success' : ($withdrawal->is_cancelled ? 'text-danger' : '') }}">
                        {{ $withdrawal->status_title }}
                    </td>
                    <td data-title="{{ __('Created') }}" class="text-right">
                        {{ $withdrawal->created_at->diffForHumans() }}
                        <span data-balloon="{{ $withdrawal->created_at }}" data-balloon-pos="up">
                            <i class="far fa-clock" ></i>
                        </span>
                    </td>
                    <td data-title="{{ __('Updated') }}" class="text-right">
                        {{ $withdrawal->updated_at->diffForHumans() }}
                        <span data-balloon="{{ $withdrawal->updated_at }}" data-balloon-pos="up">
                            <i class="far fa-clock" ></i>
                        </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $withdrawals->appends(['sort' => $sort])->appends(['order' => $order])->links() }}
        </div>
    @endif
@endsection
