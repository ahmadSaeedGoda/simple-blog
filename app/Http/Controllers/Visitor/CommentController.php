<?php

namespace App\Http\Controllers\Visitor;

use App\Models\Comment;
use App\Models\Article;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComment;
use Brian2694\Toastr\Facades\Toastr;

class CommentController extends Controller
{
    protected $model_comment;
    protected $per_page = 500;

    /**
     * CommentController constructor.
     *
     * @param Comment $model_comment
     */
    public function __construct(Comment $model_comment, $per_page = 500)
    {
        $this->per_page = $per_page;
        $this->model_comment = new Repository($model_comment, $this->per_page);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\StoreComment  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComment $request)
    {
        // The incoming request is valid...
    
        // Retrieve the validated input data...
        $validated = $request->validated();
        $obj_comment = $this->model_comment->create();
        $obj_comment->article_id = $request->article_id;
        $obj_comment->user_id = $request->user_id;
        $obj_comment->comment = $request->comment;
        $obj_comment->save();

        Toastr::success('Comment Successfully Saved :)','Success');
        return redirect()->back();
    }
}
