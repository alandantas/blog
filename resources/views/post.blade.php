@extends('layouts.frontend.app')

@section('title')
{{$post->title}}
@endsection

@push('css')
    <link rel="stylesheet" href="{{asset('assets/frontend/css/single-post/styles.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/single-post/responsive.css')}}">

    <style>
        .header-bg{
            height: 400px;
            width: 100%;
            background-image: url({{Storage::disk('public')->url('post/'.$post->image)}});
            background-size: cover;
        }
        .favorite_posts{
            color: red;
        
        }
    </style>

@endpush


@section('content')
    <div class="header-bg">

    </div><!-- slider -->

    <section class="post-area section">
        <div class="container">

            <div class="row">

                <div class="col-lg-8 col-md-12 no-right-padding">

                    <div class="main-post">

                        <div class="blog-post-inner">

                            <div class="post-info">

                                <div class="left-area">
                                    <a class="avatar" href="#"><img src="{{Storage::disk('public')->url('profile/'.$post->user->image)}}" alt="Profile Image"></a>
                                </div>

                                <div class="middle-area">
                                    <a class="name" href="#">Publicado por: <b>{{ $post->user->name}}</b></a>
                                    <h6 class="date">em: {{$post->created_at->format('l j F Y H:i:s')}}</h6>
                                </div>

                            </div><!-- post-info -->

                            <h3 class="title"><a href="#"><b>{{$post->title}}</b></a></h3>

                            <p class="para">
                                {!! html_entity_decode($post->body) !!}
                            </p>

                            <ul class="tags">
                                @foreach($post->tags as $tag)
                                    <li><a href="{{route('tag.posts',$tag->slug)}}">{{$tag->name}}</a></li>
                                @endforeach
                            </ul>
                        </div><!-- blog-post-inner -->

                        <div class="post-icons-area">
                            <ul class="post-icons">
                                <li>
                                    @guest
                                        <a href="javascript:void(0);" onclick="toastr.info('Para adicionar à sua lista de favoritos você precisa estar logado!','Atenção',{closeButton: true, progressBar: true,})"><i class="ion-heart"></i>{{$post->favorite_to_users->count()}}</a>
                                    @else
                                        <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{$post->id}}').submit();"
                                           class="{{ !Auth::user()->favorite_posts->where('pivot.post_id', $post->id)->count() == 0 ? 'favorite_posts' : ''}}">
                                            <i class="ion-heart"></i>{{$post->favorite_to_users->count()}}</a>
                                        <form id="favorite-form-{{$post->id}}" method="POST" action="{{route('post.favorite', $post->id)}}" style="display: none;">
                                            @csrf
                                        </form>
                                    @endguest
                                </li>
                                <li><a href="#"><i class="ion-chatbubble"></i>{{$post->comments()->count()}}</a></li>
                                <li><a href="#"><i class="ion-eye"></i>{{$post->view_count}}</a></li>
                            </ul>

                            <ul class="icons">
                                <li>Compartilhe: </li>
                                <li><a href="#"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="#"><i class="ion-social-pinterest"></i></a></li>
                            </ul>
                        </div>

                        <div class="post-info">

                            <div class="left-area">
                                <a class="avatar" href="#"><img src="{{Storage::disk('public')->url('profile/'.$post->user->image)}}" alt="Profile Image"></a>
                            </div>

                            <div class="middle-area">
                                <a class="name" href="#">Publicado por: <b>{{ $post->user->name}}</b></a>
                                <h6 class="date">em: {{$post->created_at->format('l j F Y H:i:s')}}</h6>
                            </div>

                        </div><!-- post-info -->


                    </div><!-- main-post -->
                </div><!-- col-lg-8 col-md-12 -->

                <div class="col-lg-4 col-md-12 no-left-padding">

                    <div class="single-post info-area">

                        <div class="sidebar-area about-area">
                            <h4 class="title"><b>Sobre o Autor</b></h4>
                            <p>{{$post->user->about}}</p>
                        </div>

                        <div class="tag-area">

                            <h4 class="title"><b>CATEGORIAS</b></h4>
                            <ul>
                                @foreach($post->categories as $category)
                                    <li><a href="{{route('category.posts',$category->slug)}}">{{$category->name}}</a></li>
                                @endforeach
                            </ul>

                        </div><!-- subscribe-area -->

                    </div><!-- info-area -->

                </div><!-- col-lg-4 col-md-12 -->

            </div><!-- row -->

        </div><!-- container -->
    </section><!-- post-area -->


    <section class="recomended-area section">
        <div class="container">
            <div class="row">
                @foreach($randomposts as $randompost)

                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><img src="{{Storage::disk('public')->url('post/'.$randompost->image)}}" alt="{{$randompost->title}}"></div>

                                <a class="avatar" href="#"><img src="{{Storage::disk('public')->url('profile/'.$randompost->user->image)}}" alt="Profile Image"></a>

                                <div class="blog-info">

                                    <h4 class="title"><a href="{{route('post.details',$randompost->slug)}}#"><b>{{$randompost->title}}</b></a></h4>

                                    <ul class="post-footer">
                                        <li>
                                            @guest
                                                <a href="javascript:void(0);" onclick="toastr.info('Para adicionar à sua lista de favoritos você precisa estar logado!','Atenção',{closeButton: true, progressBar: true,})"><i class="ion-heart"></i>{{$randompost->favorite_to_users->count()}}</a>
                                            @else
                                                <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{$randompost->id}}').submit();"
                                                   class="{{ !Auth::user()->favorite_posts->where('pivot.post_id', $randompost->id)->count() == 0 ? 'favorite_posts' : ''}}">
                                                    <i class="ion-heart"></i>{{$randompost->favorite_to_users->count()}}</a>
                                                <form id="favorite-form-{{$randompost->id}}" method="POST" action="{{route('post.favorite', $randompost->id)}}" style="display: none;">
                                                    @csrf
                                                </form>
                                            @endguest
                                        </li>
                                        <li><a href="#"><i class="ion-chatbubble"></i>{{$post->comments()->count()}}</a></li>
                                        <li><a href="#"><i class="ion-eye"></i>{{$randompost->view_count}}</a></li>
                                    </ul>

                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->

                @endforeach

            </div><!-- row -->

        </div><!-- container -->
    </section>

    <section class="comment-section">
        <div class="container">
            <h4><b>ADD COMENTÁRIO:</b></h4>
            <div class="row">

                <div class="col-lg-8 col-md-12">
                    <div class="comment-form">
                        @guest
                            <div class="alert alert-info">Para inserir um novo comentário é necessário que faça login primeiro. <a href="{{route('login')}}" class="alert-link">Login</a> </div>
                        @else
                            <form method="post" action="{{route('comment.store', $post->id)}}">
                                @csrf
                                <div class="row">

                                    <div class="col-sm-12">
                                        <textarea name="comment" rows="2" class="text-area-messge form-control"
                                                  placeholder="Digite seu comentário" aria-required="true" aria-invalid="false"></textarea >
                                    </div><!-- col-sm-12 -->
                                    <div class="col-sm-12">
                                        <button class="submit-btn" type="submit" id="form-submit"><b>COMENTAR</b></button>
                                    </div><!-- col-sm-12 -->

                                </div><!-- row -->
                            </form>
                         @endguest
                    </div><!-- comment-form -->

                    <h4><b>COMENTÁRIOS ({{$post->comments()->count()}})</b></h4>
                    @if($post->comments->count() > 0)
                        @foreach($post->comments as $comment)
                            <div class="commnets-area ">
                                <div class="comment">
                                    <div class="post-info">
                                        <div class="left-area">
                                            <a class="avatar" href="#"><img src="{{Storage::disk('public')->url('profile/'.$comment->user->image)}}" alt="Profile Image"></a>
                                        </div>
                                        <div class="middle-area">
                                            <a class="name" href="#">Por: <b>{{$comment->user->name}}</b></a>
                                            <h6 class="date">em: {{$comment->created_at->diffForHumans()}}</h6>

                                        </div>
                                        <div class="right-area">
                                            <h5 class="reply-btn" ><a href="#"><b>RESPONDER</b></a></h5>
                                        </div>
                                    </div><!-- post-info -->
                                    <p>{{$comment->comment}}</p>
                                </div>

                            </div><!-- commnets-area -->
                        @endforeach
                    @else
                        <div class="commnets-area">
                            <div class="alert alert-info">Não há comentários! Você pode ser o primeiro a comentar essa postagem <strong>:)</strong></div>
                        </div>
                    @endif
                </div><!-- col-lg-8 col-md-12 -->
            </div><!-- row -->
        </div><!-- container -->
    </section>
@endsection

@push('js')

@endpush