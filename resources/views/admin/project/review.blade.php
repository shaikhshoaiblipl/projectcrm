@extends('admin.layouts.valex_app')
@section('styles')
<link href="{{asset('template/valex-theme/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('template/valex-theme/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{asset('template/valex-theme/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{asset('template/valex-theme/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('template/valex-theme/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
@endsection
@section('content')
<!-- Begin Page Content -->
<div class="container">
  <div class="breadcrumb-header justify-content-between">
      <div class="left-content">
          <div>
            <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Project Enquiry </h2>
          </div>
      </div>
  </div>
 <input type="hidden" value="{{$id}}" id="hidden_id">
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header py-3 cstm_hdr">
             <h6 class="m-0 font-weight-bold text-primary">Project Enquiry List</h6> 
                <a href="{{route('admin.projects.addEnquiry',$id)}}" class="btn btn-sm btn-icon-split float-right btn-outline-warning">Add New Enquery</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0" id="projectpreview">
                    <thead>
                        <tr>
                            <th>Product Category</th>
                            <th>Source</th>
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
<script type="text/javascript">   
    
    jQuery(document).ready(function(){
        getProjects();
    });
    
    function getProjects(){
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
                data: {id:id}
            },
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50,100,"All"]
            ],
            columns: [
                {data: 'getproductcategory.title', name:'getproductcategory.title'},
                {data: 'enq_source_type', name: 'enq_source_type'},
                {data: 'expected_date', name: 'expected_date'},
                {data: 'received_date', name: 'received_date'},
                {data: 'quotation_date', name: 'quotation_date'},
                {data: 'won_loss', name: 'won_loss'},
                {data: 'remarks', name: 'remarks'},
                {data: 'action', name: 'action', orderable: false, searchable: false, "width": "15%"},

                
            ],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthMenu: '_MENU_',
            },
        });
    }

    function addremark(){

alert('hello');
    
}


</script>





@endsection