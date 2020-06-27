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
<?php $countries= $subCategories =array(); ?>
 

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
                <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12 form-group {{$errors->has('project_name') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Project Name <span style="color:red">*</span></label>
                        {!! Form::text('project_name', old('project_name',isset($project->project_name)?$project->project_name:''), ['id'=>'project_name', 'class' => 'form-control', 'placeholder' => 'Project Name']) !!}
                        @if($errors->has('project_name'))
                        <p class="help-block">
                            <strong>{{ $errors->first('project_name') }}</strong>
                        </p>
                        @endif
                    </div>     
                    <div class="col-md-12 form-group {{$errors->has('project_type') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                            <label for="project_type">Project Type <span style="color:red">*</span></label>
                           {!! Form::select('project_type_id', $projecttype, old('project_type_id', isset($project->project_type_id)?$project->project_type_id:''), ['id'=>'project_type_id', 'class' => 'form-control', 'placeholder' => '-Select-']) !!}
                           @if($errors->has('project_type_id'))
                            <p class="help-block">
                                <strong>{{ $errors->first('project_type') }}</strong>
                            </p>
                            @endif                       
                    </div>
                    <div class="col-md-12 form-group {{$errors->has('project_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Project Date<span style="color:red">*</span></label> 
                        {!! Form::text('project_date', old('project_date', isset($project->project_date)?date('d/m/Y', strtotime($project->project_date)):''), ['id'=>'project_date', 'class' => 'form-control datepicker', 'placeholder' => 'Project Date']) !!}
                        @if($errors->has('project_date'))
                        <p class="help-block">
                            <strong>{{ $errors->first('project_date') }}</strong>
                        </p>
                        @endif
                    </div>
                    <div class="col-md-12 form-group {{$errors->has('project_commencement_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Date of Commencement <span style="color:red">*</span></label> 
                        {!! Form::text('commencement_date', old('commencement_date', isset($project->commencement_date)?date('d/m/Y', strtotime($project->commencement_date)) :''), ['id'=>'project_commencement_date', 'class' => 'form-control datepicker', 'placeholder' => 'MM/DD/YYYY']) !!}
                        @if($errors->has('project_commencement_date'))
                        <p class="help-block">
                            <strong>{{ $errors->first('project_commencement_date') }}</strong>
                        </p>
                        @endif
                    </div>
                     <div class="col-md-12 form-group {{$errors->has('expected_date_completion') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Expected Date of Completion  <span style="color:red">*</span></label> 
                    
                        {!! Form::text('completion_date', old('completion_date', isset($project->completion_date)?date('d/m/Y', strtotime($project->completion_date)):''), ['id'=>'expected_date_completion', 'class' => 'form-control datepicker', 'placeholder' => 'Project Date']) !!}

                        @if($errors->has('expected_date_completion'))
                        <p class="help-block">
                            <strong>{{ $errors->first('expected_date_completion') }}</strong>
                        </p>
                        @endif
                    </div>
                    <div class="col-md-12 form-group {{$errors->has('project_budget') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Project Budget  <span style="color:red">*</span></label>
                        {!! Form::number('project_budget', old('project_budget', isset($project->project_budget)?$project->project_budget:''), ['id'=>'project_budget', 'class' => 'form-control', 'placeholder' => 'Project Budget']) !!}

                        @if($errors->has('project_budget'))
                        <p class="help-block">
                            <strong>{{ $errors->first('project_budget') }}</strong>
                        </p>
                        @endif
                    </div>
                    <div class="col-md-12 form-group {{$errors->has('client_developer') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Client / Developer<span style="color:red">*</span></label>
                        {!! Form::text('developer', old('developer', isset($project->developer)?$project->developer:''), ['id'=>'developer', 'class' => 'form-control', 'placeholder' => 'Client / Developer']) !!}
                        @if($errors->has('developer'))
                        <p class="help-block">
                            <strong>{{ $errors->first('developer') }}</strong>
                        </p>
                        @endif
                    </div>
                    <div class="col-md-12 form-group {{$errors->has('project_financer') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Project Financier<span style="color:red">*</span></label>
                        {!! Form::text('project_financier', old('project_financier', isset($project->project_financier)?$project->project_financier:''), ['id'=>'project_financier', 'class' => 'form-control', 'placeholder' => 'Project Financier']) !!}

                        @if($errors->has('project_financier'))
                        <p class="help-block">
                            <strong>{{ $errors->first('project_financier') }}</strong>
                        </p>
                        @endif
                    </div>
                    <div class="col-md-12 form-group {{$errors->has('qty_surveyor') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Qty Surveyor<span style="color:red">*</span></label>
                        {!! Form::number('surveyor_qty', old('surveyor_qty', isset($project->surveyor_qty)?$project->surveyor_qty:''), ['id'=>'surveyor_qty', 'class' => 'form-control', 'placeholder' => 'Qty Surveyor']) !!}

                        @if($errors->has('surveyor_qty'))
                        <p class="help-block">
                            <strong>{{ $errors->first('surveyor_qty') }}</strong>
                        </p>
                        @endif
                    </div>
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
                <div class="col-md-6">
                    <div class="col-md-12 form-group {{$errors->has('mech_eng') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="country_id">Mech Engg  <span style="color:red">*</span></label>
                           {!! Form::text('mech_engg', old('mech_engg', isset($project->mech_engg)?$project->mech_engg:''), ['id'=>'mech_engg', 'class' => 'form-control', 'placeholder' => 'Mech Engg']) !!}
                           @if($errors->has('mech_engg'))
                            <p class="help-block">
                                <strong>{{ $errors->first('mech_engg') }}</strong>
                            </p>
                            @endif                       
                   </div>
                   <div class="col-md-12 form-group {{$errors->has('architect') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="architect">Architect<span style="color:red">*</span></label>
                           {!! Form::text('architect', old('architect', isset($project->architect)?$project->architect:''), ['id'=>'architect', 'class' => 'form-control', 'placeholder' => 'Architect']) !!}
                           @if($errors->has('architect'))
                            <p class="help-block">
                                <strong>{{ $errors->first('architect') }}</strong>
                            </p>
                            @endif                       
                   </div>
                   <div class="col-md-12 form-group {{$errors->has('interior') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="interior">Interior<span style="color:red">*</span></label>
                           {!! Form::text('interior', old('interior', isset($project->interior)?$project->interior:''), ['id'=>'interior', 'class' => 'form-control', 'placeholder' => 'Interior']) !!}
                           @if($errors->has('interior'))
                            <p class="help-block">
                                <strong>{{ $errors->first('interior') }}</strong>
                            </p>
                            @endif                       
                   </div> 
                   <div class="col-md-12 form-group {{$errors->has('main_contractor') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="main_contractor">Main Contractor<span style="color:red">*</span></label>
                           {!! Form::text('main_contractor', old('main_contractor', isset($project->main_contractor)?$project->main_contractor:''), ['id'=>'main_contractor', 'class' => 'form-control', 'placeholder' => 'Main Contractor']) !!}
                           @if($errors->has('main_contractor'))
                            <p class="help-block">
                                <strong>{{ $errors->first('main_contractor') }}</strong>
                            </p>
                            @endif                       
                   </div>
                   <div class="col-md-12 form-group {{$errors->has('project_category') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                           <label for="project_category">Project Category <span style="color:red">*</span></label>
                           {!! Form::select('project_category_id', $projectcategory, old('project_category_id', isset($project->project_category_id)?$project->project_category_id:''), ['id'=>'project_category_id', 'class' => 'form-control', 'placeholder' => '-Select-']) !!}
                           @if($errors->has('project_category_id'))
                            <p class="help-block">
                                <strong>{{ $errors->first('project_category_id') }}</strong>
                            </p>
                            @endif                       
                    </div>
                    <div class="col-md-12 form-group {{$errors->has('project_sub_contractor') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                            <label for="project_sub_contractor">Project Sub Contractor <span style="color:red">*</span></label>
                            {!! Form::select('sub_contractor_id', $subcontractor, old('sub_contractor_id', isset($project->sub_contractor_id)?$project->sub_contractor_id:''), ['id'=>'sub_contractor_id', 'class' => 'form-control', 'placeholder' => '-Select-']) !!}                
                           @if($errors->has('sub_contractor_id'))
                            <p class="help-block">
                                <strong>{{ $errors->first('sub_contractor_id') }}</strong>
                            </p>
                            @endif                       
                    </div> 
@if(isset($project) && count($project->Projectenquiry) > 0)
                 
@endif
                    <!-- small form  start -->
                   
                    <label>Project Status :- </label>
     
                    <div class="row presently_field_wrapper"> 
                    <?php if(isset($project) && count($project->Projectenquiry) > 0){ 
                        foreach ($project->Projectenquiry as $key => $Projectenquiry){ 
                            if($key==0){
                                $action='<a href="javascript:void(0)" class="add_button"><i class="fa fa-plus"></i></a>';
                            }else{
                              $action='<a href="javascript:void(0)" class="remove_button"><i class="fa  fa-minus"></i></a>';
                            }
                     ?>
                      <div class="col-md-12 after-add-more">
                       <div class="col-md-12">
                           <?php echo $action; ?>
                       </div> 
                       <div class="col-md-12 form-group {{$errors->has('sub_product_id') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                         <label for="title">Enq for (product category) <span style="color:red">*</span></label>
                          {!! Form::select('sub_product_id[]', $projectcategory, old('sub_product_id', isset($Projectenquiry->product_category_id)?$Projectenquiry->product_category_id:''), ['id'=>'sub_product_id', 'class' => 'form-control', 'placeholder' => '-Select-']) !!}
                          @if($errors->has('sub_product_id'))
                           <p class="help-block">
                               <strong>{{ $errors->first('sub_product_id') }}</strong>
                           </p>
                           @endif    
                       </div>
                       <div class="col-md-12 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                         <label for="title">Expected Date<span style="color:red">*</span></label>
                          {!! Form::text('expected_date[]',old('expected_date', isset($Projectenquiry->expected_date)?date('d/m/Y', strtotime($Projectenquiry->expected_date)):''), ['id'=>'expected_date', 'class' => 'form-control datepicker', 'placeholder' => 'MM/DD/YYYY']) !!}
                          @if($errors->has('expected_date'))
                           <p class="help-block">
                               <strong>{{ $errors->first('expected_date') }}</strong>
                           </p>
                           @endif    
                       </div>
                       <div class="col-md-12 form-group {{$errors->has('enq_source_list') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                         <label for="title">Enq Source (list of people) <span style="color:red">*</span></label>
                          <!-- {!! Form::select('enq_source_list[]', $subCategories, old('enq_source_list', isset($city->country_id)?$city->country_id:''), ['id'=>'enq_source_list', 'class' => 'form-control', 'placeholder' => '-Select-']) !!} -->
                          <select  class="form-control" name="enq_source_list[]" value="old('enq_source_list',isset($Projectenquiry->enq_source)?$Projectenquiry->enq_source:''))" id="enq_source_list">
                              <option value="">-Select-</option>
                              <option value="1" selected>People 1</option>
                           </select>

                          @if($errors->has('enq_source_list'))
                           <p class="help-block">
                               <strong>{{ $errors->first('enq_source_list') }}</strong>
                           </p>
                           @endif    
                       </div> 

   <!-- will work only in edit start-->
   <div class="col-md-12 form-group {{$errors->has('received_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Received Date<span style="color:red">*</span></label> 
                        {!! Form::text('received_date[]', old('received_date', isset($Projectenquiry->received_date)?date('d/m/Y', strtotime($Projectenquiry->received_date)):''), ['id'=>'received_date', 'class' => 'form-control datepicker', 'placeholder' => 'Received Date']) !!}
                        @if($errors->has('received_date'))
                        <p class="help-block">
                            <strong>{{ $errors->first('received_date') }}</strong>
                        </p>
                        @endif
                    </div>
                    <div class="col-md-12 form-group {{$errors->has('quotation_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Quotation Date<span style="color:red">*</span></label> 
                        {!! Form::text('quotation_date[]', old('quotation_date', isset($Projectenquiry->quotation_date)?date('d/m/Y', strtotime($Projectenquiry->quotation_date)):''), ['id'=>'quotation_date', 'class' => 'form-control datepicker', 'placeholder' => 'Quotation Date']) !!}
                        @if($errors->has('quotation_date'))
                        <p class="help-block">
                            <strong>{{ $errors->first('quotation_date') }}</strong>
                        </p>
                        @endif
                    </div>
                    <div class="col-md-12 form-group {{$errors->has('remarks') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Remarks (stored date wise)</label>
                        {!! Form::textarea('remarks[]', old('remarks', isset($Projectenquiry->remarks)?$Projectenquiry->remarks:''),['placeholder' => 'remarks', 'id'=>'remarks', 'class'=>'form-control', 'rows' => 4, 'cols' => 40]) !!}

                        @if($errors->has('remarks'))
                        <p class="help-block">
                            <strong>{{ $errors->first('remarks') }}</strong>
                        </p>
                        @endif
                    </div>  
                    <div class="col-md-12 form-group {{$errors->has('won_loss') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                        <label for="title">Win/Loss </label>
                         {!!Form::radio('won_loss', 'Won')!!}
                        @if($errors->has('won_loss'))
                        <p class="help-block">
                            <strong>{{ $errors->first('won_loss') }}</strong>
                        </p>
                        @endif
                    </div> 
                    <!-- will work only in edit mode end -->
                   </div> 
                        <?php }
         }else{  ?>
            
                   <div class="col-md-12">
                    <div class="col-md-12">
                        <a  href="javascript:void(0)" class="add_button"><i class="fa fa-plus"></i></a>
                    </div> 
                    <div class="col-md-12 form-group {{$errors->has('sub_product_id') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                      <label for="title">Enq for (product category) <span style="color:red">*</span></label>
                       {!! Form::select('sub_product_id[]', $projectcategory, old('sub_product_id', isset($projectcategory->id)?$projectcategory->id:''), ['id'=>'sub_product_id', 'class' => 'form-control', 'placeholder' => '-Select-']) !!}
                       @if($errors->has('sub_product_id'))
                        <p class="help-block">
                            <strong>{{ $errors->first('sub_product_id') }}</strong>
                        </p>
                        @endif    
                    </div>
                    <div class="col-md-12 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                      <label for="title">Expected Date<span style="color:red">*</span></label>
                       {!! Form::text('expected_date[]',old('expected_date', isset($city->country_id)?$city->country_id:''), ['id'=>'expected_date', 'class' => 'form-control datepicker', 'placeholder' => 'MM/DD/YYYY']) !!}

                       @if($errors->has('expected_date'))
                        <p class="help-block">
                            <strong>{{ $errors->first('expected_date') }}</strong>
                        </p>
                        @endif    
                    </div>
                    <div class="col-md-12 form-group {{$errors->has('enq_source_list') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                    <label for="title">Enq Source (list of people) <span style="color:red">*</span></label>
                       <!-- {!! Form::select('enq_source_list[]', $subCategories, old('enq_source_list', isset($city->country_id)?$city->country_id:''), ['id'=>'enq_source_list', 'class' => 'form-control', 'placeholder' => '-Select-']) !!} -->
                       <select  class="form-control" name="enq_source_list[]" id="enq_source_list">
                           <option value="">-Select-</option>
                           <option value="1">People 1</option>
                        </select>
                       @if($errors->has('enq_source_list'))
                        <p class="help-block">
                            <strong>{{ $errors->first('enq_source_list') }}</strong>
                        </p>
                        @endif    
                    </div>  
                    <?php  }?>
                    <!-- small form end -->
                </div> 
               </div>
             
             </div>
          
        </div> 
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
@endsection

@section('scripts')
<script src="{{ asset('js/datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
 $(document).ready(function(){
    $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            orientation: 'bottom',
            autoclose: true
    });

    //{!! Form::select('sub_product_id[]', $subCategories, old('sub_product_id', isset($city->country_id)?$city->country_id:''), ['id'=>'sub_product_id', 'class' => 'form-control', 'placeholder' => '-Select-']) !!}
    var presentlyaddButton = $('.add_button'); //Add button selector
    var presentlywrapper = $('.presently_field_wrapper'); //Input field wrapper
    presentlyfieldHTML='<div class="col-md-12 after-add-more"><div class="col-md-12"><a  href="javascript:void(0)" class="remove_button"><i class="fa fa-minus"></i></a></div><div class="col-md-12 form-group {{$errors->has('sub_product_id') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}"><label for="title">Enq for (product category) <span style="color:red">*</span></label>{!! Form::select('sub_product_id[]', $projectcategory, old('sub_product_id', isset($Projectenquiry->product_category_id)?$Projectenquiry->product_category_id:''), ['id'=>'sub_product_id', 'class' => 'form-control', 'placeholder' => '-Select-']) !!}@if($errors->has('sub_product_id'))<p class="help-block"><strong>{{ $errors->first('sub_product_id') }}</strong></p>@endif</div><div class="col-md-12 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}"><label for="title">Expected Date<span style="color:red">*</span></label>{!! Form::text('expected_date[]',old('expected_date', isset($Projectenquiry->expected_date)?date('d/m/Y', strtotime($Projectenquiry->expected_date)):''), ['id'=>'expected_date', 'class' => 'form-control datepicker', 'placeholder' => 'MM/DD/YYYY']) !!}@if($errors->has('expected_date'))<p class="help-block"><strong>{{ $errors->first('expected_date') }}</strong></p> @endif </div><div class="col-md-12 form-group {{$errors->has('enq_source_list') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}"><label for="title">Enq Source (list of people) <span style="color:red">*</span></label><select  class="form-control" name="enq_source_list[]" id="enq_source_list"><option value="">-Select-</option><option value="1">People 1</option></select>@if($errors->has('enq_source_list'))<p class="help-block"><strong>{{ $errors->first('enq_source_list') }}</strong></p>@endif</div> @if(isset($project) && count($project->Projectenquiry) > 0)<div class="col-md-12 form-group {{$errors->has('received_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}"><label for="title">Received Date<span style="color:red">*</span></label>{!! Form::text('received_date[]', old('received_date', isset($Projectenquiry->received_date)?date('d/m/Y', strtotime($Projectenquiry->received_date)):''), ['id'=>'received_date', 'class' => 'form-control datepicker', 'placeholder' => 'Received Date']) !!}@if($errors->has('received_date'))<p class="help-block"><strong>{{ $errors->first('received_date') }}</strong></p>@endif</div><div class="col-md-12 form-group {{$errors->has('quotation_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}"><label for="title">Quotation Date<span style="color:red">*</span></label>{!! Form::text('quotation_date[]', old('quotation_date', isset($Projectenquiry->quotation_date)?date('d/m/Y', strtotime($Projectenquiry->quotation_date)):''), ['id'=>'quotation_date', 'class' => 'form-control datepicker', 'placeholder' => 'Quotation Date']) !!}@if($errors->has('quotation_date'))<p class="help-block"><strong>{{ $errors->first('quotation_date') }}</strong></p>@endif</div><div class="col-md-12 form-group {{$errors->has('remarks') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}"> <label for="title">Remarks (stored date wise)</label>{!! Form::textarea('remarks[]', old('remarks', isset($Projectenquiry->remarks)?$Projectenquiry->remarks:''),['placeholder' => 'remarks', 'id'=>'remarks', 'class'=>'form-control', 'rows' => 4, 'cols' => 40]) !!}@if($errors->has('remarks'))<p class="help-block"><strong>{{ $errors->first('remarks') }}</strong></p>@endif</div><div class="col-md-12 form-group {{$errors->has('won_loss') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}"><label for="title">Win/Loss </label>{!!Form::radio('won_loss', 'Won')!!}@if($errors->has('won_loss'))<p class="help-block"><strong>{{ $errors->first('won_loss') }}</strong></p>@endif</div></div>@endif';   
                    // will work only in edit mode end 
    //Once add button is clicked
    $(presentlyaddButton).click(function(){
      $(presentlywrapper).append(presentlyfieldHTML); //Add field html
       $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            orientation: 'bottom',
            autoclose: true
      });
    });

    //Once remove button is clicked
    $(presentlywrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).parents(".after-add-more").remove();
         //Remove field html
    });
});

</script>
<script type="text/javascript">
  // radio button

   var radioState = false;
    function test(element){
        if(radioState == false) {
            check();
            radioState = true;
        }else{
            uncheck();
            radioState = false;
        }
    }
    function check() {
        document.getElementById("radioBtn").checked = true;
    }
    function uncheck() {
        document.getElementById("radioBtn").checked = false;
    }


</script>

<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('#frmproject').validate({
        rules: {
            project_name: {
                required: true
            },
            project_type_id: {
                required: true
            },
            project_date: {
                required: true
            },
            commencement_date: {
                required: true
            },
            completion_date: {
                required: true
            },
            project_budget: {
                required: true
            },
            developer: {
                required: true
            },
            project_financier: {
                required: true
            },
            surveyor_qty: {
                required: true
            },
            commentery: {
                required: true
            },
            mech_engg: {
                required: true
            },
            architect: {
                required: true
            },
            interior: {
                required: true
            },
            main_contractor: {
                required: true
            },
            project_category_id: {
                required: true
            },
            sub_contractor_id: {
                required: true
            }
        }
    });
});
</script>
@endsection
