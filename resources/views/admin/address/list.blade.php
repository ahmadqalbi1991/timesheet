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
                    @if(get_user_permission('address','c'))
                    <a href="{{route('address.create')}}?user_id={{$user_id}}" class="main-btn primary-btn btn-hover btn-sm"><i class='bx bx-plus'></i> Create</a>
                    @endif
                </div>
                <div class="card-body">
                  <div class="card-datatable text-nowrap">
                    <div class="table-responsive">
                      <table class="datatables-ajax table table-condensed" data-role="ui-datatable" data-src="{{route('getaddressList')}}?user_id={{$user_id}}" data-searching="true">
                        <thead>
                            <tr>
                                <th class="pt-0" data-colname="id">#</th>
                                <th class="pt-0" data-colname="address">Address</th>
                                <th class="pt-0" data-colname="building">Building</th>
                                <th class="pt-0" data-colname="phone">Phone</th>
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
@stop
@section('script')
<script>
  jQuery(document).ready(function(){

      App.initTreeView();

  })
</script>
@stop
