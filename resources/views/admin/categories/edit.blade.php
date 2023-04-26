@extends('admin.layouts.main')

@section('seo-title')
<title>{{ __('categories.edit-category') }}  {{ config('website.seo-separator') }} {{ config('app.name') }}</title>
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
                        {{ __('categories.edit-category') }}
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
                    <div class="card-header">{{ __('categories.edit-category')  }} {{ $category->name }}</div>
                    <div class="card-body">
                        <!-- Component Preview-->
                        <div class="sbp-preview">
                            <div class="sbp-preview-content">
                                <form method="post" action="{{ route('categories.update', ['category' => $category]) }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="mb-2 fw-bold" for="name">{{ __('categories.name') }}</label>
                                        <input class="form-control" id="name" type="text" placeholder="{{ __('categories.name') }}" name="name" value="{{ old('name', $category->name) }}" />
                                        @error('name')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-2 fw-bold" for="description">{{ __('categories.description') }}</label>
                                        <textarea class="form-control" id="description" name="description" rows='3' placeholder="{{ __('website.add-description') }}">{{ old('description', $category->description) }}</textarea>
                                        @error('description')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="mb-2 fw-bold">{{ __('categories.text') }}</label>
                                        <textarea id="editor" class="form-control" rows='3' name="text" placeholder="{{ __('categories.add-text') }}">{{ old('text', $category->text) }}</textarea>
                                        <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
                                        <script>
                                            ClassicEditor
                                                .create( document.querySelector( '#editor' ) )
                                                .catch( error => {
                                                    console.error( error );
                                                } );
                                        </script>
                                        @error('text')
                                            <div class="text text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- <div class="mb-3">
                                        <input class="form-check-input" id="active" type="checkbox" value="1" name="active" />
                                        <label class="form-check-label" for="active">User is active?</label>
                                    </div> -->
                                    <div class="mb-3 text-center">
                                        <button class="btn btn-primary" type="submit" name="submit">{{ __('categories.edit-category') }}</button>
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

