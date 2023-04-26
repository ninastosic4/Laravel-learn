@extends('admin.layouts.main-noauth')

@section('seo-title')
<title>{{ __('website.login') }}  {{ config('website.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')

@endsection

@section('content')
<!-- Basic login form-->
<div class="card shadow-lg border-0 rounded-lg mt-5">
    <div class="card-header justify-content-center m-auto"><h1 class="fw-bold my-4">{{ __('website.login') }}</h1></div>
    <div class="card-body">
        @if(request()->session()->has('message'))
            <div class="w-50 m-auto">
                <span class="text {{ request()->session()->get('message')['type'] }}">{{ request()->session()->get('message')['text'] }}</span>
            </div>
        @endif
        <!-- Login form-->
        <form method="POST" action="">
            @csrf
            <!-- Form Group (email address)-->
            <div class="mb-3">
                <label class="small mb-1" for="inputEmailAddress">{{ __('users.email') }}</label>
                <input class="form-control" id="inputEmailAddress" type="text" placeholder="{{ __('users.insert-email') }}" name="email" value="{{ old('email') }}" />
                @error('email')
                    <div class="text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <!-- Form Group (password)-->
            <div class="mb-3">
                <label class="small mb-1" for="inputPassword">{{ __('users.password') }}</label>
                <input class="form-control" id="inputPassword" type="password" placeholder="{{ __('users.enter-password') }}" name="password" />
                @error('password')
                    <div class="text text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Form Group (login box)-->
            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                <!-- Google reCaptcha div -->
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                <a class="small" href="{{ route('users.forgotpassword') }}">{{ __('users.forgot-password') }}?</a>
                <button type="submit" class="btn btn-primary">{{ __('website.login') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection


@section('custom-js')

@endsection