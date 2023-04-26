@extends('admin.layouts.main')

@section('seo-title')
<title>{{ __('categories.all-categories') }}  {{ config('website.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <style>
        .datatable-input {
            display: none
        }
    </style>

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
@endsection

@section('content')
<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-xl px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i data-feather="file"></i></div>
                        {{ __('categories.all-categories') }}
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
        <div class="card-header">{{ __('categories.categories-list') }}</div>
        <div class="card-body">
            <table id="categoriesDatatable">
                <thead>
                    <tr>
                        <th>{{ __('website.priority') }}</th>
                        <th>{{ __('website.name') }}</th>
                        <th>{{ __('website.status') }}</th>
                        <th>{{ __('website.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($categories) > 0)
                        @foreach($categories as $value)
                        <tr>
                            <td>{{ $value->priority }}</td>
                            <td>{{ $value->name }}</td>
                            <td>
                                @if($value->active == 1)
                                    <a class="btn btn-sm btn-primary" href='{{ route("categories.status", ["category" => $value]) }}'>{{ __('website.active') }}</a>
                                @else
                                    <a class="btn btn-sm btn-warning" href='{{ route("categories.status", ["category" => $value]) }}'>{{ __('website.inactive') }}</a>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a data-bs-placement="top" title="{{ __('categories.edit-category') }}" class="btn btn-sm btn-success tooltip-custom" href='{{ route("categories.edit", ["category" => $value]) }}'>{{ __('website.edit') }}</a>
                                    <a data-bs-toggle="modal" data-bs-placement="top" title="{{ __('categories.delete-category') }}" data-bs-target="#deleteModal"  class="btn btn-sm btn-danger tooltip-custom" data-name="{{ $value->name }}" data-href='{{ route("categories.destroy", ["category" => $value->id]) }}'>{{ __('website.delete') }}</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deleteModalLabel">{{ __('categories.delete-category') }}</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-bs-dismiss="modal">{{ __('website.cancel') }}</button>
        <a type="button" class="btn btn-danger" id="delete-button-modal">{{ __('website.delete') }}</a>
      </div>
    </div>
  </div>
</div>


@endsection


@section('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <!-- <script src="/templates/admin/js/datatables/datatables-simple-demo.js"></script> -->

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script>
        window.addEventListener('DOMContentLoaded', event => {

            const datatablesSimple = document.getElementById('categoriesDatatable');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple, {
                    columns: [
                        {
                            select: 0,
                            sortable: false,
                            searchable: false,
                        },
                        {
                            select: 1,
                            sortable: false,
                            searchable: false
                        },
                        {
                            select: 2,
                            sortable: false,
                            searchable: false
                        },
                        {
                            select: 3,
                            sortable: false,
                            searchable: false
                        }
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/sr.json',
                    },
                    paging: false
                });
            }            
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $('tbody').sortable();
    </script>
    
    
    <script>
        const deleteModal = document.getElementById('deleteModal')
        deleteModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const link = button.getAttribute('data-href');
                const categoryToDelete = button.getAttribute('data-name');
                // If necessary, you could initiate an AJAX request here
                // and then do the updating in a callback.
                //
                // Update the modal's content.
                const modalTitle = deleteModal.querySelector('.modal-title')
                const modalBody = deleteModal.querySelector('.modal-body')

                modalBody.textContent = "{{ __('categories.delete-category-question') }} " + categoryToDelete + "?";

                const modalDeleteButton = deleteModal.querySelector('#delete-button-modal');
                // console.log(modalDeleteButton);
                modalDeleteButton.href = link;
            })


        $(function () {
            $('.tooltip-custom').tooltip();
            // Enable tooltips globally
            // var tooltipTriggerList = [].slice.call(document.querySelectorAll('.tooltip-custom]'));
            // var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            //     return new bootstrap.Tooltip(tooltipTriggerEl);
            // });
        })
    </script>


@endsection

