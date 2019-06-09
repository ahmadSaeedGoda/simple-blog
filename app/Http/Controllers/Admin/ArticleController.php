<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Models\Category;
use App\Http\Requests\StoreArticle;
use App\Http\Requests\UpdateArticle;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class ArticleController extends Controller
{

    protected $model_article;
    protected $per_page = 500;

    /**
     * ArticleController constructor.
     *
     * @param Article $model_article
     */
    public function __construct(Article $model_article, $per_page = 500)
    {
        $this->per_page = $per_page;
        $this->model_article = new Repository($model_article, $this->per_page);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr_articles = $this->model_article->with('category');
        $int_articles_count = $this->model_article->count();
        return view('admin.article.index', compact('arr_articles', 'int_articles_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arr_categories = (new Repository(new Category))->allWithoutPagination();
        return view('admin.article.create', compact('arr_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\StoreArticle  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticle $request)
    {
        // The incoming request is valid...
    
        // Retrieve the validated input data...
        $validated = $request->validated();
        $slug = str_slug($request->title);
        $obj_article = $this->model_article->create();
        $obj_article->title = $request->title;
        $obj_article->slug = $slug;
        $obj_article->body = $request->body;
        $obj_article->is_published = ($request->is_published)? true:false;
        $obj_article->category_id = $request->category_id;
        $obj_article->save();

        Toastr::success('Article Successfully Saved :)','Success');
        return redirect()->route('admin.article.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $model_article
     * @return \Illuminate\Http\Response
     */
    public function show($int_id)
    {
        $obj_article = $this->model_article->show($int_id);
        $arr_article_comments = $obj_article->comments()->with('user')->paginate($this->per_page);
        $int_article_comments_count = $obj_article->comments->count();
        return view('admin.article.show',compact(
            'obj_article', 'arr_article_comments',
            'int_article_comments_count'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $model_article
     * @return \Illuminate\Http\Response
     */
    public function edit($int_id)
    {
        $obj_article = $this->model_article->show($int_id);
        $arr_categories = (new Repository(new Category))->all();
        return view('admin.article.edit', compact('obj_article', 'arr_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Requests\StoreArticle  $request
     * @param  \App\Models\Article  $model_article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticle $request, $int_id)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
        $slug = str_slug($request->title);

        $obj_article = $this->model_article->show($int_id);
        $obj_article->title = $request->title;
        $obj_article->slug = $slug;
        $obj_article->body = $request->body;
        $obj_article->is_published = ($request->is_published)? true:false;
        $obj_article->category_id = $request->category_id;
        $obj_article->save();

        Toastr::success('Article Successfully Updated :)','Success');
        return redirect()->route('admin.article.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $model_article
     * @return \Illuminate\Http\Response
     */
    public function destroy($int_id)
    {
        $obj_article = $this->model_article->show($int_id);
        $obj_article->delete();
        Toastr::success('Article Successfully Deleted :)','Success');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $model_article
     * @return \Illuminate\Http\Response
     */
    public function publish($int_id)
    {
        $obj_article = $this->model_article->show($int_id);
        if ($obj_article->is_published == false)
        {
            $obj_article->is_published = true;
            $obj_article->save();
            Toastr::success('Article Successfully Published :)','Success');
        } else {
            Toastr::info('This Article is already Published','Info');
        }
        return redirect()->back();
    }
}
