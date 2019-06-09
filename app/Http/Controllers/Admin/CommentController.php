<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Repository;
use App\Http\Requests\StoreComment;
use App\Http\Requests\UpdateComment;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;

class CommentController extends Controller
{
    protected $model_comment;
    protected $per_page = 500;

    /**
     * Create a new controller instance.
     *
     * @param Comment $model_comment
     *
     * @return void
     */
    public function __construct(Comment $model_comment, $per_page = 500)
    {
        $this->per_page = $per_page;
        $this->model_comment = new Repository($model_comment, $this->per_page);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr_comments = $this->model_comment->all();
        $int_comments_count = $this->model_comment->count();
        return view('admin.comment.index', compact(
            'arr_comments', 'int_comments_count'
            )
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $model_comment
     * @return \Illuminate\Http\Response
     */
    public function show($int_id)
    {
        $obj_comment = $this->model_comment->show($int_id);
        return view('admin.comment.show',compact(
            'obj_comment'
            )
        );
    }

}
