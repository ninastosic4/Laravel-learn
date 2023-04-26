@extends('admin.layouts.main')

@section('seo-title')
<title>{{ __('users.change-password-for') }} {{ $user->name }} {{ config('website.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')

@endsection

@section('content')
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-xl px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="file"></i></div>
                        {{ __('users.change-password-for') }} {{ $user->name }}
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3"></div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container-xl px-4">
    <div class="row">
        <div class="col-lg-9">
            <div id="default">
                <div class="card mb-4">
                    <div class="card-body">
                        <!-- Component Preview-->
                        <div class="sbp-preview">
                            <div class="sbp-preview-content">
                                <form method="post" action="{{ route('users.changepasswordpost', ['user' => $user->id]) }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="password">{{ __('users.password') }}</label>
                                        <input class="form-control" id="password" type="password" name="password"/>
                                        @error('password')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="password-confirm">{{ __('users.confirm-password') }}</label>
                                        <input class="form-control" id="password_confirmation" type="password" name="password_confirmation"/>
                                        @error('password_confirmation')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 text-center">
                                        <button class="btn btn-primary" type="submit" name="submit">{{ __('website.save') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('custom-js')

@endsection

