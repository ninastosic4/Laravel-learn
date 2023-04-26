@extends('admin.layouts.main-noauth')

@section('seo-title')
<title>{{ __('users.forgotten-password') }}  {{ config('website.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')

@endsection

@section('content')
 <!-- Basic forgot password form-->
 <div class="card shadow-lg border-0 rounded-lg mt-5">
    <div class="card-header justify-content-center m-auto"><h2 class="fw-bold my-4">{{ __('users.password-recovery') }}</h2></div>
    <div class="card-body">
        <div class="small mb-3 text-muted">{{ __('users.enter-email-recovery') }}</div>
        <!-- Forgot password form-->
        <form method="post" action="{{ route('users.forgotpasswordpost') }}">
            @csrf
            <!-- Form Group (email address)-->
            <div class="mb-3">
                <label class="small mb-1" for="email">{{ __('users.email') }}</label>
                <input class="form-control" id="email" type="email" name="email" placeholder="{{ __('users.insert-email') }}" />
                @error('email')
                    <div class="text text-danger">{{ $message }}</div>
                @enderror
                @if(request()->session()->has('message'))
                    <span class="text {{ request()->session()->get('message')['type'] }}">{{ request()->session()->get('message')['text'] }}</span>
                @endif
            </div>
            <!-- Form Group (submit options)-->
            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                <a class="small" href="{{ route('users.login') }}">{{ __('users.return-to-login') }}</a>
                <button class="btn btn-primary" type="submit" name="submit">{{ __('users.reset-password') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection


@section('custom-js')

@endsection