@extends("admin.template.layout")
@section('header')
    <style>
    .input_span{
      display: none;
    }
    .input_commission{
      width: 50%;
    }

    div.dataTables_wrapper div.dataTables_filter input {
      width: 100%;
  }

  .dataTables_length, .dataTables_filter{
    display:inline-block;
  }
  .dataTables_filter{
    float:right;
  }

  .active-tab{
    display:block
  }

  .inactive-tab{
    display:none
  }
  .main-btn:disabled {
          background: #dddddd;
  }

    </style>


@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

              <!-- Ajax Sourced Server-side -->
              <div class="card">
                <div class="card-header justify-content-between">
                    <h5 class="mb-0">{{$mode ?? $page_heading}}</h5>
                    @if(get_user_permission('bookings','c'))
                    <a href="{{ route('bookings.create') }}" class="main-btn primary-btn btn-hover btn-sm float-right"><i class="bx bx-plus"></i> Create</a>
                    {{--
                    <a href="{{ route('bookings.import') }}" class="main-btn primary-btn btn-hover btn-sm float-right"><i class="bx bx-file"></i> Import</a>
                    --}}
                    @endif
                </div>
                <div class="card-body">
                  <div class="card-datatable text-nowrap">
                    <div class="table-responsive">
                      <form method="get">
                        <div class="row align-items-end chk">
                            <div class="col-md-2 mb-4">
                                <label>Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Select</option>
                                    <option value="pending">Pending</option>
                                    <option value="approved_by_admin">Admin Approved Quotes</option>
                                    <option value="driver_qouted">Quotes Received</option>
                                    <option value="ask_for_qoute">Driver Assigned</option>
                                    <option value="on_process">On Process</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>
                             <div class="col-md-2 mb-4">
                                <label>Payment Status</label>
                                <select name="payment_status" id="payment_status" class="form-control">
                                    <option value="">Select</option>
                                    <option value="yes">Paid</option>
                                    <option value="no">Unpaid</option>

                                </select>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label>Date</label>
                               <input type="text" name="date" id="created_date" class="form-control">
                            </div>
                            <div class="col-md-3 mb-4">
                                <label>Customer</label>
                               <input type="text" name="user" id="user" class="form-control">

                            </div>
                            <div class="col-md-2 mb-4">
                              {{-- <input type="button" name="" id="filter_booking" value="Search" class="btn btn-primary"> --}}
                              <button type="button" class="btn primary-btn btn-primary w-100"  id="filter_booking" style="color: white !important" >
                                Search
                              </button>
                            </div>
                        </div>
                      </form>
                      <table class="datatables-ajax table table-condensed" data-role="ui-datatable" data-src="{{route('getbookingList')}}" data-searching = "true" width="100%">
                        <thead>
                            <tr>
                                <th class="pt-0" width="3%" data-colname="id" data-searchable="false">#</th>
                                <th class="pt-0" width="3%" data-colname="booking_number" > Booking#</th>
                                <th class="pt-0" data-colname="deligate_name"> Deligate</th>
                                <th class="pt-0" data-colname="customer_name"> Customer Name</th>
                                <th class="pt-0" data-colname="booking_status" > Booking Status</th>
                                <th class="pt-0" data-colname="created_at" data-searchable="false"> Created At</th>
                                <th class="pt-0" data-colname="action" data-searchable="false">Action</th>
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
          <div class="modal fade bd-example-modal-lg" id="booking-charges-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Charges <span id = "booking_id_span"></span></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body charges-form">

                </div>
                <div class="modal-footer">
                  <a href = "" class="btn btn-secondary" >Close</a>
                  <button type="button" class="btn btn-primary save-charges" >Save changes</button>
                </div>
              </div>
            </div>
          </div>

            <!-- Modal -->
          <div class="modal fade" id="booking-payment-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Payment <span id = "booking_id_payment"></span></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body payment-form">

                </div>
                <div class="modal-footer">
                  <a href = "" class="btn btn-secondary" >Close</a>
                  <button type="button" class="btn btn-primary save-payment" >Save changes</button>
                </div>
              </div>
            </div>
          </div>

           <!-- Modal -->
           <div class="modal fade" id="delete-charges-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Warning </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  Are you sure you want to remove these charges from bookings
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" id = "delete-id-charge" value = "">Remove</button>
                </div>
              </div>
            </div>
          </div>


@stop
@section('script')
<script>
  jQuery(document).ready(function(){
    $("#created_date").datepicker({maxDate: '0'});

    $(document).on('keyup','#received_amount',function(){

      if(Number($('#total_amount').val()) < Number($(this).val())){
        $('.save-payment').prop('disabled',true);
        $('#validate-message').show();
      }else{
        $('.save-payment').prop('disabled',false);
        $('#validate-message').hide();
      }
    })

    $(document).on('click','.add-payment',function(){
      let booking_id = $(this).data("id");
      $.ajax({
        url:"{{ route('get.booking.payments') }}",
        type:'POST',
        data:{'_token':"{{ csrf_token() }}",booking_id:booking_id},
        success:function(res){
          res = JSON.parse(res);
          if(res['status'] == '1'){
              $('#booking_id_payment').html(res['oData'].booking_number);
              $('.payment-form').html(res['oData'].html);
              $('#booking-payment-modal').modal('show');
          }else{
            $('#booking_id_payment').html('');
            $('.payment-form').html(res['oData'].html);
            $('#booking-payment-modal').modal('show');
          }
        },
        error:function(err){
          App.alert('Something went wrong with booking');
        }
      })
    })

    $(document).on('click','.save-payment',function(e){

        var datastring = $("#booking-payments-form").serialize();
        $.ajax({
          url:"{{ route('add.booking.payments') }}",
          type:'POST',
          data:datastring,
          success:function(res){
            res = JSON.parse(res);

            if(res['status'] == '1'){
              $('.payment-form').html(res['oData'].html);

            }else{
              App.alert('Payment could not added','Error')
            }
          },
          error:function(err){
            App.alert('Something went wrong with booking');
          }
        })

    })


    $(document).on('click','.save-charges',function(e){

        var datastring = $("#booking-charges-form").serialize();
        $.ajax({
          url:"{{ route('add.booking.charges') }}",
          type:'POST',
          data:datastring,
          success:function(res){
            res = JSON.parse(res);

            if(res['status'] == '1'){
              $('.charges-form').html(res['oData'].html);

            }else{
              App.alert('Charges could not added','Error')
            }
          },
          error:function(err){
            App.alert('Something went wrong with booking');
          }
        })

    })



    $(document).on('click','.delete-charge',function(){
      $('#delete-id-charge').val($(this).data('id'));
      $('#delete-charges-modal').modal('show');
    })

    $(document).on('click','#delete-id-charge',function(){

      let id = $(this).val();
      $.ajax({
        url:"{{ route('remove.booking.charges') }}",
        type:'POST',
        data:{'_token':"{{ csrf_token() }}",id:id},
        success:function(res){
          res = JSON.parse(res);

          if(res['status'] == '1'){

            $('.charges-form').html(res['oData'].html);
            $('#delete-charges-modal').modal('hide');
          }else{
            $('#delete-charges-modal').modal('hide');
             App.alert('Charges could not removed','Error')
          }
        },
        error:function(err){
          App.alert('Something went wrong with booking');
        }
      })

    })

    $(document).on('click','.add-charges',function(){
      let booking_id = $(this).data("id");
      $.ajax({
        url:"{{ route('get.booking.charges') }}",
        type:'POST',
        data:{'_token':"{{ csrf_token() }}",booking_id:booking_id},
        success:function(res){
          res = JSON.parse(res);
          if(res['status'] == '1'){
              $('#booking_id_span').html(res['oData'].booking_number);
              $('.charges-form').html(res['oData'].html);
              $('#booking-charges-modal').modal('show');
          }else{
            $('#booking_id_span').html('');
            $('.charges-form').html(res['oData'].html);
            $('#booking-charges-modal').modal('show');
          }
        },
        error:function(err){
          App.alert('Something went wrong with booking');
        }
      })
    })

    $(document).on('click','.add',function(){
          $('#add-fields').append('<div class="row"> <div class="col-md-4" > <label class="form-label">Charges Name</label> <input type="text" name="charges_name[]" class="form-control-plaintext" values=""> </div><div class="col-md-4" > <label class="form-label">Amount</label> <input type="text" name="amount[]" class="form-control-plaintext" values=""> </div><div class="col-md-4" > <button type="button" class="btn btn-primary btn-xs mt-4 add"><i class="fa fa-plus"></i></button> <button type="button" class="btn btn-danger btn-xs mt-4 remove"><i class="fa fa-trash"></i></button> </div></div>');
      })

      $(document).on('click','.remove',function(){
          $(this).parent().parent('.row').remove();
          calculate_total();
      })


      $(document).on('click','.edit-commission',function(){
        let row_id = $(this).data('id');
        $('#span'+row_id).hide();
        $('#input_span'+row_id).show()
      })

      $(document).on('click','.save-commission',function(){
          let row_id = $(this).data('id');

          let commission_amount = $('#input'+row_id).val();
          let booking_id = row_id;

          $.ajax({
            url:"{{ route('bookings.add.commission') }}",
            type:"POST",
            data:{commission_amount:commission_amount,booking_id:booking_id,'_token':"{{ csrf_token() }}"},
            success:function(res){
              res = JSON.parse(res);

              App.toast(res['message']||'The commission amount has been added to the booking', 'Success!','success');
                    if(res['status'] != '0'){
                      $('#span'+row_id).html(res['html'])
                      $('#input_span'+row_id).hide();
                      $('#span'+row_id).show();
                    }
            },
            error: function (e) {
              console.log(e);
              App.alert( "Sorry! The following commission amount could not added", 'Oops!','error');
            }
          })


      })

      App.initTreeView();

  })


</script>
@stop
