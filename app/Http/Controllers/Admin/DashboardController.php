<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Repository;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;

class DashboardController extends Controller
{
    protected $model_user;
    protected $model_category;
    protected $model_article;
    protected $model_comment;

    /**
     * Create a new controller instance.
     *
     * @param Category $category
     * @param Article $article
     * @param Comment $comment
     * @param User $visitor
     *
     * @return void
     */
    public function __construct(
        Category $category,
        Article $article,
        Comment $comment,
        User $visitor
    )
    {
        $this->model_category = new Repository($category);
        $this->model_article = new Repository($article);
        $this->model_comment = new Repository($comment);
        $this->model_user = new Repository($visitor);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $int_categories_count = $this->model_category->count();
        $int_articles_count = $this->model_article->count();
        $int_pending_articles_count = $this->model_article->getModel()->pending()->count();
        $int_comments_count = $this->model_comment->count();
        $int_visitors_count = $this->model_user->getModel()->Visitor()->count();
        // dd($int_visitors_count);
        return view('admin.dashboard',
            compact('int_categories_count', 'int_articles_count',
            'int_comments_count', 'int_visitors_count',
            'int_pending_articles_count'
            )
        );
    }
}
