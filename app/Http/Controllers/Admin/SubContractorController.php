<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\SubContractor;
use DataTables;
use Form;


class SubContractorController extends Controller
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
       return view('admin.sub_contractor.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSubContractors(Request $request){        
        $categories = SubContractor::query();
        
         return DataTables::of($categories)
            ->editColumn('is_active', function ($category) {
                if($category->is_active == TRUE ){
                    return "<a href='".route('admin.subcontractor.status',[$category->id])."'><span class='badge badge-success'>Active</span></a>";
                }else{
                    return "<a href='".route('admin.subcontractor.status',[$category->id])."'><span class='badge badge-danger'>Inactive</span></a>";
                }
            })
            ->addColumn('action', function ($category) {
                return
                    // edit
                    '<a href="'.route('admin.subcontractor.edit',[$category->id]).'" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></a> '.
                    // Delete
                    Form::open(array(
                        'style' => 'display: inline-block;',
                        'method' => 'DELETE',
                        'onsubmit'=>"return confirm('Do you really want to delete?')",
                        'url' => route('admin.subcontractor.destroy', [$category->id]))).
                        
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
       
        $categories = SubContractor::where(['is_active'=>TRUE])->pluck('title', 'id');
        return view('admin.sub_contractor.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $rules = [
            'title'=>['required', Rule::unique(with(new SubContractor)->getTable(), 'title')],
        ];

        $request->validate($rules);

        $data = $request->all();

        SubContractor::create($data);
        $request->session()->flash('success',__('global.messages.add'));
        return redirect()->route('admin.subcontractor.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(SubContractor $productcategory){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $subcontractor = SubContractor::findOrFail($id);
        return view('admin.sub_contractor.form', compact('subcontractor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $subcontractor = SubContractor::findOrFail($id);
        $rules = [
            'title'=>['required',Rule::unique(with(new SubContractor)->getTable(), 'title')->ignore($subcontractor->getKey())],
        ];

        $request->validate($rules);
        $data = $request->all();
        $subcontractor->update($data);

        $request->session()->flash('success',__('global.messages.update'));
        return redirect()->route('admin.subcontractor.index');
    }

    /**
     * Change status the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function status(Request $request, $id=null){
        $subcontractor = SubContractor::findOrFail($id);
        if (isset($subcontractor->is_active) && $subcontractor->is_active==FALSE) {
            $subcontractor->update(['is_active'=>TRUE]);
            $request->session()->flash('success',__('global.messages.activate'));
        }else{
            $subcontractor->update(['is_active'=>FALSE]);
            $request->session()->flash('danger',__('global.messages.deactivate'));
        }
        return redirect()->route('admin.subcontractor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id){
        $subcontractor = SubContractor::findOrFail($id);
        if($subcontractor->id == config('constants.CATEGORY_TYPE_QURAN_ID')){
            $request->session()->flash('danger',__('global.messages.default_message_category'));
            return redirect()->route('admin.subcontractor.index'); 
        }else{
           $subcontractor->delete();
           $request->session()->flash('danger',__('global.messages.delete'));
           return redirect()->route('admin.subcontractor.index'); 
        }

       
        
    }
}
