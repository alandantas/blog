@extends('layouts.backend.app')

@section('title', 'Posts')

@push('css')
    <!-- Bootstrap Select Css -->
    <link href="{{asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />

@endpush

@section('content')
    <div class="container-fluid">
        <form action="{{route('author.post.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
        <div class="row clearfix">
            <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            ADD NOVO POST
                        </h2>
                    </div>
                    <div class="body">
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" id="title" class="form-control" name="title">
                                <label class="form-label">Título do Post</label>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <label for="image">Imagem em Destaque</label>
                                <input type="file" name="image" class="btn bg-teal btn-block btn-lg waves-effect">
                        </div>

                        <div class="form-group form-float">
                            <input type="checkbox" id="publish" class="filled-in" name="status" value="1">
                            <label for="publish"><b>Publicar ?</b></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                CATEGORIAS E TAG's
                            </h2>
                        </div>
                        <div class="body">
                            <div class="form-group form-float">
                                <div class="form-line {{$errors->has('categories')? 'focused error' : ''}}">
                                    <label for="category">Categoria</label>
                                    <select name="categories[]" id="category" class="form-control show-tick" data-live-search="true" multiple title="Selecionar Categoria">
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-float">
                                <div class="form-line {{$errors->has('tags')? 'focused error' : ''}}">
                                    <label for="tag">TAG</label>
                                    <select name="tags[]" id="tag" class="form-control show-tick" data-live-search="true" multiple title="Selecionar Tag's">
                                        @foreach($tags as $tag)
                                            <option value="{{$tag->id}}">{{$tag->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            TEXTO DA POSTAGEM
                        </h2>
                    </div>
                    <div class="body">
                        <div class="form-group form-float">
                            <div class="form-group">
                            <textarea name="body" id="tinymce"></textarea>
                                <br>

                                <a href="{{route('author.post.index')}}" class="btn btn-danger waves-effect">
                                    <i class="material-icons">highlight_off</i>
                                    <span>CANCELAR</span>
                                </a>

                                <button type="submit" class="btn btn-success waves-effect">
                                    <i class="material-icons">assignment_turned_in</i>
                                    <span>SALVAR POST</span>
                                </button>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>

@endsection

@push('js')
    <!-- Select Plugin Js -->
    <script src="{{asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

    <!-- TinyMCE -->
    <script src="{{asset('assets/backend/plugins/tinymce/tinymce.js')}}"></script>

    <script>
        $(function () {
            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                language_url : '{{asset('assets/backend/plugins/tinymce/langs/pt_BR.js')}}',
                theme: "modern",
                image_caption: true,
                image_dimensions: false,
                image_class_list: [
                    {title: 'Responsive', value: 'img-responsive'}
                ],
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
    </script>
@endpush