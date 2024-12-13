@extends("admin.template.layout")
@section('header')
    <style>
    .input_span{
      display: none;
    }
    .input_commission{
      width: 50%;
    }
    .buttons-excel{
      margin: 5px;
      padding: 10px;
      border-radius: 10px;
      transition: all 0.3s ease-in-out;
      background: #2596be;
      color: white;      
    }

    .buttons-excel:hover {
      filter: brightness(130%);
    }

    div.dataTables_wrapper div.dataTables_filter input {
      width: 100%; 
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
                <div class="card-header">
                    <h5 class="mb-0 mt-3">{{$mode ?? $page_heading}}</h5>
                    <form method="get" action='' class="w-100 mt-3">
                <div id="column-filter_filter" class="dataTables_filter">
                    <div class="row w-100 align-items-center">
                        <div class="col-lg-3 mb-3">
                             <label>From Date:
                                <input type="date" name="from_date" class="form-control form-control-sm" placeholder=""
                                    aria-controls="column-filter" value="{{$from_date}}">
                            </label>

                        </div>
                        <div class="col-lg-3 mb-3">
                             <label>To Date:
                                <input type="date" name="to_date" class="form-control form-control-sm" placeholder=""
                                    aria-controls="column-filter" value="{{$to_date}}">
                            </label>
                        </div>
                        <div class="col-lg-2 mb-3">
                             <button type="submit" class="btn btn-primary primary-btn w-100" style="color:#fff !important">Submit</button>
                        </div>
                        <div class="col-lg-2 mb-3">
                              <button type="submit" name="excel" value="Export XLSX" class="btn btn-primary primary-btn w-100" style="color:#fff !important">Export XLSX</button>
                        </div>
                        <div class="col-lg-2 mb-3">
                             <a href="{{route('reports.jobs_in_transit')}}" class="btn btn-primary primary-btn w-100" style="color:#fff !important">Clear</a>
                        </div>
                    </div>
                    
                    
                   
                    <!-- <input type="submit" name="excel" value="Export Pdf" class="btn btn-primary"> -->
                    
                </div>
            </form>
                </div>
                <div class="card-body">
                  <div class="card-datatable text-nowrap">
                    <div class="table-responsive">
                
                      <table class="table table-condensed" id = "reports"  data-searching = "true">  
                        <thead>
                            <tr>
                                <th >#</th>
                                <th> Booking#</th>
                                <th> Customer Name</th>
                                <th> Driver Name</th>
                                
                                <th> Quoted Amount</th>
                                <th> Total Amount</th>
                                <!-- <th> Commission %</th> -->
                                <th> Booking Status</th>
                                <th> Created At</th>
                            </tr>
                          </thead>
                          <tbody>
                                <?php $i = $bookings->perPage() * ($bookings->currentPage() - 1); ?>
                            @foreach($bookings as $booking)
                            <?php $i++; ?>
                              <tr>
                                 <td>{{$i}}</td>
                                <td> {{ $booking->booking_number }}</td>
                                <td> {{ $booking->customer_name ?? ''}}</td>
                                <td> {{ $booking->driver_name ?? ''}}</td>
                               
                                <td> {{ number_format($booking->qouted_amount,3) }}</td>
                                <td> {{ $booking->total_amount }}</td>
                              <!--   <td>@if($booking->commission_amount) {{ $booking->commission_amount }}% @endif</td> -->
                                <td> {!! get_driver_tracking_status($booking->status) !!}</td>
                                <td> {{ date('d/m/y H:i A',strtotime($booking->created_at)) }}</td>
                            </tr>
                            @endforeach
                          </tbody>
                      </table>
                      <!-- <span>Total {{ $bookings->total() }} entries</span> -->

            <div class="col-sm-12 col-md-12 pull-right">
                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                    {{-- {!! $bookings->links('admin.template.pagination') !!} --}}
                    {!! $bookings->appends(request()->input())->links('admin.template.pagination') !!}
                </div>
            </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Ajax Sourced Server-side -->


            </div>
@stop
@section('script')
<!-- <script src = "https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src = "https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src = "https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<script>
  jQuery(document).ready(function(){
      $('#reports').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel'
        ]
      } );
      App.initTreeView();

  })
</script> -->
@stop
