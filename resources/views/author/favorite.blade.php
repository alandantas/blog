@extends('layouts.backend.app')

@section('title','Favoritos')

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
                            Meus POST's Favoritos
                            <span class="badge bg-teal">{{$posts->count()}}</span>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Título</th>
                                    <th class="text-center">Autor</th>
                                    <th class="text-center">Favoritos</th>
                                    <th class="text-center">Comentários</th>
                                    <th class="text-center">Views</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Título</th>
                                    <th class="text-center">Autor</th>
                                    <th class="text-center">Favoritos</th>
                                    <th class="text-center">Comentários</th>
                                    <th class="text-center">Views</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @forelse($posts as $post)
                                    <tr>
                                        <td class="text-center">{{$post->id}}</td>
                                        <td class="text-center">{{str_limit($post->title,'10')}}</td>
                                        <td class="text-center">{{$post->user->name}}</td>
                                        <td class="text-center">{{$post->favorite_to_users->count()}}</td>
                                        <td class="text-center"></td>
                                        <td class="text-center">{{$post->view_count}}</td>
                                        <td class="text-center">

                                            <a href="{{ route('author.post.show',$post->id) }}" class="btn btn-info waves-effect btn-xs">
                                                <i class="material-icons">visibility</i>
                                            </a>

                                            <button class="btn btn-danger waves-effect btn-xs" type="button" onclick="removePost({{ $post->id }})">
                                                <i class="material-icons">delete</i>
                                            </button>
                                            <form id="remove-form-{{ $post->id }}" action="{{ route('post.favorite',$post->id) }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert bg-teal text-center">
                                        Você não possui POST's pendentes de aprovação !!
                                    </div>
                                @endforelse
                                </tbody>
                            </table>
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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
    <script type="text/javascript">
        function removePost(id) {
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
                confirmButtonText: 'Sim, remover da minha lista!',
                cancelButtonText: 'Cancelar!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                event.preventDefault();
                document.getElementById('remove-form-'+id).submit();

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