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
            display:{{$booking->deligate_type == 'ftl'?'none':''}};
    }
    .deligate_details_warehousing {
        display:none;
    }    
    </style>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Ajax Sourced Server-side -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{$booking->booking_number}}</h5>
            </div>
            <div class="card-body">
            
                            <form id="admin_form" action = "{{ route('bookings.update.trucking',['id' => $booking->id]) }}" method = "POST" enctype="multipart/form-data">
                                    @csrf    
                                    
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
                                                    <label class="form-label">Total Gross Weight (Per Truck)</label>
                                                    <input type = "number" class="form-control-plaintext" data-jqv-required="true" value = "{{ $booking_truck->gross_weight }}" disabled>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type = "button" class = "btn btn-primary rounded-0 btn-sm add"><i class = "fa fa-plus"></i></button>
                                                </div>
                                                @if($booking_truck->booking_truck_alot->count() == 0)
                                                <div class="col-md-10">
                                                    <label class="form-label">Drivers</label>
                                                    <select class="company-select company-select-2" name = "drivers[{{$booking_truck->id}}][]" data-jqv-required="true" multiple >
                                                        @foreach(get_truck_drivers($booking_truck->truck_id) as $driver)
                                                        <option value = "{{ $driver->user_id }}" {{ in_array($driver->id,$booking_truck->booking_truck_alot->pluck('user_id')->toArray())?'selected':'' }}>{{ $driver->name }} {{  ($driver->is_company == 'no')?'(Individual)':'(Company)'  }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @else
                                                <div class="col-md-10">
                                                    <label class="form-label">Drivers</label>
                                                    <select class="company-select company-select-2" data-jqv-required="true" multiple disabled>
                                                        @foreach($companies as $company)
                                                        <option value = "{{ $company->id }}" {{ in_array($company->id,$booking_truck->booking_truck_alot->pluck('user_id')->toArray())?'selected':'' }}>{{ $company->name }} {{  ($company->role_id == 2)?'(Individual)':'(Company)'  }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @endif
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
                                                    <label class="form-label">Total Gross Weight (Per Truck)</label>
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

                                
                                <div class = "row">
                                    <div class="col-md-12">

                                        <button class="main-btn primary-btn btn-hover btn-sm mt-4" type="submit" id = "submit"> Update Booking
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
                    <label class="form-label">Total Gross Weight (Per Truck)</label>
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
