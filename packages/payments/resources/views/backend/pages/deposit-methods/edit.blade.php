@extends('backend.layouts.main')

@section('title')
    {{ __('Deposit method') }} {{ $props['method']->id }} :: {{ __('Edit') }}
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
        <a href="{{ route('backend.deposit-methods.index') }}"><i class="fas fa-long-arrow-alt-left"></i> {{ __('Back to all deposit methods') }}</a>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="{{ mix('js/payments/admin/method-form.js') }}"></script>
@endpush
