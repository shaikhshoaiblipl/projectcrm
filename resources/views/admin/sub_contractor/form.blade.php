@extends('admin.layouts.valex_app')

@section('content')
<div class="container">
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
              <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Sub-Contractors</h2>
            </div>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-xl-12">
<!-- Content Row -->
            <div class="card">

                {!! Form::open(['method' => 'POST', 'url' => isset($subcontractor->id)?route('admin.subcontractor.update',[$subcontractor->id]):route('admin.subcontractor.store'),'class' => 'form-horizontal','id' => 'frmsubcontractor']) !!}
                @csrf
                @if(isset($subcontractor->id))
                @method('PUT')
                @endif
                <div class="card-header py-3 cstm_hdr">
                    <h6 class="m-0 font-weight-bold text-primary">{{ isset($subcontractor->id)?'Edit':'Add' }} Sub-Contractors</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12 form-group {{$errors->has('title') ? config('constants.ERROR_FORM_GROUP_CLASS') : ''}}">
                                <label for="title">Name <span style="color:red">*</span></label>
                                {!! Form::text('title', old('title', isset($subcontractor->title)?$subcontractor->title:''), ['id'=>'title', 'class' => 'form-control', 'placeholder' => 'Title']) !!}

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
                    <a href="{{route('admin.subcontractor.index')}}"  class="btn btn-secondary">Cancel</a>
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
    jQuery('#frmsubcontractor').validate({
        rules: {
            title: {
                required: true
            }
        }
    });
});
</script>
@endsection
