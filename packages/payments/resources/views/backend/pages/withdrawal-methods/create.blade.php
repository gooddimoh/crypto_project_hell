@extends('backend.layouts.main')

@section('title')
    {{ __('Withdrawal method') }} :: {{ __('Create') }}
@endsection

@section('content')
    <div
        id="component-container"
        data-props="{{ json_encode(array_merge($props, [
            'input' => session()->getOldInput(),
            'errors' => $errors->get('*')
        ]), JSON_NUMERIC_CHECK) }}"
    ></div>
    <div class="mt-3">
        <a href="{{ route('backend.withdrawal-methods.index') }}"><i class="fas fa-long-arrow-alt-left"></i> {{ __('Back to all withdrawal methods') }}</a>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ mix('js/payments/admin/method-form.js') }}"></script>
@endpush
