<?php

namespace App\Http\Controllers\Visitor;

use App\Models\Comment;
use App\Models\Article;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComment;
use Brian2694\Toastr\Facades\Toastr;
use App\Traits\ControllerClassMembersForPagingAndModeling;

/**
 * Comment Controller Class
 */
class CommentController extends Controller
{
    use ControllerClassMembersForPagingAndModeling;
    /**
     * Comment Controller Constructor.
     *
     * @param Int $per_page
     */
    public function __construct(Int $per_page = 500)
    {
        $this->repository = new Repository(new Comment);
        $this->per_page   = $per_page;
    }//end __construct()

    /**
     * Store a newly created resource in a storage.
     *
     * @param  StoreComment $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComment $request)
    {
        // The incoming request is valid...
        // Retrieve the validated input data...
        $validated = $request->validated();

        $this->repository->fillAndSave($validated);
        
        Toastr::success('Comment Successfully Saved :)', 'Success');
        
        return redirect()->back();

    }//end store()


}//end class
