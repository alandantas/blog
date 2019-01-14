@extends('layouts.backend.app')

@section('title','Categorias')

@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">

@endpush

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <a class="btn btn-primary waves-effect" href="{{route('admin.category.create')}}">
                <i class="material-icons">add</i>
                <span>ADD NOVA CATEGORIA</span>
            </a>
        </div>
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            TOTAL DE CATEGORIAS
                            <span class="badge bg-teal">{{$categories->count()}}</span>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Nome</th>
                                    <th class="text-center">Total|POST</th>
                                    <th class="text-center">Imagem</th>
                                    <th class="text-center">Data|Criação</th>
                                    <th class="text-center">Última Alteração</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Nome</th>
                                    <th class="text-center">Total|POST</th>
                                    <th class="text-center">Imagem</th>
                                    <th class="text-center">Data|Criação</th>
                                    <th class="text-center">Última Alteração</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td class="text-center">{{$category->id}}</td>
                                            <td class="text-center">{{$category->name}}</td>
                                            <td class="text-center">{{$category->posts->count() }}</td>
                                            <td class="text-center" width="100"><img class="img-responsive thumbnail" src="{{ Storage::disk('public')->url('category/'.$category->image)}}" alt=""></td>
                                            <td class="text-center">{{$category->created_at->format('d/m/Y - H:i:s')}}</td>
                                            <td class="text-center">{{$category->updated_at->format('d/m/Y - H:i:s')}}</td>
                                            <td class="text-center">
                                                <a class="btn btn-info waves-effect btn-xs" href="{{route('admin.category.edit',$category->id)}}">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <button class="btn btn-danger waves-effect btn-xs" type="button" onclick="deleteCategory({{$category->id}})">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                                <form id="delete-form-{{$category->id}}" action="{{route('admin.category.destroy',$category->id)}}" method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <p>{!!$categories->links() !!}</p>
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
        function deleteCategory(id) {
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
                    confirmButtonText: 'Sim, deletar isto!',
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