<?php

namespace App\Http\Controllers\Visitor;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
    public function index(Request $request)
    {
        $arr_articles = $this->model_article->getModel()->Published()
            ->latest()->paginate($this->per_page);
        $arr_categories = (new Repository(new Category))->allWithoutPagination();
        $int_articles_count = $this->model_article->getModel()->Published()->count();
        return view('visitor.article.index', compact(
            'arr_articles', 'int_articles_count',
            'arr_categories'
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show($int_id)
    {
        $obj_article = $this->model_article->show($int_id);
        $arr_article_comments = $obj_article->comments()->with('user')->paginate($this->per_page);
        $int_article_comments_count = $obj_article->comments->count();

        $random_articles = $this->model_article->getModel()
            ->Published()->take(3)->inRandomOrder()->get();
        return view('visitor.article.show',compact(
            'obj_article', 'arr_article_comments',
            'int_article_comments_count', 'random_articles'
            )
        );
    }

    /**
     * Get all articles assigned to a given category.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function getArticlesByCategory(Request $request)
    {
        $messages = [
            'category_id.required' => 'You need to choose one category.',
        ];

        $validator = Validator::make($request->all(), [
            "category_id" => "required|integer",
        ], $messages);

        if ($validator->fails())
            return redirect()->back()->withErrors($validator);
        
        $int_category_id = $request->category_id;
        
        $obj_selected_category = (new Repository(new Category))->show($int_category_id);
        
        $arr_articles = $this->model_article->getModel()->Published()
            ->where('category_id', $int_category_id)
            ->latest()->paginate($this->per_page);
        
        $arr_categories = (new Repository(new Category))->allWithoutPagination();
        
        $int_articles_count = $arr_articles->count();
        
        return view('visitor.article.index', compact(
            'arr_articles', 'int_articles_count',
            'arr_categories', 'obj_selected_category'
        ));
    }
}
