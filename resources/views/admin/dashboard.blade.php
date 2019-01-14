@extends('layouts.backend.app')

@section('title','Dashboard')

@push('css')

@endpush

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>DASHBOARD</h2>
        </div>

        <!-- Widgets -->
        <div class="row clearfix">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-green hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">library_books</i>
                    </div>
                    <div class="content">
                        <div class="text">TOTAL POSTs</div>
                        <div class="number count-to" data-from="0" data-to="{{$posts->count()}}" data-speed="15" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-cyan hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">favorite</i>
                    </div>
                    <div class="content">
                        <div class="text">TOTAL FAVORITOS</div>
                        <div class="number count-to" data-from="0" data-to="{{Auth::user()->favorite_posts()->count()}}" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-red hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">announcement</i>
                    </div>
                    <div class="content">
                        <div class="text">POSTs PENDENTES</div>
                        <div class="number count-to" data-from="0" data-to="{{$total_pending_posts}}" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-orange hover-expand-effect">
                    <div class="icon">
                        <i class="material-icons">visibility</i>
                    </div>
                    <div class="content">
                        <div class="text">TOTAL VIEWs</div>
                        <div class="number count-to" data-from="0" data-to="{{$all_views}}" data-speed="1000" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Widgets -->

        <!-- Widgets -->
        <div class="row clearfix">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
                <div class="info-box bg-pink hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">apps</i>
                    </div>
                    <div class="content">
                        <div class="text">CATEGORIAS</div>
                        <div class="number count-to" data-from="0" data-to="{{$category_count}}" data-speed="15" data-fresh-interval="20"></div>
                    </div>
                </div>
                <div class="info-box bg-blue-grey hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">label</i>
                    </div>
                    <div class="content">
                        <div class="text">TAGs</div>
                        <div class="number count-to" data-from="0" data-to="{{$tag_count}}" data-speed="15" data-fresh-interval="20"></div>
                    </div>
                </div>
                <div class="info-box bg-purple hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">account_circle</i>
                    </div>
                    <div class="content">
                        <div class="text">TOTAL AUTORES</div>
                        <div class="number count-to" data-from="0" data-to="{{$author_count}}" data-speed="15" data-fresh-interval="20"></div>
                    </div>
                </div>
                <div class="info-box bg-deep-purple hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">fiber_new</i>
                    </div>
                    <div class="content">
                        <div class="text">NOVOS AUTORES</div>
                        <div class="number count-to" data-from="0" data-to="{{$author_count}}" data-speed="15" data-fresh-interval="20"></div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-9">
                <div class="card">
                    <div class="header">
                        <h2>POSTs MAIS POPULARES</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Título</th>
                                    <th>Autor</th>
                                    <th>Views</th>
                                    <th>Favoritos</th>
                                    <th>Comentários</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($popular_posts as $key=>$post)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{str_limit($post->title,'20')}}</td>
                                            <td>{{$post->user->name}}</td>
                                            <td>{{$post->view_count}}</td>
                                            <td>{{$post->favorite_to_users_count}}</td>
                                            <td>{{$post->comments_count}}</td>
                                            <td>
                                                @if($post->status == true)
                                                    <span class="label bg-green">Publicado</span>
                                                @else
                                                    <span class="label bg-red">Pendente</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-xs btn-primary waves-effect" target="_blank" href="{{route('post.details',$post->slug)}}">Visualizar</a>

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
        <!-- #END# Widgets -->

        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>TOP 10 AUTORES ATIVOS</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                <tr>
                                    <th>Rank</th>
                                    <th>Nome</th>
                                    <th>Post</th>
                                    <th>Comentários</th>
                                    <th>Favoritos</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($active_authors as $key=>$author)
                                        <tr>
                                            <td>{{$key +1}}</td>
                                            <td>{{$author->name}}</td>
                                            <td>{{$author->posts_count}}</td>
                                            <td>{{$author->comments_count}}</td>
                                            <td>{{$author->favorite_posts_count}}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Task Info -->
        </div>
    </div>

@endsection

@push('js')
    <!-- Jquery CountTo Plugin Js -->
    <script src="{{asset('assets/backend/plugins/jquery-countto/jquery.countTo.js')}}"></script>

    <!-- Morris Plugin Js -->
    <script src="{{asset('assets/backend/plugins/raphael/raphael.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/morrisjs/morris.js')}}"></script>

    <!-- ChartJs -->
    <script src="{{asset('assets/backend/plugins/chartjs/Chart.bundle.js')}}"></script>

    <!-- Flot Charts Plugin Js -->
    <script src="{{asset('assets/backend/plugins/flot-charts/jquery.flot.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/flot-charts/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/flot-charts/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/flot-charts/jquery.flot.categories.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/flot-charts/jquery.flot.time.js')}}"></script>

    <!-- Sparkline Chart Plugin Js -->
    <script src="{{asset('assets/backend/plugins/jquery-sparkline/jquery.sparkline.js')}}"></script>

    <script src="{{asset('assets/backend/js/pages/index.js')}}"></script>

@endpush
