<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Http\Controllers\Controller;
use App\Repositories\Repository;
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
     * @param int $per_page
     */
    public function __construct(int $per_page = 500)
    {
        $this->repository   = new Repository(new Comment());
        $this->per_page     = $per_page;
    }//end __construct()


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_size      = $this->per_page;

        $comments       = $this->repository->page($page_size);
        
        $comments_count = $this->repository->count();

        return view(
            'admin.comment.index',
            compact(
                'comments',
                'comments_count'
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
    public function show(string $id)
    {
        $comment = $this->repository->find($id);

        return view(
            'admin.comment.show',
            compact(
                'comment'
            )
        );
    }//end show()
}//end class
