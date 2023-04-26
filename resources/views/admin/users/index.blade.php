@extends('admin.layouts.main')

@section('seo-title')
<title>{{ __('users.all-users') }}  {{ config('website.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />


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
                        {{ __('users.all-users') }}
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
        <div class="card-header">{{ __('users.admin-users-list') }}</div>
        <div class="card-body">
            <table id="allDatatables">
                <thead>
                    <tr>
                        <th>{{ __('users.name') }}</th>
                        <th>{{ __('users.email') }}</th>
                        <th>{{ __('users.role') }}</th>
                        <th>{{ __('users.phone') }}</th>
                        <th>{{ __('users.address') }}</th>
                        <th>{{ __('users.status') }}</th>
                        <th>{{ __('users.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($users) > 0)
                        @foreach($users as $value)
                        <tr>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->email }}</td>
                            <td>{{ $value->role }}</td>
                            <td>{{ $value->phone }}</td>
                            <td>{{ $value->address }}</td>
                            <td>
                                @if($value->active == 1)
                                    <a class="btn btn-sm btn-primary" href='{{ route("users.status", ["user" => $value->id]) }}'>{{ __('users.status-active') }}</a>
                                @else
                                    <a class="btn btn-sm btn-warning" href='{{ route("users.status", ["user" => $value->id]) }}'>{{ __('users.status-inactive') }}</a>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a data-bs-placement="top" title="{{ __('users.change-profile') }}" class="btn btn-sm btn-success tooltip-custom" href='{{ route("users.edit", ["user" => $value->id]) }}'>{{ __('website.edit') }}</a>
                                    <a data-bs-placement="top" title="{{ __('users.change-password') }}" class="btn btn-sm btn-primary btn-icon rounded-0 tooltip-custom" href='{{ route("users.changepassword", ["user" => $value->id]) }}'><i data-feather="feather"></i></a>
                                    <a data-bs-toggle="modal" data-bs-placement="top" title="{{ __('users.delete-user') }}" data-bs-target="#deleteModal"  class="btn btn-sm btn-danger tooltip-custom" data-name="{{$value->name}}" data-href='{{ route("users.delete", ["user" => $value->id]) }}'>{{ __('website.delete') }}</a>
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
        <h1 class="modal-title fs-5" id="deleteModalLabel">{{ __('users.delete-user') }}</h1>
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

            const datatablesSimple = document.getElementById('allDatatables');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple, {
                    columns: [
                        // {
                        //     select: 5,
                        //     sortable: false,
                        //     searchable: false
                        // },
                        {
                            select: 6,
                            sortable: false,
                            searchable: false
                        }
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/sr.json',
                    },
                });
            }
            
        });
    </script>

    <script>
        const deleteModal = document.getElementById('deleteModal')
        deleteModal.addEventListener('show.bs.modal', event => {
                // Button that triggered the modal
                const button = event.relatedTarget
                // Extract info from data-bs-* attributes
                const link = button.getAttribute('data-href');
                const userForDelete = button.getAttribute('data-name');
                // If necessary, you could initiate an AJAX request here
                // and then do the updating in a callback.
                //
                // Update the modal's content.
                const modalTitle = deleteModal.querySelector('.modal-title')
                const modalBody = deleteModal.querySelector('.modal-body')

                modalBody.textContent = "{{ __('users.delete-user-question') }} " + userForDelete + "?";

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

