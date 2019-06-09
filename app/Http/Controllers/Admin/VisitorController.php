<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class VisitorController extends Controller
{

    protected $model_visitor;
    protected $per_page = 500;

    /**
     * VisitorController constructor.
     *
     * @param Visitor $model_visitor
     */
    public function __construct(User $model_visitor, $per_page)
    {
        $this->per_page = $per_page;
        $this->model_visitor = new Repository($model_visitor, $this->per_page);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $arr_visitors = $this->model_visitor->getModel()->Visitor()->all();
        return view('admin.visitor.index', compact('arr_visitors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arr_categories = (new Repository(new Category))->all();
        return view('admin.visitor.create', compact('arr_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\StoreUser  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        // The incoming request is valid...
    
        // Retrieve the validated input data...
        $validated = $request->validated();
        $slug = str_slug($request->title);
        $obj_visitor = $this->model_visitor->create();
        $obj_visitor->title = $request->title;
        $obj_visitor->slug = $slug;
        $obj_visitor->body = $request->body;
        $obj_visitor->is_published = ($request->is_published)? true:false;
        $obj_visitor->category_id = $request->category_id;
        $obj_visitor->save();

        Toastr::success('User Successfully Saved :)','Success');
        return redirect()->route('admin.visitor.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $model_visitor
     * @return \Illuminate\Http\Response
     */
    public function show($int_id)
    {
        $obj_visitor = $this->model_visitor->show($int_id);
        $arr_visitor_comments = $obj_visitor->comments()->with('user')->get();
        return view('admin.visitor.show',compact(
            'obj_visitor', 'arr_visitor_comments'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $model_visitor
     * @return \Illuminate\Http\Response
     */
    public function edit($int_id)
    {
        $obj_visitor = $this->model_visitor->show($int_id);
        $arr_categories = (new Repository(new Category))->all();
        return view('admin.visitor.edit', compact('obj_visitor', 'arr_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Requests\StoreUser  $request
     * @param  \App\Models\User  $model_visitor
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request, $int_id)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
        $slug = str_slug($request->title);

        $obj_visitor = $this->model_visitor->show($int_id);
        $obj_visitor->title = $request->title;
        $obj_visitor->slug = $slug;
        $obj_visitor->body = $request->body;
        $obj_visitor->is_published = ($request->is_published)? true:false;
        $obj_visitor->category_id = $request->category_id;
        $obj_visitor->save();

        Toastr::success('User Successfully Updated :)','Success');
        return redirect()->route('admin.visitor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $model_visitor
     * @return \Illuminate\Http\Response
     */
    public function destroy($int_id)
    {
        $obj_visitor = $this->model_visitor->show($int_id);
        $obj_visitor->delete();
        Toastr::success('User Successfully Deleted :)','Success');
        return redirect()->back();
    }
}
