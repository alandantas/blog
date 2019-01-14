@extends('layouts.backend.app')

@section('title', 'Categorias')

@push('css')

@endpush

@section('content')
    <div class="container-fluid">
            <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            EDIÇÃO DE CATEGORIAS
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <form action="{{route('admin.category.update',$category->id)}}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            @method('PUT')
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" id="name" class="form-control" name="name" value="{{$category->name}}">
                                    <label class="form-label">Nome da Categoria </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="file" name="image" class="btn btn-warning waves-effect" value="{{$category->image}}">
                            </div>
                            <div>
                                <input type="hidden" name="_method" value="put">
                            </div>

                            <a class="btn btn-danger m-t-15 waves-effect" href="{{route('admin.category.index')}}">Cancelar</a>
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')

@endpush