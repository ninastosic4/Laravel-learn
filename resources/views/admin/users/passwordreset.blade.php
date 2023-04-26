@extends('admin.layouts.main-noauth')

@section('seo-title')
<title>{{ __('users.password-recovery') }}  {{ config('website.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')

@endsection

@section('content')
 <!-- Password recovery form-->
 <div class="card shadow-lg border-0 rounded-lg mt-5">
    <div class="card-header justify-content-center m-auto"><h2 class="fw-bold my-4">{{ __('users.password-recovery') }}</h2></div>
    <div class="card-body">
        <div class="small mb-3 text-muted"></div>
        <!-- Password recovery form -->
            <form method="post" action="{{ route('users.passwordresetpost') }}">
                @csrf
                <div class="mb-3">
                    <label for="password">{{ __('users.email') }}</label>
                    <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="{{ __('users.insert-email') }}"/>
                    @error('email')
                        <div class="text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password">{{ __('users.password') }}</label>
                    <input class="form-control" id="password" type="password" name="password" placeholder="{{ __('users.enter-new-password') }}"/>
                    @error('password')
                        <div class="text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password-confirm">{{ __('users.confirm-password') }}</label>
                    <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" placeholder="{{ __('users.confirm-new-password') }}"/>
                    @error('password_confirmation')
                        <div class="text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input class="form-control" id="token" type="hidden" name="token" value="{{ $token }}"/>
                    @error('token')
                        <div class="text text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 text-center">
                    <button class="btn btn-primary" type="submit" name="submit">{{ __('users.reset-password') }}</button>
                </div>
            </form>
    </div>
</div>
@endsection


@section('custom-js')

@endsection