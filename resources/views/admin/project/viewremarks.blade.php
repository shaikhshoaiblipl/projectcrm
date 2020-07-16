@extends('admin.layouts.valex_app')
@section('content')
<div class="container">
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
              <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Enquiry Remarks</h2>
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
                <h6 class="m-0 font-weight-bold text-primary">Remark List</h6>
            </div> 
            <!-- card body start-->
            <div class="card-body">
<!-- small form start-->
<div class="col-md-12">
<div class="container">
  <table class="table table-bordered">
  <thead>
      <tr>
        <th class="text-bold"><h6>Sr.no</h6></th>
        <th class="text-bold"><h6>Remarks</h6></th>
        <th class="text-bold"><h6>Date</h6></th>
      </tr>
    </thead>
    <tbody>
  <!--   @if(!empty($remarks))
     <tr>
        <td>1</td>
        <td>{{ucfirst($remarks['remarks'])}}</td>
        <td>{{($remarks['quotation_date'])?date('d M Y', strtotime($remarks['quotation_date'])):''}}</td>
     </tr>
     @endif -->
    @if(count($remarks->getremarks) > 0)
    @foreach($remarks->getremarks as $remark)
      <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{ucfirst($remark['remarks'])}}</td>
        <td>{{date('d M Y', strtotime($remark['date']))}}</td>
      </tr>
     @endforeach
     @endif
     </tbody>
    
   <!-- <h3 class="text-danger">Sorry No Remarks Found!!</h3> -->
  
   </table>
</div>
    
    
</div>  
</div>
<div class="card-footer">
  <a href="<?php echo url('admin/projects/projectpreview/'.$remarks->project_id); ?>" class="btn btn-secondary">Cancel</a>
</div>

</div>
</div>
</div>
</div>

@endsection


