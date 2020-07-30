@extends('admin.layouts.valex_app')
@section('styles')
<link href="{{asset('template/valex-theme/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('template/valex-theme/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('template/valex-theme/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{asset('template/valex-theme/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('template/valex-theme/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{ asset('css/bootstrap-datepicker3.standalone.min.css') }}" rel="stylesheet">
<link href="{{ asset('template/valex-theme/export/css/buttons.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('template/valex-theme/export/css/jquery.dataTables.min.css') }}" rel="stylesheet">
@endsection
@section('content')
<!-- Begin Page Content -->
<div class="container">
  <div class="breadcrumb-header justify-content-between">
      <div class="left-content">
          <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Period Performance</h2>
          </div>
      </div>
      <div class="right-content">
          <div>
            <a style="color:#001f51;" href="{{ url()->previous() }}"><i class="fa fa-arrow-circle-left" aria-hidden="true"> Back</i></a>
          </div>
      </div>
  </div>
 <input type="hidden" value="{{$id}}" id="hidden_id">
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header py-3 cstm_hdr">
             <h6 class="m-0 font-weight-bold text-primary">Period Performance Reports</h6> 
        </div>
        <div class="card-body">
                <div class="well mb-3">
                     {!! Form::open(['method' => 'POST', 'class' => 'form-inline', 'id' => 'frmFilter']) !!}
                    <div class="row col-md-12">
                          <?php if(Auth::user()->roles->first()->id == config('constants.ROLE_TYPE_SUPERADMIN_ID')){   ?>
                                @if(!isset($id))
                                <div class="form-group mr-sm-2 mb-2">
                                    {!! Form::select('sales_id', $sales, old('sales_id'), ['id'=>'sales_id', 'class' => 'form-control', 'placeholder' => '-Select Sales-']) !!}                   
                                </div> 
                                @endif
                            <?php } ?>   
                            <?php if(Auth::user()->roles->first()->id == config('constants.ROLE_TYPE_SUPERADMIN_ID')){   ?>
                            @if(!isset($id))
                   
                         
                            <div class="form-group mr-sm-2 mb-2">
                                  {!! Form::text('expected_date', old('expected_date', isset($project->expected_date)?$project->expected_date:''), ['id'=>'expected_date', 'class' => 'form-control datepicker', 'placeholder' => 'Start Date','readOnly'=>'readOnly' ]) !!}                  
                            </div>   
                            <div class="form-group mr-sm-2 mb-2">
                                  {!! Form::text('received_date', old('received_date', isset($project->received_date)?$project->received_date:''), ['id'=>'received_date', 'class' => 'form-control datepicker', 'placeholder' => 'End Date','readOnly'=>'readOnly' ]) !!}                  
                            </div> 
                            @endif
                            <?php } ?>   
                            <button type="submit" class="btn btn-responsive btn-primary mr-sm-2 mb-2">{{ __('Filter') }}</button>
                            <a href="javascript:;" onclick="resetFilter();" class="btn btn-responsive btn-danger mb-2">{{ __('Reset') }}</a>
                    </div>
                              {!! Form::close() !!}
                         
                         
                    </div>
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0" id="projectpreview">
                    <thead>
                        <tr>
                            <th colspan="2"></th>
                            <th colspan="4" style="text-align: center;">At Start Date</th>
                            <th colspan="5" style="text-align: center;">During The Selected Period</th>
                        </tr>
                        <tr>
                            <th>Sales Name</th>
                            <th>Project Name</th>
                            <th>No of Enquiries</th>
                            <th>Won</th>
                            <th>Lost</th>
                            <th>Live</th>
                            <!-- during -->
                            <th>New</th>
                            <th>Won</th>
                            <th>Lost</th>
                            <th>Status Updated</th>
                            <th>Live</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sales Name</th>
                            <th>Project Name</th>
                            <th>No of Enquiries</th>
                            <th>Won</th>
                            <th>Lost</th>
                            <th>Live</th>
                            <!-- during -->
                            <th>New</th>
                            <th>Won</th>
                            <th>Lost</th>
                            <th>Status Updated</th>
                            <th>Live</th>
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
<script src="{{ asset('template/valex-theme/export/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/valex-theme/export/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('template/valex-theme/export/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('template/valex-theme/export/js/jszip.min.js') }}"></script>
<script src="{{ asset('template/valex-theme/export/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('template/valex-theme/export/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('template/valex-theme/export/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('template/valex-theme/export/js/buttons.print.min.js') }}"></script>
<script type="text/javascript">   
    
    jQuery(document).ready(function(){
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

        jQuery('#projectpreview').dataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ],
        });
        jQuery('#frmFilter').submit(function(){
            var sales_id = jQuery('#frmFilter [name=sales_id]').val();
            var expected_date = jQuery('#frmFilter [name=expected_date]').val();       
            var received_date = jQuery('#frmFilter [name=received_date]').val();
            if(sales_id!='' || expected_date!='' || received_date!=''){
               getSalesReports();
            }
            return false;
        });
    });

    function resetFilter(){
        jQuery('#frmFilter :input:not(:button, [type="hidden"])').val('');
    }
    
    function getSalesReports(){
        var sales_id = jQuery('#frmFilter [name=sales_id]').val(); 
        var type_id = jQuery('#frmFilter [name=type_id]').val(); 
        var expected_date = jQuery('#frmFilter [name=expected_date]').val();       
        var received_date = jQuery('#frmFilter [name=received_date]').val(); 
        var product_category_id = jQuery('#frmFilter [name=product_category_id]').val(); 
        var source = jQuery('#frmFilter [name=source]').val(); 
        var status = jQuery('#frmFilter [name=status]').val(); 
        
        var id=$('#hidden_id').val();
        jQuery('#projectpreview').dataTable().fnDestroy();
        jQuery('#projectpreview tbody').empty();
        jQuery('#projectpreview').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel',
            ],
            processing: true,
            serverSide: true,
            iDisplayLength:50,
            ajax: {
                url: "{{ route('admin.reports.performancelist')}}",
                method: 'GET',
                data: {
                        id:id,
                        sales_id:sales_id,
                        type_id:type_id,
                        expected_date:expected_date,
                        received_date:received_date,
                        product_category_id:product_category_id,
                        source:source,
                        status:status
                    }
            },
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50,100,"All"]
            ],
            columns: [
                {data: 'sales_name', name:'sales_name', orderable: false, searchable: false},
                {data: 'project_name', name:'project_name', orderable: false, searchable: false},
                {data: 'number_of_enqueries', name:'number_of_enqueries', orderable: false, searchable: false},
                {data: 'won', name:'won', orderable: false, searchable: false},
                {data: 'lost', name: 'lost', orderable: false, searchable: false},
                {data: 'live', name: 'live', orderable: false, searchable: false},
                {data: 'new', name: 'new', orderable: false, searchable: false},
                {data: 'during_won', name: 'during_won', orderable: false, searchable: false},
                {data: 'during_lost', name: 'during_lost', orderable: false, searchable: false},
                {data: 'status_updated', name: 'status_updated', orderable: false, searchable: false},
                {data: 'during_live', name: 'during_live', orderable: false, searchable: false},
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