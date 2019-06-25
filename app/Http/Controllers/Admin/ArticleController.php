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
use App\Events\PublishArticle;
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
        $this->repository   = new Repository(new Article);
        $this->per_page     = $per_page;
    }//end __construct()


    /**
     * Display All Records For The Resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_size          = $this->per_page;

        $articles       = $this->repository->page($page_size, ['category']);

        $articles_count = $this->repository->count();

        return view('admin.article.index', compact('articles', 'articles_count'));
    }//end index()


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->repository->setModel(new Category())->all();

        return view('admin.article.create', compact('categories'));

    }//end create()


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreArticle $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticle $request)
    {
        // The incoming request is valid...
        // Retrieve the validated input data...
        $validated = $request->validated();
        
        $this->repository->fillAndSave($validated);

        Toastr::success('Article Successfully Saved :)', 'Success');

        return redirect()->route('admin.article.index');

    }//end store()


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
        $article_comments       = $article->comments()->with('user')->paginate($this->per_page);
        $article_comments_count = $article->comments->count();

        return view(
            'admin.article.show',
            compact(
                'article',
                'article_comments',
                'article_comments_count'
            )
        );

    }//end show()


    /**
     * Show the form for editing the specified resource.
     *
     * @param String $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(String $id)
    {
        $article    = $this->repository->find($id);
        
        $categories = $this->repository->setModel(new Category())->all();

        return view('admin.article.edit', compact('article', 'categories'));

    }//end edit()


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Requests\StoreArticle $request
     * @param String $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticle $request, String $id)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $this->repository->update($id, $validated);

        Toastr::success('Article Successfully Updated :)', 'Success');

        return redirect()->route('admin.article.index');

    }//end update()


    /**
     * Remove the specified resource from storage.
     *
     * @param String $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $id)
    {
        $this->repository->remove($id);
        
        Toastr::success('Article Successfully Deleted :)', 'Success');

        return redirect()->back();

    }//end destroy()


    /**
     * Publish the specified resource.
     *
     * @param String $id
     *
     * @return \Illuminate\Http\Response
     */
    public function publish(String $id)
    {
        $this->repository->update($id, ['is_published'=>true]);

        Toastr::success('Article Successfully Published :)', 'Success');

        return redirect()->back();

    }//end publish()


}//end class
