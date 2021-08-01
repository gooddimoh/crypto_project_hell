@extends('backend.layouts.main')

@section('title')
    {{ __('Withdrawal methods') }}
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col">
            <a href="{{ route('backend.withdrawal-methods.create') }}" class="btn btn-primary">
                {{ __('Create withdrawal method') }}
            </a>
        </div>
    </div>
    @if($withdrawal_methods->isEmpty())
        <div class="alert alert-info" role="alert">
            {{ __('No withdrawal methods found.') }}
        </div>
    @else
        <table class="table table-hover table-stackable">
            <thead>
            <tr>
                <th>{{ __('ID') }}</th>
                <th>{{ __('Code') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Gateway') }}</th>
                <th>{{ __('Status') }}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($withdrawal_methods as $withdrawal_method)
                <tr>
                    <td data-title="{{ __('ID') }}">{{ $withdrawal_method->id }}</td>
                    <td data-title="{{ __('Code') }}">{{ $withdrawal_method->code }}</td>
                    <td data-title="{{ __('Name') }}">{{ $withdrawal_method->name }}</td>
                    <td data-title="{{ __('Gateway') }}">{{ $withdrawal_method->gateway->name ?? '' }}</td>
                    <td data-title="{{ __('Status') }}">{{ $withdrawal_method->status_title }}</td>
                    <td class="text-right">
                        <div class="btn-group" role="group" aria-label="{{ __('Edit') }}">
                            <a href="{{ route('backend.withdrawal-methods.edit', array_merge(['withdrawal-method' => $withdrawal_method], request()->query())) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit fa-sm"></i>
                                {{ __('Edit') }}
                            </a>
                            <div class="btn-group" role="group">
                                <button id="users-action-button" type="button" class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                <div class="dropdown-menu" aria-labelledby="users-action-button">
                                    <a class="dropdown-item" href="{{ route('backend.withdrawal-methods.edit', array_merge(['withdrawal-method' => $withdrawal_method], request()->query())) }}">
                                        <i class="fas fa-edit fa-sm"></i>
                                        {{ __('Edit') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('backend.withdrawal-methods.delete', array_merge(['withdrawal-method' => $withdrawal_method], request()->query())) }}">
                                        <i class="fas fa-trash fa-sm"></i>
                                        {{ __('Delete') }}
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
