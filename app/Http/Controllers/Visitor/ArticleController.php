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
use App\Traits\ControllerClassMembersForPagingAndModeling;

/**
 * Article Controller Class
 */
class ArticleController extends Controller
{
    use ControllerClassMembersForPagingAndModeling;
    /**
     * Article Controller Constructor.
     *
     * @param Int $per_page
     */
    public function __construct(Int $per_page = 500)
    {
        $this->repository = new Repository(new Article);
        $this->per_page   = $per_page;
    }//end __construct()


    /**
     * Display All Records For The Resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_size      = $this->per_page;

        $articles       = $this->repository->getModel()->Published()->with('category')->paginate($page_size);

        $articles_count = $this->repository->getModel()->Published()->count();

        $categories     = $this->repository->setModel(new Category())->all();

        return view(
            'visitor.article.index',
            compact(
                'articles',
                'articles_count',
                'categories'
            )
        );
    }//end index()


    /**
     * Display the specified resource.
     *
     * @param String $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(String $id)
    {
        $article                = $this->repository->find($id);
        
        $article_comments_count = $article->comments->count();

        return view(
            'visitor.article.show',
            compact(
                'article',
                'article_comments_count'
            )
        );

    }//end show()


    /**
     * Get all articles assigned to a given category.
     *
     * @param  Illuminate\Http\Request $request
     * @param  \App\Models\Category    $category
     * @return \Illuminate\Http\Response
     */
    public function getArticlesByCategory(Request $request)
    {
        $messages = [
            'category_id.required' => 'You need to choose one category.',
            'category_id.min:1' => 'Please Select Category!'
        ];

        $validator = Validator::make(
            $request->all(),
            ['category_id' => 'required|integer|min:1'],
            $messages
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $category_id        = $request->category_id;

        $selected_category  = $this->repository->setModel(new Category)->find($category_id);

        $categories         = $this->repository->all();
        
        $articles           = $this->repository->setModel(new Article)->getModel()->Published()->where('category_id', $category_id)->latest()->paginate($this->per_page);

        $articles_count     = $this->repository->getModel()->Published()->count();

        return view(
            'visitor.article.index',
            compact(
                'articles',
                'articles_count',
                'categories',
                'selected_category'
            )
        );

    }//end getArticlesByCategory()


}//end class