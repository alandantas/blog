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
                <div class="info-box bg-pink hover-expand-effect">
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
                <div class="info-box bg-light-green hover-expand-effect">
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
        <div class="row clearfix">
            <!-- Task Info -->
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>TOP 5 POSTs POPULARES</h2>

                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover dashboard-task-infos">
                                <thead>
                                <tr>
                                    <th class="text-center">#Rank List</th>
                                    <th class="text-center">Título</th>
                                    <th class="text-center">Views</th>
                                    <th class="text-center">Favoritos</th>
                                    <th class="text-center">Comentários</th>
                                    <th class="text-center">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($popular_posts as $key=>$post)
                                    <tr>
                                        <td class="text-center">{{$key + 1}}</td>
                                        <td class="text-center">{{str_limit($post->title,30)}}</td>
                                        <td class="text-center">{{$post->view_count}}</td>
                                        <td class="text-center">{{$post->favorite_to_users_count}}</td>
                                        <td class="text-center">{{$post->comments_count}}</td>
                                        <td class="text-center">
                                            @if($post->status == true)
                                                <span class="label bg-green">Publicado</span>
                                            @else
                                                <span class="label bg-red">Pendente</span>
                                            @endif
                                        </td>
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

    <script src="{{asset('assets/backend/js/pages/index.js')}}"></script>

@endpush
