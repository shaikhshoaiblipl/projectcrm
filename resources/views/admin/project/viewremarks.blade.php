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
                    <div class="row">
                       <div class="col-md-12"><labal>Project Information : </labal></div>
                          <div class="col-md-6">
                            <div class="p-1">
                                <strong>Project Name : </strong> {{isset($remarks->getProject->project_name)?$remarks->getProject->project_name:''}}
                            </div>
                            <div class="p-1">
                                <strong>Date : </strong> {{isset($remarks->getProject->project_date)?$remarks->getProject->project_date:''}}
                            </div>
                            <div class="p-1">
                                <strong>Type : </strong> {{isset($remarks->getProject->getprojecttype->title)?$remarks->getProject->getprojecttype->title:''}}
                            </div>
                            <div class="p-1">
                                <strong>Commencement Date : </strong> {{isset($remarks->getProject->commencement_date)?$remarks->getProject->commencement_date:''}}
                            </div>
                            <div class="p-1">
                                <strong>Completion Date : </strong>{{isset($remarks->getProject->completion_date)?$remarks->getProject->completion_date:''}}
                            </div>
                            <div class="p-1">
                                <strong>Project Budget : </strong> {{isset($remarks->getProject->project_budget)?$remarks->getProject->project_budget:''}}
                            </div>
                            <div class="p-1">
                                <strong>Sub Contractor: </strong> {{isset($remarks->getProject->contractor)?$remarks->getProject->contractor:''}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-1">
                                <strong>Client/Developer : </strong> {{isset($remarks->getProject->getdeveloper->name)?$remarks->getProject->getdeveloper->name:''}}
                            </div>
                            <div class="p-1">
                                <strong>Financier : </strong>{{isset($remarks->getProject->getfinancier->name)?$remarks->getProject->getfinancier->name:''}}
                            </div>
                            <div class="p-1">
                                <strong>Quantity Surveyor  : </strong> {{isset($remarks->getProject->getquantity->name)?$remarks->getProject->getquantity->name:''}}
                            </div> 
                            <div class="p-1">
                                <strong>Mechanical Engineer : </strong> {{isset($remarks->getProject->getmengineer->name)?$remarks->getProject->getmengineer->name:''}}
                            </div> 
                            <div class="p-1">
                                <strong>Architect : </strong> {{isset($remarks->getProject->getquantity->name)?$remarks->getProject->getquantity->name:''}}
                            </div> 
                            <div class="p-1">
                                <strong>Interior : </strong> {{isset($remarks->getProject->getinterior->name)?$remarks->getProject->getinterior->name:''}}
                            </div> 
                            <div class="p-1">
                                <strong>Main Contractor : </strong> {{isset($remarks->getProject->getmcontractor->name)?$remarks->getProject->getmcontractor->name:''}}
                            </div> 
                        </div>
                        <div class="col-md-12">
                            <div class="p-1">
                                <strong>Commentery : </strong> {{isset($remarks->getProject->commentery)?$remarks->getProject->commentery:''}}
                            </div>
                        </div>
                    </div>
                 <br>
                 <div class="row">
                   <div class="col-md-12">  <labal>Project Enquiry Information : </labal></div>
                        <div class="col-md-6">
                            <div class="p-1">
                                <strong>Product Category : </strong> {{isset($remarks->getproductcategory->title)?$remarks->getproductcategory->title:''}}
                            </div>
                            <div class="p-1">
                                <strong>Expected Date : </strong> {{isset($remarks->expected_date)?$remarks->expected_date:''}}
                            </div>
                            <div class="p-1">
                                <strong>Received Date : </strong> {{isset($remarks->received_date)?$remarks->received_date:''}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-1">
                                <strong>Won Loss : </strong> {{isset($remarks->won_loss)?$remarks->won_loss:''}}
                            </div>
                            <div class="p-1">
                                <strong>Quotation Date : </strong> {{isset($remarks->expected_budget)?$remarks->quotation_date:''}}
                            </div>
                            <div class="p-1">
                                <strong>Expected Budget : </strong>{{isset($remarks->expected_budget)?$remarks->expected_budget:''}}
                            </div> 
                        </div>
                </div>
                <br>
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


