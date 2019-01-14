@extends('layouts.backend.app')

@section('title','Autores')

@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">

@endpush

@section('content')
    <div class="container-fluid">
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            AUTORES
                            <span class="badge bg-teal">{{$authors->count()}}</span>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Nome</th>
                                    <th class="text-center">POSTs</th>
                                    <th class="text-center">Comentários</th>
                                    <th class="text-center">POSTs Favoritos</th>
                                    <th class="text-center">Data|Criação</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Nome</th>
                                    <th class="text-center">POSTs</th>
                                    <th class="text-center">Comentários</th>
                                    <th class="text-center">POSTs Favoritos</th>
                                    <th class="text-center">Data|Criação</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($authors as $author)
                                        <tr>
                                            <td class="text-center">{{$author->id}}</td>
                                            <td class="text-center">{{$author->name}}</td>
                                            <td class="text-center">{{$author->posts_count }}</td>
                                            <td class="text-center">{{$author->comments_count }}</td>
                                            <td class="text-center">{{$author->favorite_posts_count }}</td>
                                            <td class="text-center">{{$author->created_at}}</td>
                                            <td class="text-center">
                                                <button class="btn btn-danger waves-effect btn-xs" type="button" title="Deletar" onclick="deleteAuthor({{$author->id}})">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                                <form id="delete-form-{{$author->id}}" action="{{route('admin.author.destroy',$author->id)}}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <p>{!!$authors->links() !!}</p>
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
    <script src="{{asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/backend//plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

    <script src="{{asset('assets/backend/js/pages/tables/jquery-datatable.js')}}"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.9/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript">
        function deleteAuthor(id) {
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                    title: 'Você tem certeza ?',
                    text: "Você não poderá reverter isto!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, deletar!',
                    cancelButtonText: 'Não, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        event.preventDefault();
                        document.getElementById('delete-form-'+id).submit();

                } else if (
                    // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                        'Cancelado',
                        'Exclusão cancelada :)',
                        'error'
                    )
                }
             })
        }
    </script>
@endpush