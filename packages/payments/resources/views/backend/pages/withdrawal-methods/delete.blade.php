@extends('backend.layouts.main')

@section('title')
    {{ __('Withdrawal method') }} {{ $withdrawal_method->id }} :: {{ __('Delete') }}
@endsection

@section('content')
    <form  class="ui form" method="POST" action="{{ route('backend.withdrawal-methods.destroy', $withdrawal_method) }}">
        @csrf
        {{ method_field('DELETE') }}
        <button type="submit" class="btn btn-danger">
            <i class="far fa-trash-alt"></i>
            {{ __('Delete') }}
        </button>
    </form>
    <div class="mt-3">
        <a href="{{ route('backend.withdrawal-methods.index') }}"><i class="fas fa-long-arrow-alt-left"></i> {{ __('Back to all withdrawal methods') }}</a>
    </div>
@endsection
