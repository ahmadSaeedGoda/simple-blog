<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Repository;
use App\Models\Category;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $repository = new Repository(new Category());

        $categories_count       = $repository->count();
        $articles_count         = $repository->setModel(new Article())->count();
        $pending_articles_count = $repository->setModel(new Article())->getModel()->pending()->count();
        $comments_count         = $repository->setModel(new Comment())->count();
        $visitors_count         = $repository->setModel(new User())->getModel()->Visitor()->count();

        return view(
            'admin.dashboard',
            compact(
                'categories_count',
                'articles_count',
                'comments_count',
                'visitors_count',
                'pending_articles_count'
            )
        );
    }//end index()
}//end class
