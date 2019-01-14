@extends('layouts.backend.app')

@section('title', 'Posts')

@push('css')

@endpush

@section('content')
    <div class="container-fluid">
        <a href="{{route('admin.post.index')}}" class="btn btn-danger waves-effect">VOLTAR</a>
        @if($post->is_approved == false)
            <button type="button" class="btn btn-success waves-effect pull-right" onclick="approvePost({{$post->id}})">
                <i class="material-icons">done</i>
                <span>Aprovar</span>
            </button>
            <form method="POST" action="{{route('admin.post.approve', $post->id)}}" id="approval-form" style="display: none;">
                @csrf
                @method('PUT')
            </form>
        @else
            <button type="button" class="btn btn-success waves-effect pull-right" disabled>
                <i class="material-icons">done</i>
                <span>Aprovado</span>
            </button>
        @endif
        </br>
        </br>
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            {{$post->title}}
                            <small>Postado por: <strong><a href="">{{$post->user->name}}</a></strong> em {{$post->created_at->format('l j F Y H:i:s')}}</small>
                        </h2>
                    </div>
                    <div class="body container-fluid">
                        {!!$post->body !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header bg-cyan">
                        <h2 class="text-center">
                            CATEGORIAS
                        </h2>
                    </div>
                    <div class="body">
                        @foreach($post->categories as $category)
                            <span class="label bg-cyan">{{$category->name}}</span>
                        @endforeach
                    </div>
                </div>
                <div class="card">
                    <div class="header bg-green">
                        <h2 class="text-center">
                            TAG's
                        </h2>
                    </div>
                    <div class="body">
                        @foreach($post->tags as $tag)
                            <span class="label bg-green">{{$tag->name}}</span>
                        @endforeach
                    </div>
                </div>
                <div class="card">
                    <div class="header bg-amber">
                        <h2 class="text-center">
                            IMAGEM DESTACADA
                        </h2>
                    </div>
                    <div class="body">
                        <img class="img-responsive thumbnail" src="{{ Storage::disk('public')->url('post/'.$post->image)}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <!-- Select Plugin Js -->
    <script src="{{asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

    <!-- TinyMCE -->
    <script src="{{asset('assets/backend/plugins/tinymce/tinymce.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.9/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript">
        $(function () {
            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                language_url : '{{asset('assets/backend/plugins/tinymce/langs/pt_BR.js')}}',
                theme: "modern",
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{asset('assets/backend/plugins/tinymce')}}';
        });
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