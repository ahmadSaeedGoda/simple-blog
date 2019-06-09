<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Repository;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategory;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

class CategoryController extends Controller
{
    protected $model_category;
    protected $per_page = 500;

    /**
     * Create a new controller instance.
     *
     * @param Category $model_category
     *
     * @return void
     */
    public function __construct(Category $model_category, $per_page = 500)
    {
        $this->per_page = $per_page;
        $this->model_category = new Repository($model_category, $this->per_page);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr_categories = $this->model_category->all();
        $int_categories_count = $this->model_category->count();
        return view('admin.category.index', compact(
            'arr_categories', 'int_categories_count'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(StoreCategory $request)
    {
        // The incoming request is valid...
        // Retrieve the validated input data...
        $validated = $request->validated();
        $slug = str_slug($request->name);

        $obj_category = $this->model_category->create();
        $obj_category->name = $request->name;
        $obj_category->slug = $slug;
        $obj_category->save();

        Toastr::success('Category Successfully Saved :)','Success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($int_id)
    {
        $obj_category = $this->model_category->show($int_id);
        $arr_category_articles = $obj_category->articles()->paginate($this->per_page);
        $int_category_articles_count = $obj_category->articles->count();
        return view('admin.category.show', compact(
            'obj_category', 'arr_category_articles',
            'int_category_articles_count'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($int_id)
    {
        $obj_category = $this->model_category->show($int_id);
        return view('admin.category.edit', compact('obj_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategory $request, $int_id)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
        $slug = str_slug($request->name);

        $obj_article = $this->model_category->show($int_id);
        $obj_article->name = $request->name;
        $obj_article->slug = $slug;
        $obj_article->save();

        Toastr::success('Category Successfully Updated :)','Success');
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($int_id)
    {
        $obj_article = $this->model_category->show($int_id);
        $obj_article->delete();
        Toastr::success('Category Successfully Deleted :)','Success');
        return redirect()->back();
    }
}
