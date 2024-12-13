@extends("admin.template.layout")
@section('header')
    <style>
        .load{
            display: none;
        }
        .load-assign{
            display: none;
        }
        .approve-load{
            display: none;
        }
        
        .main-btn:disabled {
          background: #dddddd;
        }

    </style>
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

              <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Assign Drivers</h5>
                    </div>
                      <div class="card-body">
                            <form id="admin_form" action = "{{ route('bookings.assign.drvivers',['id' => $booking->id]) }}" method = "POST" enctype="multipart/form-data">
                                @csrf    
                                
                            <div class="row " id = "add_trucks_div">    
                                <div class = "col-md-12 add-trucks">
                                @foreach($booking->booking_truck as $booking_truck_index => $booking_truck)    
                                        <div class="row align-items-end">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Truck Type</label>
                                                <select class="form-control-plaintext truck_type" disabled>
                                                    <option value = "">Select Truck Type</option>
                                                    @foreach($trucks as $truck)
                                                    <option value = "{{$truck->id}}" {{ $booking_truck->truck_id == $truck->id?'selected':'' }}>{{$truck->truck_type." -- "."(".$truck->dimensions.")"." -- ".strtoupper($truck->type)}}</option>
                                                    @endforeach
                                                </select>
                                                <input type = "hidden" name = "truck_type[{{$booking_truck_index}}]" value = "{{$booking_truck->truck_id}}">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Quantity</label>
                                                <input type = "number" class="form-control-plaintext" name = "quantity[{{$booking_truck_index}}]" data-jqv-required="true" value = "{{ $booking_truck->quantity }}" readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label">Total Gross Weight (Per Truck)</label>
                                                <input type = "text" class="form-control-plaintext" name = "gross_weight[{{$booking_truck_index}}]" data-jqv-required="true" value = "{{ $booking_truck->gross_weight }}" readonly>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <button type = "button" class = "btn btn-primary rounded-0 btn-sm add w-100"><i class = "fa fa-plus"></i></button>
                                            </div>
                                      
                                           
                                            
                                            
                                        </div>
                                        <div class="row">
                                             <div class="col-md-12">
                                                <label class="form-label">Drivers</label>
                                                <select class="company-select company-select-2" name = "drivers[{{$booking_truck_index}}][]" data-jqv-required="true" multiple >
                                                    @foreach(get_truck_drivers($booking_truck->truck_id,$booking->id) as $driver)
                                                    <option value = "{{ $driver->user_id }}" >{{ $driver->name }}  {{  ($driver->is_company == 'no')?'(Individual)':'(Company)'  }} {{$driver->email}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endforeach
                                        @if(count($booking->booking_truck) == 0)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Truck Type</label>
                                                <select class="form-control-plaintext truck_type" name = "truck_type[0]"  data-id = "0">
                                                    <option value = "">Select Truck Type</option>
                                                    @foreach($trucks as $truck)
                                                    <option value = "{{$truck->id}}" >{{$truck->truck_type." -- "."(".$truck->dimensions.")"." -- ".strtoupper($truck->type)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Quantity</label>
                                                <input type = "number" class="form-control-plaintext" name = "quantity[0]" data-jqv-required="true" value = "">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Total Gross Weight (Per Truck)</label>
                                                <input type = "text" class="form-control-plaintext" name = "gross_weight[0]" data-jqv-required="true" value = "">
                                            </div>
                                            <div class="col-md-2">
                                                <button type = "button" class = "btn btn-primary rounded-0 btn-sm add"><i class = "fa fa-plus"></i></button>
                                            </div>
                                            <div class="col-md-10">
                                                <label class="form-label">Drivers</label>
                                                <select class="company-select" name = "drivers[0][]" id = "company-0" data-jqv-required="true" multiple>
                                                    <option value = ""></option>
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                <div>
                            </div>        
                            </div>
                            </div>

                            
                            <div class = "row">
                                <div class="col-md-12">

                                    <button class="main-btn primary-btn btn-hover btn-sm mt-4" type="submit"> Assign Drivers
                                        <span class="spinner-border spinner-border-sm load" role="status" aria-hidden="true"></span>
                                        <span class="sr-only load">Loading...</span>
                                    </button>

                                </div>
                            </div>
                        </form>
                
            </div>
        </div>
          <br />
          <br />
              <!-- Ajax Sourced Server-side -->
              <div class="card">
                <div class="card-header justify-content-between">
                    <h5 class="mb-0">{{'Received Qoutes' ?? $page_heading}}</h5>
                    @if($booking->status != 'completed')
                    <button class="main-btn primary-btn btn-hover btn-sm float-right" type="button" id = "submit-approve"> Approve Quotes
                          <span class="spinner-border spinner-border-sm approve-load" role="status" aria-hidden="true"></span>
                          <span class="sr-only approve-load">Loading...</span>
                    </button>

                 
                    @endif
                    @if($booking->admin_can_accept_quote == 1)
                        <button class="main-btn primary-btn btn-hover btn-sm float-right" type="button" id = "submit-accept"> Accept Quotes
                          <span class="spinner-border spinner-border-sm approve-load" role="status" aria-hidden="true"></span>
                          <span class="sr-only approve-load">Loading...</span>
                    </button>
                    @endif
                </div>
                <div class="card-body">
                  <div class="card-datatable text-nowrap">
                    <div class="table-responsive">
                      <table class="datatables-ajax table table-condensed" data-role="ui-datatable" data-src="{{route('getBookingQouteList',['id' => $id])}}" >
                        <thead>
                            <tr>
                                <th class="pt-0" data-colname="id">Sr.</th>
                                <th class="pt-0" data-colname="created_at"> Quotation date</th>
                                <th class="pt-0" data-colname="check_all" data-orderable="false">
                                  <input type = "checkbox" name = "all" id = "all" >
                                </th>
                                
                                <th class="pt-0" data-colname="driver_name"> Driver Name</th>
                                <th class="pt-0" data-colname="truck_type"> Truck Type</th>
                                <th class="pt-0" data-colname="deliver_address"> Destination</th>
                                <th class="pt-0" data-colname="collection_address"> Collection Point</th>
                                <th class="pt-0" data-colname="qouted_amount"> Quoted Amount</th>
                                <!-- <th class="pt-0" data-colname="comission_amount"> Commission</th> -->
                                <th class="pt-0" data-colname="hours"> Total Hours</th>
                                <th class="pt-0" data-colname="qoute_status"> Quote Status</th>
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
{{--
          <div class="modal fade" id="assign-drivers-modals" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Select Drivers to Assign in Booking Request</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <input type = "text" name = "search" id = "search" class = "form-control" placeholder="Search by name or email" >
                  <form action = "{{ route('bookings.assign.drvivers',['id' => $id]) }}" id = "assign_drivers_form" method = "POST">
                    @csrf
                    <table class = "table table-bordered" id = "drivers">
                      <tr>
                        <th><input type = "checkbox" name = "select_all_drivers" id = "select-all"></th>
                        <th>Drivers Name (Email)</th>
                        <th>Truck Type</th>
                      </tr>
                      @foreach($drivers as $driver)
                      <tr>
                        <td><input type = "checkbox" name = "drivers[]" class = "select-driver" value = "{{$driver->user_id}}" required = "required"></td>
                        <td>{{ $driver->name."(". $driver->email.")"}}</td>
                        <td>{{ $truck->truck_type ?? '' }}</td>
                      </tr>
                      @endforeach
                    </table>

                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="main-btn primary-btn btn-hover btn-sm" id = "assign" onclick="$('#assign_drivers_form').submit()">Assign
                    <span class="spinner-border spinner-border-sm load-assign" role="status" aria-hidden="true"></span>
                          <span class="sr-only load">Loading...</span>
                  </button>
                </div>
              </div>
            </div>
          </div>
  --}}

      <!-- Modal -->
          <div class="modal fade" id="quote-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Quote </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body quote-form">
                <form action = "{{ route('add.qoutes.save') }}" method = "POST" id = "quote-form">
                  
                    <input type = "hidden" name = "qouteid" id = "qouteid" value = "">  
                      @csrf
                      <div class="row">
                          <div class="col-md-12" >
                              <label class="form-label">Quote Amount</label>
                              <input type = "number" name = "price" id = "price" class = "form-control-plaintext" value = "" >
                          </div>
                           <div class="col-md-12" >
                              <label class="form-label">Hours</label>
                              <input type = "number" name = "hours" id = "hours" class = "form-control-plaintext" value = "" >
                          </div>
                      </div>
                    <hr />
                  
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary save-quote" >Save changes</button>
                </div>
              </div>
            </div>
          </div>


              <!-- Modal -->
          <div class="modal fade" id="commission-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabeldd">Add Commission </h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body commission-form">
                <form action = "{{ route('add.qoutes.commission') }}" method = "POST" id = "commission-form">
                  
                    <input type = "hidden" name = "qoute_id" id = "qoute_id" value = "">  
                      @csrf
                      <div class="row">
                          <div class="col-md-12" >
                              <label class="form-label">Commission %</label>
                              <input type = "number" name = "commission_amount" id = "commission_amount" class = "form-control-plaintext" value = "" min="0" max="100">
                          </div>
                      </div>
                    <hr />
                  
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary save-commission" >Save changes</button>
                </div>
              </div>
            </div>
          </div>
<?php
    $optionsString = "<option>Select Truck</option>";
foreach($trucks as $truck){
    $optionsString .= "<option value='".$truck->id."'>".$truck->truck_type." -- (".$truck->dimensions.")"."</option>";
}
?>        

  @stop
  @section('script')
  <script>
    jQuery(document).ready(function(){
        App.initTreeView();

        $("#assign_drivers_form").validate();


        $("#search").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#drivers tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });  

        $('[id]').each(function (i) {
          $('[id="' + this.id + '"]').slice(1).remove();
        });

        $(document).on('click','#select-all',function(){
          if($(this).is(":checked")){
            $('.select-driver').prop('checked', true);
          }
          else{
            $('.select-driver').prop('checked', false);
          }
        })


        $(document).on('click','.select-driver',function(){
            
            let totalCheckboxes = ($('.select-driver').length);
            
            let numberOfChecked = $('.select-driver:checked').length;

            console.log('totalCheckboxes'+totalCheckboxes+'=numberOfChecked'+numberOfChecked)
            if(totalCheckboxes == numberOfChecked){
               $('#select-all').prop('checked', true); 
            }else{
              $('#select-all').prop('checked', false);
            }          
        })


        $(document).on('click','#all',function(){
          
          if($(this).is(":checked")){
            $('.check_all').prop('checked', true);
          }
          else{
            $('.check_all').prop('checked', false);
          }
        })


        $(document).on('click','.check_all',function(){
            
            let totalCheckboxes = $('.check_all').length;
            
            let numberOfChecked = $('.check_all:checked').length;

            if(totalCheckboxes == numberOfChecked){
               $('#all').prop('checked', true); 
            }else{
              $('#all').prop('checked', false);
            }          
        })


    })

    $(document).on('click','#submit-approve',function(){
      let ids = [];
      $(".check_all:checked").each(function(){
          ids.push($(this).val());
      }); 
      let booking_id = "{{ $id }}";
      if(ids.length > 0){
        $.ajax({
          url:"{{ route('approve.qoutes') }}",
          type:"POST",
          data:{ids:ids,booking_id:booking_id,'_token':"{{ csrf_token() }}"},
          beforeSend: function() {
              $("#submit-approve").attr('disabled','disabled');
              $('.approve-load').show();
          },
          success:function(res){
            res = JSON.parse(res);
            App.alert(res['message']||'The Following Quotes have been approved and sent to customer', 'Success!','success');
                  if(res['status'] != '0'){
                    setTimeout(function(){
                        window.location.href = res['oData']['redirect'];
                    },2500);
                  }
          },
          error: function (e) {
            console.log(e);
            App.alert( "Sorry The Following Quotes could not approved", 'Oops!','error');
          },
          complete: function() {
              $("#submit-approve").removeAttr('disabled');
              $('.approve-load').hide();
          },
        })
      }else{
        App.alert( "Atleast select one quote to approve", 'Oops!','error');
      }

    })


    $(document).on('click','#submit-accept',function(){
      let ids = [];
      $("body").find(".checked:checked").each(function(){
          ids.push($(this).val());
      }); 
      let booking_id = "{{ $id }}";
      if(ids.length > 0){
        $.ajax({
          url:"{{ route('accept.qoutes') }}",
          type:"POST",
          data:{quote_ids:ids,booking_id:booking_id,'_token':"{{ csrf_token() }}"},
          beforeSend: function() {
              $("#submit-approve").attr('disabled','disabled');
              $('.approve-load').show();
          },
          success:function(res){
            res = JSON.parse(res);
            App.alert(res['message']||'The Following Quotes have been accepted', 'Success!','success');
                  if(res['status'] != '0'){
                    setTimeout(function(){
                        window.location.href = res['oData']['redirect'];
                    },2500);
                  }
          },
          error: function (e) {
            console.log(e);
            App.alert( "Sorry The Following Quotes could not accepted", 'Oops!','error');
          },
          complete: function() {
              $("#submit-approve").removeAttr('disabled');
              $('.approve-load').hide();
          },
        })
      }else{
        App.alert( "Atleast select one quote to accept", 'Oops!','error');
      }

    })

    $(document).on('click','.save-commission',function(){
      let qoute_id = $('#qoute_id').val();
      let commission_amount = $('#commission_amount').val();
      $.ajax({
        url:"{{ route('add.qoutes.commission') }}",
        type:'POST',
        data:{'_token':"{{ csrf_token() }}",qoute_id:qoute_id,commission_amount:commission_amount},
        success:function(res){
          res = JSON.parse(res);
          if(res['status'] == '1'){
            App.alert(res['message']);     
          }else{
            App.alert(res['message']);
          }

          setTimeout(function(){
              window.location.href = '';
          },2500);

        },
        error:function(err){
          App.alert('Something went wrong');
        }
      })
    })



    $(document).on('submit','#assign_drivers_form',function(e){
      e.preventDefault();

      let ids = [];
      $(".select-driver:checked").each(function(){
          ids.push($(this).val());
      }); 
      let booking_id = "{{ $id }}";
      if(ids.length > 0){
        $.ajax({
          url:"{{ route('bookings.assign.drvivers',['id' => $id]) }}",
          type:"POST",
          data:{drivers:ids,'_token':"{{ csrf_token() }}"},
          beforeSend: function() {
              $("#assign").attr('disabled','disabled');
              $('.load-assign').show();
          },
          success:function(res){
            res = JSON.parse(res);
              $('#modal').modal('hide');
            
                  if(res['status'] != '0'){
                    setTimeout(function(){
                      App.alert(res['message']||'Drivers assigned successfully', 'Success!','success');
                      location.reload(true);
                    },2500);
                  }
          },
          error: function (e) {
            console.log(e);
            App.alert( "Sorry Drivers could not be assigned", 'Oops!','error');
          },
          complete: function() {
              $("#assign").removeAttr('disabled');
              $('.load-assign').hide();
          },
        })
      }else{
        App.alert( "Atleast select one driver to assign", 'Oops!','error');
      }

    })
  </script>

  
<script>
        jQuery(document).ready(function () {
            $('.company-select-2').select2();
            $('#company-0').select2();

            $(document).on('change','.truck_type',function(){
                if($(this).val() != ''){
                    let truck_id = $(this).val();
                    let id = $(this).data('id');
                    $.ajax({
                        url:"{{ route('get_drivers') }}",
                        type:'POST',
                        data:{truck_id:truck_id,'_token':"{{ csrf_token() }}"},
                        success:function(res){
                            $('#company-'+id).html(res.options)

                        }
                    })
                }
                else{
                    let id = $(this).data('id');
                    $('#company-'+id).html.html('')
                }
                
            })


    $('.all-select').click(function(){
        $(this).siblings('.crud-items').prop('checked', this.checked);
    });
    $('.crud-items').click(function(){
        $(this).siblings('.all-select').prop('checked', false);
    });
    $('.all-p').click(function(){
        $(this).siblings('.reader').prop('checked', true);
    });
    App.initFormView();
    let form_in_progress=0;

    $('body').off('submit', '#admin_form');
    $('body').on('submit', '#admin_form', function(e) {
        e.preventDefault();
        var validation = $.Deferred();
        var $form = $(this);
        var formData = new FormData(this);

        $form.validate({
            rules: {
                customer:{
                    required:true
                },
                deligate:{
                  required:true  
                },
                shipping_method:{
                  required:true  
                },
                collection_address:{
                  required:true  
                },
                deliver_address:{
                  required:true  
                }
            },
            errorElement: 'div',
            errorPlacement: function(error, element) {
                element.addClass('is-invalid');
                error.addClass('error');
                error.insertAfter(element);
            }
        });

        // Bind extra rules. This must be called after .validate()
        App.setJQueryValidationRules('#admin_form');

        if ( $form.valid() ) {
            validation.resolve();
        } else {
            var error = $form.find('.is-invalid').eq(0);
            $('html, body').animate({
                scrollTop: (error.offset().top - 100),
            }, 500);
            validation.reject();
        }

        validation.done(function() {
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('div.error').remove();


            App.button_loading(true);


            form_in_progress = 1;
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: $form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                dataType:'html',
                beforeSend: function() {
                    $("#submit").attr('disabled','disabled');
                    $('.load').show();
                },
                success: function (res) {
                    res = JSON.parse(res);
                    console.log(res['status']);
                    form_in_progress = 0;
                    App.button_loading(false);
                    if ( res['status'] == 0 ) {
                        if ( typeof res['errors'] !== 'undefined' ) {
                            var error_def = $.Deferred();
                            var error_index = 0;
                            jQuery.each(res['errors'], function (e_field, e_message) {
                                if ( e_message != '' ) {
                                    $('[name="'+ e_field +'"]').eq(0).addClass('is-invalid');
                                    $('<div class="error">'+ e_message +'</div>').insertAfter($('[name="'+ e_field +'"]').eq(0));
                                    App.alert(e_message, 'Oops!','error');
                                    $('.load').hide();
                                    if ( error_index == 0 ) {
                                        error_def.resolve();
                                    }
                                    error_index++;
                                }
                            });
                            error_def.done(function() {
                                var error = $form.find('.is-invalid').eq(0);
                                                $('html, body').animate({
                                                    scrollTop: (error.offset().top - 100),
                                                }, 500);
                                            });
                        } else {
                            var m = res['message']||'Unable to save variation. Please try again later.';
                            App.alert(m, 'Oops!','error');
                        }
                    } else {
                        App.alert(res['message']||'Record saved successfully', 'Success!','success');
                        setTimeout(function(){
                            window.location.href = res['oData']['redirect'];
                        },2500);

                    }

                },
                complete: function() {
                    $("#submit").removeAttr('disabled');
                    $('.load').hide();
                },
                error: function (e) {
                    form_in_progress = 0;
                    App.button_loading(false);
                    console.log(e);
                    $('.load').hide();
                    App.alert( "The Booking information creating failed", 'Oops!','error');
                }
            });
        });
    });
        })

        $(document).ready(function(){
              
            let truckCount = "{{ isset($booking_truck_index)?($booking_truck_index + 1):1 }}";
            let trucks = @json($optionsString);
            function addTruckRow() {
                const truckRow = `
                <div class="row">
                    <div class="col-md-6">
                    <label class="form-label">Truck Type</label>
                    <select class="form-control-plaintext truck_type" name="truck_type[${truckCount}]" id="truck_type" data-id="${truckCount}">
                        ${trucks}
                    </select>
                    </div>
                    <div class="col-md-2">
                    <label class="form-label">Quantity</label>
                    <input type="number" class="form-control-plaintext" name="quantity[${truckCount}]" data-jqv-required="true" value="">
                    </div>
                    <div class="col-md-2">
                    <label class="form-label">Total Gross Weight (Per Truck)</label>
                    <input type="number" class="form-control-plaintext" name="gross_weight[${truckCount}]" data-jqv-required="true" value="">
                    </div>
                    <div class="col-md-2"> 
                    <button type = "button" class="btn btn-primary rounded-0 btn-sm add"><i class="fa fa-plus"></i></button>
                    <button type = "button" class="btn btn-danger rounded-0 btn-sm remove"><i class="fa fa-minus"></i></button>
                    </div>
                    <div class="col-md-10">
                    <label class="form-label">Drivers</label>
                    <select class="company-select" name="drivers[${truckCount}][]" id="company-${truckCount}" data-jqv-required="true" multiple>
                        <option value=""></option>
                    </select>
                    </div>
                </div>`;

                $('.add-trucks').append(truckRow);
                $('#company-'+truckCount).select2();
                truckCount++;
            }


            $(document).on('click','.add',function(){
                addTruckRow()
            })

            $(document).on('click','.remove',function(){
                $(this).closest('.row').remove();
            })
             
             
        })

        $(document).on('click','.add-commission',function(){
          $('#commission_amount').val($(this).data('commission'));
          $('#qoute_id').val($(this).data('id'));
          $('#commission-modal').modal('show');
        })

         $(document).on('click','.add-quote',function(){
          
          $('#qouteid').val($(this).data('id'));

          $('#price').val($(this).data('price'));

          $('#hours').val($(this).data('hours'));
        })



        $('#add-quote').on('click',function(){
            $('#quote-modal').modal('show');

        });

        $(document).on('click','.save-quote',function(){
      let qoute_id = $('#qouteid').val();
      let price = $('#price').val();
      let hours = $('#hours').val();
      $.ajax({
        url:"{{ route('add.qoutes.save') }}",
        type:'POST',
        data:{'_token':"{{ csrf_token() }}",qoute_id:qoute_id,hours:hours,price:price},
        success:function(res){
          res = JSON.parse(res);
          if(res['status'] == '1'){
            $('#quote-modal').modal('hide');
            App.alert(res['message']);     
          }else{
            App.alert(res['message']);
          }

          setTimeout(function(){
              window.location.href = '';
          },2500);

        },
        error:function(err){
          App.alert('Something went wrong');
        }
      })
    })
        
    </script>


  @stop
