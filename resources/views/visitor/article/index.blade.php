@extends('layouts.frontend.app')

@section('title','Articles')

@push('css')
    <link href="{{ asset('assets/frontend/css/category/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/frontend/css/category/responsive.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="center-text">
        <h3 class="title"><b>{{ ($int_articles_count==1)? "$int_articles_count ARTICLE" : "$int_articles_count ARTICLES"}}</b></h3>
    </div><!-- slider -->

    <section class="blog-area section">
        <div class="container">
            <h2>Filter By Category</h2>
            <br>
            <form method="POST" action="{{ route('visitor.articles.category') }}">
                @csrf
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <div class="form-group form-float">
                            <div class="form-line {{ $errors->has('category_id') ? 'focused error' : '' }}">
                                <select name="category_id" id="category" class="form-control show-tick" data-live-search="true">
                                    <option value="">Select Category</option>
                                    @foreach($arr_categories as $obj_category)
                                        @if(!empty($obj_selected_category)&&$obj_selected_category->id == $obj_category->id)
                                            <option value="{{ $obj_category->id }}" selected>{{ $obj_category->name }}</option>
                                        @else
                                            <option value="{{ $obj_category->id }}">{{ $obj_category->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                    </div>
                </div>
            </form>

            <div class="row">
                @foreach($arr_articles as $obj_article)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">
                                <div class="blog-info">
                                    <h4 class="title">
                                        <a href="{{ route('visitor.article.show', $obj_article->id) }}">
                                            <b>{{ $obj_article->title }}</b>
                                        </a>
                                    </h4>
                                    <ul class="post-footer">
                                        <li><a href="#"><i class="ion-chatbubble"></i>{{ $obj_article->comments->count() }}</a></li>
                                    </ul>
                                </div><!-- blog-info -->
                            </div><!-- single-post -->
                        </div><!-- card -->
                    </div><!-- col-lg-4 col-md-6 -->
                @endforeach
            </div><!-- row -->
            {{ $arr_articles->links() }}
        </div><!-- container -->
    </section><!-- section -->
@endsection

@push('js')

@endpush