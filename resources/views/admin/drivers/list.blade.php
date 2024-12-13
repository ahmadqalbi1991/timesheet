@extends("admin.template.layout")
<style>
    div.dataTables_wrapper div.dataTables_filter input {
      width: 100%; 
  }

  .dataTables_length, .dataTables_filter{
    display:inline-block;
  }
  .dataTables_filter{
    float:right;
  }

</style>
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  
              <!-- Ajax Sourced Server-side -->
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{$mode ?? $page_heading}}</h5>
                    <div class="d-flex justify-content-between align-items-center">
                      <a href="{{ route('drivers.ExportDriver') }}" data-toggle="modal" data-target="#exampleModal" class="main-btn primary-btn btn-hover btn-sm">  <i class="bx bx-plus"></i>Import</a>
                      <a href="{{asset('')}}Timex Driver Import.xlsx" target="_blank" class="main-btn primary-btn btn-hover btn-sm"> <i class="fa-solid fa-download"></i> Download Sample</a>
                      @if(get_user_permission('drivers','c'))
                      <a href="{{ route('drivers.create') }}" class="main-btn primary-btn btn-hover btn-sm"><i class="bx bx-plus"></i> Create</a>
                      @endif
                    </div>
                </div>
                <div class="card-body">
                  <div class="card-datatable text-nowrap">
                    <div class="table-responsive">
                      <table class="datatables-ajax table table-condensed" data-role="ui-datatable" data-src="{{route('getdriversList')}}" data-searching = "true">
                        <thead>
                            <tr>
                                <th class="pt-0" data-colname="id">#</th>
                                <th class="pt-0" data-colname="name"> Name</th>
                                <th class="pt-0" data-colname="is_company"> Driver Type</th>
                                <th class="pt-0" data-colname="email">email</th>
                                <th class="pt-0" data-colname="phone"> Phone</th>
                                <th class="pt-0" data-colname="user_status"> Status</th>
                                <th class="pt-0" data-colname="created_at" data-searchable="false">Created on</th>
                                <th class="pt-0" data-colname="action">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Ajax Sourced Server-side -->






            </div>
                <!-- Modal -->
    <form action="{{ route('drivers.driver_import') }}" method="POST" enctype="multipart/form-data">
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="">Excel File</label>
                            <input required class="form-control" type="file" name="excel_file" id="excelFile" accept=".xlsx, .xls">
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
@section('script')
<script>
  jQuery(document).ready(function(){

      App.initTreeView();

  })
</script>
@stop
