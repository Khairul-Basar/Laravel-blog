@extends('layouts.backend.app')

@section('title','Authors')

@push('css')
    <!-- JQuery DataTable Css -->
    <link href=" {{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css') }}" rel="stylesheet">
    @endpush



@section('content')
    <div class="container-fluid">

        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            ALL CATEGORYS TABLE
                            <span class="badge bg-green">{{ $authors->count() }}</span>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Posts</th>
                                    <th>Favorite Posts</th>
                                    <th>Comments</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Posts</th>
                                    <th>Favorite Posts</th>
                                    <th>Comments</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($authors as $key=>$author)
                                        <tr>
                                            <td>{{ $key +1 }}</td>
                                            <td><strong>{{ $author->name }}</strong></td>
                                            <td><span class="badge bg-cyan">{{ $author->posts_count }}</span></td>
                                            <td><span class="badge bg-cyan">{{ $author->favorite_posts_count }}</span></td>
                                            <td><span class="badge bg-cyan">{{ $author->comments_count }}</span></td>
                                            <td>{{ $author->created_at->toDateString() }}</td>
                                            <td class="text-center">

                                                <button class="btn btn-danger waves-effect" type="button" onclick="deleteAuthors({{ $author->id }})">
                                                    <i class="material-icons">delete</i>
                                                </button>

                                                <form id="delete-form-{{ $author->id }}" action="{{ route('admin.author.destroy',$author->id) }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Exportable Table -->
    </div>
    @endsection



@push('js')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js') }} "></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>

    <!-- Custom Js -->
    <script src=" {{ asset('assets/backend/js/pages/tables/jquery-datatable.js') }}"></script>

    <!-- sweet alert Js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.3.17/dist/sweetalert2.all.min.js"></script>


    <script type="text/javascript">
        function deleteAuthors(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>

    @endpush

