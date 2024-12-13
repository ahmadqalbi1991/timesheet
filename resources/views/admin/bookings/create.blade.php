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

    .deligate_details {
            display:none;
    }
    .deligate_details_warehousing {
        display:none;
    }    
    
    .btn-sm{
        width: 44px;
        height: 44px;
      padding: 0 !important;
      background: #008645 !important;
      color: #fff;
      border: 1px solid #008645 !important;
      border-radius: 5px !important;
    }
    
    .btn-sm.remove{
        background: #ED622F !important;
        border: 1px solid #ED622F !important;
    }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Ajax Sourced Server-side -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{$mode ?? $page_heading}}</h5>
            </div>
            <div class="card-body">
            
                            <form id="admin_form" action = "{{ route('bookings.store') }}" method = "POST" enctype="multipart/form-data" data-parsley-validate="true">
                                    @csrf    
                                
                                <div class = "row">
                                    
                                    <div class="col-md-6" >
                                        <label class="form-label">Select Customer</label>
                                        <select class="form-control-plaintext" name = "customer" id = "customer" data-jqv-required="true">
                                            <option value = "">Select Customer (Sender)</option>
                                            @foreach($customers as $customer)
                                            <option value = "{{$customer->id}}" >{{$customer->name."\n"."(".$customer->email.")"}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                
                                    <div class="col-md-6" >
                                        <label class="form-label">Deligate</label>
                                        <select class="form-control-plaintext" name = "deligate" id = "deligate">
                                            <option value = "">Select Deligate</option>
                                            @foreach($deligates as $deligate)
                                            <option value = "{{$deligate->id}}" >{{$deligate->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6" style = "display:none" id = "ftl-ltl">
                                        <label class="form-label">Type</label>
                                        <select class="form-control-plaintext jqv-input ftl-ltl-input" data-jqv-required="true" name="type">
                                            <option  value="">Select Type</option>
                                            <option  value="ftl">FTL</option>
                                            <option  value="ltl">LTL</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6" style = "display:none" id = "fcl-lcl">
                                        <label class="form-label">Type</label>
                                        <select class="form-control-plaintext jqv-input fcl-lcl" data-jqv-required="true" name="type_fcl_lcl">
                                            <option  value="">Select Type</option>
                                            <option  value="fcl">FCL</option>
                                            <option  value="lcl">LCL</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 deligate_details_warehousing">
                                        <label class="form-label">Would you like to <b>Timex Shipping LLC</b> to collect your cargo?</label>
                                        <select class="form-control-plaintext deligate_details_warehousing_input" id = "is_collection" data-jqv-required="true" name="is_collection">
                                            <option  value="1">Yes</option>
                                            <option  value="0">No</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-12" id="addresslist">
                                      
                                    </div>

                                    <!-- <div class="col-md-6" id = "collection_address_div" >
                                        <label class="form-label">Collection Address</label>
                                        <input type = "text" class="form-control-plaintext" name = "collection_address" id = "collection_address" value = "" data-jqv-required="true">
                                        <input type="hidden" name="collection_latitude" id="collection_latitude">
                                        <input type="hidden" name="collection_longitude" id="collection_longitude">
                                        <div id="collection_map"></div>
                                    </div>

                                    <div class="col-md-6" id = "deliver_address_div">
                                        <label class="form-label">Deliver Address</label>
                                        <input type = "text" class="form-control-plaintext" name = "deliver_address" id = "deliver_address" value = "" data-jqv-required="true">
                                        <input type="hidden" name="deliver_latitude" id="deliver_latitude">
                                        <input type="hidden" name="deliver_longitude" id="deliver_longitude">
                                        <div id="deliver_map"></div>
                                    </div> -->

                                    <!-- Deligate Details -->
                                    
                                    <div class="col-md-6 deligate_details">
                                        <label class="form-label">Item / HS Code</label>
                                        <input type = "text" class="form-control-plaintext deligate_details_input" name = "item" value = "" data-jqv-required="true">
                                    </div>

                                    <div class="col-md-6 deligate_details">
                                        <label class="form-label">No of Packages</label>
                                        <input type = "number" class="form-control-plaintext deligate_details_input" name = "no_of_packages" value = "" data-jqv-required="true">
                                    </div>

                                    <div class="col-md-6 deligate_details">
                                        <label class="form-label">Dimension of each Package</label>
                                        <input type = "text" class="form-control-plaintext deligate_details_input" name = "dimension_of_each_package" value = "" data-jqv-required="true">
                                    </div>

                                    <div class="col-md-6 deligate_details">
                                        <label class="form-label">Weight of each Package</label>
                                        <input type = "number" class="form-control-plaintext deligate_details_input" name = "weight_of_each_package" value = "" data-jqv-required="true">
                                    </div>

                                    <div class="col-md-6 deligate_details">
                                        <label class="form-label">Total Gross Weight</label>
                                        <input type = "number" class="form-control-plaintext deligate_details_input" name = "total_gross_weight" value = "" data-jqv-required="true">
                                    </div>
                                    
                                    <div class="col-md-6 deligate_details">
                                        <label class="form-label">Total Volume in CBM</label>
                                        <input type = "number" class="form-control-plaintext deligate_details_input" name = "total_volume_in_cbm" value = "" data-jqv-required="true">
                                    </div>

                                    <!-- Deligate Details  -->
                            
                                    <!-- Deligate Details Warehousing -->
                                    
                                    <div class="col-md-6 deligate_details_warehousing">
                                        <label class="form-label">Items are stockable</label>
                                        <select class="form-control-plaintext deligate_details_warehousing_input" data-jqv-required="true" name="items_are_stockable">
                                            <option  value="">Items are stockable</option>
                                            <option  value="yes">Yes</option>
                                            <option  value="no">No</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 deligate_details_warehousing">
                                        <label class="form-label">Types of Storages</label>
                                        <select class="form-control-plaintext deligate_details_warehousing_input" data-jqv-required="true" name="types_of_storages">
                                            <option  value="">Select an Option</option>
                                            <option  value="1">General Warehouse (Non AC)</option>
                                            <option  value="2">Cold Warehouse</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 deligate_details_warehousing">
                                        <label class="form-label">Item</label>
                                        <input type = "text" class="form-control-plaintext deligate_details_warehousing_input" name = "item" value = "" data-jqv-required="true">
                                    </div>

                                    <div class="col-md-6 deligate_details_warehousing">
                                        <label class="form-label">No of Pallets</label>
                                        <input type = "number" class="form-control-plaintext deligate_details_warehousing_input" name = "no_of_pallets" value = "" data-jqv-required="true">
                                    </div>

                                    <div class="col-md-6 deligate_details_warehousing">
                                        <label class="form-label">Pallet Dimensions</label>
                                        <input type = "text" class="form-control-plaintext deligate_details_warehousing_input" name = "pallet_dimension" value = "" data-jqv-required="true">
                                    </div>

                                    <div class="col-md-6 deligate_details_warehousing">
                                        <label class="form-label">Weight per Pallet (Kg)</label>
                                        <input type = "number" class="form-control-plaintext deligate_details_warehousing_input" name = "weight_per_pallet" value = "" data-jqv-required="true">
                                    </div>

                                    <div class="col-md-6 deligate_details_warehousing">
                                        <label class="form-label">Total Weight (Kg)</label>
                                        <input type = "number" class="form-control-plaintext deligate_details_warehousing_input" name = "total_weight" value = "" data-jqv-required="true">
                                    </div>
                                    
                                    <div class="col-md-6 deligate_details_warehousing">
                                        <label class="form-label">Total Item Cost</label>
                                        <input type = "number" class="form-control-plaintext deligate_details_warehousing_input" name = "total_item_cost" value = "" data-jqv-required="true">
                                    </div>

                                    <!-- Deligate Details Warehousing -->

                                    <div class="col-md-6" id = "shipping_method_div">
                                        <label class="form-label">Shipping Method</label>
                                        <select class="form-control-plaintext" name = "shipping_method" id = "shipping_method">
                                            <option value = "">Select Shipping Method</option>
                                            @foreach($shipping_methods as $shipping_method)
                                            <option value = "{{$shipping_method->id}}" >{{$shipping_method->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Invoice Number</label>
                                        <input type = "text" class="form-control-plaintext" name = "invoice_number" value = "" >
                                    </div>

                                </div>     

                                    
                                <div class="row " id = "add_trucks_div">    
                                    <div class = "col-md-12 add-trucks">
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
                                                    <button type = "button" class = "btn btn-primary rounded-0 btn-sm add mt-4"><i class = "fa fa-plus"></i></button>
                                                </div>
                                                <div class="col-md-10">
                                                    <label class="form-label">Drivers</label>
                                                    <select class="company-select" name = "company[0][]" id = "company-0" data-jqv-required="true" multiple >
                                                        <option value = ""></option>
                                                    </select>
                                                </div>
                                            </div>
                                    <div>
                                </div>        
                                </div>
                                </div>

                                
                                <div class = "row">
                                    <div class="col-md-12">

                                        <button class="main-btn primary-btn btn-hover mt-4" type="submit" id = "submit"> Create Booking
                                            <span class="spinner-border spinner-border-sm load" role="status" aria-hidden="true"></span>
                                            <span class="sr-only load">Loading...</span>
                                        </button>

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
 <script
        src="//maps.googleapis.com/maps/api/js?key=AIzaSyD12qKppGVDn6Y5QPwpO5liu8326w9jNwY&v=weekly&libraries=drawing,places"
        async defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
   
    
        jQuery(document).ready(function () {
            $('#company-0').select2();
            $('#customer').select2();

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
                                    if(e_field == 'company') {
                                        $('.company-select').eq(0).addClass('is-invalid');
                                        $('<div class="error">'+ e_message +'</div>').insertAfter('.company-select');
                                    } else {
                                        $('[name="'+ e_field +'"]').eq(0).addClass('is-invalid');
                                        $('<div class="error">'+ e_message +'</div>').insertAfter($('[name="'+ e_field +'"]').eq(0));
                                        if ( error_index == 0 ) {
                                            error_def.resolve();
                                        }
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
                <div class="row mt-2">
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
                    <button type = "button" class="btn btn-primary rounded-0 btn-sm add mt-4"><i class="fa fa-plus"></i></button>
                    <button type = "button" class="btn btn-danger rounded-0 btn-sm remove mt-4"><i class="fa fa-minus"></i></button>
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
             
             
        });

$(document).ready(function(){ 

        var currentLat = 25.204819;
        var currentLong = 55.270931;
        //$("#reg_location").val(currentLat + "," + currentLong);

        currentlocation = {
            lat: currentLat,
            lng: currentLong,
        };
        initMap();
        initAutocomplete();
        function initMap() {
            map2 = new google.maps.Map(document.getElementById("collection_map"), {
                center: {
                    lat: currentlocation.lat,
                    lng: currentlocation.lng,
                },
                zoom: 14,
                gestureHandling: "greedy",
                mapTypeControl: false,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                },
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.LEFT_BOTTOM,
                },
            });

            geocoder = new google.maps.Geocoder();

            // geocoder2 = new google.maps.Geocoder;
            usermarker = new google.maps.Marker({
                position: {
                    lat: currentlocation.lat,
                    lng: currentlocation.lng,
                },
                map: map2,
                draggable: true,
                icon: '{{asset("front_end/assets/image/location_pin.svg")}}',
                animation: google.maps.Animation.BOUNCE,
            });

            //map click
            google.maps.event.addListener(map2, "click", function (event) {
                updatepostition(event.latLng, "movemarker");
                //drag end event
                usermarker.addListener("dragend", function (event) {
                    // alert();
                    updatepostition(event.latLng, "movemarker");
                });
            });

            //drag end event
            usermarker.addListener("dragend", function (event) {
                // alert();
                updatepostition(event.latLng);
            });
        }
        updatepostition = function (position, movemarker) {
            geocodePosition(position);
            usermarker.setPosition(position);
            map2.panTo(position);
            map2.setZoom(15);
            let createLatLong = position.lat() + "," + position.lng();
            console.log("Address Lat/long=" + createLatLong);
            $("#collection_address").val(createLatLong);
            $("#collection_latitude").val(position.lat());
            $("#collection_longitude").val(position.lng());
        };
        function geocodePosition(pos) {
            geocoder.geocode(
                {
                    latLng: pos,
                },
                function (responses) {
                    if (responses && responses.length > 0) {
                        usermarker.formatted_address = responses[0].formatted_address;
                    } else {
                        usermarker.formatted_address = "Cannot determine address at this location.";
                    }
                    $("#collection_address").val(usermarker.formatted_address);
                   
                }
            );
        }
        function initAutocomplete() {
            // Create the search box and link it to the UI element.
            var input2 = document.getElementById("collection_address");
            var searchBox2 = new google.maps.places.SearchBox(input2);

            map2.addListener("bounds_changed", function () {
                searchBox2.setBounds(map2.getBounds());
            });

            searchBox2.addListener("places_changed", function () {
                var places2 = searchBox2.getPlaces();

                if (places2.length == 0) {
                    return;
                }
                $("#collection_address").val(input2.value);
                

                var bounds2 = new google.maps.LatLngBounds();
                places2.forEach(function (place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }

                    updatepostition(place.geometry.location);

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds2.union(place.geometry.viewport);
                    } else {
                        bounds2.extend(place.geometry.location);
                    }
                });
                map2.fitBounds(bounds2);
            });
        }
        updatepostition = function (position, movemarker) {
            console.log(position);
            geocodePosition(position);
            usermarker.setPosition(position);
            map2.panTo(position);
            map2.setZoom(15);
            let createLatLong = position.lat() + "," + position.lng();
            // console.log("Address Lat/long="+createLatLong);
            $("#collection_address").val(createLatLong);
            $("#collection_latitude").val(position.lat());
            $("#collection_longitude").val(position.lng());
            
        };

        initMap1();
        initAutocomplete1();
        function initMap1() {
            map2 = new google.maps.Map(document.getElementById("deliver_map"), {
                center: {
                    lat: currentlocation.lat,
                    lng: currentlocation.lng,
                },
                zoom: 14,
                gestureHandling: "greedy",
                mapTypeControl: false,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
                },
                streetViewControlOptions: {
                    position: google.maps.ControlPosition.LEFT_BOTTOM,
                },
            });

            geocoder = new google.maps.Geocoder();

            // geocoder2 = new google.maps.Geocoder;
            usermarker = new google.maps.Marker({
                position: {
                    lat: currentlocation.lat,
                    lng: currentlocation.lng,
                },
                map: map2,
                draggable: true,
                icon: '{{asset("front_end/assets/image/location_pin.svg")}}',
                animation: google.maps.Animation.BOUNCE,
            });

            //map click
            google.maps.event.addListener(map2, "click", function (event) {
                updatepostition1(event.latLng, "movemarker");
                //drag end event
                usermarker.addListener("dragend", function (event) {
                    // alert();
                    updatepostition1(event.latLng, "movemarker");
                });
            });

            //drag end event
            usermarker.addListener("dragend", function (event) {
                // alert();
                updatepostition1(event.latLng);
            });
        }
        updatepostition1 = function (position, movemarker) {
            geocodePosition1(position);
            usermarker.setPosition(position);
            map2.panTo(position);
            map2.setZoom(15);
            let createLatLong = position.lat() + "," + position.lng();
            console.log("Address Lat/long=" + createLatLong);
            $("#deliver_address").val(createLatLong);
            $("#deliver_latitude").val(position.lat());
            $("#deliver_longitude").val(position.lng());
        };
        function geocodePosition1(pos) {
            geocoder.geocode(
                {
                    latLng: pos,
                },
                function (responses) {
                    if (responses && responses.length > 0) {
                        usermarker.formatted_address = responses[0].formatted_address;
                    } else {
                        usermarker.formatted_address = "Cannot determine address at this location.";
                    }
                    $("#deliver_address").val(usermarker.formatted_address);
                   
                }
            );
        }
        function initAutocomplete1() {
            // Create the search box and link it to the UI element.
            var input2 = document.getElementById("deliver_address");
            var searchBox2 = new google.maps.places.SearchBox(input2);

            map2.addListener("bounds_changed", function () {
                searchBox2.setBounds(map2.getBounds());
            });

            searchBox2.addListener("places_changed", function () {
                var places2 = searchBox2.getPlaces();

                if (places2.length == 0) {
                    return;
                }
                $("#deliver_address").val(input2.value);
                

                var bounds2 = new google.maps.LatLngBounds();
                places2.forEach(function (place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }

                    updatepostition1(place.geometry.location);

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds2.union(place.geometry.viewport);
                    } else {
                        bounds2.extend(place.geometry.location);
                    }
                });
                map2.fitBounds(bounds2);
            });
        }
        updatepostition1 = function (position, movemarker) {
            console.log(position);
            geocodePosition1(position);
            usermarker.setPosition(position);
            map2.panTo(position);
            map2.setZoom(15);
            let createLatLong = position.lat() + "," + position.lng();
            // console.log("Address Lat/long="+createLatLong);
            $("#deliver_address").val(createLatLong);
            $("#deliver_latitude").val(position.lat());
            $("#deliver_longitude").val(position.lng());
            
        };
    
});

$( document ).ready(function() {
       $("#customer").change(function(){
            var cusid = $("#customer").val();
           
            $.ajax({
           type: "POST",
           url: "{{route('address.get_list')}}",
           data: {'cusid': cusid,'_token':'{{ csrf_token() }}'},
           success: function (result) {
               $("#addresslist").empty();
               $("#addresslist").append(result);
               $('.collectionaddress').slick({
                  infinite: true,
                  slidesToShow: 2,
                  slidesToScroll: 1,
                  speed: 300,
                  prevArrow: $('.prev'),
                  nextArrow: $('.next'),
                });
               $('.deliveraddress').slick({
                  infinite: true,
                  slidesToShow: 2,
                  slidesToScroll: 1,
                  speed: 300,
                  prevArrow: $('.prev1'),
                  nextArrow: $('.next1'),
                });
            }
          });
       });
    });

    </script>
@stop
