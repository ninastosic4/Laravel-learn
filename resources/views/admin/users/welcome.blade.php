@extends('admin.layouts.main')

@section('seo-title')
<title>{{ __('website.welcome') }}  {{ config('website.seo-separator') }} {{ config('app.name') }}</title>
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
                        {{ __('website.welcome') }}, {{ auth()->user()->name }}
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3"></div>
            </div>
        </div>
    </div>
</header>
<!-- Main page content-->
<div class="container-xl px-4 mt-4">
    @include('admin.layouts.partials.flashmessages')
    <div class="card">
        <div class="card-header">{{ __('website.example-card') }}</div>
        <div class="card-body">{{ __('website.example-card-text') }}</div>
    </div>
</div>
@endsection


@section('custom-js')

@endsection

