@extends('frontend.layouts.main')

@section('title')
    {{ __('Deposit') }}
@endsection

@section('content')
    <div
        id="component-container"
        data-props="{{ json_encode(array_merge($props, [
            'input' => session()->getOldInput(),
            'errors' => $errors->get('*')
        ]), JSON_NUMERIC_CHECK) }}"
    ></div>
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/payments/' . $settings->theme . '.css') }}">
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ mix('js/payments/deposits/create.js') }}"></script>
@endpush
