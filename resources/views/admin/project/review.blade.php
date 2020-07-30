@extends('admin.layouts.valex_app')
@section('styles')
<link href="{{asset('template/valex-theme/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('template/valex-theme/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('template/valex-theme/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{asset('template/valex-theme/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('template/valex-theme/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{ asset('css/bootstrap-datepicker3.standalone.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<!-- Begin Page Content -->
<div class="container">
  <div class="breadcrumb-header justify-content-between">
      <div class="left-content">
          <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Project Enquiry  </h2>

          </div>
      </div>
      <div class="right-content">
          <div>
            <a style="color:#001f51;" href="{{route('admin.project.index')}}"><i class="fa fa-arrow-circle-left" aria-hidden="true"> Back</i></a>
          </div>
      </div>
  </div>

 <input type="hidden" value="{{$id}}" id="hidden_id">
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header py-3 cstm_hdr">
             <h6 class="m-0 font-weight-bold text-primary">Project Enquiry List</h6> 
            <?php if(Auth::user()->roles->first()->id != config('constants.ROLE_TYPE_SUPERADMIN_ID')){   ?>
                @if(isset($id))
                    <a href="{{route('admin.projects.addEnquiry',$id)}}" class="btn btn-sm btn-icon-split float-right btn-outline-warning">Add New Enquiry</a>
                @endif
             <?php } ?>   
        </div>
        <div class="card-body">
                <div class="well mb-3">
                            {!! Form::open(['method' => 'POST', 'class' => 'form-inline', 'id' => 'frmFilter']) !!}
                           
                            <div class="form-group mr-sm-2 mb-2">
                                    {!! Form::select('product_category_id', $productcategory, old('product_category_id'), ['id'=>'product_category_id', 'class' => 'form-control', 'placeholder' => '-Select Product Category-']) !!}                   
                            </div> 
                            
                            <div class="form-group mr-sm-2 mb-2">
                                  {!! Form::text('expected_date', old('expected_date', isset($project->expected_date)?$project->expected_date:''), ['id'=>'expected_date', 'class' => 'form-control datepicker', 'placeholder' => 'Expected Date','readOnly'=>'readOnly' ]) !!}                  
                            </div>   
                            <div class="form-group mr-sm-2 mb-2">
                                  {!! Form::text('received_date', old('received_date', isset($project->received_date)?$project->received_date:''), ['id'=>'received_date', 'class' => 'form-control datepicker', 'placeholder' => 'Received Date','readOnly'=>'readOnly' ]) !!}                  
                            </div> 
                           
                           
                            <button type="submit" class="btn btn-responsive btn-primary mr-sm-2 mb-2">{{ __('Filter') }}</button>
                            <a href="javascript:;" onclick="resetFilter();" class="btn btn-responsive btn-danger mb-2">{{ __('Reset') }}</a>
                            {!! Form::close() !!}
                    </div>
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0" id="projectpreview">
                    <thead>
                        <tr>
                            <th>Product Category</th>
                            <th>Source</th>
                            <th>Source Name</th>
                            <th>Expected</th>
                            <th>Received</th>
                            <th>Quotation</th>
                            <th>Status(Lost/Won)</th>
                            <th>Remarks</th> 
                            <th>Action</th>                 
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Product Category</th>
                            <th>Source</th>
                            <th>Source Name</th>
                            <th>Expected Date</th>
                            <th>Received</th>
                            <th>Quotation</th>
                            <th>Status(Lost/Won)</th>
                            <th>Remarks</th>  
                            <th>Action</th>                      
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>    
<!-- /.container-fluid -->

@endsection

@section('scripts')
<script src="{{ asset('template/valex-theme/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/valex-theme/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ asset('template/valex-theme/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('template/valex-theme/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ asset('template/valex-theme/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('template/valex-theme/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('template/valex-theme/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('template/valex-theme/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('template/valex-theme/plugins/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">   
    
    jQuery(document).ready(function(){
         $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            orientation: 'bottom',
            autoclose: true
        });
        
         // set default dates
        var start = new Date();
        // set end date to max one year period:
        var end = new Date(new Date().setYear(start.getFullYear()+1));
        $('#expected_date').datepicker({
            format: 'mm/dd/yyyy',
            orientation: 'bottom',
            autoclose: true
        // update "received_date" defaults whenever "expected_date" changes
        }).on('changeDate', function(){
            // set the "received_date" start to not be later than "expected_date" ends:
            $('#received_date').datepicker('setStartDate', new Date($(this).val()));
        }); 
        $('#received_date').datepicker({
            format: 'mm/dd/yyyy',
            orientation: 'bottom',
            autoclose: true
        // update "expected_date" defaults whenever "received_date" changes
        }).on('changeDate', function(){
            // set the "expected_date" end to not be later than "received_date" starts:
            $('#expected_date').datepicker('setEndDate', new Date($(this).val()));
        });

        getProjectReviwes();

        jQuery('#frmFilter').submit(function(){
            getProjectReviwes();
            return false;
        });
    });

    function resetFilter(){
        jQuery('#frmFilter :input:not(:button, [type="hidden"])').val('');
        getProjectReviwes();
    }
    
    function getProjectReviwes(){
      
        var product_category_id = jQuery('#frmFilter [name=product_category_id]').val(); 
        var expected_date = jQuery('#frmFilter [name=expected_date]').val();       
        var received_date = jQuery('#frmFilter [name=received_date]').val(); 
      
        var id=$('#hidden_id').val();
        jQuery('#projectpreview').dataTable().fnDestroy();
        jQuery('#projectpreview tbody').empty();
        jQuery('#projectpreview').DataTable({
            processing: true,
            serverSide: true,
            iDisplayLength:50,
            ajax: {
                url: "{{ route('admin.projects.getpreview')}}",
                method: 'GET',
                data: {id:id,
                       expected_date:expected_date,
                        received_date:received_date,
                        product_category_id:product_category_id,
                    }
            },
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50,100,"All"]
            ],
            columns: [
                {data: 'getproductcategory.title', name:'getproductcategory.title'},
                {data: 'enq_source_type', name: 'enq_source_type'},
                {data: 'enq_source', name: 'enq_source'},
                {data: 'expected_date', name: 'expected_date'},
                {data: 'received_date', name: 'received_date'},
                {data: 'quotation_date', name: 'quotation_date'},
                {data: 'won_loss', name: 'won_loss'},
                {data: 'remarks', name: 'remarks',visible:false},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%"},
            ],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_',
            },
        });
    }
</script>
@endsection