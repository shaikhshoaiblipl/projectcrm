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
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Salesman</h2>
          </div>
      </div>
  </div>
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header py-3 cstm_hdr">
             <h6 class="m-0 font-weight-bold text-primary">Salesman Reports</h6>
        </div>
        <div class="card-body">
             <div class="well mb-3">
                            {!! Form::open(['method' => 'POST', 'class' => 'form-inline', 'id' => 'frmFilter']) !!}
                            <?php if(Auth::user()->roles->first()->id == config('constants.ROLE_TYPE_SUPERADMIN_ID')){   ?>
                                <div class="form-group mr-sm-2 mb-2">
                                    {!! Form::select('sales_id', $sales, old('sales_id'), ['id'=>'sales_id', 'class' => 'form-control', 'placeholder' => '-Select Sales-']) !!}                   
                                </div> 
                            <?php } ?>   
                            <div class="form-group mr-sm-2 mb-2">
                                    {!! Form::select('type_id', $projecttype, old('type_id'), ['id'=>'type_id', 'class' => 'form-control', 'placeholder' => '-Select Type-']) !!}                   
                            </div> 
                            <div class="form-group mr-sm-2 mb-2">
                                  {!! Form::number('project_budget', old('project_budget', isset($project->project_budget)?$project->project_budget:''), ['id'=>'project_budget', 'class' => 'form-control', 'placeholder' => 'Project Budget']) !!}                  
                            </div> 
                            <div class="form-group mr-sm-2 mb-2">
                                  {!! Form::text('start_date', old('start_date', isset($project->start_date)?$project->start_date:''), ['id'=>'start_date', 'class' => 'form-control datepicker', 'placeholder' => 'Start Date','readOnly'=>'readOnly' ]) !!}                  
                            </div>   
                            <div class="form-group mr-sm-2 mb-2">
                                  {!! Form::text('end_date', old('end_date', isset($project->end_date)?$project->end_date:''), ['id'=>'end_date', 'class' => 'form-control datepicker', 'placeholder' => 'End Date','readOnly'=>'readOnly' ]) !!}                  
                            </div>  
                            <button type="submit" class="btn btn-responsive btn-primary mr-sm-2 mb-2">{{ __('Filter') }}</button>
                            <a href="javascript:;" onclick="resetFilter();" class="btn btn-responsive btn-danger mb-2">{{ __('Reset') }}</a>
                            {!! Form::close() !!}
                    </div> 
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0" id="categories">
                    <thead>
                        <tr>
                            <th>Sales Name</th>  
                            <th>Project Name</th>
                            <th>Type</th>
                            <th>Project Budget</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Sales Name</th>  
                            <th>Project Name</th>
                            <th>Type</th>
                            <th>Project Budget</th>
                            <th>Start Date</th>
                            <th>End Date</th>
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
    <?php
     $status= 'false'; 
    if(Auth::user()->roles->first()->id == config('constants.ROLE_TYPE_SUPERADMIN_ID')){ 
         $status= 'true';
    } ?> 
    
    jQuery(document).ready(function(){
        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            orientation: 'bottom',
            autoclose: true
        });

        getProjects();

        jQuery('#frmFilter').submit(function(){
            getProjects();
            return false;
        });
    });

    

    function resetFilter(){
        jQuery('#frmFilter :input:not(:button, [type="hidden"])').val('');
        getProjects();
    }
    
    function getProjects(){
        var sales_id = jQuery('#frmFilter [name=sales_id]').val(); 
        var type_id = jQuery('#frmFilter [name=type_id]').val(); 
        var client_id = jQuery('#frmFilter [name=client_id]').val();  
        var financier_id = jQuery('#frmFilter [name=financier_id]').val();    
        var quantity_id = jQuery('#frmFilter [name=quantity_id]').val();       
        var mech_engg_id = jQuery('#frmFilter [name=mech_engg_id]').val(); 
        var architect_id = jQuery('#frmFilter [name=architect_id]').val(); 
        var interior_id = jQuery('#frmFilter [name=interior_id]').val();  
        var contractor_id = jQuery('#frmFilter [name=contractor_id]').val();    
        var start_date = jQuery('#frmFilter [name=start_date]').val();       
        var end_date = jQuery('#frmFilter [name=end_date]').val(); 
        var product_category_id = jQuery('#frmFilter [name=product_category_id]').val(); 
        var project_budget = jQuery('#frmFilter [name=project_budget]').val(); 
      
        jQuery('#categories').dataTable().fnDestroy();
        jQuery('#categories tbody').empty();
        jQuery('#categories').DataTable({
            processing: true,
            serverSide: true,
            iDisplayLength:50,
            ajax: {
                url: "{{ route('admin.project.getProject') }}",
                method: 'POST',
                data: {
                    sales_id:sales_id,
                    type_id:type_id,
                    client_id:client_id,
                    financier_id:financier_id,
                    quantity_id:quantity_id,
                    mech_engg_id:mech_engg_id,
                    architect_id:architect_id,
                    interior_id:interior_id,
                    contractor_id:contractor_id,
                    product_category_id:product_category_id,
                    start_date:start_date, 
                    end_date:end_date,
                    project_budget:project_budget
                }
            },
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50,100,"All"]
            ],
            columns: [ 
                {data: 'created_by', name: 'created_by', 'visible': <?php echo $status; ?> },    
                {data: 'project_name', name: 'project_name'},
                {data: 'getprojecttype.title', name: 'getprojecttype.title'},
                {data: 'project_budget', name: 'project_budget'},
                {data: 'commencement_date', name: 'commencement_date'},
                {data: 'completion_date', name: 'completion_date'},
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