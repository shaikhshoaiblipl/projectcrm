@extends('admin.layouts.valex_app')

@section('content')
<div class="container">
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
              <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Project Type</h2>
            </div>
        </div>
        <div class="right-content">
          <div>
            <a style="color:#001f51;" href="{{ url()->previous() }}"><i class="fa fa-arrow-circle-left" aria-hidden="true"> Back</i></a>
          </div>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-xl-12">
<!-- Content Row -->
            <div class="card">

                {!! Form::open(['method' => 'POST', 'url' => isset($project_type->id)?route('admin.projecttype.update',[$project_type->id]):route('admin.projecttype.store'),'class' => 'form-horizontal','id' => 'frmprojecttype']) !!}
                @csrf
                @if(isset($project_type->id))
                @method('PUT')
                @endif
                <div class="card-header py-3 cstm_hdr">
                    <h6 class="m-0 font-weight-bold text-primary">{{ isset($project_type->id)?'Edit':'Add' }} Project Type</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12 form-group {{$errors->has('title') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                                <label for="title">Title <span style="color:red">*</span></label>
                                {!! Form::text('title', old('title', isset($project_type->title)?$project_type->title:''), ['id'=>'title', 'class' => 'form-control', 'placeholder' => 'Title']) !!}

                                @if($errors->has('title'))
                                <p class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </p>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                </div>  
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{route('admin.projecttype.index')}}"  class="btn btn-secondary">Cancel</a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('#frmprojecttype').validate({
        rules: {
            title: {
                required: true
            }
        }
    });
});
</script>
@endsection
