@extends('layouts.backend.app')

@section('title','Article')

@push('css')
    <!-- Bootstrap Select Css -->
    <link href="{{ asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Vertical Layout | With Floating Label -->
        <form action="{{ route('admin.article.store') }}" method="POST">
            @csrf
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               ADD NEW Article
                            </h2>
                        </div>
                        <div class="body">
                                <div class="form-group form-float">
                                    <div class="form-line">
                                        <input type="text" id="title" class="form-control" name="title" value="{{ old('title') }}">
                                        <label class="form-label">Article Title</label>
                                    </div>
                                </div>

                            <div class="form-group">
                                <input type="checkbox" id="publish" class="filled-in" name="is_published" value="1" {{ old('is_published')? 'checked' : '' }}>
                                <label for="publish">Publish</label>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Categories
                            </h2>
                        </div>
                        <div class="body">
                            <div class="form-group form-float">
                                <div class="form-line {{ $errors->has('category_id') ? 'focused error' : '' }}">
                                    <label for="category">Select Category</label>
                                    <select name="category_id" id="category" class="form-control show-tick" data-live-search="true">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $obj_category)
                                            <option value="{{ $obj_category->id }}">{{ $obj_category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <a  class="btn btn-danger m-t-15 waves-effect" href="{{ route('admin.article.index') }}">BACK</a>
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               BODY
                            </h2>
                        </div>
                        <div class="body">
                            <textarea id="tinymce" name="body" class="form-control">{{ old('body') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <!-- Select Plugin Js -->
    <script src="{{ asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>
    <!-- TinyMCE -->
    <script src="{{ asset('assets/backend/plugins/tinymce/tinymce.js') }}"></script>
    <script>
    </script>

@endpush