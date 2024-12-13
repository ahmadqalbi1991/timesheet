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
                if($booking->status == 'qoutes_received'){
                    // $booking->status = 'qouted';
                }
                $status = '';
                $status_color = '';
                $statuses = ['pending','qoutes_received','on_process','cancelled','completed'];
                if($booking->status == 'pending'){
                    $statuses = ['qoutes_received','cancelled'];
                    $status = 'Pending';
                    $status_color = 'secondary';
                }

                else if($booking->status == 'qoutes_received'){
                    $quote = $booking->booking_qoutes->first();
                    if($quote && $quote->status == 'accepted'){
                    }else{
                        $statuses = ['cancelled'];
                        $statuses = ['on_process','cancelled'];
                    }

                    $status = 'Qouted';
                    $status_color = 'warning';
                }
                else if($booking->status == 'on_process'){
                    $statuses = [
                        'collected_from_shipper',
                        // 'cargo_cleared_at_origin_border',
                        // 'cargo_tracking',
                        // 'cargo_reached_destination_border',
                        // 'cargo_cleared_destination_customs',
                        // 'delivery_completed'
                    ];
                    // $statuses = ['completed'];

                    $status = 'On Process';
                    $status_color = 'info';
                }
                else if($booking->status == 'collected_from_shipper'){
                    $statuses = [
                        // 'collected_from_shipper',
                        'cargo_cleared_at_origin_border',
                        // 'cargo_tracking',
                        // 'cargo_reached_destination_border',
                        // 'cargo_cleared_destination_customs',
                        // 'delivery_completed'
                    ];
                    // $statuses = ['completed'];

                    $status = 'Collected From Shipper';
                    $status_color = 'info';
                }
                else if($booking->status == 'cargo_cleared_at_origin_border'){
                    $statuses = [
                        // 'collected_from_shipper',
                        // 'cargo_cleared_at_origin_border',
                        'cargo_tracking',
                        // 'cargo_reached_destination_border',
                        // 'cargo_cleared_destination_customs',
                        // 'delivery_completed'
                    ];
                    // $statuses = ['completed'];

                    $status = 'Cargo Cleared at Origin Border';
                    $status_color = 'info';
                }
                else if($booking->status == 'cargo_tracking'){
                    $statuses = [
                        // 'collected_from_shipper',
                        // 'cargo_cleared_at_origin_border',
                        // 'cargo_tracking',
                        'cargo_reached_destination_border',
                        // 'cargo_cleared_destination_customs',
                        // 'delivery_completed'
                    ];
                    // $statuses = ['completed'];

                    $status = 'Cargo Tracking';
                    $status_color = 'info';
                }
                else if($booking->status == 'cargo_reached_destination_border'){
                    $statuses = [
                        // 'collected_from_shipper',
                        // 'cargo_cleared_at_origin_border',
                        // 'cargo_tracking',
                        // 'cargo_reached_destination_border',
                        'cargo_cleared_destination_customs',
                        // 'delivery_completed'
                    ];
                    // $statuses = ['completed'];

                    $status = 'Cargo Reached Destination Border';
                    $status_color = 'info';
                }
                else if($booking->status == 'cargo_cleared_destination_customs'){
                    $statuses = [
                        // 'collected_from_shipper',
                        // 'cargo_cleared_at_origin_border',
                        // 'cargo_tracking',
                        // 'cargo_reached_destination_border',
                        // 'cargo_cleared_destination_customs',
                        'delivery_completed'
                    ];
                    // $statuses = ['completed'];

                    $status = 'Cargo Cleared Destination Customs';
                    $status_color = 'info';
                }
                else if($booking->status == 'delivery_completed'){
                    $statuses = [
                        // 'collected_from_shipper',
                        // 'cargo_cleared_at_origin_border',
                        // 'cargo_tracking',
                        // 'cargo_reached_destination_border',
                        // 'cargo_cleared_destination_customs',
                        // 'delivery_completed'
                    ];
                    // $statuses = ['completed'];

                    $status = 'Delivery Completed';
                    $status_color = 'info';
                }
                else if($booking->status == 'cancelled'){
                    $statuses = [];

                    $status = 'Cancelled';
                    $status_color = 'danger';
                }
                else if($booking->status == 'completed'){
                    $statuses = [];

                    $status = 'Completed';
                    $status_color = 'success';
                }

                

                $html = '';
                $html .= '<div class="dropdown float-right" >';
                $html .=            '<button class="btn btn-'.$status_color.' dropdown-toggle" type="button" data-toggle="dropdown">
                                '. $status.'
                            <span class="caret"></span></button>';
                if(count( $statuses)){
                    $html .=   '<ul class="dropdown-menu">';
                    foreach($statuses as $st){
                        if(strtoupper(str_replace('_',' ',$st)) == $status){
                            continue;
                        }

                        $route = route('booking_status',['id' => $booking->id,'status' => $st]);
                        if($st == 'qoutes_received'){
                            $st = 'qouted';
                        }

                        $html .= '<li><a class="dropdown-item" href="'.$route.'">'.strtoupper(str_replace('_',' ',$st)) .'</a></li>';
                    }
                    $html .=    '</ul>';
                }
                
                $html .=    '</div>';
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
                $p_html .=            '<button class="btn btn-'.$p_status_color.' dropdown-toggle" type="button" data-toggle="dropdown">
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
                <h5 class="mb-0">{{$mode ?? $page_heading}}</h5>
                {!! $p_html !!}
                {!! $html !!}
            </div>
            <div class="card-body">
            
                            <form id="admin_form" action = "{{ route('bookings.update.airfreight',['id' => $booking->id]) }}" method = "POST" enctype="multipart/form-data">
                                    @csrf    
                                
                                <div class = "row">
                                    
                                    <div class="col-md-6" >
                                        <label class="form-label">Select Customer</label>
                                        <select class="form-control-plaintext" name = "customer" id = "customer" data-jqv-required="true" disabled>
                                            <option value = "">Select Customer (Sender)</option>
                                            @foreach($customers as $customer)
                                            <option value = "{{$customer->id}}" {{ $booking->sender_id == $customer->id?'selected':'' }}>{{$customer->name."\n"."(".$customer->email.")"}}</option>
                                            @endforeach
                                        </select>
                                        <input type = "hidden" name = "customer" value = "{{$booking->sender_id}}">
                                    </div>
                                
                                    <div class="col-md-6" >
                                        <label class="form-label">Deligate</label>
                                        <select class="form-control-plaintext" name = "deligate" id = "deligate" disabled>
                                            <option value = "">Select Deligate</option>
                                            @foreach($deligates as $deligate)
                                            <option value = "{{$deligate->id}}" {{ $booking->deligate_id == $deligate->id?'selected':''}}>{{$deligate->name}}</option>
                                            @endforeach
                                        </select>
                                        <input type = "hidden" name = "deligate" value = "{{$booking->deligate_id}}">
                                    </div>

                                    <div class="col-md-6" id = "collection_address_div">
                                        <label class="form-label">Collection Address</label>
                                        <input type = "text" class="form-control-plaintext" name = "collection_address" id = "collection_address" value = "{{ $booking->collection_address ?? '' }}" data-jqv-required="true">
                                    </div>

                                    <div class="col-md-6" id = "deliver_address_div">
                                        <label class="form-label">Deliver Address</label>
                                        <input type = "text" class="form-control-plaintext" name = "deliver_address" id = "deliver_address" value = "{{ $booking->deliver_address ?? '' }}" data-jqv-required="true">
                                    </div>

                                    <!-- Deligate Details -->
                                    
                                    <div class="col-md-6 deligate_details">
                                        <label class="form-label">Item / HS Code</label>
                                        <input type = "text" class="form-control-plaintext deligate_details_input" name = "item" value = "{{ $booking->booking_deligate_detail->item ?? '' }}" data-jqv-required="true">
                                    </div>

                                    <div class="col-md-6 deligate_details">
                                        <label class="form-label">No of Packages</label>
                                        <input type = "number" class="form-control-plaintext deligate_details_input" name = "no_of_packages" value = "{{ $booking->booking_deligate_detail->no_of_packages ?? '' }}" data-jqv-required="true">
                                    </div>

                                    <div class="col-md-6 deligate_details">
                                        <label class="form-label">Dimension of each Package</label>
                                        <input type = "text" class="form-control-plaintext deligate_details_input" name = "dimension_of_each_package" value = "{{ $booking->booking_deligate_detail->dimension_of_each_package ?? '' }}" data-jqv-required="true">
                                    </div>

                                    <div class="col-md-6 deligate_details">
                                        <label class="form-label">Weight of each Package</label>
                                        <input type = "number" class="form-control-plaintext deligate_details_input" name = "weight_of_each_package" value = "{{ $booking->booking_deligate_detail->weight_of_each_package ?? '' }}" data-jqv-required="true">
                                    </div>

                                    <div class="col-md-6 deligate_details">
                                        <label class="form-label">Total Gross Weight</label>
                                        <input type = "number" class="form-control-plaintext deligate_details_input" name = "total_gross_weight" value = "{{ $booking->booking_deligate_detail->total_gross_weight ?? '' }}" data-jqv-required="true">
                                    </div>
                                    
                                    <div class="col-md-6 deligate_details">
                                        <label class="form-label">Total Volume in CBM</label>
                                        <input type = "number" class="form-control-plaintext deligate_details_input" name = "total_volume_in_cbm" value = "{{ $booking->booking_deligate_detail->total_volume_in_cbm ?? '' }}" data-jqv-required="true">
                                    </div>

                                    <!-- Deligate Details  -->

                                    <div class="col-md-6" id = "shipping_method_div">
                                        <label class="form-label">Shipping Method</label>
                                        <select class="form-control-plaintext" name = "shipping_method" id = "shipping_method">
                                            <option value = "">Select Shipping Method</option>
                                            @foreach($shipping_methods as $shipping_method)
                                            <option value = "{{$shipping_method->id}}" {{ $booking->shipping_method_id == $shipping_method->id?'selected':'' }}>{{$shipping_method->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Invoice Number</label>
                                        <input type = "text" class="form-control-plaintext" name = "invoice_number" value = "{{ $booking->invoice_number }}" >
                                    </div>
                                    @php
                                    $quote = $booking->booking_qoutes->first();
                                    @endphp
                                    @if($quote)
                                        <div class="col-md-6">
                                            <label class="form-label">Quote Price</label>
                                            <input type = "number" min="0" class="form-control-plaintext" name = "price" value = "{{ $quote->price }}" {{$quote->status == 'accepted' ? 'disabled' : ''}} >
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Hours</label>
                                            <input type = "number" min="0" class="form-control-plaintext" name = "hours" value = "{{ $quote->hours }}" {{$quote->status == 'accepted' ? 'disabled' : ''}} >
                                        </div>
                                        <div class="col-md-6 d-none">
                                            <label class="form-label">Commission %</label>
                                            <input type = "number" min="0" class="form-control-plaintext" name = "comission_amount" value = "{{ $quote->comission_amount ?? 0 }}" {{$quote->status == 'accepted' ? 'disabled' : ''}} >
                                        </div>
                                    @else
                                        <div class="col-md-6">
                                            <label class="form-label">Quote Price</label>
                                            <input type = "number" min="0" class="form-control-plaintext" name = "price" value = "0" >
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Hours</label>
                                            <input type = "number" min="0" class="form-control-plaintext" name = "hours" value = "0" >
                                        </div>
                                        <div class="col-md-6 d-none">
                                            <label class="form-label">Commission %</label>
                                            <input type = "number" min="0" class="form-control-plaintext" name = "comission_amount" value = "0" >
                                        </div>
                                    @endif


                                </div>     

                              {{--       
                                <div class="row " id = "add_trucks_div">    
                                    <div class = "col-md-12 add-trucks">
                                    @foreach($booking->booking_truck as $booking_truck)    
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Truck Type</label>
                                                    <select class="form-control-plaintext truck_type" id = "truck_type"  disabled>
                                                        <option value = "">Select Truck Type</option>
                                                        @foreach($trucks as $truck)
                                                        <option value = "{{$truck->id}}" {{ $booking_truck->truck_id == $truck->id?'selected':'' }}>{{$truck->truck_type." -- "."(".$truck->dimensions.")"." -- ".strtoupper($truck->type)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Quantity</label>
                                                    <input type = "number" class="form-control-plaintext" data-jqv-required="true" value = "{{ $booking_truck->quantity }}" disabled>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Total Gross Weight</label>
                                                    <input type = "number" class="form-control-plaintext" data-jqv-required="true" value = "{{ $booking_truck->gross_weight }}" disabled>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type = "button" class = "btn btn-primary rounded-0 btn-sm add"><i class = "fa fa-plus"></i></button>
                                                </div>
                                                   
                                                <div class="col-md-10">
                                                    <label class="form-label">Drivers</label>
                                                    <select class="company-select company-select-2" data-jqv-required="true" multiple disabled>
                                                        @foreach($companies as $company)
                                                        <option value = "{{ $company->id }}" {{ in_array($company->id,$booking_truck->booking_truck_alot->pluck('user_id')->toArray())?'selected':'' }}>{{ $company->name }} {{  ($company->role_id == 2)?'(Individual)':'(Company)'  }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endforeach
                                            @if(count($booking->booking_truck) == 0)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Truck Type</label>
                                                    <select class="form-control-plaintext truck_type" name = "truck_type[0]" id = "truck_type" data-id = "0">
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
                                                    <label class="form-label">Total Gross Weight</label>
                                                    <input type = "number" class="form-control-plaintext" name = "gross_weight[0]" data-jqv-required="true" value = "">
                                                </div>
                                                <div class="col-md-2">
                                                    <button type = "button" class = "btn btn-primary rounded-0 btn-sm add"><i class = "fa fa-plus"></i></button>
                                                </div>
                                                <div class="col-md-10">
                                                    <label class="form-label">Drivers</label>
                                                    <select class="company-select" name = "company[0][]" id = "company-0" data-jqv-required="true" multiple>
                                                        <option value = ""></option>
                                                    </select>
                                                </div>
                                            </div>
                                            @endif
                                    <div>
                                </div>        
                                </div>
                                </div>
                               --}} 
                                
                                <div class = "row">
                                    <div class="col-md-12">
                                        @if($booking->status != 'completed')
                                        <button class="main-btn primary-btn btn-hover btn-sm mt-4" type="submit" id = "submit"> Update Booking
                                            <span class="spinner-border spinner-border-sm load" role="status" aria-hidden="true"></span>
                                            <span class="sr-only load">Loading...</span>
                                        </button>
                                        @endif

                                    </div>
                                </div>
                            </form>
                    
                
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
                },
                'truck_type[0]':{
                    required:true
                },
                'quantity[0]':{
                    required:true
                },
                'gross_weight[0]':{
                    required:true
                },
                'company[0][]':{
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
                    App.alert( "The Booking information creating failed", 'Oops!','error');
                }
            });
        });
    });
        })

        $(document).ready(function(){
            // Handle Trucking Freight
            $(document).on('change','#deligate',function(){
                 
                if($(this).val() == 1){
                    $('#ftl-ltl').show();
                    $('.ftl-ltl-input').prop('disabled',false);
                }else{
                    $('#ftl-ltl').hide();
                    $('.ftl-ltl-input').prop('disabled',true);
                }

            })  
            
              
            $(document).on('change','select[name="type"]',function(){
                if($(this).val() == 'ltl'){
                    $('.deligate_details').show();
                    $('.deligate_details_input').show();
                    $('.deligate_details_input').prop('disabled', false);
                }else{
                    $('.deligate_details').hide();
                    $('.deligate_details_input').hide();
                    $('.deligate_details_input').prop('disabled', true);
                }

            })


            let truckCount = 1;
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
                    <label class="form-label">Total Gross Weight</label>
                    <input type="number" class="form-control-plaintext" name="gross_weight[${truckCount}]" data-jqv-required="true" value="">
                    </div>
                    <div class="col-md-2"> 
                    <button type = "button" class="btn btn-primary rounded-0 btn-sm add"><i class="fa fa-plus"></i></button>
                    <button type = "button" class="btn btn-danger rounded-0 btn-sm remove"><i class="fa fa-minus"></i></button>
                    </div>
                    <div class="col-md-10">
                    <label class="form-label">Drivers</label>
                    <select class="company-select" name="company[${truckCount}][]" id="company-${truckCount}" data-jqv-required="true" multiple>
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

            // Handle Air Freight
            $(document).on('change','#deligate',function(){
                 
                 if($(this).val() == 2){
                     $('.deligate_details').show();
                     $('.deligate_details_input').show();
                     $('.deligate_details_input').prop('disabled', false);   
                 }else{
                     $('.deligate_details').hide();
                     $('.deligate_details_input').hide();
                     $('.deligate_details_input').prop('disabled', true);
                 }
 
             })  

            // Handle Warehousing
            $(document).on('change','#deligate',function(){
                 
                 if($(this).val() == 4){
                     $('.deligate_details_warehousing').show();
                     $('.deligate_details_warehousing_input').show();
                     $('.deligate_details_warehousing_input').prop('disabled', false);
                     $('#deliver_address').hide();
                     $('#deliver_address_div').hide();   
                 }else{
                     $('.deligate_details_warehousing').hide();
                     $('.deligate_details_warehousing_input').hide();
                     $('.deligate_details_warehousing_input').prop('disabled', true);
                     $('#deliver_address').show();
                     $('#deliver_address_div').show();
                 }
 
             })  

             $(document).on('change','#is_collection',function(){
                 
                 if($(this).val() == '1'){

                     $('#collection_address').show();
                     $('#collection_address_div').show();
                     $('#add_trucks_div').show();
                       
                 }else{
                    $('#collection_address').hide();
                    $('#collection_address_div').hide();
                     $('#add_trucks_div').hide();
                 }
 
             })  
             
             
        })
    </script>
@stop
