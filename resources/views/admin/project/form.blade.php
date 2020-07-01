    @extends('admin.layouts.valex_app')
    @section('content')
    <div class="container">
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <div>
                  <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Project</h2>
              </div>
          </div>
      </div>

      <div class="row row-sm">
        <div class="col-xl-12">
            <!-- Content Row -->
            <div class="card">
                {!! Form::open(['method' => 'POST', 'url' => isset($project->id)?route('admin.project.update',[$project->id]):route('admin.project.store'),'class' => 'form-horizontal','id' => 'frmproject']) !!}
                @csrf
                @if(isset($project->id))
                @method('PUT')
                @endif
                <div class="card-header py-3 cstm_hdr">
                    <h6 class="m-0 font-weight-bold text-primary">{{ isset($project->id)?'Edit':'Add' }} Project</h6>
                    @if(isset($project->id))
                    <a href="{{route('admin.projects.prereview')}}" class="btn btn-sm btn-icon-split float-right btn-outline-warning">rewiew</a>
                    @endif
                </div> 
                <!-- card body start-->
                <div class="card-body">
                    <!-- small to form start -->
                    <!-- row 1 -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="col-md-12 form-group {{$errors->has('commencement_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                                {!! Form::text('commencement_date', old('commencement_date', isset($project->commencement_date)?date('d/m/Y', strtotime($project->commencement_date)) :''), [ 'id'=>'commencement_date_id','class' => 'form-control datepicker', 'placeholder' => 'MM/DD/YYYY']) !!}
                                @if($errors->has('commencement_date'))
                                <p class="help-block">
                                    <strong>{{ $errors->first('commencement_date') }}</strong>
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>


                    <!-- row 2 -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="col-md-12 form-group {{$errors->has('project_type_id') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                             {!! Form::select('project_type_id', $projecttype, old('project_type_id', isset($projecttype->id)?$projecttype->id:''), ['id'=>'project_type_id', 'class' => 'form-control', 'placeholder' => '-Select Project Type-']) !!}
                             @if($errors->has('project_type_id'))
                             <p class="help-block">
                                <strong>{{ $errors->first('project_type') }}</strong>
                            </p>
                            @endif                       
                        </div>
                    </div>
                </div>

                <!-- row 3 -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="col-md-12 form-group {{$errors->has('project_name') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                         {!! Form::text('project_name', old('project_name', isset($project->id)?$project->id:''), ['id'=>'project_name', 'class' => 'form-control', 'placeholder' => 'Project Name']) !!}
                         @if($errors->has('project_name'))
                         <p class="help-block">
                            <strong>{{ $errors->first('project_name') }}</strong>
                        </p>
                        @endif                       
                    </div>
                </div>
            </div>
            <!-- small top form end -->
            <!-- row 1 start -->
            <div class="row">
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('commencement_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Date of Commencement<span style="color:red">*</span></label> 
                        {!! Form::text('commencement_date', old('commencement_date', isset($project->commencement_date)?date('d/m/Y', strtotime($project->commencement_date)) :''), ['id'=>'project_commencement_date', 'class' => 'form-control datepicker', 'placeholder' => 'MM/DD/YYYY']) !!}
                        @if($errors->has('commencement_date'))
                        <p class="help-block">
                            <strong>{{ $errors->first('commencement_date') }}</strong>
                        </p>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('completion_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Expected Date of Completion<span style="color:red">*</span></label> 
                        {!! Form::text('completion_date', old('completion_date', isset($project->completion_date)?date('d/m/Y', strtotime($project->completion_date)):''), ['id'=>'expected_date_completion', 'class' => 'form-control datepicker', 'placeholder' => 'Project Date']) !!}
                        @if($errors->has('completion_date'))
                        <p class="help-block">
                            <strong>{{ $errors->first('completion_date') }}</strong>
                        </p>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('project_budget') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Budget<span style="color:red">*</span></label> 
                        {!! Form::number('project_budget', old('project_budget', isset($project->project_budget)?$project->project_budget:''), ['id'=>'project_budget', 'class' => 'form-control', 'placeholder' => 'Project Budget']) !!}

                        @if($errors->has('project_budget'))
                        <p class="help-block">
                            <strong>{{ $errors->first('project_budget') }}</strong>
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            <!-- row 1 end -->
            <!-- row 2 -->
            <div class="row">
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('developer') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="developer">Client/Developer<span style="color:red">*</span></label>
                        <select name='developer' id='developer' class = 'form-control'>
                        <option value="">-Select-</option>
                        
                            <?php if(isset($clientdeveloper) && (!empty($clientdeveloper))){
                                foreach ($clientdeveloper as $key => $name) { ?>
                                      <option value="{{ $key }}">{{ $name }}</option>
                                 
                              <?php  } 
                            } 
                            ?>
                            <option value="add_new_client">Add New Client</option>
                        </select>
                      
                        @if($errors->has('developer'))
                        <p class="help-block">
                            <strong>{{ $errors->first('developer') }}</strong>
                        </p>
                        @endif                      
                    </div> 
                </div>
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('add_developer') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Add New Client/Developer</label>
                        {!! Form::text('add_developer', old('add_developer', isset($project->developer)?$project->developer:''), ['id'=>'add_developer','readOnly'=>'readOnly','class' => 'form-control', 'placeholder' => 'Add New Client / Developer']) !!}
                        @if($errors->has('add_developer'))
                        <p class="help-block">
                            <strong>{{ $errors->first('add_developer') }}</strong>
                        </p>
                        @endif
                    </div> 

                </div>
            </div>
            <!-- row 3 -->
            <div class="row">
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('financier_id') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="financier_id">Financier<span style="color:red">*</span></label>
                           <select name='financier_id' id='financier_id', class = 'form-control '>
                           <option value="">-Select-</option>
                            <?php if(isset($financier) && (!empty($financier))){
                                foreach ($financier as $key => $name) { ?>
                                      <option value="{{ $key }}">{{ $name }}</option>
                                 
                              <?php  } 
                            } 
                            ?>
                            <option value="add_new_financier">Add New Financier</option>
                        </select>
                       
                        @if($errors->has('financier_id'))
                        <p class="help-block">
                            <strong>{{ $errors->first('financier_id') }}</strong>
                        </p>
                        @endif                       
                    </div> 
                </div>
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('add_project_financier') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Add New Financier</label>
                        {!! Form::text('add_project_financier', old('add_project_financier', isset($project->project_financier)?$project->project_financier:''), ['id'=>'add_project_financier','readOnly'=>'readOnly', 'class' => 'form-control', 'placeholder' => 'Add New Financier']) !!}

                        @if($errors->has('add_project_financier'))
                        <p class="help-block">
                            <strong>{{ $errors->first('add_project_financier') }}</strong>
                        </p>
                        @endif
                    </div> 

                </div>
            </div>
            <!-- row 4 -->
            <div class="row">
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('quantity_id') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Quantity<span style="color:red">*</span></label>
                           <select name='quantity_id' id='quantity_id', class = 'form-control '>
                           <option value="">-Select-</option>
                            <?php if(isset($quantity) && (!empty($quantity))){
                                foreach ($quantity as $key => $name) { ?>
                                      <option value="{{ $key }}">{{ $name }}</option>
                                 
                              <?php  } 
                            } 
                            ?>
                            <option value="add_new_quantity">Add New Quantity</option>
                        </select>
                      
                        @if($errors->has('quantity_id'))
                        <p class="help-block">
                            <strong>{{ $errors->first('quantity_id') }}</strong>
                        </p>
                        @endif                       
                    </div> 
                </div>
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('add_surveyor_qty') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Add New Quantity</label>
                        {!! Form::text('add_surveyor_qty', old('surveyor_qty', isset($project->surveyor_qty)?$project->surveyor_qty:''), ['id'=>'add_surveyor_qty','readOnly'=>'readOnly', 'class' => 'form-control', 'placeholder' => 'Add New Quantity']) !!}

                        @if($errors->has('add_surveyor_qty'))
                        <p class="help-block">
                            <strong>{{ $errors->first('add_surveyor_qty') }}</strong>
                        </p>
                        @endif
                    </div> 
                </div>
            </div>
            <!-- row 5 -->
            <div class="row">
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('mech_engg_id') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Mechanical Engineer<span style="color:red">*</span></label>
                           <select name='mech_engg_id' id='mech_engg_id', class = 'form-control '>
                           <option value="">-Select-</option>
                            <?php if(isset($clientdeveloper) && (!empty($clientdeveloper))){
                                foreach ($clientdeveloper as $key => $name) { ?>
                                      <option value="{{ $key }}">{{ $name }}</option>
                                 
                              <?php  } 
                            } 
                            ?>
                            <option value="add_new_mech_engineer">Add New Mechanical Engineer</option>
                        </select>

                   
                        @if($errors->has('mech_engg_id'))
                        <p class="help-block">
                            <strong>{{ $errors->first('mech_engg_id') }}</strong>
                        </p>
                        @endif                       
                    </div> 
                </div>
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('add_mech_engg') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Add New Mechanical Engineer</label>
                        {!! Form::text('add_mech_engg', old('add_mech_engg', isset($project->mech_engg)?$project->mech_engg:''), ['id'=>'add_mech_engg','readOnly'=>'readOnly', 'class' => 'form-control', 'placeholder' => 'Add New Mechanical Engineer']) !!}
                        @if($errors->has('add_mech_engg'))
                        <p class="help-block">
                            <strong>{{ $errors->first('add_mech_engg') }}</strong>
                        </p>
                        @endif
                    </div> 
                </div>
            </div>
            <!-- row 6 -->
            <div class="row">
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('architect') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Architect<span style="color:red">*</span></label>
                           <select name='architect_id' id='architect_id', class = 'form-control '>
                           <option value="">-Select-</option>
                            <?php if(isset($architect) && (!empty($architect))){
                                foreach ($architect as $key => $name) { ?>
                                      <option value="{{ $key }}">{{ $name }}</option>
                                 
                              <?php  } 
                            } 
                            ?>
                            <option value="add_new_architect">Add New Architect</option>
                        </select>

                        @if($errors->has('architect_id'))
                        <p class="help-block">
                            <strong>{{ $errors->first('architect_id') }}</strong>
                        </p>
                        @endif                       
                    </div> 
                </div>
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('add_architect') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Add New Architect</label>
                        {!! Form::text('add_architect', old('add_architect', isset($project->architect)?$project->architect:''), ['id'=>'add_architect','readOnly'=>'readOnly', 'class' => 'form-control', 'placeholder' => 'Add New Architect']) !!}
                        @if($errors->has('add_architect'))
                        <p class="help-block">
                            <strong>{{ $errors->first('add_architect') }}</strong>
                        </p>
                        @endif 
                    </div> 

                </div>
            </div>
            <!-- row 7 -->
            <div class="row">
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('interior_id') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Interior<span style="color:red">*</span></label>
                           <select name='interior_id' id='interior_id', class = 'form-control '>
                           <option value="">-Select-</option>
                            <?php if(isset($interior) && (!empty($interior))){
                                foreach ($interior as $key => $name) { ?>
                                      <option value="{{ $key }}">{{ $name }}</option>
                                 
                              <?php  } 
                            } 
                            ?>
                            <option value="add_new_interior">Add New Interior</option>
                        </select>

                       
                        @if($errors->has('interior_id'))
                        <p class="help-block">
                            <strong>{{ $errors->first('interior_id') }}</strong>
                        </p>
                        @endif                       
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('add_interior') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Add New Interior</label>
                        {!! Form::text('add_interior', old('add_interior', isset($project->interior)?$project->interior:''), ['id'=>'add_interior','readOnly'=>'readOnly', 'class' => 'form-control', 'placeholder' => 'Add New Interior']) !!}
                        @if($errors->has('add_interior'))
                        <p class="help-block">
                            <strong>{{ $errors->first('add_interior') }}</strong>
                        </p>
                        @endif 
                    </div> 
                </div>
            </div>
            <!-- row 8 -->
            <div class="row">
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('contractor_id') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Main Contractor<span style="color:red">*</span></label>
                    <select name='contractor_id' id='contractor_id', class = 'form-control '>
                    <option value="">-Select-</option>
                            <?php if(isset($contractor) && (!empty($contractor))){
                                foreach ($contractor as $key => $name) { ?>
                                      <option value="{{ $key }}">{{ $name }}</option>
                                 
                              <?php  } 
                            } 
                            ?>
                            <option value="add_new_contractor">Add New Contractor</option>
                        </select>

                      
                        @if($errors->has('contractor_id'))
                        <p class="help-block">
                            <strong>{{ $errors->first('contractor_id') }}</strong>
                        </p>
                        @endif                       
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('add_main_contractor') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Add New Main Contractor</label>
                        {!! Form::text('add_main_contractor', old('add_main_contractor',isset($project->project_name)?$project->project_name:''), ['id'=>'add_main_contractor','readOnly'=>'readOnly', 'class' => 'form-control', 'placeholder' => 'Add New Main Contractor']) !!}
                        @if($errors->has('add_main_contractor'))
                        <p class="help-block">
                            <strong>{{ $errors->first('add_main_contractor') }}</strong>
                        </p>
                        @endif
                    </div> 
                </div>
            </div>
            <!-- row 9 -->
            <div class="row">
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('sub_contractor_id') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="project_type">Category<span style="color:red">*</span></label>
                        {!! Form::select('sub_contractor_id', $subcontractor, old('sub_contractor_id', isset($projectcategory->id)?$project->project_type_id:''), ['id'=>'category', 'class' => 'form-control', 'placeholder' => '-Select-']) !!}
                        @if($errors->has('sub_contractor_id'))
                        <p class="help-block">
                            <strong>{{ $errors->first('sub_contractor_id') }}</strong>
                        </p>
                        @endif                       
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-md-12 form-group {{$errors->has('contractor') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Contractor</label>
                        {!! Form::text('contractor', old('contractor',isset($project->contractor)?$project->contractor:''), ['id'=>'sub_contractor', 'class' => 'form-control', 'placeholder' => 'Add Sub Contractor']) !!}
                        @if($errors->has('contractor'))
                        <p class="help-block">
                            <strong>{{ $errors->first('contractor') }}</strong>
                        </p>
                        @endif
                    </div>  
                </div>
            </div>
            <!-- row 10 -->
            <div class="row">
                <div class="col-md-8">
                    <div class="col-md-12 form-group {{$errors->has('commentery') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Commentery </label>
                        {!! Form::textarea('commentery', old('commentery', isset($project->commentery)?$project->commentery:''),['placeholder' => 'commentery', 'id'=>'commentery', 'class'=>'form-control', 'rows' => 4, 'cols' => 40]) !!}

                        @if($errors->has('commentery'))
                        <p class="help-block">
                            <strong>{{ $errors->first('commentery') }}</strong>
                        </p>
                        @endif
                    </div> 
                </div>
            </div>
            <br>
            <!-- small form start-->

            <div class="col-md-12">
                <label>Project Review :-</label>
                <div class="field_wrapper presently_field_wrapper">
                    <div class="row cls_field_wrapper ">
                        <div class="col-md-12">
                            <a href="javascript:void(0)" class="add_button crcl_btn"><i class="fa fa-plus"></i></a>   
                        </div>
                        <!-- row 1 -->
                        <div class="col-md-4 form-group {{$errors->has('product_category') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                            <label for="sku">Enq for (product category)<span style="color:red">*</span></label>
                            {!! Form::select('product_category[]', $productcategory, old('product_category', isset($project->project_type_id)?$project->project_type_id:''), ['id'=>'project_category_id', 'class' => 'form-control', 'placeholder' => '-Select-']) !!}
                            @if($errors->has('product_category'))
                            <p class="help-block">
                                <strong>{{ $errors->first('product_category') }}</strong>
                            </p>
                            @endif 
                        </div>

                        <!-- row 2 -->
                        <div class="col-md-4 form-group {{$errors->has('people_list') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                            <label for="sku">Enq Source (list of people from this project)<span style="color:red">*</span></label>
                            {!! Form::select('people_list[]', $peoplelist, old('people_list', isset($project->project_type_id)?$project->project_type_id:''), ['id'=>'project_list_id', 'class' => 'form-control', 'placeholder' => '-Select-']) !!}
                            @if($errors->has('people_list'))
                            <p class="help-block">
                                <strong>{{ $errors->first('people_list') }}</strong>
                            </p>
                            @endif 
                        </div>
                        <!-- row 3 -->
                        <div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} ">
                            <label for="sku">Expected Date<span style="color:red">*</span></label>
                            {!! Form::text('expected_date[]', old('expected_date',isset($project->project_name)?$project->project_name:''), ['id'=>'expected_date', 'class' => 'form-control datepicker', 'placeholder' => 'Project Name']) !!}
                            @if($errors->has('expected_date'))
                            <p class="help-block">
                                <strong>{{ $errors->first('expected_date') }}</strong>
                            </p>
                            @endif
                        </div>   
                    </div>
                </div>
            </div>
            <!-- small form end -->

        </div>

        <!-- card body end  -->

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{route('admin.project.index')}}"  class="btn btn-secondary">Cancel</a>
        </div>
        {!! Form::close() !!}
    </div>
</div>
</div>
</div>




@endsection
@section('styles')
<link href="{{ asset('css/bootstrap-datepicker3.standalone.min.css') }}" rel="stylesheet">
<link href="{{asset('template/valex-theme/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ asset('js/datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{asset('template/valex-theme/plugins/select2/js/select2.min.js')}}"></script>

<script type="text/javascript">
    // date picker
    $(document).ready(function(){
        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            orientation: 'bottom',
            autoclose: true
        }).datepicker('setDate', 'today');
    // select 2
   


  

    // select 2 end

        // hide inputs
        // hide inputs end

        var presentlyaddButton = $('.add_button'); //Add button selector
        var presentlywrapper = $('.presently_field_wrapper'); //Input field wrapper
        presentlyfieldHTML='<div class="row after-add-more  cls_field_wrapper "><div class="col-md-12"><a href="javascript:void(0)" class="remove_button crcl_btn"><i class="fa fa-minus"></i></a></div><div class="col-md-4 form-group {{$errors->has('product_category') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}"><label for="sku">Enq for (product category)<span style="color:red">*</span></label>{!! Form::select('product_category[]', $productcategory, old('product_category', isset($project->project_type_id)?$project->project_type_id:''), ['id'=>'project_category_id', 'class' => 'form-control', 'placeholder' => '-Select-']) !!}@if($errors->has('product_category'))<p class="help-block"><strong>{{ $errors->first('product_category') }}</strong></p>@endif</div><div class="col-md-4 form-group {{$errors->has('people_list') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}"><label for="sku">Enq Source (list of people from this project)<span style="color:red">*</span></label>{!! Form::select('people_list[]', $projecttype, old('people_list',isset($project->project_type_id)?$project->project_type_id:''), ['id'=>'people_list_id', 'class' => 'form-control', 'placeholder' => '-Select-']) !!}@if($errors->has('people_list'))<p class="help-block"><strong>{{ $errors->first('people_list') }}</strong></p>@endif</div><div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} "><label for="sku">Expected Date<span style="color:red">*</span></label>{!! Form::text('expected_date[]', old('expected_date',isset($project->project_name)?$project->project_name:''), ['id'=>'expected_date', 'class' => 'form-control datepicker', 'placeholder' => 'Project Name']) !!}@if($errors->has('expected_date'))<p class="help-block"><strong>{{ $errors->first('expected_date') }}</strong></p>@endif</div></div>';     
                        // will work only in edit mode end 
        //Once add button is clicked
        $(presentlyaddButton).click(function(){
          $(presentlywrapper).append(presentlyfieldHTML); //Add field html
          $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            orientation: 'bottom',
            autoclose: true
        }).datepicker('setDate','today');
      });

        //Once remove button is clicked
        $(presentlywrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parents(".after-add-more").remove();
             //Remove field html
         });


    $('#developer').select2({
        placeholder: '-Select-'
        
    });
    /// code fop add new client
    jQuery("#developer").change(function(){
        var developer = jQuery(this).val();
        if(developer=='add_new_client'){
            $("#add_developer").removeAttr("readonly");
            $("#add_develoepr").addClass("required"); 
        }else{
            $("#add_develoepr").removeClass("required"); 
            $("#add_develoepr").parents("div").removeClass('has-error border-left-danger'); 
            $("#add_developer").val(""); 
            $("#add_develoepr").attr("readonly", true); 
        }
    });


    $('#quantity_id').select2({
        placeholder: '-Select-'
        
    });
    /// code fop add new client
    jQuery("#quantity_id").change(function(){
        var quantity_id = jQuery(this).val();
        if(quantity_id=='add_new_quantity'){
            $("#add_surveyor_qty").removeAttr("readonly");
            $("#add_surveyor_qty").addClass("required"); 
        }else{
            $("#add_surveyor_qty").removeClass("required"); 
            $("#add_surveyor_qty").parents("div").removeClass('has-error border-left-danger'); 
            $("#add_surveyor_qty").val(""); 
            $("#add_surveyor_qty").attr("readonly", true); 
        }
    });



    $('#financier_id').select2({
        placeholder: '-Select-'
        
    });
    /// code fop add new client
    jQuery("#financier_id").change(function(){
        var financier_id = jQuery(this).val();
        if(financier_id=='add_new_financier'){
            $("#add_project_financier").removeAttr("readonly");
            $("#add_project_financier").addClass("required"); 
        }else{
            $("#add_project_financier").removeClass("required"); 
            $("#add_project_financier").parents("div").removeClass('has-error border-left-danger'); 
            $("#add_project_financier").val(""); 
            $("#add_project_financier").attr("readonly", true); 
        }
    });

    $('#mech_engg_id').select2({
        placeholder: '-Select-'
        
    });
    /// code fop add new client
    jQuery("#mech_engg_id").change(function(){
        var mech_engg_id = jQuery(this).val();
        if(mech_engg_id=='add_new_mech_engineer'){
            $("#add_mech_engg").removeAttr("readonly");
            $("#add_mech_engg").addClass("required"); 
        }else{
            $("#add_mech_engg").removeClass("required"); 
            $("#add_mech_engg").parents("div").removeClass('has-error border-left-danger'); 
            $("#add_mech_engg").val(""); 
            $("#add_mech_engg").attr("readonly", true); 
        }
    });


    $('#architect_id').select2({
        placeholder: '-Select-'
        
    });
    /// code fop add new client
    jQuery("#architect_id").change(function(){
        var architect_id = jQuery(this).val();
        if(architect_id=='add_new_architect'){
            $("#add_architect").removeAttr("readonly");
            $("#add_architect").addClass("required"); 
        }else{
            $("#add_architect").removeClass("required"); 
            $("#add_architect").parents("div").removeClass('has-error border-left-danger'); 
            $("#add_architect").val(""); 
            $("#add_architect").attr("readonly", true); 
        }
    });


    $('#interior_id').select2({
        placeholder: '-Select-'
        
    });
    /// code fop add new client
    jQuery("#interior_id").change(function(){
        var interior_id = jQuery(this).val();
        if(interior_id=='add_new_interior'){
            $("#add_interior").removeAttr("readonly");
            $("#add_interior").addClass("required"); 
        }else{
            $("#add_interior").removeClass("required"); 
            $("#add_interior").parents("div").removeClass('has-error border-left-danger'); 
            $("#add_interior").val(""); 
            $("#add_interior").attr("readonly", true); 
        }
    });




    $('#contractor_id').select2({
        placeholder: '-Select-'
        
    });
    /// code fop add new client
    jQuery("#contractor_id").change(function(){
        var contractor_id = jQuery(this).val();
        if(contractor_id=='add_new_contractor'){
            $("#add_main_contractor").removeAttr("readonly");
            $("#add_main_contractor").addClass("required"); 
        }else{
            $("#add_main_contractor").removeClass("required"); 
            $("#add_main_contractor").parents("div").removeClass('has-error border-left-danger'); 
            $("#add_main_contractor").val(""); 
            $("#add_main_contractor").attr("readonly", true); 
        }
    });








    });

</script>


<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#frmproject').validate({
            rules: {
                commencement_date_id: {
                    required: true
                },
                project_type_id: {
                    required: true
                },
                project_name: {
                    required: true
                },
                project_commencement_date: {
                    required: true
                },
                expected_date_completion: {
                    required: true
                },
                project_budget: {
                    required: true
                },
                developer: {
                    required: true
                },
                // add_developer: {
                //     required: true
                // },
                financier_id: {
                    required: true
                },
                // add_project_financier: {
                //     required: true
                // },
                quantity_id: {
                    required: true
                },
                // add_surveyor_qty: {
                //     required: true
                // },
                mech_engg_id: {
                    required: true
                },
                // add_mech_engg: {
                //     required: true
                // },
                architect_id: {
                    required: true
                },
                // add_architect: {
                //     required: true
                // },
                interior_id: {
                    required: true
                },
                // add_interior: {
                //     required: true
                // },
                contractor_id: {
                    required: true
                },
                // add_main_contractor: {
                //     required: true
                // },
                category: {
                    required: true
                }
                ,
                sub_contractor: {
                    required: true
                }
                ,
                commentery: {
                    required: true
                }
            }
        });
    });


</script>
@endsection
