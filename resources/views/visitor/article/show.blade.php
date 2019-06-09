@extends('layouts.frontend.app')

@section('title')
    {{ $obj_article->title }}
@endsection

@push('css')
    <link href="{{ asset('assets/frontend/css/single-post/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frontend/css/single-post/responsive.css') }}" rel="stylesheet">
@endpush

@section('content')
    <!-- slider -->
    <section class="post-area section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12 no-right-padding">
                    <div class="main-post">
                        <div class="blog-post-inner">
                            <div class="post-info">
                                <h6 class="date">Posted on {{ $obj_article->created_at->diffForHumans() }}</h6>
                            </div><!-- post-info -->
                            <h3 class="title"><a href="#"><b>{{ $obj_article->title }}</b></a></h3>
                            <div class="para">
                                {!! html_entity_decode($obj_article->body) !!}
                            </div>
                        </div><!-- blog-post-inner -->
                    </div><!-- main-post -->
                </div><!-- col-lg-8 col-md-12 -->
                <div class="col-lg-4 col-md-12 no-left-padding">
                    <div class="single-post info-area">
                        <div class="sidebar-area about-area">
                        </div>
                        <div class="tag-area">
                            <h4 class="title"><b>CATEGORY</b></h4>
                            <ul>
                                <li>
                                    <span>
                                        {{ $obj_article->category->name }}
                                    </span>
                                </li>
                            </ul>
                            <form id="getArticlesByCategory-form" method="POST" action="{{ route('visitor.articles.category') }}" style="display: none;">
                                @csrf
                                <input type="hidden" id="category_id" name="category_id" value="{{$obj_article->category_id}}">
                            </form>
                        </div><!-- subscribe-area -->
                    </div><!-- info-area -->
                </div><!-- col-lg-4 col-md-12 -->
            </div><!-- row -->
        </div><!-- container -->
    </section><!-- post-area -->

    <section class="comment-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="comment-form">
                        @guest
                            <p>For post a new comment. You need to login first. <a href="{{ route('login') }}">Login</a></p>
                        @else
                            <form method="post" action="{{ route('visitor.comment.store', $obj_article->id) }}">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="hidden" id="user_id" name="user_id" value="{{Auth::id()}}">
                                        <input type="hidden" id="article_id" name="article_id" value="{{$obj_article->id}}">
                                        <textarea name="comment" rows="2" class="text-area-messge form-control"
                                                  placeholder="Enter your comment" aria-required="true" aria-invalid="false"></textarea >
                                    </div><!-- col-sm-12 -->
                                    <div class="col-sm-12">
                                        <button class="submit-btn" type="submit" id="form-submit"><b>Comment</b></button>
                                    </div><!-- col-sm-12 -->
                                </div><!-- row -->
                            </form>
                        @endguest
                    </div><!-- comment-form -->
                    <h4><b>COMMENTS({{ $int_article_comments_count }})</b></h4>
                    @if($int_article_comments_count > 0)
                        @foreach($obj_article->comments as $comment)
                            <div class="commnets-area ">
                                <div class="comment">
                                    <div class="post-info">
                                        <span class="name" href="#"><b>{{ $comment->user->full_name }}</b></span>
                                        <h6 class="date">on {{ $comment->created_at->diffForHumans()}}</h6>
                                    </div><!-- post-info -->
                                    <p>{{ $comment->comment }}</p>
                                </div>
                            </div><!-- commnets-area -->
                        @endforeach
                    @else
                    <div class="commnets-area ">
                        <div class="comment">
                            <p>No Comment yet. Be the first :)</p>
                    </div>
                    </div>
                    @endif
                </div><!-- col-lg-8 col-md-12 -->
            </div><!-- row -->
        </div><!-- container -->
    </section>
    
    <section class="recomended-area section">
        <div class="container">
            <div class="row">
                @foreach($random_articles as $obj_random_article)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">
                                <div class="blog-info">
                                    <h4 class="title"><a href="{{ route('visitor.article.show', $obj_random_article->id) }}"><b>{{ $obj_random_article->title }}</b></a></h4>
                                    <ul class="post-footer">
                                        <li><a href="#"><i class="ion-chatbubble"></i>{{ $obj_random_article->comments->count() }}</a></li>
                                    </ul>
                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->
                @endforeach
            </div><!-- row -->
        </div><!-- container -->
    </section>
@endsection

@push('js')

@endpush