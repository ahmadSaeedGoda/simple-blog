<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Repository;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\UpdateCategory;
use Brian2694\Toastr\Facades\Toastr;
use App\Traits\ControllerClassMembersForPagingAndModeling;

/**
 * Category Controller Class
 */
class CategoryController extends Controller
{
    use ControllerClassMembersForPagingAndModeling;
    /**
     * Category Controller Constructor.
     *
     * @param Int $per_page
     */
    public function __construct(int $per_page = 500)
    {
        $this->repository   = new Repository(new Category());
        $this->per_page     = $per_page;
    }//end __construct()


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_size          = $this->per_page;

        $categories       = $this->repository->page($page_size);
        
        $categories_count = $this->repository->count();

        return view(
            'admin.category.index',
            compact(
                'categories',
                'categories_count'
            )
        );
    }//end index()


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }//end create()


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategory $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategory $request)
    {
        // The incoming request is valid...
        // Retrieve the validated input data...
        $validated = $request->validated();
        
        $this->repository->fillAndSave($validated);

        Toastr::success('Category Successfully Saved :)', 'Success');

        return redirect()->route('admin.category.index');
    }//end store()


    /**
     * Display the specified resource.
     *
     * @param String $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $category                = $this->repository->find($id);
        $category_articles       = $category->articles()->paginate($this->per_page);
        $category_articles_count = $category->articles->count();

        return view(
            'admin.category.show',
            compact(
                'category',
                'category_articles',
                'category_articles_count'
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
    public function edit(string $id)
    {
        $category = $this->repository->find($id);

        return view('admin.category.edit', compact('category'));
    }//end edit()


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategory $request
     * @param String $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategory $request, string $id)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
        
        $this->repository->update($id, $validated);

        Toastr::success('Category Successfully Updated :)', 'Success');

        return redirect()->route('admin.category.index');
    }//end update()


    /**
     * Remove the specified resource from storage.
     *
     * @param String $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $this->repository->remove($id);
        
        Toastr::success('Category Successfully Deleted :)', 'Success');

        return redirect()->back();
    }//end destroy()
}//end class
