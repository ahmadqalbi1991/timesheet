@extends("admin.template.layout")
@section('header')
    <style>
    .input_span{
      display: none;
    }
    .input_commission{
      width: 50%;
    }
    </style>
@endsection

@section('content')
                    @php
                    $from = null;
                    $to = null;
                    if(request()->get('from')){
                      $from = request()->get('from');
                    }
                    if(request()->get('to')){
                      $to = request()->get('to');
                    }
                    @endphp
<div class="container-xxl flex-grow-1 container-p-y">
  
              <!-- Ajax Sourced Server-side -->
              <div class="card">
                <div class="card-header justify-content-between">
                    <h5 class="mb-0">{{$mode ?? $page_heading}}</h5>
                    
                </div>
                <div class="card-body">
                  <div class="card-datatable text-nowrap">
                    <div class="table-responsive">
                        <div class="row">
                           <div class="col-md-6 mb-5">
                            <div class="card" style="width: 18rem;">
                               
                                <div class="card-body">
                                  <h5 class="card-title">Total Earning</h5>
                                  <p class="card-text">{{$totalEarning}}</p>
                                  
                                </div>
                              </div>
                               </div>
                                 <div class="col-md-6 mb-5">
                            <div class="card" style="width: 18rem;">
                               
                                <div class="card-body">
                                  <h5 class="card-title">Paid Earning</h5>
                                  <p class="card-text">{{$paidEarning}}</p>
                                  
                                </div>
                              </div>
                               </div>
                               
                           
                          
                        </div>
                        <table class="datatables-ajax table table-condensed" data-role="ui-datatable" data-src="{{route('driver.getearningList',['id' => $id])}}" >
                     
                        <thead>
                            <tr>
                                <th class="pt-0" data-colname="id">#</th>
                                <th class="pt-0" data-colname="booking_number"> Booking#</th>
                                
                                <th class="pt-0" data-colname="qouted_amount"> Quoted Amount</th>
                                
                                <th class="pt-0" data-colname="customer_name">Customer</th>
                                
                               <!--  <th class="pt-0" data-colname="booking_status"> Booking Status</th> -->
                                <th class="pt-0" data-colname="created_at"> Created At</th>
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
