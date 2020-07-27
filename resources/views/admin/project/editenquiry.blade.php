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
                <label for="sku">Enquiry for (product category) <span style="color:red">*</span></label>
                {!! Form::select('product_category', $productcategory, old('product_category', isset($project->product_category_id)?$project->product_category_id:''), ['id'=>'project_category_id', 'class' => 'form-control', 'placeholder' => '-Select-']) !!}
                @if($errors->has('product_category'))
                <p class="help-block">
                    <strong>{{ $errors->first('product_category') }}</strong>
                </p> 
                 @endif 
            </div> 
            <!-- row 2 -->
             <div class="col-md-4 form-group {{$errors->has('enq_source') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                            <label for="sku">Enquiry Source (list of people from this project) <span style="color:red">*</span></label>
                            
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
                <label for="sku">Expected Date <span style="color:red">*</span></label>
                
                {!! Form::text('expected_date', old('expected_date',isset($project->expected_date)? Carbon\Carbon::parse($project->expected_date)->format('m/d/Y'):''), ['id'=>'expected_date', 'class' => 'form-control datepicker', 'placeholder' => 'MM/DD/YYYY']) !!}
                @if($errors->has('expected_date'))
                <p class="help-block">
                    <strong>{{ $errors->first('expected_date') }}</strong>
                </p>
                @endif
            </div> 

            <!-- edit mode start -->
           <div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} ">
                <label for="sku">Received Date <span style="color:red">*</span></label>
                {!! Form::text('received_date', old('received_date',isset($project->received_date)?Carbon\Carbon::parse($project->received_date)->format('m/d/Y'):''), ['id'=>'received_date', 'class' => 'form-control datepicker', 'placeholder' => 'MM/DD/YYYY']) !!}
                @if($errors->has('received_date'))
                <p class="help-block">
                    <strong>{{ $errors->first('received_date') }}</strong>
                </p>
                @endif
            </div> 
            <div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} ">
                <label for="sku">Quotation Date <span style="color:red">*</span></label>
                {!! Form::text('quotation_date', old('quotation_date',isset($project->quotation_date)?Carbon\Carbon::parse($project->quotation_date)->format('m/d/Y')	:''), ['id'=>'quotation_date', 'class' => 'form-control datepicker', 'placeholder' => 'MM/DD/YYYY']) !!}
                @if($errors->has('quotation_date'))
                <p class="help-block">
                    <strong>{{ $errors->first('quotation_date') }}</strong>
                </p>
                @endif
            </div> 
            <div class="col-md-8 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} ">
                <label for="sku">Remarks</label>
                <textarea name="remarks" id="remark"  placeholder="Remarks" cols="20" rows="4" class="form-control">{{old('remarks')}}</textarea>
                @if($errors->has('remark'))
                <p class="help-block">
                    <strong>{{ $errors->first('remark') }}</strong>
                </p>
                @endif
                <span style="color: red;">( If order lost, please mention name of competition to whom it was lost and reason for the same)</span>
            </div>  
            <!-- radio button -->
             <div class="col-md-4 form-group {{$errors->has('expected_date') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}} "> 
                <label for="sku">Won/loss </label> 
                <input type="radio" id="Win" class="status" name="won_loss"  value="Won" {{($project->won_loss=="Won")? "checked" : "" }}> &nbsp;Won &nbsp; &nbsp;
                <input type="radio" id="Loss" class="status" name="won_loss"  value="Loss"{{($project->won_loss=="Loss")? "checked" : "" }}>&nbsp;Loss
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
     <a href="<?php echo url('admin/projects/projectpreview/'.$project->project_id); ?>" class="btn btn-secondary">Cancel</a>
    
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
    // date picker
    $(document).ready(function(){
        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            orientation: 'bottom',
            autoclose: true,
            
        });
        $( ".status" ).change(function() {
            var status = $(this).val();
            if(status=='Loss'){
                $("#remark").addClass("required"); 
            }else{
                $("#remark").parents("div").removeClass('has-error border-left-danger'); 
                $("#remark").removeClass("required"); 
            }
          
        });
 });
</script>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#frmproject').validate({
            rules: {
                expected_date: {
                    required: true
                },
                received_date: {
                    required: true
                },
                quotation_date: {
                    required: true
                },
                product_category: {
                    required: true
                },
                enq_source: {
                    required: true
                }
            }
        });
    });


</script>
@endsection

