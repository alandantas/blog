@extends('layouts.backend.app')

@section('title','Comentários')

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
                            Comentários
                            <span class="badge bg-teal">{{$myComments->count()}}</span>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-responsive table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">Comentário</th>
                                    <th class="text-center">Post</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th class="text-center">Comentário</th>
                                    <th class="text-center">Post</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @forelse($comments as $comment)
                                    <tr>
                                        <td>
                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="#">
                                                        <img class="media-object" src="{{ Storage::disk('public')->url('profile/'.$comment->user->image) }}" width="64" height="64">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h4 class="media-heading">{{ $comment->user->name }} <small>{{ $comment->created_at->diffForHumans() }}</small>
                                                    </h4>
                                                    <p>{{ $comment->comment }}</p>
                                                    <a target="_blank" href="{{ route('post.details',$comment->post->slug.'#comments') }}">Responder</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="media">
                                                <div class="media-right">
                                                    <a target="_blank" href="{{ route('post.details',$comment->post->slug) }}">
                                                        <img class="media-object" src="{{ Storage::disk('public')->url('post/'.$comment->post->image) }}" width="64" height="64">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <a target="_blank" href="{{ route('post.details',$comment->post->slug) }}">
                                                        <h4 class="media-heading">{{ str_limit($comment->post->title,'40') }}</h4>
                                                    </a>
                                                    <p>by <strong>{{ $comment->post->user->name }}</strong></p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger waves-effect btn-xs" onclick="deleteComment({{ $comment->id }})">
                                                <i class="material-icons">delete</i>
                                            </button>
                                            <form id="delete-form-{{ $comment->id }}" method="POST" action="{{ route('author.comment.destroy',$comment->id) }}" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert bg-teal text-center">
                                        Não há comentários !!
                                    </div>
                                @endforelse
                                </tbody>
                            </table>
                            {{$comments->links()}}
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
        function deleteComment(id) {
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
                confirmButtonText: 'Sim, excluir comentário!',
                cancelButtonText: 'Cancelar!',
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