<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\ProductCategory;
use DataTables;
use Form;
use App\ProjectType;
use App\SubContractor;
use App\Project;
use App\ProjectEnquiry;
use Carbon\Carbon;
use App\Architect;
use App\Financier;
use App\Interior;
use App\MechanicalEngineer;
use App\Quantity;
use App\Contractor;
use Auth;
use App\Client;
use App\EnquiryRemarks;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.project.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProject(Request $request){
        if(Auth::user()->id == 1){
            $projects = Project::query()->with('getdeveloper');
        }else{
            $projects = Project::query()->with('getdeveloper')->where('created_by',Auth::user()->id);
        }
        
        return DataTables::of($projects)
        ->editColumn('is_active', function ($project) {
            if($project->is_active == TRUE ){
                return "<a href='".route('admin.project.status',[$project->id])."'><span class='badge badge-success'>Active</span></a>";
            }else{
                return "<a href='".route('admin.project.status',[$project->id])."'><span class='badge badge-danger'>Inactive</span></a>";
            }
        })
        ->addColumn('action', function ($project) {
            return
            // edit
            '<a href="'.route('admin.project.edit',[$project->id]).'" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></a> '.
            //update
            '<a href="'.route('admin.projects.prereview',[$project->id]).'" class="btn btn-success btn-circle btn-sm">Update</i></a> '.
   
            
            // Delete
            Form::open(array(
                'style' => 'display: inline-block;',
                'method' => 'DELETE',
                'onsubmit'=>"return confirm('Do you really want to delete?')",
                'url' => route('admin.project.destroy', [$project->id]))).
            ' <button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>'.
            Form::close();
            //update

        })
        ->rawColumns(['is_active','action'])
        ->make(true);

    }

    public function create() 
    {
        $projecttype = ProjectType::where(['is_active'=>TRUE])->pluck('title', 'id');
        $project =Project::where(['is_active'=>TRUE])->pluck('project_name', 'id');
        $productcategory=ProductCategory::where(['is_active'=>TRUE])->pluck('title', 'id');
        $subcontractor=SubContractor::where(['is_active'=>TRUE])->pluck('title', 'id');
        $architect=Architect::where(['is_active'=>TRUE])->pluck('name', 'id');
        $clientdeveloper=Client::where(['is_active'=>TRUE])->pluck('name', 'id');
        $financier=Financier::where(['is_active'=>TRUE])->pluck('name', 'id');
        $interior=Interior::where(['is_active'=>TRUE])->pluck('name', 'id');
        $mechanicalEngineer=MechanicalEngineer::where(['is_active'=>TRUE])->pluck('name', 'id');
        $quantity=Quantity::where(['is_active'=>TRUE])->pluck('name', 'id');
        $contractor=Contractor::where(['is_active'=>TRUE])->pluck('name', 'id');

        
        return view('admin.project.form',compact('projecttype','project','productcategory','subcontractor','architect','clientdeveloper','financier','interior','mechanicalEngineer','quantity','contractor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //     $rules = [
        //     'project_name'=>'required',
        //     'project_type_id'=>'required',
        //     'project_date'=>'required',
        //     'commencement_date'=>'required',
        //     'completion_date'=>'required',
        //     'project_budget'=>'required',
        //     'developer'=>'required',
        //     'project_financier'=>'required',
        //     'surveyor_qty'=>'required',
        //     'commentery'=>'required',
        //     'mech_engg'=>'required',
        //     'architect'=>'required',
        //     'interior'=>'required',
        //     'main_contractor'=>'required',
        //     'project_category_id'=>'required',
        //     'sub_contractor_id'=>'required', 
        //      ];
       
        // $request->validate($rules);

        $data= $request->except(['sub_product_id','expected_date','enq_source_list']);
        $project_date=isset($request->project_date)?$request->project_date:date('Y-m-d');
        $commencement_date=isset($request->commencement_date)?$request->commencement_date:date('Y-m-d');
        $completion_date=isset($request->completion_date)?$request->completion_date:date('Y-m-d');

        $add_developer=isset($data['add_developer'])?$data['add_developer']:'';
        $add_project_financier=isset($data['add_project_financier'])?$data['add_project_financier']:'';
        $add_surveyor_qty=isset($data['add_surveyor_qty'])?$data['add_surveyor_qty']:'';
        $add_mech_engg=isset($data['add_mech_engg'])?$data['add_mech_engg']:'';
        $add_architect=isset($data['add_architect'])?$data['add_architect']:'';
        $add_interior=isset($data['add_interior'])?$data['add_interior']:'';
        $add_main_contractor=isset($data['add_main_contractor'])?$data['add_main_contractor']:'';
        

        if($project_date!=''){
         $project_date=date('Y-m-d',strtotime($project_date));
     }
     if($commencement_date!=''){
        $commencement_date=date('Y-m-d',strtotime($commencement_date));
    }
    if($completion_date!=''){
        $completion_date=date('Y-m-d',strtotime($completion_date));
    }
    $data['project_date'] =  $project_date;
    $data['commencement_date'] =  $commencement_date;
    $data['completion_date'] =  $completion_date;
    $data['contractor'] =  isset($data['contractor'])?$data['contractor']:'';
    $data['contractor_id'] =  isset($data['contractor_id'])?$data['contractor_id']:'';
    $data['created_by']=Auth::user()->id;  
    $data['main_contractor'] =  isset($data['main_contractor'])?$data['main_contractor']:'';
    $data['mech_engg'] =  isset($data['mech_engg_id'])?$data['mech_engg_id']:'';
    $data['project_financier'] =  isset($data['financier_id'])?$data['financier_id']:'';
    $data['surveyor_qty'] =  isset($data['quantity_id'])?$data['quantity_id']:'';
    $data['architect'] =  isset($data['architect_id'])?$data['architect_id']:'';
    $data['interior'] =  isset($data['interior_id'])?$data['interior_id']:'';

    $project=Project::create($data);
                // backend start
    
    if($project->id > 0){
        if($data['developer']=='add_new_client'){
            $developer=Client::create(['name'=>$add_developer]);
            $developer_id=$developer->id;
        }else{
            $developer_id = isset($data['developer'])?$data['developer']:0;
            
        }
        $project->update(array('developer'=>$developer_id));


        if($data['architect_id']=='add_new_architect'){
            $architect=Architect::create(['name'=>$add_architect]);
            $architect_id=$architect->id;
        }else{
            $architect_id = isset($data['architect_id'])?$data['architect_id']:0;
        }
        $project->update(array('architect'=>$architect_id));


        if($data['financier_id']=='add_new_financier'){
            $financier=Financier::create(['name'=>$add_project_financier]);
            $financier_id=$financier->id;
        }else{
            $financier_id = isset($data['financier_id'])?$data['financier_id']:0;
        }
        $project->update(array('project_financier'=>$financier_id));


        if($data['mech_engg_id']=='add_new_mech_engineer'){
            $mechanical=MechanicalEngineer::create(['name'=>$add_mech_engg]);
            $mechanical_id=$mechanical->id;
        }else{
            $mechanical_id = isset($data['mech_engg_id'])?$data['mech_engg_id']:0;
        }
        $project->update(array('mech_engg'=>$mechanical_id));


        if($data['interior_id']=='add_new_interior'){
            $interior=Interior::create(['name'=>$add_interior]);
            $interior_id=$interior->id;
        }else{
            $interior_id = isset($data['interior_id'])?$data['interior_id']:0;
        }
        $project->update(array('interior'=>$interior_id));

        if($data['main_contractor']=='add_new_contractor'){
            $contractor=Contractor::create(['name'=>$add_main_contractor]);
            $contractor_id=$contractor->id;
        }else{
            $contractor_id = isset($data['main_contractor'])?$data['main_contractor']:0;
        }
        $project->update(array('main_contractor'=>$contractor_id));


        if($data['quantity_id']=='add_new_quantity'){
            $quantity=Quantity::create(['name'=>$add_surveyor_qty]);
            $quantity_id=$quantity->id;
        }else{
            $quantity_id = isset($data['quantity_id'])?$data['quantity_id']:0;
        }
        $project->update(array('surveyor_qty'=>$quantity_id));


    


                // backend end

    }
    if(isset($request->product_category)){
        foreach($request->enq_source as $key=>$enq){
            $source=explode('-',$enq);
            $expected_date = date('Y-m-d', strtotime($request->expected_date[$key]));
            $data=[
                'project_id'=>$project->id,
                'product_category_id' => $request->product_category[$key],
                'expected_date' =>isset($expected_date)?$expected_date:date('Y-m-d'),
                'enq_source' => isset($source[0])?$source[0]:0,
                'enq_source_type'=>isset($source[1])?$source[1]:''
            ];
            ProjectEnquiry::insert($data);

        }
        
    }
    $request->session()->flash('success',__('global.messages.add'));
    return redirect()->route('admin.project.index');
    
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //    //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::with('getprojecttype','Projectenquiry','getdeveloper','getfinancier','getquantity','getmengineer','getarchitect','getinterior','getmcontractor','getpcategory','getsubcontractor')->findOrFail($id);
        $projecttype = ProjectType::where(['is_active'=>TRUE])->pluck('title', 'id');
        $productcategory=ProductCategory::where(['is_active'=>TRUE])->pluck('title', 'id');
        $architect=Architect::where(['is_active'=>TRUE])->pluck('name', 'id');
        $clientdeveloper=Client::where(['is_active'=>TRUE])->pluck('name', 'id');
        $financier=Financier::where(['is_active'=>TRUE])->pluck('name', 'id');
        $interior=Interior::where(['is_active'=>TRUE])->pluck('name', 'id');
        $mechanicalEngineer=MechanicalEngineer::where(['is_active'=>TRUE])->pluck('name', 'id');
        $quantity=Quantity::where(['is_active'=>TRUE])->pluck('name', 'id');
        $contractor=Contractor::where(['is_active'=>TRUE])->pluck('name', 'id');
        $subcontractor=SubContractor::where(['is_active'=>TRUE])->pluck('title', 'id');
        $people_list='';
        if(isset($project->Projectenquiry)){
        foreach($project->Projectenquiry as $people){
        if($people->enq_source_type == 'client'){
        $people_list=Client::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
        $people_list=$people_list->id.'-'.'client';
      
        }
        elseif($people->enq_source_type == 'financier'){
        $people_list=Financier::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
        $people_list=$people_list->id.'-'.'financier';
        }
        elseif($people->enq_source_type == 'quantity'){
         $people_list=Quantity::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
         $people_list=$people_list->id.'-'.'quantity';
        }
        elseif($people->enq_source_type == 'engineer'){
         $people_list=MechanicalEngineer::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
         $people_list=$people_list->id.'-'.'engineer';
        }
        elseif($people->enq_source_type == 'architect'){
         $people_list=Architect::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
         $people_list=$people_list->id.'-'.'architect';
        }
        elseif($people->enq_source_type == 'interior'){
         $people_list=Interior::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
         $people_list=$people_list->id.'-'.'interior';
        }
        elseif($people->enq_source_type == 'contractor'){
        $people_list=Contractor::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
        $people_list=$people_list->id.'-'.'contractor';
        }
        else{

        }
          }

        }
         
        return view('admin.project.edit',compact('project','productcategory','projecttype','architect','clientdeveloper','financier','interior','mechanicalEngineer','quantity','contractor','subcontractor','people_list'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

  
        $project = Project::findOrFail($id);
        $rules = [
            'project_name'=>'required',
        ];
        $request->validate($rules);
        $data= $request->except(['expected_date','enq_source_list']);
        $project_date=isset($request->project_date)?$request->project_date:date('Y-m-d');
        $commencement_date=isset($request->commencement_date)?$request->commencement_date:date('Y-m-d');
        $completion_date=isset($request->completion_date)?$request->completion_date:date('Y-m-d');
        $add_developer=isset($data['add_developer'])?$data['add_developer']:'';
        $add_project_financier=isset($data['add_project_financier'])?$data['add_project_financier']:'';
        $add_surveyor_qty=isset($data['add_surveyor_qty'])?$data['add_surveyor_qty']:'';
        $add_mech_engg=isset($data['add_mech_engg'])?$data['add_mech_engg']:'';
        $add_architect=isset($data['add_architect'])?$data['add_architect']:'';
        $add_interior=isset($data['add_interior'])?$data['add_interior']:'';
        $add_main_contractor=isset($data['add_main_contractor'])?$data['add_main_contractor']:'';
        $data['mech_engg'] =  isset($data['mech_engg_id'])?$data['mech_engg_id']:'';


        if($project_date!=''){
         $project_date=date('Y-m-d',strtotime($project_date));
     }
     if($commencement_date!=''){
        $commencement_date=date('Y-m-d',strtotime($commencement_date));
    }
    if($completion_date!=''){
        $completion_date=date('Y-m-d',strtotime($completion_date));
    }
    $data['project_date'] =  $project_date;
    $data['commencement_date'] =  $commencement_date;
    $data['completion_date'] =  $completion_date;

    $data['contractor'] =  isset($data['contractor'])?$data['contractor']:'';
    $data['contractor_id'] =  isset($data['contractor_id'])?$data['contractor_id']:'';
    $data['main_contractor'] =  isset($data['main_contractor'])?$data['main_contractor']:'';
    $data['mech_engg'] =  isset($data['mech_engg_id'])?$data['mech_engg_id']:'';
    $data['project_financier'] =  isset($data['financier_id'])?$data['financier_id']:'';
    $data['surveyor_qty'] =  isset($data['quantity_id'])?$data['quantity_id']:'';
    $data['architect'] =  isset($data['architect_id'])?$data['architect_id']:'';
    $data['interior'] =  isset($data['interior_id'])?$data['interior_id']:'';
    

    $project->update($data);
                // backend start
    
    if($project->id > 0){
        if($data['developer']=='add_new_client'){
            $developer=Client::create(['name'=>$add_developer]);
            $developer_id=$developer->id;
        }else{
            $developer_id = isset($data['developer'])?$data['developer']:0;
            
        }
        $project->update(array('developer'=>$developer_id));


        if($data['architect_id']=='add_new_architect'){
            $architect=Architect::create(['name'=>$add_architect]);
            $architect_id=$architect->id;
        }else{
            $architect_id = isset($data['architect_id'])?$data['architect_id']:0;
        }
        $project->update(array('architect'=>$architect_id));


        if($data['financier_id']=='add_new_financier'){
            $financier=Financier::create(['name'=>$add_project_financier]);
            $financier_id=$financier->id;
        }else{
            $financier_id = isset($data['financier_id'])?$data['financier_id']:0;
        }
        $project->update(array('project_financier'=>$financier_id));


        if($data['mech_engg_id']=='add_new_mech_engineer'){
            $mechanical=MechanicalEngineer::create(['name'=>$add_mech_engg]);
            $mechanical_id=$mechanical->id;
        }else{
            $mechanical_id = isset($data['mech_engg_id'])?$data['mech_engg_id']:0;
        }
        $project->update(array('mech_engg'=>$mechanical_id));


        if($data['interior_id']=='add_new_interior'){
            $interior=Interior::create(['name'=>$add_interior]);
            $interior_id=$interior->id;
        }else{
            $interior_id = isset($data['interior_id'])?$data['interior_id']:0;
        }
        $project->update(array('interior'=>$interior_id));

        if($data['main_contractor']=='add_new_contractor'){
            $contractor=Contractor::create(['name'=>$add_main_contractor]);
            $contractor_id=$contractor->id;
        }else{
            $contractor_id = isset($data['main_contractor'])?$data['main_contractor']:0;
        }
        $project->update(array('main_contractor'=>$contractor_id));


        if($data['quantity_id']=='add_new_quantity'){
            $quantity=Quantity::create(['name'=>$add_surveyor_qty]);
            $quantity_id=$quantity->id;
        }else{
            $quantity_id = isset($data['quantity_id'])?$data['quantity_id']:0;
        }
        $project->update(array('surveyor_qty'=>$quantity_id));


    }

    // if(!empty(ProjectEnquiry::where('project_id',$id)->get())){
    //     ProjectEnquiry::where('project_id',$id)->delete();
    //     if(isset($request->product_category)){
    //         foreach($request->enq_source as $key=>$enq){
    //             $source=explode('-',$enq);
    //             $expected_date = date('Y-m-d', strtotime($request->expected_date[$key]));
    //             $received_date = date('Y-m-d', strtotime($request->received_date[$key]));
    //             $quotation_date = date('Y-m-d', strtotime($request->quotation_date[$key]));
    //             $data=[
    //                 'project_id'=>$project->id,
    //                 'product_category_id' => $request->product_category[$key],
    //                 'expected_date' =>isset($expected_date)?$expected_date:date('Y-m-d'),
    //                 'enq_source' => isset($source[0])?$source[0]:0,
    //                 'enq_source_type'=>isset($source[1])?$source[1]:'',
    //                 "received_date" => isset($received_date)?$received_date:date('Y-m-d'),
    //                 "quotation_date" => isset($quotation_date)?$quotation_date:date('Y-m-d'),
    //                 "remarks" => isset($request->remarks[$key])?$request->remarks[$key]:'',
    //                 "won_loss" => isset($request->won_loss[$key])?$request->won_loss[$key]:'Loss'
    //             ];
    //             ProjectEnquiry::insert($data);
                
    //         }
    //     }
    // }

    
    $request->session()->flash('success',__('global.messages.update'));
    return redirect()->route('admin.project.index');
    
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id=null)
    {
        $project = Project::findOrFail($id);
        if($project->id == config('constants.CATEGORY_TYPE_QURAN_ID')){
            $request->session()->flash('danger',__('global.messages.default_message_category'));
            return redirect()->route('admin.project.index'); 
        }else{
         $project->delete();
         ProjectEnquiry::where('project_id',$id)->delete();
         $request->session()->flash('danger',__('global.messages.delete'));
         return redirect()->route('admin.project.index'); 
     }
 }

 public function status(Request $request, $id=null){
    $project = Project::findOrFail($id);
    if (isset($project->is_active) && $project->is_active==FALSE) {
        $project->update(['is_active'=>TRUE]);
        $request->session()->flash('success',__('global.messages.activate'));
    }else{
        $project->update(['is_active'=>FALSE]);
        $request->session()->flash('danger',__('global.messages.deactivate'));
    }
    return redirect()->route('admin.project.index'); 
}

public function projectpreview(Request $request){
    try {

        
        $id=$request->id;
        return view('admin.project.review',compact('id'));
        
    } catch (Exception $e) {
     
    }  
}

public function getpreview(Request $request){
    try {
        $projectenquiry = ProjectEnquiry::query()->with('getproductcategory')->where('project_id',$request->id)->get();
        return  DataTables::of($projectenquiry)
        ->editColumn('expected_date', function ($project){
            $expected_date=$project->expected_date?$project->expected_date:date('Y-m-d');
            return  date('d M Y', strtotime($expected_date));  
        })
        ->editColumn('received_date', function ($project){
            $received_date=$project->received_date?$project->received_date:date('Y-m-d');
            return  date('d M Y', strtotime($received_date));  
        })->editColumn('quotation_date', function ($project){
            $quotation_date=$project->quotation_date?$project->quotation_date:date('Y-m-d');
            return  date('d M Y', strtotime($quotation_date));  
        })->addColumn('action', function ($projectenquiry) {
            return 
            // edit
            '<a href="'.route('admin.projects.editenquiry',[$projectenquiry->id]).'" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></a> '.
            // add remarks
            '<a href="'.route('admin.projects.addremarks',[$projectenquiry->id]).'" class="btn btn-success btn-circle btn-sm"><i class="fa fa-plus" aria-hidden="true"></i>
             Add Remarks</a> ';
        })->rawColumns(['action'])->make(true);
    } catch (Exception $e) {
     
    } 
    
}
public function editenquiry($id){
    $project= ProjectEnquiry::findOrFail($id);
    $projecttype = ProjectType::where(['is_active'=>TRUE])->pluck('title', 'id');
    $productcategory=ProductCategory::where(['is_active'=>TRUE])->pluck('title', 'id');
    $architect=Architect::where(['is_active'=>TRUE])->pluck('name', 'id');
    $clientdeveloper=Client::where(['is_active'=>TRUE])->pluck('name', 'id');
    $financier=Financier::where(['is_active'=>TRUE])->pluck('name', 'id');
    $interior=Interior::where(['is_active'=>TRUE])->pluck('name', 'id');
    $mechanicalEngineer=MechanicalEngineer::where(['is_active'=>TRUE])->pluck('name', 'id');
    $quantity=Quantity::where(['is_active'=>TRUE])->pluck('name', 'id');
    $contractor=Contractor::where(['is_active'=>TRUE])->pluck('name', 'id');
    $subcontractor=SubContractor::where(['is_active'=>TRUE])->pluck('title', 'id');
    $people_list='';

    if(isset($project)){
    if($project->enq_source_type == 'client'){
    $people_list=Client::where('id',$project->enq_source)->where('is_active',1)->select('id','name')->first();
    $people_list=$people_list->id.'-'.'client';
  
    }
    elseif($project->enq_source_type == 'financier'){
    $people_list=Financier::where('id',$project->enq_source)->where('is_active',1)->select('id','name')->first();
    $people_list=$people_list->id.'-'.'financier';
    }
    elseif($project->enq_source_type == 'quantity'){
     $people_list=Quantity::where('id',$project->enq_source)->where('is_active',1)->select('id','name')->first();
     $people_list=$people_list->id.'-'.'quantity';
    }
    elseif($project->enq_source_type == 'engineer'){
     $people_list=MechanicalEngineer::where('id',$project->enq_source)->where('is_active',1)->select('id','name')->first();
     $people_list=$people_list->id.'-'.'engineer';
    }
    elseif($project->enq_source_type == 'architect'){
     $people_list=Architect::where('id',$project->enq_source)->where('is_active',1)->select('id','name')->first();
     $people_list=$people_list->id.'-'.'architect';
    }
    elseif($project->enq_source_type == 'interior'){
     $people_list=Interior::where('id',$project->enq_source)->where('is_active',1)->select('id','name')->first();
     $people_list=$people_list->id.'-'.'interior';
    }
    elseif($project->enq_source_type == 'contractor'){
    $people_list=Contractor::where('id',$project->enq_source)->where('is_active',1)->select('id','name')->first();
    $people_list=$people_list->id.'-'.'contractor';
    }
    else{

    } 
    }
    return view('admin.project.editenquiry',compact('project','productcategory','projecttype','architect','clientdeveloper','financier','interior','mechanicalEngineer','quantity','contractor','subcontractor','people_list'));

}

public function addEnquiry($id){

    $project_id=$id;
    $projecttype = ProjectType::where(['is_active'=>TRUE])->pluck('title', 'id');
    $productcategory=ProductCategory::where(['is_active'=>TRUE])->pluck('title', 'id');
    $architect=Architect::where(['is_active'=>TRUE])->pluck('name', 'id');
    $clientdeveloper=Client::where(['is_active'=>TRUE])->pluck('name', 'id');
    $financier=Financier::where(['is_active'=>TRUE])->pluck('name', 'id');
    $interior=Interior::where(['is_active'=>TRUE])->pluck('name', 'id');
    $mechanicalEngineer=MechanicalEngineer::where(['is_active'=>TRUE])->pluck('name', 'id');
    $quantity=Quantity::where(['is_active'=>TRUE])->pluck('name', 'id');
    $contractor=Contractor::where(['is_active'=>TRUE])->pluck('name', 'id');
    $subcontractor=SubContractor::where(['is_active'=>TRUE])->pluck('title', 'id');
    $people_list='';
    if(isset($project->Projectenquiry)){
    foreach($project->Projectenquiry as $people){
    if($people->enq_source_type == 'client'){
    $people_list=Client::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
    $people_list=$people_list->id.'-'.'client';
  
    }
    elseif($people->enq_source_type == 'financier'){
    $people_list=Financier::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
    $people_list=$people_list->id.'-'.'financier';
    }
    elseif($people->enq_source_type == 'quantity'){
     $people_list=Quantity::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
     $people_list=$people_list->id.'-'.'quantity';
    }
    elseif($people->enq_source_type == 'engineer'){
     $people_list=MechanicalEngineer::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
     $people_list=$people_list->id.'-'.'engineer';
    }
    elseif($people->enq_source_type == 'architect'){
     $people_list=Architect::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
     $people_list=$people_list->id.'-'.'architect';
    }
    elseif($people->enq_source_type == 'interior'){
     $people_list=Interior::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
     $people_list=$people_list->id.'-'.'interior';
    }
    elseif($people->enq_source_type == 'contractor'){
    $people_list=Contractor::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
    $people_list=$people_list->id.'-'.'contractor';
    }
    else{

    }
      }

    }
    return view('admin.project.enquiry',compact('project_id','productcategory','projecttype','architect','clientdeveloper','financier','interior','mechanicalEngineer','quantity','contractor','subcontractor','people_list'));
}

public function insertinquiry(Request $request){

    
    if(isset($request->product_category)){
        foreach($request->enq_source as $key=>$enq){
            $source=explode('-',$enq);
            $expected_date = date('Y-m-d', strtotime($request->expected_date[$key]));
            $data=[
                'project_id'=>$request->project_id,
                'product_category_id' => $request->product_category[$key],
                'expected_date' =>isset($expected_date)?$expected_date:date('Y-m-d'),
                'enq_source' => isset($source[0])?$source[0]:0,
                'enq_source_type'=>isset($source[1])?$source[1]:''
            ];
            ProjectEnquiry::insert($data);

        }  
    }
    $request->session()->flash('success',__('global.messages.add'));
    return redirect()->route('admin.projects.prereview',$request->project_id);
    
}
public function updateEnquiry(Request $request , $id){
    $enq=explode('-',$request->enq_source);
    $data=[
        'product_category_id'=>$request->product_category,
        'expected_date'=>date('Y-m-d', strtotime($request->expected_date)),
        'received_date'=>date('Y-m-d', strtotime($request->received_date)),
        'remarks'=>$request->remarks,
        'won_loss'=>$request->won_loss,
        'quotation_date'=>date('Y-m-d', strtotime($request->quotation_date)),
        'enq_source'=>$enq[0],
        'enq_source_type'=>$enq[1],
    ];
    ProjectEnquiry::where('id',$id)->update($data);
    $request->session()->flash('success',__('global.messages.add'));
    return redirect()->back();

}


public function addremarks($id){
  

return view('admin.project.addremarks',compact('id'));

}
public function saveremark(Request $request){
   $date= date('Y-m-d', strtotime("now"));
    $remark=[
        'enquiry_id'=>$request->enquiry_id,
        'remarks'=>$request->remarks,
        'date'=>$date
    ];
    EnquiryRemarks::insert($remark);

    $request->session()->flash('success',__('global.messages.add'));
    return redirect()->back();
}

}
