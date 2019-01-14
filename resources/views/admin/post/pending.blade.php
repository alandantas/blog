@extends('layouts.backend.app')

@section('title','Aprovar POST')

@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">

@endpush

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <a class="btn btn-primary waves-effect" href="{{route('admin.post.create')}}">
                <i class="material-icons">add</i>
                <span>ADD NOVO POST</span>
            </a>
        </div>
        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            POST's pendentes de aprovação
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
                                    <th class="text-center">Views</th>
                                    <th class="text-center">Aprovado</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Data|Criação</th>
                                    {{--<th class="text-center">Última Alteração</th>--}}
                                    <th class="text-center" width="160">Ações</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Título</th>
                                    <th class="text-center">Autor</th>
                                    <th class="text-center">Views</th>
                                    <th class="text-center">Aprovado</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Data|Criação</th>
                                    {{--<th class="text-center">Última Alteração</th>--}}
                                    <th class="text-center" width="250">Ações</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @forelse($posts as $post)
                                    <tr>
                                        <td class="text-center">{{$post->id}}</td>
                                        <td class="text-center">{{str_limit($post->title,'10')}}</td>
                                        <td class="text-center">{{$post->user->name}}</td>
                                        <td class="text-center">{{$post->view_count}}</td>
                                        <td class="text-center">
                                            @if($post->is_approved == true)
                                                <span class="badge bg-green">Aprovado</span>
                                            @else
                                                <span class="badge bg-orange">Pendente</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($post->status == true)
                                                <span class="badge bg-green">Publicado</span>
                                            @else
                                                <span class="badge bg-orange">Pendente</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{$post->created_at->format('d/m/Y')}}</td>
                                        <td class="text-center">
                                            @if($post->is_approved == false)
                                                <button type="button" class="btn btn-success waves-effect btn-xs" onclick="approvePost({{$post->id}})">
                                                    <i class="material-icons">done</i>
                                                    <span>Aprovar</span>
                                                </button>
                                                <form method="POST" action="{{route('admin.post.approve', $post->id)}}" id="approval-form" style="display: none;">
                                                    @csrf
                                                    @method('PUT')
                                                </form>
                                            @endif
                                            <a class="btn btn-info waves-effect btn-xs" href="{{route('admin.post.show',$post->id)}}">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                            <a class="btn btn-info waves-effect btn-xs" href="{{route('admin.post.edit',$post->id)}}">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button class="btn btn-danger waves-effect btn-xs" type="button" onclick="deletePost({{$post->id}})">
                                                <i class="material-icons">delete</i>
                                            </button>
                                            <form id="delete-form-{{$post->id}}" action="{{route('admin.post.destroy',$post->id)}}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.9/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript">
        function deletePost(id) {
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
        function approvePost(id) {
            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            })
            swalWithBootstrapButtons({
                title: 'Deseja aprovar esse POST?',
                text: "O POST ficará visível para todos!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aprovar POST!',
                cancelButtonText: 'Aprovar mais tarde!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                event.preventDefault();
                document.getElementById('approval-form').submit();

            } else if (
                // Read more about handling dismissals
            result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                    'Cancelado',
                    'Aprovação Cancelada :(',
                    'error'
                )
            }
        })
        }
    </script>

@endpush