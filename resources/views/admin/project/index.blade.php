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
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Projects</h2>
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
      <div class="card">
        <div class="card-header py-3 cstm_hdr">
             <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
             <?php if(Auth::user()->roles->first()->id != config('constants.ROLE_TYPE_SUPERADMIN_ID')){   ?>
            <a href="{{route('admin.project.create')}}" class="btn btn-sm btn-icon-split float-right btn-outline-warning">
                <span class="icon text-white-50">
                  <i class="fas fa-plus"></i>
                </span>
                <span class="text">Add Project</span>
            </a>
           <?php } ?>
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
                            <?php if(Auth::user()->roles->first()->id == config('constants.ROLE_TYPE_SUPERADMIN_ID')){   ?>
                            <div class="form-group mr-sm-2 mb-2">
                                    {!! Form::select('client_id', $clientdeveloper, old('client_id'), ['id'=>'client_id', 'class' => 'form-control', 'placeholder' => '-Select Client-']) !!}                   
                            </div> 
                             <div class="form-group mr-sm-2 mb-2">
                                    {!! Form::select('financier_id', $financier, old('financier_id'), ['id'=>'financier_id', 'class' => 'form-control', 'placeholder' => '-Select Financier-']) !!}                   
                            </div> 
                             <div class="form-group mr-sm-2 mb-2">
                                    {!! Form::select('quantity_id', $quantity, old('quantity_id'), ['id'=>'quantity_id', 'class' => 'form-control', 'placeholder' => '-Select Qty Surveyor-']) !!}                   
                            </div> 
                            <div class="form-group mr-sm-2 mb-2">
                                    {!! Form::select('mech_engg_id', $mechanicalEngineer, old('mech_engg_id'), ['id'=>'mech_engg_id', 'class' => 'form-control', 'placeholder' => '-Select Mechanical Eng-']) !!}                   
                            </div> 
                            <div class="form-group mr-sm-2 mb-2">
                                    {!! Form::select('architect_id', $architect, old('architect_id'), ['id'=>'architect_id', 'class' => 'form-control', 'placeholder' => '-Select Architect-']) !!}                   
                            </div> 
                            <div class="form-group mr-sm-2 mb-2">
                                    {!! Form::select('interior_id', $interior, old('interior_id'), ['id'=>'interior_id', 'class' => 'form-control', 'placeholder' => '-Select Interior-']) !!}                   
                            </div> 
                            <div class="form-group mr-sm-2 mb-2">
                                    {!! Form::select('contractor_id', $contractor, old('contractor_id'), ['id'=>'contractor_id', 'class' => 'form-control', 'placeholder' => '-Select Main Contractor-']) !!}                   
                            </div> 
                            <div class="form-group mr-sm-2 mb-2">
                                    {!! Form::select('product_category_id', $productcategory, old('product_category_id'), ['id'=>'product_category_id', 'class' => 'form-control', 'placeholder' => '-Select Product Category-']) !!}                   
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
                            <?php } ?>   
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
                            <th>Status</th>
                            <th>Action</th>                      
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
                            <th>Status</th>
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
    <?php
     $status= 'false'; 
    if(Auth::user()->roles->first()->id == config('constants.ROLE_TYPE_SUPERADMIN_ID')){ 
         $status= 'true';
    } ?> 
    
    jQuery(document).ready(function(){
        // set default dates
        var start = new Date();
        // set end date to max one year period:
        var end = new Date(new Date().setYear(start.getFullYear()+1));
        $('#start_date').datepicker({
            format: 'mm/dd/yyyy',
            autoclose: true
        // update "end_date" defaults whenever "start_date" changes
        }).on('changeDate', function(){
            // set the "end_date" start to not be later than "start_date" ends:
            $('#end_date').datepicker('setStartDate', new Date($(this).val()));
        }); 
        $('#end_date').datepicker({
            format: 'mm/dd/yyyy',
            autoclose: true
        // update "start_date" defaults whenever "end_date" changes
        }).on('changeDate', function(){
            // set the "start_date" end to not be later than "end_date" starts:
            $('#start_date').datepicker('setEndDate', new Date($(this).val()));
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
                {data: 'is_active', name: 'is_active', class: 'text-center', "width": "10%"},
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