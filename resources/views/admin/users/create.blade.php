@extends('admin.layouts.main')

@section('seo-title')
<title>{{ __('users.create-user') }}  {{ config('website.seo-separator') }} {{ config('app.name') }}</title>
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
                        {{ __('users.create-user') }}
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
                    <div class="card-header">{{ __('users.insert-save') }}</div>
                    <div class="card-body">
                        <!-- Component Preview-->
                        <div class="sbp-preview">
                            <div class="sbp-preview-content">
                                <form method="post" action="{{ route('users.store') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name">{{ __('users.name') }}</label>
                                        <input class="form-control" id="name" type="text" placeholder="{{ __('users.name') }}" name="name" value="{{ old('name') }}" />
                                        @error('name')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="email">{{ __('users.email-address') }}</label>
                                        <input class="form-control" id="email" type="email" placeholder="{{ __('users.email-placeholder') }}" name="email" value="{{ old('email') }}" />
                                        @error('email')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
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
                                    <div class="mb-3">
                                        <label for="role">{{ __('users.choose-role') }}</label>
                                        <select class="form-control" id="role" name="role">
                                            <option value="">----------------</option>
                                            <option value="administrator" {{ (old('role') == "administrator") ? 'selected' : '' }}>Administrator</option>
                                            <option value="moderator" {{ (old('role') == "moderator") ? 'selected' : '' }}>Moderator</option>
                                        </select>
                                        @error('role')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- <div class="mb-3">
                                        <input class="form-check-input" id="active" type="checkbox" value="1" name="active" />
                                        <label class="form-check-label" for="active">User is active?</label>
                                    </div> -->
                                    <div class="mb-3">
                                        <label for="address">{{ __('users.address') }}</label>
                                        <input class="form-control" id="address" type="text" placeholder="{{ __('users.address') }}" name="address" value="{{ old('address') }}" />
                                        @error('address')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone">{{ __('users.phone') }}</label>
                                        <input class="form-control" id="phone" type="text" placeholder="{{ __('users.phone') }}" name="phone" value="{{ old('phone') }}" />
                                        @error('phone')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 text-center">
                                        <button class="btn btn-primary" type="submit" name="submit">{{ __('users.add-user') }}</button>
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

