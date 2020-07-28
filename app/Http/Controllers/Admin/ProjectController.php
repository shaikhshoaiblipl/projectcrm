<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\ProductCategory;
use App\ProjectHasProductCategory;
use DataTables;
use Form;
use App\ProjectType;
use App\SubContractor;
use App\Project;
use App\Project_has_sub_contractor;
use App\ProjectEnquiry;
use Carbon\Carbon;
use App\Architect;
use App\User;
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
        $sales=User::with('roles')->whereHas('roles', function($query){
            $query->where('id',config('constants.ROLE_TYPE_SALES_ID'));
        })->where(['is_active'=>TRUE])->pluck('name', 'id');

        $productcategory=ProductCategory::where(['is_active'=>TRUE])->pluck('title', 'id');
        $projecttype = ProjectType::where(['is_active'=>TRUE])->pluck('title', 'id');
        $clientdeveloper=Client::where(['is_active'=>TRUE])->pluck('name', 'id');
        $subcontractor=SubContractor::where(['is_active'=>TRUE])->pluck('title', 'id');
        $architect=Architect::where(['is_active'=>TRUE])->pluck('name', 'id');
        $financier=Financier::where(['is_active'=>TRUE])->pluck('name', 'id');
        $interior=Interior::where(['is_active'=>TRUE])->pluck('name', 'id');
        $mechanicalEngineer=MechanicalEngineer::where(['is_active'=>TRUE])->pluck('name', 'id');
        $quantity=Quantity::where(['is_active'=>TRUE])->pluck('name', 'id');
        $contractor=Contractor::where(['is_active'=>TRUE])->pluck('name', 'id');
        return view('admin.project.index',compact('sales','projecttype','clientdeveloper','financier','quantity','mechanicalEngineer','architect','interior','contractor','productcategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getProject(Request $request){
        $projects = Project::query()->with('getprojecttype','users','getProjectProductCategories'); 
        if(in_array(Auth::user()->roles->first()->id, [config('constants.ROLE_TYPE_SALES_ID')])) {
            $projects->where('created_by',Auth::user()->id);
        }
        $projects->select([\DB::raw(with(new Project)->getTable().'.*')])->groupBy('id');  

        $sales_id = intval($request->input('sales_id'));
        if(intval($sales_id) > 0)
            $projects->where('created_by', $sales_id);  

        $type_id = intval($request->input('type_id'));
        if($type_id > 0) 
            $projects->where('project_type_id', $type_id); 
        
        $client_id = $request->input('client_id');
        if($client_id!='') 
            $projects->where('developer', $client_id); 

        $financier_id = intval($request->input('financier_id'));
        if(intval($financier_id) > 0)
            $projects->where('project_financier', $financier_id); 

        $quantity_id = intval($request->input('quantity_id'));
        if(intval($quantity_id) > 0)
            $projects->where('surveyor_qty', $quantity_id); 

        $mech_engg_id = intval($request->input('mech_engg_id'));
        if(intval($mech_engg_id) > 0)
            $projects->where('mech_engg', $mech_engg_id); 

        $architect_id = intval($request->input('architect_id'));
        if(intval($architect_id) > 0)
            $projects->where('architect', $architect_id);

        $interior_id = intval($request->input('interior_id'));
        if(intval($interior_id) > 0)
            $projects->where('interior', $interior_id);

        $contractor_id = intval($request->input('contractor_id'));
        if(intval($contractor_id) > 0)
            $projects->where('main_contractor', $contractor_id);

        $project_budget = intval($request->input('project_budget'));
        if($project_budget!='')
            $projects->where('project_budget', $project_budget);

        $product_category_id = intval($request->input('product_category_id'));
        if(intval($product_category_id) > 0){
            $projects->whereHas('getProjectProductCategories', function($query) use ($product_category_id) { 
                $query->where('product_category_id',$product_category_id);              
            }); 
        }

        $start_date = $request->input('start_date');
        if($start_date!=''){
           $start_date = date('Y-m-d', strtotime($start_date));
           $projects->whereDate('commencement_date', '>=', $start_date);
        } 
        
        $end_date = $request->input('end_date');
        if($end_date!=''){
           $end_date = date('Y-m-d', strtotime($end_date));
           $projects->whereDate('completion_date', '<=', $end_date);
        } 
        
        return DataTables::of($projects)
        ->editColumn('is_active', function ($project) {
            if(Auth::user()->roles->first()->id == config('constants.ROLE_TYPE_SUPERADMIN_ID')){ 
                if($project->is_active == TRUE ){
                    return "<span class='badge badge-success'>Active</span>";
                }else{
                    return "<span class='badge badge-danger'>Inactive</span>";
                }
            }else{
                if($project->is_active == TRUE ){
                    return "<a href='".route('admin.project.status',[$project->id])."'><span class='badge badge-success'>Active</span></a>";
                }else{
                    return "<a href='".route('admin.project.status',[$project->id])."'><span class='badge badge-danger'>Inactive</span></a>";
                }
            }
        })
        ->editColumn('created_by', function ($project) {
                return isset($project->users->name)?$project->users->name:'';
        })
        ->editColumn('commencement_date', function ($project){
                $commencement_date=$project->commencement_date?$project->commencement_date:date('Y-m-d');
                return  date('d M Y', strtotime($commencement_date));  
        })
        ->editColumn('completion_date', function ($project){
                $completion_date=$project->completion_date?$project->completion_date:date('Y-m-d');
                return  date('d M Y', strtotime($completion_date));  
              
        })
        ->addColumn('action', function ($project) {
            $html='';
            if(Auth::user()->roles->first()->id != config('constants.ROLE_TYPE_SUPERADMIN_ID')){  
                $html.='<a href="'.route('admin.project.edit',[$project->id]).'" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></a> <a href="'.route('admin.projects.prereview',[$project->id]).'" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-user-edit"></i></a> ';

               $html.= Form::open(array(
                        'style' => 'display: inline-block;',
                        'method' => 'DELETE',
                        'onsubmit'=>"return confirm('Do you really want to delete?')",
                        'url' => route('admin.project.destroy', [$project->id]))).
                        ' <button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>'.
                        Form::close();
            }else{
                $html.= '<a href="'.route('admin.projects.prereview',[$project->id]).'" class="btn btn-warning btn-circle btn-sm"><i class="fas fa-user-edit"></i></a>';
            }
            return $html;
        })
        ->rawColumns(['is_active','action'])
        ->make(true);

    }

    public function create(Request $request) 
    {   
        if(Auth::user()->roles->first()->id != config('constants.ROLE_TYPE_SUPERADMIN_ID')){  
            $projecttype = ProjectType::where(['is_active'=>TRUE])->pluck('title', 'id');
            $project =Project::where(enquiryDetails['is_active'=>TRUE])->pluck('project_name', 'id');
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
        }else{
            $request->session()->flash('danger',__('Project Create Not Allow For Admin.'));
            return redirect()->route('admin.project.index'); 
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // $rules = [
        //     'project_name'=>'required',
        //     'project_type_id'=>'required',
        //     'project_date'=>'required',
        //     'project_type_id'=>'required',
        //     'commencement_date'=>'required',
        //     'developer'=>'required',
        //     'project_budget'=>'required',
        //     'completion_date'=>'required',
        //     'architect_id'=>'required',
        //     'main_contractor'=>'required',
        //     'project_product_category[]'=>'required', 
        // ];

        // $request->validate($rules);

        $data= $request->except(['sub_product_id','expected_date','enq_source_list','contractor_id','sub_contractor']);
        $project_date=isset($request->project_date)?$request->project_date:date('Y-m-d');
        $commencement_date=isset(enquiryDetails$request->commencement_date)?$request->commencement_date:date('Y-m-d');
        $completion_date=isset($request->completion_date)?$request->completion_date:date('Y-m-d');

        $add_developer=isset($data['add_developer'])?$data['add_developer']:'';
        $add_project_financier=isset($data['add_project_financier'])?$data['add_project_financier']:'';
        $add_surveyor_qty=isset($data['add_surveyor_qty'])?$data['add_surveyor_qty']:'';
        $add_mech_engg=isset($data['add_mech_engg'])?$data['add_mech_engg']:'';
        $add_architect=isset($data['add_architect'])?$data['add_architect']:'';
        $add_interior=isset($data['add_interior'])?$data['add_interior']:'';
        $add_main_contractor=isset($data['add_main_contractor'])?$data['add_main_contractor']:'';

        $project_product_category=isset($data['project_product_category'])?$data['project_product_category']:array();
        
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
        $data['created_by']=Auth::user()->id;  
        $data['main_contractor'] =  isset($data['main_contractor'])?$data['main_contractor']:'';
        $data['mech_engg'] =  isset($data['mech_engg_id'])?$data['mech_engg_id']:'';
        $data['project_financier'] =  isset($data['financier_id'])?$data['financier_id']:'';
        $data['surveyor_qty'] =  isset($data['quantity_id'])?$data['quantity_id']:'';
        $data['architect'] =  isset($data['architect_id'])?$data['architect_id']:'';
        $data['interior'] =  isset($data['interior_id'])?$data['interior_id']:'';
        $project=Project::create($data);
                // backend start
        if(isset($request->contractor_id) && isset($request->sub_contractor)){
            foreach ($request->contractor_id as $key => $contractor_id) {
              $sub_c=$request->sub_contractor[$key];
              if($contractor_id!='' && $sub_c!=''){
                Project_has_sub_contractor::create(['project_id'=>$project->id,'contractor_id'=>$contractor_id,'sub_contractor'=>$request->sub_contractor[$key]]);
              }
            }
        }
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

            /*if(isset($request->product_category)){
                foreach($request->enq_source as $key=>$enq){
                    $source=explode('-',$enq);
                    $expected_date = date('Y-m-d', strtotime($request->expected_date[$key]));
                    $data=[
                        'project_id'=>$project->id,
                        'product_category_id' => isset($request->product_category[$key])?$request->product_category[$key]:'',
                        'expected_date' =>isset($expected_date)?$expected_date:date('Y-m-d'),
                        'enq_source' => isset($source[0])?$source[0]:0,
                        'enq_source_type'=>isset($source[1])?$source[1]:''
                    ];
                    ProjectEnquiry::insert($data);
                }   
            }*/

            if(!empty($project_product_category)){
                foreach($project_product_category as $key=>$category){
                    $prodject_data=[
                        'project_id'=>$project->id,
                        'product_category_id' => $category,
                    ];
                    ProjectHasProductCategory::create($prodject_data);
                }   
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
    public function edit(Request $request, $id)
    {
        if(Auth::user()->roles->first()->id != config('constants.ROLE_TYPE_SUPERADMIN_ID')){  

            $project = Project::with('getprojecttype','Projectenquiry','getdeveloper','getfinancier','getquantity','getmengineer','getarchitect','getinterior','getmcontractor','getpcategory','getsubcontractor','project_has_sub_contractor')->findOrFail($id);
           // echo "<pre>"; print_r($project->project_has_sub_contractor); die();
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
                    }elseif($people->enq_source_type == 'financier'){
                        $people_list=Financier::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
                        $people_list=$people_list->id.'-'.'financier';
                    }elseif($people->enq_source_type == 'quantity'){
                       $people_list=Quantity::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
                       $people_list=$people_list->id.'-'.'quantity';
                    }elseif($people->enq_source_type == 'engineer'){
                       $people_list=MechanicalEngineer::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
                       $people_list=$people_list->id.'-'.'engineer';
                    }elseif($people->enq_source_type == 'architect'){
                       $people_list=Architect::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
                       $people_list=$people_list->id.'-'.'architect';
                    }elseif($people->enq_source_type == 'interior'){
                       $people_list=Interior::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
                       $people_list=$people_list->id.'-'.'interior';
                    }elseif($people->enq_source_type == 'contractor'){
                        $people_list=Contractor::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
                        $people_list=$people_list->id.'-'.'contractor';
                }
                else{

                }
            }

    }
    $productCategories=ProjectHasProductCategory::where('project_id',$id)->pluck('product_category_id');
    return view('admin.project.edit',compact('project','productcategory','projecttype','architect','clientdeveloper','financier','interior','mechanicalEngineer','quantity','contractor','subcontractor','people_list','productCategories'));

    }else{
            $request->session()->flash('danger',__('Project Edit Not Allow For Admin.'));
            return redirect()->route('admin.project.index'); 
    }

}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $project = Project::findOrFail($id);
        $rules = [
            'project_name'=>'required',
        ];
        $request->validate($rules);
        $data= $request->except(['expected_date','enq_source_list','sub_contractor','contractor_id']);
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
        $data['main_contractor'] =  isset($data['main_contractor'])?$data['main_contractor']:'';
        $data['mech_engg'] =  isset($data['mech_engg_id'])?$data['mech_engg_id']:'';
        $data['project_financier'] =  isset($data['financier_id'])?$data['financier_id']:'';
        $data['surveyor_qty'] =  isset($data['quantity_id'])?$data['quantity_id']:'';
        $data['architect'] =  isset($data['architect_id'])?$data['architect_id']:'';
        $data['interior'] =  isset($data['interior_id'])?$data['interior_id']:'';

        $project_product_category=isset($data['project_product_category'])?$data['project_product_category']:array();
        

        $project->update($data);
        if(isset($request->contractor_id) && isset($request->sub_contractor)){
            Project_has_sub_contractor::where(['project_id'=>$id])->delete();
            foreach ($request->contractor_id as $key => $contractor_id) {
              $sub_c=$request->sub_contractor[$key];
              if($contractor_id!='' && $sub_c!=''){
                  Project_has_sub_contractor::create(['project_id'=>$id,'contractor_id'=>$contractor_id,'sub_contractor'=>$request->sub_contractor[$key]]);
              }
            }
        }
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


            if(!empty($project_product_category)){
                ProjectHasProductCategory::where('project_id',$id)->delete();
                foreach($project_product_category as $key=>$category){
                    $prodject_data=[
                        'project_id'=>$project->id,
                        'product_category_id' => $category,
                    ];
                    ProjectHasProductCategory::create($prodject_data);
                }   
            }
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
    public function destroy(Request $request, $id=null){
        if(Auth::user()->roles->first()->id != config('constants.ROLE_TYPE_SUPERADMIN_ID')){  
            $project = Project::findOrFail($id);
            if($project->id == config('constants.CATEGORY_TYPE_QURAN_ID')){
                $request->session()->flash('danger',__('global.messages.default_message_category'));
                return redirect()->route('admin.project.index'); 
            }else{
               $project->delete();
               Project_has_sub_contractor::where(['project_id'=>$id])->delete();
               ProjectEnquiry::where('project_id',$id)->delete();
               $request->session()->flash('danger',__('global.messages.delete'));
               return redirect()->route('admin.project.index'); 
           }
        }else{
            $request->session()->flash('danger',__('Project Delete Not Allow For Admin.'));
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

    // newly added functions
    public function projectpreview(Request $request){
        try {
            $id=$request->id;
            $sales=User::with('roles')->whereHas('roles', function($query){
                $query->where('id',config('constants.ROLE_TYPE_SALES_ID'));
            })->where(['is_active'=>TRUE])->pluck('name', 'id');
            $projecttype = ProjectType::where(['is_active'=>TRUE])->pluck('title', 'id');
            $productcategory=ProductCategory::where(['is_active'=>TRUE])->pluck('title', 'id');
            return view('admin.project.review',compact('id','sales','projecttype','productcategory'));
        } catch (Exception $e) {

        }  
    }

    public function getpreview(Request $request){
       try {
            $projectenquiry = ProjectEnquiry::query()->with('getproductcategory','getremarks','getProject')->select([\DB::raw(with(new ProjectEnquiry)->getTable().'.*')])->groupBy('id');

            if($request->input('id') && $request->id!=''){
               $projectenquiry->where('project_id',$request->id);
            }
           
            $product_category_id = intval($request->input('product_category_id'));
            if(intval($product_category_id) > 0){
                $projectenquiry->where('product_category_id',$product_category_id);              
            }

            $sales_id = intval($request->input('sales_id'));
            if(intval($sales_id) > 0){
                $projectenquiry->whereHas('getProject', function($query) use ($sales_id) { 
                    $query->where('created_by',$sales_id);              
                }); 
            }

            $type_id = intval($request->input('type_id'));
            if(intval($type_id) > 0){
                $projectenquiry->whereHas('getProject', function($query) use ($type_id) { 
                    $query->where('project_type_id',$type_id);              
                }); 
            }

            $source =$request->input('source');
            if($source!=''){
                $projectenquiry->where('enq_source_type',$source);              
            }
           
            $status = $request->input('status');
            if($status !=''){
                if($status=='live'){
                      $projectenquiry->where('won_loss',null);  
                }else{
                     $projectenquiry->where('won_loss',$status);    
                }
            }
            
            $expected_date = $request->input('expected_date');
            if($expected_date!=''){
               $expected_date = date('Y-m-d', strtotime($expected_date));
               $projectenquiry->whereDate('expected_date', '>=', $expected_date);
            } 
            
            $received_date = $request->input('received_date');
            if($received_date!=''){
               $received_date = date('Y-m-d', strtotime($received_date));
               $projectenquiry->whereDate('received_date', '<=', $received_date);
            } 

            return  DataTables::of($projectenquiry)
            ->editColumn('expected_date', function ($project){
                $expected_date=$project->expected_date?$project->expected_date:date('Y-m-d');
                return  date('d M Y', strtotime($expected_date));  
            })
            ->editColumn('enq_source_type', function ($project){
                return  isset($project->enq_source_type)?ucwords($project->enq_source_type):'';
            })
            ->editColumn('received_date', function ($project){
                $received_date=$project->received_date?$project->received_date:'';
                if($received_date!=''){
                    return  date('d M Y', strtotime($received_date));  
                }
                return '';
            })
            ->editColumn('enq_source', function ($project){
                $enq_source=isset($project->enq_source)?$project->enq_source:'';
                $enq_source_type=isset($project->enq_source_type)?$project->enq_source_type:'';
                      $people_list='';
                
                if($enq_source_type == 'client'){
                    $people_list=Client::where('id',$enq_source)->where('is_active',1)->select('name')->first();
                }elseif($enq_source_type== 'financier'){
                    $people_list=Financier::where('id',$enq_source)->where('is_active',1)->select('name')->first();
                }elseif($enq_source_type== 'quantity'){
                   $people_list=Quantity::where('id',$enq_source)->where('is_active',1)->select('name')->first();
                }elseif($enq_source_type== 'engineer'){
                   $people_list=MechanicalEngineer::where('id',$enq_source)->where('is_active',1)->select('name')->first();
                }elseif($enq_source_type== 'architect'){
                   $people_list=Architect::where('id',$enq_source)->where('is_active',1)->select('name')->first();
                }elseif($enq_source_type== 'interior'){
                   $people_list=Interior::where('id',$enq_source)->where('is_active',1)->select('name')->first();
                }elseif($enq_source_type== 'contractor'){
                    $people_list=Contractor::where('id',$enq_source)->where('is_active',1)->select('name')->first();
                }
                return  $people_list['name'];
            })
            ->editColumn('enq_source_type', function ($project){
                $enq_source_type=isset($project->enq_source_type)?$project->enq_source_type:'';
                if($enq_source_type=='quantity'){
                        return 'Quantity Surveyor';
                }else if($enq_source_type=='engineer'){
                           return 'Mechanical Engineer';
                }
                    return  isset($project->enq_source_type)?ucwords($project->enq_source_type):'';
            })
            ->editColumn('won_loss', function ($project){
                $won_loss=$project->won_loss?$project->won_loss:'';
                if($won_loss==''){
                   return 'Live';
                }
                return $won_loss;
            })
            ->editColumn('quotation_date', function ($project){
                $quotation_date=$project->quotation_date?$project->quotation_date:'';
                if($quotation_date!=''){
                    return date('d M Y', strtotime($quotation_date)); 
                }
                return  '';
            })->editColumn('remarks', function ($project){
                return $project->remarks;
            })->addColumn('action', function ($projectenquiry) {
                   $html='';
                    if(Auth::user()->roles->first()->id != config('constants.ROLE_TYPE_SUPERADMIN_ID')){  
                        $html.='<a href="'.route('admin.projects.editenquiry',[$projectenquiry->id]).'" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></a> <a href="'.route('admin.projects.addremarks',[$projectenquiry->id]).'" class="btn btn-info btn-circle btn-sm"><i class="fa fa-plus" aria-hidden="true"></i></a> <a href="'.route('admin.projects.viewremark',[$projectenquiry->id]).'" class="btn btn-secondary btn-circle btn-sm"><i class="fas fa-eye" aria-hidden="true"></i></a>';
                    }else{
                        $html.= '<a href="'.route('admin.projects.viewremark',[$projectenquiry->id]).'" class="btn btn-secondary btn-circle btn-sm"><i class="fas fa-eye" aria-hidden="true"></i></a>';
                    }
            return $html;

           })->rawColumns(['action'])->make(true);
        } catch (Exception $e) {

        }  
    }

    public function addEnquiry(Request $request, $id){

        if(Auth::user()->roles->first()->id != config('constants.ROLE_TYPE_SUPERADMIN_ID')){  
            $project_id=$id;
            $project=Project::with('Projectenquiry')->where('id',$project_id)->first()->toArray();
            $projecttype = ProjectType::where(['is_active'=>TRUE])->pluck('title', 'id');
            $productcategory=ProductCategory::where(['is_active'=>TRUE])->pluck('title', 'id');
            $clientdeveloper=Client::where(['is_active'=>TRUE,'id'=>$project['developer']])->pluck('name', 'id');
            $architect=Architect::where(['is_active'=>TRUE,'id'=>$project['architect']])->pluck('name', 'id');
            $financier=Financier::where(['is_active'=>TRUE,'id'=>$project['project_financier']])->pluck('name', 'id');
            $interior=Interior::where(['is_active'=>TRUE,'id'=>$project['interior']])->pluck('name', 'id');
            $mechanicalEngineer=MechanicalEngineer::where(['is_active'=>TRUE,'id'=>$project['mech_engg']])->pluck('name', 'id');
            $quantity=Quantity::where(['is_active'=>TRUE,'id'=>$project['surveyor_qty']])->pluck('name', 'id');
            $contractor=Contractor::where(['is_active'=>TRUE,'id'=>$project['main_contractor']])->pluck('name', 'id');
            $subcontractor=SubContractor::where(['is_active'=>TRUE,'id'=>$project['developer']])->pluck('title', 'id');
            $people_list='';
            // echo "<pre>";
            // print_r($project);die;
            
                //     if(isset($project->Projectenquiry)){
                //         foreach($project->Projectenquiry as $people){
                //             if($people->enq_source_type == 'client'){
                //                 $people_list=Client::where('id',$project->developer)->where('is_active',1)->select('id','name')->first();
                //                 $people_list=$people_list->id.'-'.'client';
                //             }
                //             elseif($people->enq_source_type == 'financier'){
                //                 $people_list=Financier::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
                //                 $people_list=$people_list->id.'-'.'financier';
                //             }
                //             elseif($people->enq_source_type == 'quantity'){
                //                $people_list=Quantity::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
                //                $people_list=$people_list->id.'-'.'quantity';
                //            }
                //            elseif($people->enq_source_type == 'engineer'){
                //                $people_list=MechanicalEngineer::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
                //                $people_list=$people_list->id.'-'.'engineer';
                //            }
                //            elseif($people->enq_source_type == 'architect'){
                //                $people_list=Architect::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
                //                $people_list=$people_list->id.'-'.'architect';
                //            }
                //            elseif($people->enq_source_type == 'interior'){
                //                $people_list=Interior::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
                //                $people_list=$people_list->id.'-'.'interior';
                //            }
                //            elseif($people->enq_source_type == 'contractor'){
                //             $people_list=Contractor::where('id',$people->enq_source)->where('is_active',1)->select('id','name')->first();
                //             $people_list=$people_list->id.'-'.'contractor';
                //         }
                //         else{
                //             $people_list='';
                //         }
                //     }
                // }
                return view('admin.project.enquiry',compact('project_id','productcategory','projecttype','architect','clientdeveloper','financier','interior','mechanicalEngineer','quantity','contractor','subcontractor','people_list'));
        }else{
            $request->session()->flash('danger',__('Enquiry Create Not Allow For Admin.'));
            return redirect()->route('admin.project.index'); 
        }
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
                    'expected_budget' => isset($request->expected_budget[$key])?$request->expected_budget[$key]:'',
                    'enq_source_type'=>isset($source[1])?$source[1]:''
                ];
                ProjectEnquiry::insert($data);
            }  
        }
        $request->session()->flash('success',__('global.messages.add'));
        return redirect()->route('admin.projects.prereview',$request->project_id); 
    }


    public function editenquiry(Request $request ,$id){

        if(Auth::user()->roles->first()->id != config('constants.ROLE_TYPE_SUPERADMIN_ID')){  
            $project= ProjectEnquiry::findOrFail($id);
            $projects=Project::where('id',$project['project_id'])->first()->toArray();
            $projecttype = ProjectType::where(['is_active'=>TRUE])->pluck('title', 'id');
            $productcategory=ProductCategory::where(['is_active'=>TRUE])->pluck('title', 'id');
           
            $clientdeveloper=Client::where(['is_active'=>TRUE,'id'=>$projects['developer']])->pluck('name', 'id');
            $architect=Architect::where(['is_active'=>TRUE,'id'=>$projects['architect']])->pluck('name', 'id');
            $financier=Financier::where(['is_active'=>TRUE,'id'=>$projects['project_financier']])->pluck('name', 'id');
            $interior=Interior::where(['is_active'=>TRUE,'id'=>$projects['interior']])->pluck('name', 'id');
            $mechanicalEngineer=MechanicalEngineer::where(['is_active'=>TRUE,'id'=>$projects['mech_engg']])->pluck('name', 'id');
            $quantity=Quantity::where(['is_active'=>TRUE,'id'=>$projects['surveyor_qty']])->pluck('name', 'id');
            $contractor=Contractor::where(['is_active'=>TRUE,'id'=>$projects['main_contractor']])->pluck('name', 'id');
            $subcontractor=SubContractor::where(['is_active'=>TRUE,'id'=>$projects['developer']])->pluck('title', 'id');
            
            $people_list='';
            if(isset($project)){
                if($project->enq_source_type == 'client'){
                    $people_list=Client::where('id',$project->enq_source)->where('is_active',1)->select('id','name')->first();
                    $people_list=$people_list->id.'-'.'client';
                }elseif($project->enq_source_type == 'financier'){
                    $people_list=Financier::where('id',$project->enq_source)->where('is_active',1)->select('id','name')->first();
                    $people_list=$people_list->id.'-'.'financier';
                }elseif($project->enq_source_type == 'quantity'){
                   $people_list=Quantity::where('id',$project->enq_source)->where('is_active',1)->select('id','name')->first();
                   $people_list=$people_list->id.'-'.'quantity';
               }elseif($project->enq_source_type == 'engineer'){
                   $people_list=MechanicalEngineer::where('id',$project->enq_source)->where('is_active',1)->select('id','name')->first();
                   $people_list=$people_list->id.'-'.'engineer';
               }elseif($project->enq_source_type == 'architect'){
                   $people_list=Architect::where('id',$project->enq_source)->where('is_active',1)->select('id','name')->first();
                   $people_list=$people_list->id.'-'.'architect';
               }elseif($project->enq_source_type == 'interior'){
                   $people_list=Interior::where('id',$project->enq_source)->where('is_active',1)->select('id','name')->first();
                   $people_list=$people_list->id.'-'.'interior';
               }elseif($project->enq_source_type == 'contractor'){
                $people_list=Contractor::where('id',$project->enq_source)->where('is_active',1)->select('id','name')->first();
                $people_list=$people_list->id.'-'.'contractor';
                }else{
                    $people_list='';
                } 
            }
            return view('admin.project.editenquiry',compact('project','productcategory','projecttype','architect','clientdeveloper','financier','interior','mechanicalEngineer','quantity','contractor','subcontractor','people_list'));
        }else{
                $request->session()->flash('danger',__('Enquiry Edit Not Allow For Admin.'));
                return redirect()->route('admin.project.index'); 
        }

    }



    public function updateEnquiry(Request $request , $id){
        $enq=explode('-',$request->enq_source);
        $data=[
            'product_category_id'=>$request->product_category,
            'expected_date'=>date('Y-m-d', strtotime($request->expected_date)),
            'received_date'=>date('Y-m-d', strtotime($request->received_date)),
            'won_loss'=>$request->won_loss,
            'quotation_date'=>date('Y-m-d', strtotime($request->quotation_date)),
            'expected_budget' => isset($request->expected_budget)?$request->expected_budget:'',
            'enq_source'=>$enq[0],
            'enq_source_type'=>$enq[1],
        ];
        ProjectEnquiry::where('id',$id)->update($data);
        if(isset($request->remarks) && $request->remarks!=''){
            $date= date('Y-m-d', strtotime("now"));
            $remark=[
                'enquiry_id'=>$id,
                'remarks'=>$request->remarks,
                'date'=>$date
                ];
            EnquiryRemarks::insert($remark);
        }
        $project_id=ProjectEnquiry::where('id',$id)->select('project_id')->first();
        $request->session()->flash('success',__('global.messages.add'));
        return redirect()->route('admin.projects.prereview',$project_id->project_id); 
    }




    public function addremarks(Request $request,$id){
        if(Auth::user()->roles->first()->id != config('constants.ROLE_TYPE_SUPERADMIN_ID')){ 
            $project=ProjectEnquiry::where('id',$id)->pluck('project_id');
            $project_id=$project[0];
            return view('admin.project.addremarks',compact('id','project_id'));
        }else{
            $request->session()->flash('danger',__('Remarks Create Not Allow For Admin.'));
            return redirect()->route('admin.project.index'); 
        }
    }



    public function saveremark(Request $request){
        $date= date('Y-m-d', strtotime("now"));
        $remark=[
            'enquiry_id'=>$request->enquiry_id,
            'remarks'=>$request->remarks,
            'date'=>$date
        ];
        EnquiryRemarks::insert($remark);
        $project_id=ProjectEnquiry::where('id',$request->enquiry_id)->select('project_id')->first();
        $request->session()->flash('success',__('global.messages.add'));
        return redirect()->route('admin.projects.prereview',$project_id->project_id);
    }

    public function viewremark($id){
        $remarks = ProjectEnquiry::with('getremarks','getProject','getProject.project_has_sub_contractor','getProject.project_has_sub_contractor.getSubcontractor')->where('id',$id)->first();

        $project_id=isset($remarks->getProject->id)?$remarks->getProject->id:'';
        $productcategories=ProjectHasProductCategory::with('category')->where('project_id',$project_id)->get();
        return view('admin.project.viewremarks',compact('remarks','productcategories'));
    }
}
