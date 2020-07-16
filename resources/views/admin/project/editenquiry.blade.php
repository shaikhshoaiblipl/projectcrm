@extends('admin.layouts.valex_app')
@section('content')
<div class="container">
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
              <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Enquiry</h2>
          </div>
      </div>
  </div>
    <div class="row row-sm">
    <div class="col-xl-12">
        <!-- Content Row -->
        <div class="card">
            {!! Form::open(['method' => 'POST', 'url' => route('admin.projects.updateEnquiry',[$project->id]),'class' => 'form-horizontal','id' => 'frmproject']) !!}
            @csrf
            <div class="card-header py-3 cstm_hdr">
                <h6 class="m-0 font-weight-bold text-primary">{{ isset($project->id)?'Edit':'Add' }} Enquiry</h6>
             
            </div> 
            <!-- card body start-->
            <div class="card-body">
            
<!-- small form start-->

<div class="col-md-12">
    <label>Project Review :-</label>
    
    <div class="field_wrapper presently_field_wrapper">
       
        <div class="row cls_field_wrapper ">
          
            <div class="col-md-12">
                <a href="javascript:void(0)" class="add_button crcl_btn"></a>   
            </div>
                     <!-- row 1  -->
             <div class="col-md-4 form-group {{$errors->has('product_category') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                <label for="sku">Enquiry for (product category)</label>
                {!! Form::select('product_category', $productcategory, old('product_category', isset($project->product_category_id)?$project->product_category_id:''), ['id'=>'project_category_id', 'class' => 'form-control', 'placeholder' => '-Select-']) !!}
                @if($errors->has('product_category'))
                <p class="help-block">
                    <strong>{{ $errors->first('product_category') }}</strong>
                </p> 
                 @endif 
            </div> 
            <!-- row 2 -->
             <div class="col-md-4 form-group {{$errors->has('enq_source') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                            <label for="sku">Enquiry Source (list of people from this project)</label>
                            
                            <select name="enq_source" id="enq_source" class="form-control">
                            <option value="">-Select-</option>
                                <optgroup label="Client/Developer">
                                @if(isset($clientdeveloper))
                                @foreach($clientdeveloper as $key=>$client)
                                <option value="{{$key}}-{{'client'}}"{{($key.'-'.'client' == $people_list) ? 'selected' : ''}}>{{$client}}</option>
                                @endforeach
                                @endif                               
                                </optgroup>
                                <optgroup label="Financier">
                                @if(isset($financier))
                                @foreach($financier as $key=>$finance)
                                <option value="{{$key}}-{{'financier'}}"{{($key.'-'.'financier' == $people_list) ? 'selected' : ''}}>{{$finance}}</option>
                                @endforeach
                                @endif  
                                </optgroup>
                                <optgroup label="Quantity">
                                @if(isset($quantity))
                                @foreach($quantity as $key=>$qty)
                                <option value="{{$key}}-{{'quantity'}}"{{($key.'-'.'quantity' == $people_list) ? 'selected' : ''}}>{{$qty}}</option>
                                @endforeach
                                @endif  
                                </optgroup>
                                <optgroup label="Mechanical Engineer">
                                @if(isset($mechanicalEngineer))
                                @foreach($mechanicalEngineer as $key=>$mech)
                                <option value="{{$key}}-{{'engineer'}}"{{($key.'-'.'engineer' == $people_list) ? 'selected' : ''}}>{{$mech}}</option>
                                @endforeach
                                @endif  
                                </optgroup>
                                <optgroup label="Architect">
                                @if(isset($architect))
                                @foreach($architect as $key=>$archi)
                                <option value="{{$key}}-{{'architect'}}"{{($key.'-'.'architect' == $people_list) ? 'selected' : ''}}>{{$archi}}</option>
                                @endforeach
                                @endif  
                                </optgroup>
                                <optgroup label="Interior">
                                @if(isset($interior))
                                @foreach($interior as $key=>$inter)
                                <option value="{{$key}}-{{'interior'}}"{{($key.'-'.'interior' == $people_list) ? 'selected' : ''}}>{{$inter}}</option>
                                @endforeach
                                @endif  
                                </optgroup>
                                <optgroup label="Main Contractor">
                                @if(isset($contractor))
                                @foreach($contractor as $key=>$cont)
                                <option value="{{$key}}-{{'contractor'}}"{{($key.'-'.'contractor' == $people_list) ? 'selected' : ''}}>{{$cont}}</option>
                                @endforeach
                                @endif  
                                </optgroup>
                            </select>
                            @if($errors->has('people_list'))
                            <p class="help-block">
                                <strong>{{ $errors->first('people_list') }}</strong>
                            </p>
                            @endif 
                        </div>
            <!-- row 3 -->
             <div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} ">
                            <label for="expected_budget">Expected Budget <span style="color:red">*</span></label>
                            {!! Form::text('expected_budget', old('expected_budget',isset($project->expected_budget)?$project->expected_budget:''), ['required' => 'required','class' => 'form-control', 'placeholder' => 'Expected Budget']) !!}
                            @if($errors->has('expected_budget'))
                            <p class="help-block">
                                <strong>{{ $errors->first('expected_budget') }}</strong>
                            </p>
                            @endif
                        </div> 
             <div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} ">
                <label for="sku">Expected Date</label>
                
                {!! Form::text('expected_date', old('expected_date',isset($project->expected_date)? Carbon\Carbon::parse($project->expected_date)->format('m/d/Y'):''), ['id'=>'expected_date', 'class' => 'form-control datepicker', 'placeholder' => 'MM/DD/YYYY']) !!}
                @if($errors->has('expected_date'))
                <p class="help-block">
                    <strong>{{ $errors->first('expected_date') }}</strong>
                </p>
                @endif
            </div> 

            <!-- edit mode start -->
           <div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} ">
                <label for="sku">Received Date</label>
                {!! Form::text('received_date', old('received_date',isset($project->received_date)?Carbon\Carbon::parse($project->received_date)->format('m/d/Y'):''), ['id'=>'received_date', 'class' => 'form-control datepicker', 'placeholder' => 'MM/DD/YYYY']) !!}
                @if($errors->has('received_date'))
                <p class="help-block">
                    <strong>{{ $errors->first('received_date') }}</strong>
                </p>
                @endif
            </div> 
            <div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} ">
                <label for="sku">Quote Date</label>
                {!! Form::text('quotation_date', old('quotation_date',isset($project->quotation_date)?Carbon\Carbon::parse($project->quotation_date)->format('m/d/Y')	:''), ['id'=>'quotation_date', 'class' => 'form-control datepicker', 'placeholder' => 'MM/DD/YYYY']) !!}
                @if($errors->has('quotation_date'))
                <p class="help-block">
                    <strong>{{ $errors->first('quotation_date') }}</strong>
                </p>
                @endif
            </div> 
            <div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} ">
                <label for="sku">Remarks</label>
                <textarea name="remarks" id="remark"  placeholder="Remarks" cols="20" rows="2" class="form-control">{{old('remarks',isset($project->remarks)?$project->remarks:'')}}</textarea>
                @if($errors->has('remark'))
                <p class="help-block">
                    <strong>{{ $errors->first('remark') }}</strong>
                </p>
                @endif
            </div>  
            <!-- radio button -->
             <div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} "> 
                <label for="sku">Won/loss<span style="color:red">*</span></label> 
                <input type="radio" id="Win" name="won_loss"  value="Win" {{($project->won_loss=="Win")? "checked" : "" }}> &nbsp;Win &nbsp; &nbsp;
                <input type="radio" id="Loss" name="won_loss"  value="Loss"{{($project->won_loss=="Loss")? "checked" : "" }}>&nbsp;Loss
                @if($errors->has('expected_date'))
                <p class="help-block">
                    <strong>{{ $errors->first('expected_date') }}</strong>
                </p>
                @endif
            </div>
            <!-- edit mode end -->
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
            autoclose: true,
            
        });
    // select 2
    


    

    // select 2 end

        // hide inputs
        // hide inputs end

        counter =100;
        counter++;

$('.add_button ').click( function() {
  // alert(counter);
    counter++;
});
        var presentlyaddButton = $('.add_button'); //Add button selector
        var presentlywrapper = $('.presently_field_wrapper'); //Input field wrapper
        presentlyfieldHTML='<div  class="row after-add-more  cls_field_wrapper"><div class="col-md-12"><a href="javascript:void(0)" class="remove_button crcl_btn"><i class="fa fa-minus"></i></a></div><div class="col-md-4 form-group {{$errors->has('product_category') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}"><label for="sku">Enquiry for (product category)</label>{!! Form::select('product_category[]', $productcategory, old('product_category'), ['id'=>'project_category_id', 'class' => 'form-control', 'placeholder' => '-Select-']) !!}@if($errors->has('product_category'))<p class="help-block"><strong>{{ $errors->first('product_category') }}</strong></p>@endif</div><div class="col-md-4 form-group {{$errors->has('people_list') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}"><label for="sku">Enquiry Source (list of people from this project)<span style="color:red">*</span></label><select name="enq_source[]" id="enq_source" class="form-control"><option value="">-Select-</option><optgroup label="Client/Developer">@foreach($clientdeveloper as $key=>$client)<option value="{{$key}}-{{'client'}}">{{$client}}</option>@endforeach</optgroup><optgroup label="Financier">@foreach($financier as $key=>$finance)<option value="{{$key}}-{{'financier'}}">{{$finance}}</option>@endforeach</optgroup><optgroup label="Quantity">@foreach($quantity as $key=>$qty)<option value="{{$key}}-{{'quantity'}}">{{$qty}}</option>@endforeach</optgroup><optgroup label="Mechanical Engineer">@foreach($mechanicalEngineer as $key=>$mech)<option value="{{$key}}-{{'engineer'}}">{{$mech}}</option>@endforeach</optgroup><optgroup label="Architect">@foreach($architect as $key=>$archi)<option value="{{$key}}-{{'architect'}}">{{$archi}}</option>@endforeach</optgroup><optgroup label="Interior">@foreach($interior as $key=>$inter)<option value="{{$key}}-{{'interior'}}">{{$inter}}</option>@endforeach</optgroup><optgroup label="Main Contractor">@foreach($contractor as $key=>$cont)<option value="{{$key}}-{{'contractor'}}">{{$cont}}</option>@endforeach</optgroup></select>@if($errors->has('people_list'))<p class="help-block"><strong>{{ $errors->first('people_list') }}</strong></p>@endif</div><div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} "><label for="expected_budget">Expected Budget <span style="color:red">*</span></label>{!! Form::text('expected_budget[]', old('expected_budget',isset($project->expected_budget)?$project->expected_budget:''), ['required' => 'required','class' => 'form-control', 'placeholder' => 'Expected Budget']) !!}@if($errors->has('expected_budget'))<p class="help-block"><strong>{{ $errors->first('expected_budget') }}</strong></p>@endif</div> <div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} "><label for="sku">Expected Date</label>{!! Form::text('expected_date[]', old('expected_date'), ['id'=>'expected_date', 'class' => 'form-control datepicker', 'placeholder' => 'MM/DD/YYYY']) !!}@if($errors->has('expected_date'))<p class="help-block"><strong>{{ $errors->first('expected_date') }}</strong></p>@endif</div><div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} "><label for="sku">Received Date<span style="color:red">*</span></label>{!! Form::text('received_date[]', old('received_date'), ['id'=>'received_date', 'class' => 'form-control datepicker', 'placeholder' => 'MM/DD/YYYY']) !!}@if($errors->has('received_date'))<p class="help-block"><strong>{{ $errors->first('received_date') }}</strong></p>@endif</div><div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} "><label for="sku">Quote Date</label>{!! Form::text('quotation_date[]', old('quotation_date'), ['id'=>'quotation_date', 'class' => 'form-control datepicker', 'placeholder' => 'MM/DD/YYYY']) !!}@if($errors->has('quotation_date'))<p class="help-block"><strong>{{ $errors->first('quotation_date') }}</strong></p>@endif</div><div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} "><label for="sku">Remarks</label><textarea name="remarks[]" placeholder="Remarks" id="remark"  cols="20" rows="2" class="form-control">{{old('remarks')}}</textarea>@if($errors->has('remark'))<p class="help-block"><strong>{{ $errors->first('remark') }}</strong></p>@endif</div><div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} "><input type="radio" id="Win" name="won_loss[]'+counter+'"  value="Win'+counter+'"> &nbsp;Win &nbsp; &nbsp;<input type="radio" id="Loss'+counter+'" name="won_loss[]'+counter+'"  value="Loss">&nbsp;Loss</div> </div>';  



                        // will work only in edit mode end 
        //Once add button is clicked
        $(presentlyaddButton).click(function(){
          $(presentlywrapper).append(presentlyfieldHTML); //Add field html
          $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            orientation: 'bottom',
            autoclose: true
        }).datepicker('setDate', 'today');
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
            $("#add_developer").attr("readonly", true); 
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
    $('#main_contractor').select2({
        placeholder: '-Select-'  
    });
    /// code fop add new client
    jQuery("#main_contractor").change(function(){
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
                architect_id: {
                    required: true
                },
                main_contractor: {
                    required: true
                },
                project_date: {
                    required: true
                },commencement_date: {
                    required: true
                },completion_date: {
                    required: true
                }
            }
        });
    });


</script>
@endsection

