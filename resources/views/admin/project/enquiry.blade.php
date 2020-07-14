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
            {!! Form::open(['method' => 'POST', 'url' => route('admin.projects.insertinquiry'),'class' => 'form-horizontal','id' => 'frmproject']) !!}
            @csrf
            @if(isset($project->id))
            @method('PUT')
            @endif
            <div class="card-header py-3 cstm_hdr">
                <h6 class="m-0 font-weight-bold text-primary">{{ isset($project->id)?'Edit':'Add' }} Enquiry</h6>
                @if(isset($project->id))
                <a href="{{route('admin.projects.prereview')}}" class="btn btn-sm btn-icon-split float-right btn-outline-warning">Add Enquiry</a>
                @endif
            </div> 
            <!-- card body start-->
            <div class="card-body">
                <!-- small to form start -->
                <!-- row 1 -->
                <!-- row 2 -->
            <!-- row 3 -->
        <!-- small top form end -->
        <!-- row 1 start -->
  
        <!-- row 1 end -->
        <!-- row 2 -->

    <!-- row 3 -->
<!-- row 4 -->

<!-- row 5 -->


<!-- row 6 -->

<!-- row 7 -->

<!-- row 8 -->

<!-- row 9 -->

<!-- row 10 -->

<br>
<!-- small form start-->


<div class="col-md-12">
                <label>Project Enquiry :-</label>
                <div class="field_wrapper presently_field_wrapper">
                    <div class="row cls_field_wrapper ">
                        <div class="col-md-12">
                            <a href="javascript:void(0)" class="add_button crcl_btn"><i class="fa fa-plus"></i></a>   
                        </div>
                        <input type="hidden" name="project_id" value="{{$project_id}}">
                        <!-- row 1 -->
                        <div class="col-md-4 form-group {{$errors->has('product_category') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                            <label for="sku">Enquiry for (product category)</label>
                            {!! Form::select('product_category[]', $productcategory, old('product_category', isset($project->project_type_id)?$project->project_type_id:''), ['id'=>'project_category_id', 'required' => 'required', 'class' => 'form-control', 'placeholder' => '-Select-']) !!}
                            @if($errors->has('product_category'))
                            <p class="help-block">
                                <strong>{{ $errors->first('product_category') }}</strong>
                            </p>
                            @endif 
                        </div>
                        <!-- row 2 -->
                        <div class="col-md-4 form-group {{$errors->has('people_list') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                            <label for="sku">Enquiry Source (list of people from this project)</label>
                            <select name="enq_source[]" id="enq_source" class="form-control" required>
                            <option value="">-Select-</option>
                                <optgroup label="Client/Developer">
                                @if(isset($clientdeveloper))
                                @foreach($clientdeveloper as $key=>$client)
                                <option value="{{$key}}-{{'client'}}">{{$client}}</option>
                                @endforeach
                                @endif                               
                                </optgroup>
                                <optgroup label="Financier">
                                @if(isset($financier))
                                @foreach($financier as $key=>$finance)
                                <option value="{{$key}}-{{'financier'}}">{{$finance}}</option>
                                @endforeach
                                @endif  
                                </optgroup>
                                <optgroup label="Quantity">
                                @if(isset($quantity))
                                @foreach($quantity as $key=>$qty)
                                <option value="{{$key}}-{{'quantity'}}">{{$qty}}</option>
                                @endforeach
                                @endif  
                                </optgroup>
                                <optgroup label="Mechanical Engineer">
                                @if(isset($mechanicalEngineer))
                                @foreach($mechanicalEngineer as $key=>$mech)
                                <option value="{{$key}}-{{'engineer'}}">{{$mech}}</option>
                                @endforeach
                                @endif  
                                </optgroup>
                                <optgroup label="Architect">
                                @if(isset($architect))
                                @foreach($architect as $key=>$archi)
                                <option value="{{$key}}-{{'architect'}}">{{$archi}}</option>
                                @endforeach
                                @endif  
                                </optgroup>
                                <optgroup label="Interior">
                                @if(isset($interior))
                                @foreach($interior as $key=>$inter)
                                <option value="{{$key}}-{{'interior'}}">{{$inter}}</option>
                                @endforeach
                                @endif  
                                </optgroup>
                                <optgroup label="Main Contractor">
                                @if(isset($contractor))
                                @foreach($contractor as $key=>$cont)
                                <option value="{{$key}}-{{'contractor'}}">{{$cont}}</option>
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
                            <label for="sku">Expected Date</label>
                            {!! Form::text('expected_date[]', old('expected_date',isset($project->project_name)?$project->project_name:''), ['id'=>'expected_date','required' => 'required','class' => 'form-control datepicker', 'placeholder' => 'MM/DD/YYYY']) !!}
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
        presentlyfieldHTML='<div class="row after-add-more  cls_field_wrapper "><div class="col-md-12"><a href="javascript:void(0)" class="remove_button crcl_btn"><i class="fa fa-minus"></i></a></div><div class="col-md-4 form-group {{$errors->has('product_category') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}"><label for="sku">Enquiry for (product category)</label>{!! Form::select('product_category[]', $productcategory, old('product_category', isset($project->project_type_id)?$project->project_type_id:''), ['id'=>'project_category_id', 'class' => 'form-control', 'placeholder' => '-Select-']) !!}@if($errors->has('product_category'))<p class="help-block"><strong>{{ $errors->first('product_category') }}</strong></p>@endif</div><div class="col-md-4 form-group {{$errors->has('people_list') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}"><label for="sku">Enquiry Source (list of people from this project)</label><select name="enq_source[]" id="enq_source" class="form-control"><option value="">-Select-</option><optgroup label="Client/Developer">@foreach($clientdeveloper as $key=>$client)<option value="{{$key}}-{{'client'}}">{{$client}}</option>@endforeach</optgroup><optgroup label="Financier">@foreach($financier as $key=>$finance)<option value="{{$key}}-{{'financier'}}">{{$finance}}</option>@endforeach</optgroup><optgroup label="Quantity">@foreach($quantity as $key=>$qty)<option value="{{$key}}-{{'quantity'}}">{{$qty}}</option>@endforeach</optgroup><optgroup label="Mechanical Engineer">@foreach($mechanicalEngineer as $key=>$mech)<option value="{{$key}}-{{'engineer'}}">{{$mech}}</option>@endforeach</optgroup><optgroup label="Architect">@foreach($architect as $key=>$archi)<option value="{{$key}}-{{'architect'}}">{{$archi}}</option>@endforeach</optgroup><optgroup label="Interior">@foreach($interior as $key=>$inter)<option value="{{$key}}-{{'interior'}}">{{$inter}}</option>@endforeach</optgroup><optgroup label="Main Contractor">@foreach($contractor as $key=>$cont)<option value="{{$key}}-{{'contractor'}}">{{$cont}}</option>@endforeach</optgroup></select>@if($errors->has('people_list'))<p class="help-block"><strong>{{ $errors->first('people_list') }}</strong></p>@endif</div><div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} "><label for="sku">Expected Date</label>{!! Form::text('expected_date[]', old('expected_date',isset($project->project_name)?$project->project_name:''), ['id'=>'expected_date', 'class' => 'form-control datepicker', 'placeholder' => 'MM/DD/YYYY']) !!}@if($errors->has('expected_date'))<p class="help-block"><strong>{{ $errors->first('expected_date') }}</strong></p>@endif</div></div>';     



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
                },project_category_id: {
                    required: true
                }
            }
        });
    });


</script>
@endsection

