<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\ProjectType;
use DataTables;
use Form;

class ProjectTypeController extends Controller
{
     /**
     * __construct
     */
    public function __construct(){
     
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
       return view('admin.project_type.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProjectTypes(Request $request){        
        $project_types = ProjectType::query();
        
         return DataTables::of($project_types)
            ->editColumn('is_active', function ($project_type) {
                if($project_type->is_active == TRUE ){
                    return "<a href='".route('admin.projecttype.status',[$project_type->id])."'><span class='badge badge-success'>Active</span></a>";
                }else{
                    return "<a href='".route('admin.projecttype.status',[$project_type->id])."'><span class='badge badge-danger'>Inactive</span></a>";
                }
            })
            ->addColumn('action', function ($project_type) {
                return
                    // edit
                    '<a href="'.route('admin.projecttype.edit',[$project_type->id]).'" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></a> '.
                    // Delete
                    Form::open(array(
                        'style' => 'display: inline-block;',
                        'method' => 'DELETE',
                        'onsubmit'=>"return confirm('Do you really want to delete?')",
                        'url' => route('admin.projecttype.destroy', [$project_type->id]))).
                        
                    ' <button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>'.
                    Form::close();
            })
            ->rawColumns(['is_active','action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
       
        $project_type = ProjectType::where(['is_active'=>TRUE])->pluck('title', 'id');
        return view('admin.project_type.form', compact('project_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $rules = [
            'title'=>['required', Rule::unique(with(new ProjectType)->getTable(), 'title')],
        ];

        $request->validate($rules);

        $data = $request->all();

        ProjectType::create($data);
        $request->session()->flash('success',__('global.messages.add'));
        return redirect()->route('admin.projecttype.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectType $project_type){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $project_type = ProjectType::findOrFail($id);
        return view('admin.project_type.form', compact('project_type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $project_type = ProjectType::findOrFail($id);
        $rules = [
            'title'=>['required',Rule::unique(with(new ProjectType)->getTable(), 'title')->ignore($project_type->getKey())],
        ];

        $request->validate($rules);
        $data = $request->all();
        $project_type->update($data);

        $request->session()->flash('success',__('global.messages.update'));
        return redirect()->route('admin.projecttype.index');
    }

    /**
     * Change status the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, $id=null){
        $project_type = ProjectType::findOrFail($id);
        if (isset($project_type->is_active) && $project_type->is_active==FALSE) {
            $project_type->update(['is_active'=>TRUE]);
            $request->session()->flash('success',__('global.messages.activate'));
        }else{
            $project_type->update(['is_active'=>FALSE]);
            $request->session()->flash('danger',__('global.messages.deactivate'));
        }
        return redirect()->route('admin.projecttype.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id){
        $project_type = ProjectType::findOrFail($id);
        if($project_type->id == config('constants.CATEGORY_TYPE_QURAN_ID')){
            $request->session()->flash('danger',__('global.messages.default_message_category'));
            return redirect()->route('admin.projecttype.index'); 
        }else{
           $project_type->delete();
           $request->session()->flash('danger',__('global.messages.delete'));
           return redirect()->route('admin.projecttype.index'); 
        }

       
        
    }
}
