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
use App\Clientdeveloper;
use App\Financier;
use App\Interior;
use App\MechanicalEngineer;
use App\Quantity;
use App\Contractor;


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
        $projects = Project::query()->with('getdeveloper');
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
                    // Delete
                    Form::open(array(
                        'style' => 'display: inline-block;',
                        'method' => 'DELETE',
                        'onsubmit'=>"return confirm('Do you really want to delete?')",
                        'url' => route('admin.project.destroy', [$project->id]))).
                    ' <button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>'.
                    Form::close();
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
        $clientdeveloper=Clientdeveloper::where(['is_active'=>TRUE])->pluck('name', 'id');
        $financier=Financier::where(['is_active'=>TRUE])->pluck('name', 'id');
        $interior=Interior::where(['is_active'=>TRUE])->pluck('name', 'id');
        $mechanicalEngineer=MechanicalEngineer::where(['is_active'=>TRUE])->pluck('name', 'id');
        $quantity=Quantity::where(['is_active'=>TRUE])->pluck('name', 'id');
        $contractor=Contractor::where(['is_active'=>TRUE])->pluck('name', 'id');

      
        $peoplelist=['1'=>'people1','2'=>'people2'];


        return view('admin.project.form',compact('projecttype','project','productcategory','subcontractor','architect','clientdeveloper','financier','interior','mechanicalEngineer','quantity','peoplelist','contractor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
// dd($request->all());
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

        // dd($request->all());
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
        $sub_contractor=isset($data['sub_contractor'])?$data['sub_contractor']:'';
     

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
             $data['sub_contractor_id'] =  isset($data['sub_contractor_id'])?$data['sub_contractor_id']:'';
         

                $project=Project::create($data);
                // backend start
            
                if($project->id > 0){
                    if($data['developer']=='add_new_client'){
                        $developer=Clientdeveloper::create(['name'=>$add_developer]);
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

                    if($data['contractor_id']=='add_new_contractor'){
                        $contractor=Contractor::create(['name'=>$add_main_contractor]);
                        $contractor_id=$contractor->id;
                    }else{
                        $contractor_id = isset($data['contractor_id'])?$data['contractor_id']:0;
                    }
                 $project->update(array('main_contractor'=>$contractor_id));


                    if($data['quantity_id']=='add_new_quantity'){
                        $quantity=Quantity::create(['name'=>$add_surveyor_qty]);
                        $quantity_id=$quantity->id;
                    }else{
                        $quantity_id = isset($data['quantity_id'])?$data['quantity_id']:0;
                    }
                   $project->update(array('surveyor_qty'=>$quantity_id));


                    // if(isset($data['sub_contractor'])){
                    //     $sub_contractor=SubContractor::create(['title'=>$add_surveyor_qty]);
                    //     $sub_contractor_id=$sub_contractor->id;
                    // }else{
                    //     $sub_contractor_id = isset($data['sub_contractor'])?$data['sub_contractor']:0;
                    // }
                    //  $project->update(array('sub_contractor_id'=>$sub_contractor_id));


                 

               

                // backend end


                    }
        if(isset($request->product_category)){
            for ($i = 0; $i < count($request->product_category); $i++){
                $expected_date = date('Y-m-d', strtotime($request->expected_date[$i]));
                $data=[
                    'project_id'=>$project->id,
                    'product_category_id' => $request->product_category[$i],
                    'expected_date' =>isset($expected_date)?$expected_date:date('Y-m-d'),
                    'enq_source' => $request->people_list[$i],
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
        $clientdeveloper=Clientdeveloper::where(['is_active'=>TRUE])->pluck('name', 'id');
        $financier=Financier::where(['is_active'=>TRUE])->pluck('name', 'id');
        $interior=Interior::where(['is_active'=>TRUE])->pluck('name', 'id');
        $mechanicalEngineer=MechanicalEngineer::where(['is_active'=>TRUE])->pluck('name', 'id');
        $quantity=Quantity::where(['is_active'=>TRUE])->pluck('name', 'id');
        $contractor=Contractor::where(['is_active'=>TRUE])->pluck('name', 'id');
        $peoplelist=['1'=>'people1','2'=>'people2'];
        $subcontractor=SubContractor::where(['is_active'=>TRUE])->pluck('title', 'id');    
        return view('admin.project.edit',compact('project','productcategory','projecttype','architect','clientdeveloper','financier','interior','mechanicalEngineer','quantity','contractor','peoplelist','subcontractor'));
        
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
        // $project->update($data);

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
        $sub_contractor=isset($data['sub_contractor'])?$data['sub_contractor']:'';
     

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
             $data['sub_contractor_id'] =  isset($data['sub_contractor_id'])?$data['sub_contractor_id']:'';
       
        

                $project->update($data);
                // backend start
            
                if($project->id > 0){
                    if($data['developer']=='add_new_client'){
                        $developer=Clientdeveloper::create(['name'=>$add_developer]);
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

                    if($data['contractor_id']=='add_new_contractor'){
                        $contractor=Contractor::create(['name'=>$add_main_contractor]);
                        $contractor_id=$contractor->id;
                    }else{
                        $contractor_id = isset($data['contractor_id'])?$data['contractor_id']:0;
                    }
                 $project->update(array('main_contractor'=>$contractor_id));


                    if($data['quantity_id']=='add_new_quantity'){
                        $quantity=Quantity::create(['name'=>$add_surveyor_qty]);
                        $quantity_id=$quantity->id;
                    }else{
                        $quantity_id = isset($data['quantity_id'])?$data['quantity_id']:0;
                    }
                   $project->update(array('surveyor_qty'=>$quantity_id));


                    // if(isset($data['sub_contractor'])){
                    //     $sub_contractor=SubContractor::create(['title'=>$add_surveyor_qty]);
                    //     $sub_contractor_id=$sub_contractor->id;
                    // }else{
                    //     $sub_contractor_id = isset($data['sub_contractor'])?$data['sub_contractor']:0;
                    // }
                    //  $project->update(array('sub_contractor_id'=>$sub_contractor_id));
                }


        if(!empty(ProjectEnquiry::where('project_id',$id)->get())){
            ProjectEnquiry::where('project_id',$id)->delete();
            if(isset($request->product_category)){
                for ($i = 0; $i < count($request->product_category); $i++){
                    $expected_date = date('Y-m-d', strtotime($request->expected_date[$i]));
                    // $received_date = date('Y-m-d', strtotime($request->received_date[$i]));
                    // $quotation_date = date('Y-m-d', strtotime($request->quotation_date[$i]));
                    $data=[
                        'project_id'=>$project->id,
                        'product_category_id' => $request->product_category[$i],
                        'expected_date' =>isset($expected_date)?$expected_date:date('Y-m-d'),
                        'enq_source' => $request->people_list[$i],
                        // "received_date" => isset($received_date)?$received_date:date('Y-m-d'),
                        // "quotation_date" => isset($quotation_date)?$quotation_date:date('Y-m-d'),
                        // "remarks" => isset($request->remarks[$i])?$request->remarks[$i]:'',
                        // "won_loss" => isset($request->won_loss[$i])?$request->won_loss[$i]:'Loss'
                    ];
                    ProjectEnquiry::insert($data);
                }
            }
        }
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
            return view('admin.project.review');
          
        } catch (Exception $e) {
           
        }  
    }
    
    public function getpreview(Request $request){
        try {
            $projectenquiry = ProjectEnquiry::with('getproductcategory');
        return DataTables::of($projectenquiry)
         ->editColumn('expected_date', function ($project) {
            $expected_date=$project->expected_date?$project->expected_date:date('Y-m-d');
            return  date('d M Y', strtotime($expected_date));  
        })
        ->editColumn('received_date', function ($project){
            $received_date=$project->received_date?$project->received_date:date('Y-m-d');
            return  date('d M Y', strtotime($received_date));  
        })->editColumn('quotation_date', function ($project){
            $quotation_date=$project->quotation_date?$project->quotation_date:date('Y-m-d');
            return  date('d M Y', strtotime($quotation_date));  
        })->make(true); 
        } catch (Exception $e) {
        //    dd($e->getMessage());
        } 
       
    }


}
