@extends("admin.template.layout")
@section('header')
    <style>
        .form-control-plaintext {
            padding-left: 7px;
            border: 1px solid #990253;
            border-radius: 10px;
            color: #212529;
            text-align: left;
            margin-bottom: 15px;
        }

        .form-label {
            margin-bottom: 5px;
        }
        .load{
            display: none;
        }

        .select2-container--default .select2-search--inline .select2-search__field {
            width: 100% !important; 
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
        cursor: default;
        padding-left: 0px; 
        padding-right: 0px; 
    }
    </style>
@endsection
@section('content')
            
            <?php 
                $html = get_booking_status($booking->admin_response,$booking->status);
            ?>
            <?php            

            $p_status = '';
            $p_status_color = '';
            if($booking->is_paid == 'no'){
                $p_status = 'UNPAID';
                $p_status_color = 'danger';
            }
            else if($booking->is_paid == 'yes'){
                $p_status = 'PAID';
                $p_status_color = 'info';
            }

            $p_statuses = ['unpaid','paid'];

            $p_html = '';
               
                $p_html .= '<div class="dropdown float-right" >';
                $p_html .=            '<button class="main-btn btn-sm btn-'.$p_status_color.' dropdown-toggle" type="button" data-toggle="dropdown">
                                '. $p_status.'
                            <span class="caret"></span></button>';

                $p_html .=   '<ul class="dropdown-menu">';
                foreach($p_statuses as $p_st){
                    if(strtoupper(str_replace('_',' ',$p_st)) == $p_status){
                        continue;
                    }

                    $route = route('payment_status',['id' => $booking->id,'status' => $p_st]);
                    $p_html .= '<li><a class="dropdown-item" href="'.$route.'">'.strtoupper(str_replace('_',' ',$p_st)) .'</a></li>';
                }
                
                $p_html .=    '</ul>';
                $p_html .=    '</div>';
            
        ?>
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Ajax Sourced Server-side -->
        <div class="card">
            <div class="card-header justify-content-between">
                {!! $html !!}
                <h5 class="mt-1">{{'Booking '. $booking->booking_number  }}</h5>
                @if(isset($booking->invoice_number))
                <h5 class="mb-0">{{'Invoice #'. $booking->invoice_number }}</h5>
                @else
                <h5 class="mb-0">{{'Invoice # (Not Added Yet)' }}</h5>
                @endif

                {{--<a class="main-btn primary-btn btn-hover btn-sm float-right" href="{{ route('booking.qoutes', ['id' => encrypt($booking->id)]) }}"><i class="bx bxs-truck"></i> Driver Quotes</a>--}}
                <a class = "main-btn primary-btn btn-hover btn-sm float-right" href = "{{ route('bookings.edit', ['id' => encrypt($booking->id)]) }}"><i class = "fa fa-pencil"></i> Edit</a>
                {!! $p_html !!}
            </div>
            <div class="card-body py-0">
                <div class="row">
                    {{--
                    <div class="col-md-2 col-sm-4 primary-btn    py-4 rounded">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="{{get_uploaded_image_url($user->user_image, 'user_image_upload_dir')}}"
                                         class="img-fluid rounded-circle"
                                         alt="Responsive image">
                                </div>
                            </div>
                        </div>
                    </div>
                    --}}

                    <div class="col-md-12 col-sm-12 py-4">
                            <form id="admin_form" action = "{{ route('bookings.update',['id' => $booking->id]) }}" method = "POST" enctype="multipart/form-data">
                                @csrf
                            <div class="row">
                                
                                <div class="col-md-6" >
                                    <label class="form-label">Customer</label>
                                    <div class="form-control-plaintext" >
                                        @foreach($customers as $customer)
                                        @if($booking->sender_id == $customer->id)
                                        {{$customer->name."\n"."(".$customer->email.")"}}
                                        @endif 
                                        @endforeach
                                    </div>    

                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Deligate</label>
                                    <div class="form-control-plaintext" >
                                        {{ $deligate->name ?? '' }}
                                    </div>      
                                </div>

                                <div class="col-md-6 deligate_details_warehousing">
                                    <label class="form-label">Would you like to <b>Timex Shipping LLC</b> to collect your cargo?</label>
                                    <div class="form-control-plaintext" >
                                        {{ $booking->is_collection == 1 ?'Yes':'No' }}
                                    </div>
                                </div>

                                @if($booking->is_collection == 1)
                                    <div class="col-md-6">
                                        <label class="form-label">Collection Address</label>
                                        <div class="form-control-plaintext" >
                                            {{ $booking->collection_address ?? '' }}
                                        </div>      
                                    </div>
                                @endif

                                <div class="col-md-6 deligate_details_warehousing">
                                    <label class="form-label">Items are stockable</label>
                                    <div class="form-control-plaintext" >
                                        {{ strtoupper($booking->warehouse_detail->items_are_stockable) }}
                                    </div>  
                                </div>

                                    <div class="col-md-6 deligate_details_warehousing">
                                        <label class="form-label">Types of Storages</label>
                                        <div class="form-control-plaintext" >
                                            {{ $booking->warehouse_detail->storage_type->name ?? ' ' }} &nbsp;
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 deligate_details_warehousing">
                                        <label class="form-label">Item</label>
                                        <div class="form-control-plaintext" >
                                            {{ $booking->warehouse_detail->item ?? ' ' }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 deligate_details_warehousing">
                                        <label class="form-label">No of Pallets</label>
                                        <div class="form-control-plaintext" >
                                            {{ $booking->warehouse_detail->no_of_pallets ?? ' ' }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 deligate_details_warehousing">
                                        <label class="form-label">Pallet Dimensions</label>
                                        <div class="form-control-plaintext" >
                                            {{ $booking->warehouse_detail->pallet_dimension ?? ' ' }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 deligate_details_warehousing">
                                        <label class="form-label">Weight per Pallet (Kg)</label>
                                        <div class="form-control-plaintext" >
                                            {{ $booking->warehouse_detail->weight_per_pallet ?? ' ' }}
                                        </div>
                                    </div>

                                    <div class="col-md-6 deligate_details_warehousing">
                                        <label class="form-label">Total Weight (Kg)</label>
                                        <div class="form-control-plaintext" >
                                            {{ $booking->warehouse_detail->total_weight ?? ' ' }}
                                        </div>    
                                    </div>
                                    
                                    <div class="col-md-6 deligate_details_warehousing">
                                        <label class="form-label">Total Item Cost</label>
                                        <div class="form-control-plaintext" >
                                            {{ $booking->warehouse_detail->total_item_cost ?? ' ' }}
                                        </div>
                                    </div>
 
                                <div class="col-md-6" >
                                    <label class="form-label">Shipping Method</label>
                                    <div class="form-control-plaintext" >
                                        @foreach($shipping_methods as $shipping_method)
                                        @if(isset($booking->shipping_method_id) && $booking->shipping_method_id == $shipping_method->id)
                                            {{$shipping_method->name}}
                                        @endif
                                        @endforeach
                                        &nbsp;&nbsp;
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Invoice Number</label>
                                    <div class="form-control-plaintext" >
                                        {{ $booking->invoice_number }}
                                         &nbsp;&nbsp;
                                    </div>    
                                </div>
                                <div class="col-md-6">
                                        <label class="form-label">Date of Commencement</label>
                                        <div class="form-control-plaintext" >
                                            {{ $booking->date_of_commencement }}
                                             &nbsp;&nbsp;
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Date of Return</label>
                                        <div class="form-control-plaintext" >
                                            {{ $booking->date_of_return }}
                                             &nbsp;&nbsp;
                                        </div>
                                    </div>
                                @if($booking->status == 'items_received_in_warehouse' || $booking->status == 'items_stored' || $booking->status == 'completed')
                                    <div class="col-md-6">
                                        <label class="form-label">Rack/ Location No</label>
                                        <div class="form-control-plaintext" >
                                            {{ $booking->rack }}
                                             &nbsp;&nbsp;
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Storage Pictures</label>
                                        @if($booking->storage_picture)
                                        <img src = "{{$booking->storage_picture }}" width = "200">
                                        @endif
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Instructions</label>
                                        <div class="form-control-plaintext" >
                                            {{ $booking->instructions }}
                                             &nbsp;&nbsp;
                                        </div>
                                    </div>
                                @endif

                                @php
                                $quote = $booking->booking_qoutes->first();
                                @endphp
                               <div class="col-md-6">
                                    <label class="form-label">Quote Price</label>
                                     <div class="form-control-plaintext" >
                                       {{ $quote->price ?? 0 }}
                                    </div> 
                                </div>
                               <!--  <div class="col-md-6">
                                    <label class="form-label">Hours</label>
                                     <div class="form-control-plaintext" >
                                        {{ $quote->hours ?? 0 }}
                                    </div> 
                                </div> -->
                                <div class="col-md-6 d-none">
                                    <label class="form-label">Commission %</label>
                                     <div class="form-control-plaintext" >
                                        {{ $quote->comission_amount ?? 0 }}
                                    </div> 
                                </div>
                            </div>
                            @if($booking->is_collection == 1)
                            <div class="row d-none">
                                @foreach($booking->booking_truck as $b_truck)
                                    <div class="col-md-6">
                                        <label class="form-label">Truck Type</label>
                                            <div class="form-control-plaintext">
                                                @foreach($trucks as $truck)
                                                    @if($truck->id == $b_truck->truck_id)
                                                    {{$truck->truck_type." -- "."(".$truck->dimensions.")"}}
                                                    @endif
                                                @endforeach
                                            </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Quantity</label>
                                        <div class="form-control-plaintext" >
                                            {{ $b_truck->quantity }}
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Total Gross Weight</label>
                                        <div class="form-control-plaintext" >
                                            {{ $b_truck->gross_weight }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @endif
                            <div class = "row d-none">
                                <div class = "col-md-12">
                                    <hr />
                                </div>
                            </div>

                            <div class = "row d-none">
                                <div class = "col-md-8">
                                    <label class="form-label">Remark</label>
                                    <textarea class="form-control-plaintext" rows = "11" readonly>{{ $accepetdqoaute->delivery_note??'' }}</textarea>
                                </div>

                                <div class = "col-md-4">
                                    <label class="form-label">Customer Signature</label>
                                    @if(!empty($accepetdqoaute->customer_signature) && $accepetdqoaute->customer_signature != null && $accepetdqoaute->customer_signature != 0)
                                        <img src = "{{ asset('storage/bookings/'.$accepetdqoaute->customer_signature) }}" width = "200">
                                    @else
                                        <img src = "{{ asset('images/no-sign.png') }}" width = "200">
                                    @endif
                                    
                                </div>
                            </div>

                            <div class = "row">
                                <div class = "col-md-4">
                                    <h5> Booking History </h5>
                                    
                                    <table class = "table table-striped">
                                        @foreach($booking->booking_status_trackings as $tracking)
                                        <tr>
                                            <th>{{strtoupper(str_replace('_',' ',$tracking->status_tracking))}}: </th>
                                            <td>{{ date('Y-m-d h:i A', strtotime($tracking->created_at)) }} </td>
                                        </tr>     
                                        @endforeach
                                    </table>
                                </div>
                                <div class = "col-md-4">
                                    <h5> Details </h5>
                                    @forelse($booking->booking_accepted_qoutes as $accepted_qoute)
                                        <div class="text-left">
                                                {{--
                                                <img src="{{$booking->company->logo}}" alt="Logo"
                                                class="img-thumbnail img-fluid" style="width: 100px;">
                                                --}}
                                                <a href = "{{ route('drivers.view',['id' => encrypt($accepted_qoute->driver->id)]) }}">
                                                    <h6 class="mt-0">{{ $accepted_qoute->driver->name ?? ''}}</h6>
                                                    <p class="text-muted mb-1">{{ $accepted_qoute->driver->driver_detail->truck_type->truck_type ?? ''}}
                                                    {!! get_booking_truck_status($accepted_qoute->status) !!} 
                                                    </p>
                                                    
                                                </a>
                                                @if($accepted_qoute->status == 'delivered')  
                                                @if($accepted_qoute->deliver_note_doc != null && $accepted_qoute->deliver_note_doc != 0)
                                                    <!-- <img src = "{{ asset('storage/bookings/'.$accepted_qoute->deliver_note_doc) }}" width = "100"> -->
                                                <a href="{{ asset('storage/bookings/'.$accepted_qoute->deliver_note_doc) }}" target="_blank"><i class="bx bx-download"></i>Delivery Note</a>
                                                @endif
                                                @endif                                                           
                                                    
                                        </div>    
                                        @empty
                                        <p class="text-muted mb-1"> Not Approved Yet </p>             
                                        @endforelse
                                    </div>

                                <div class = "col-md-4">
                                    <table class = "table table-striped">
                                        <tr>
                                            <th>Total Quoted Amount: </th>
                                            <td>{{ number_format($booking->total_qoutation_amount,2)}} </td>
                                        </tr>
                                        <!-- <tr>
                                            <th>Total Commission (%): </th>
                                            <td>{{ number_format($booking->total_commission_amount,2) }}  </td>
                                        </tr> -->
                                        {{--
                                        <tr>
                                            <th>Border Charges: </th>
                                            <td>{{ number_format($booking->border_charges,2)}} </td>
                                        </tr>
                                        
                                        <tr>
                                            <th>Shipping Charges: </th>
                                            <td>{{ number_format($booking->shipping_charges,2)}} </td>
                                        </tr>
                                        <tr>
                                            <th>Waiting Charges: </th>
                                            <td>{{ number_format($booking->waiting_charges,2)}} </td>
                                        </tr>
                                        <tr>
                                            <th>Custom Charges: </th>
                                            <td>{{ number_format($booking->custom_charges,2)}} </td>
                                        </tr>
                                        <tr>
                                            <th>Cost of Truck: </th>
                                            <td>{{ number_format($booking->cost_of_truck,2)}} </td>
                                        </tr>
                                        --}}
                                        @if(count($booking->booking_charges) > 0)
                                            @foreach($booking->booking_charges as $charge)
                                            <tr>
                                                <th>{{$charge->charges_name ?? ''}}: </th>
                                                <td>{{ $charge->charges_amount ?? 0 }} </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                        <tr>
                                            <th>Sub Total: </th>
                                            <td>{{ number_format($booking->sub_total,2)}} </td>
                                        </tr>
                                        <tr>
                                            <th>Grand Total: </th>
                                            <td>{{ number_format($booking->sub_total,2)}} </td>
                                        </tr>
                                        <tr>
                                            <th>Advance Payment: </th>
                                            <td>{{ number_format($booking->total_received_amount,2)}} </td>
                                        </tr>
                                        <tr>
                                            <th>Balance Payment: </th>
                                            <td>{{ number_format($booking->grand_total - $booking->total_received_amount,2)}} </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class = "row">
                                <div class = "col-md-12">
                                    <hr />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                {{--
                                    <label class="form-label">Location</label>
                                
                                @if($user->lattitude && $user->longitude)
                                <x-elements.map-location
                                    addressFieldName="address"
                                    :lat="$user->lattitude"
                                    :lng="$user->longitude"
                                    :address="$user->address"
                                    :mapOnly="true"
                                />
                                    @else
                                    <div class="form-control-plaintext text-center py-4">
                                        <img src="{{asset('images/location-marker.png')}}" style="height: 200px" alt="" class="img-fluid">
                                        <h6 class="h6">No location added yet.</h6>
                                    </div>
                                    @endif
                                    --}}
                                </div>
                            </div>
                            <div class = "row">
                                <div class="col-sm-3">


                                </div>
                            </div>
                        </form>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        jQuery(document).ready(function () {
            $('.company-select-2').select2();
            

            $(document).on('change','#truck_type',function(){
                if($(this).val() != ''){
                    let truck_id = $(this).val();
                    $.ajax({
                        url:"{{ route('get_drivers') }}",
                        type:'POST',
                        data:{truck_id:truck_id,'_token':"{{ csrf_token() }}"},
                        success:function(res){
                            $('#driver').html(res.options)

                        }
                    })
                }
                else{
                    $('#driver').html('')
                }
                
            })
            App.initTreeView();

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
                truck_type:{
                    required:true
                },
                dial_code:{
                    required:true
                },
                phone:{
                    required:true
                },
                driver:{
                  required:true  
                },
                quantity:{
                  required:true  
                },
                collection_address:{
                  required:true  
                },
                deliver_address:{
                  required:true  
                },
                receiver_name:{
                  required:true  
                },
                receiver_email:{
                  required:true  
                },
                receiver_phone:{
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
                    App.alert( "The Booking information updating failed", 'Oops!','error');
                }
            });
        });
    });
        })
    </script>
@stop
