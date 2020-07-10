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
            {!! Form::open(['method' => 'POST', 'url' => route('admin.projects.saveremark'),'class' => 'form-horizontal','id' => 'frmremarks']) !!}
            @csrf
            <div class="card-header py-3 cstm_hdr">
             
            </div> 
            <!-- card body start-->
            <div class="card-body">
            
<!-- small form start-->
<div class="col-md-12">
    <label>Add Remark:-</label>
    
    <div class="field_wrapper presently_field_wrapper">
       
        <div class="row cls_field_wrapper">
          
            <div class="col-md-12">
                <a href="javascript:void(0)" class="add_button crcl_btn"></a>   
            </div>
                     <!-- row 1  -->
                    <input type="hidden" name="enquiry_id" value="{{$id}}">
             <div class="col-md-12 form-group {{$errors->has('remarks') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                <label for="sku">Add Remark(For Enquiry)<span style="color:red">*</span></label>
             <textarea name="remarks"  id="remarks" cols="30" rows="10" class="form-control"></textarea>
             @if($errors->has('remarks'))
                <p class="help-block">
                    <strong>{{ $errors->first('remarks') }}</strong>
                </p> 
                 @endif 
            </div> 
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
<link href="{{asset('template/valex-theme/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ asset('js/datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{asset('template/valex-theme/plugins/select2/js/select2.min.js')}}"></script>


<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#frmremarks').validate({
            rules: {
                remarks: {
                    required: true
                }
            }
        });
    });


</script> 

   
@endsection

