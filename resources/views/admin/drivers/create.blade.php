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
    </style>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Ajax Sourced Server-side -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{$mode ?? $page_heading}}</h5>
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
                            <form id="admin_form" action = "{{ route('drivers.submit') }}" method = "POST" enctype="multipart/form-data">
                                @csrf
                            <div class="row">
                                <div class="col-md-6" id = "driver-type-div">
                                    <label class="form-label">Driver Type</label>
                                    <select class="form-control-plaintext" name = "driver_type" id = "driver_type" data-jqv-required="true">
                                        <option>Select Driver Type</option>
                                        @foreach($get_driver_types as $driver_type)
                                        <option value = "{{$driver_type->id}}" >{{$driver_type->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6" id = "company-div" style = "display: none;">
                                    <label class="form-label">Comapany</label>
                                    <select class="form-control-plaintext" name = "company" style = "">
                                    <option value="0">Select</option>
                                        @foreach($companies as $company)
                                        <option value = "{{$company->id}}" >{{$company->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6" >
                                    <label class="form-label">Truck Type</label>
                                    <select class="form-control-plaintext" name = "truck_type" style = "">
                                        @foreach($trucks as $truck)
                                        <option value = "{{$truck->id}}" >{{$truck->truck_type." -- ".$truck->dimensions}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type = "text" class="form-control-plaintext" name = "name" value = "" data-jqv-required="true">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type = "email" class="form-control-plaintext" name = "email" value = "" data-jqv-required="true">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Password</label>
                                    <input type = "password" class="form-control-plaintext" name = "password" value = "" id = "password" data-jqv-required="true">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Confirm Password</label>
                                    <input type = "password" class="form-control-plaintext" name = "confirm_password" value = "" id = "confirm_password" data-jqv-required="true">
                                    <span id='password-message'></span>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Phone</label>
                                    <select class="form-control-plaintext" id="dial_code" name = "dialcode" data-jqv-required="true">
                                        <option value = "">Dial Code</option>
                                        @foreach(dial_codes() as $key => $country)
                                        <option value = "{{$key}}" {{$key == 971?'selected':''}}>{{'+'.$key}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Number</label>
                                    <input type = "text" class="form-control-plaintext" name = "phone" value = "" data-jqv-required="true">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Account Status</label>
                                    <select class="form-control-plaintext" name = "status">
                                        <option value = "inactive" >Inactive</option>
                                        <option value = "active" >Active</option>
                                    </select>
                                </div>    

                                </div>
                                <!-- Driving Documents -->
                                <div class = " row align-items-end">
                                    <div class = "col-md-12">
                                        <hr />
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Upload Vehicle Registration</label>
                                        <input type = "file" name = "mulkiya" class = "form-control-plaintext" >
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Vehicle Registration Number</label>
                                        <input type = "text" class="form-control-plaintext" name = "mulkiya_number" value = "">
                                    </div>  
                                     

                                    <div class="col-md-6">
                                        <label class="form-label">Upload Emirate ID or Passport (Front)</label>
                                        <input type = "file" name = "emirates_id_or_passport" class = "form-control-plaintext" >
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Upload Emirate ID or Passport (Back)</label>
                                        <input type = "file" name = "emirates_id_or_passport_back" class = "form-control-plaintext" >
                                    </div>

                                    
                                    <div class="col-md-6">
                                        <label class="form-label">Driving License Issued By</label>
                                        <select class="form-control-plaintext" name = "driving_license_issued_by" data-jqv-required="true">
                                            @foreach(get_cities() as $key => $city)
                                            <option value = "{{$city}}" >{{$city}}</option>
                                            @endforeach
                                        </select>    
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Upload Driving License</label>
                                        <input type = "file" name = "driving_license" class = "form-control-plaintext" >
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Driving License Number</label>
                                        <input type = "text" class="form-control-plaintext" name = "driving_license_number" value = "" data-jqv-required="true">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Driving License Expiry</label>
                                        <input type = "date" class="form-control-plaintext" name = "driving_license_expiry" value = "" data-jqv-required="true">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Vehicle Plate Number</label>
                                        <input type = "text" class="form-control-plaintext" name = "vehicle_plate_number" value = "" data-jqv-required="true">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Vehicle Plate Number Issued Place (City Name)</label>
                                        <select class="form-control-plaintext" name = "vehicle_plate_place" data-jqv-required="true">
                                            @foreach(get_cities() as $key => $city)
                                            <option value = "{{$city}}" >{{$city}}</option>
                                            @endforeach
                                        </select>    
                                    </div>
                                
                                </div>
                                <!-- Address Section -->
                                <div class = "row">
                                    <div class = "col-md-12">
                                            <hr />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Country</label>
                                        <select class="form-control-plaintext" name = "country" data-jqv-required="true" id = "country">
                                            @foreach(get_countries() as $key => $country)
                                            <option value = "{{$country}}" >{{$country}}</option>
                                            @endforeach
                                        </select>    
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">City</label>
                                        <select class="form-control-plaintext" name = "city" data-jqv-required="true" id = "cities">
                                            @foreach(get_cities() as $key => $city)
                                            <option value = "{{$city}}" >{{$city}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6" style="display:none;">
                                        <label class="form-label">Zip Code</label>
                                        <input type = "number" name = "zip_code" class="form-control" placeholder = "">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Address (Optional)</label>
                                        <input type = "text" name = "address_2" class="form-control" placeholder = "5th Floor, 304 Apartment">
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">

                                            <x-elements.map-location 
                                            addressFieldName="address"
                                            lat=""
                                            lng=""
                                            address=""/>
                                        </div>

                                    </div>
                                </div>
                                <H6>Additional Phone</H6>
                                <div class="additional_phone">
                                </div>
                             <a href="javascript:void(0)" class="add_more_phone btn btn-info float-right">Add More Mobile</a>
                                <input type="hidden" name="" id="total_phone" value="0">

                            <!-- <div class="row">
                                <div class="col-sm-12">
                                    <label class="form-label">Location</label>
                                {{--
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
                                    --}} -->
                                </div>
                            </div>
                             
                            <div class = "row">
                                <div class="col-sm-3">
                                    <input class = "btn btn-info mb-3" type = "submit" name = "submit" value = "Save Information">
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

            $(document).on('change','#country',function(){
                let country = $(this).val();
                $.ajax({
                    url:"{{ route('get.cities') }}",
                    type:'GET',
                    data:{country:country},
                    success:function(res){
                        $('#cities').html(res.options)
                    },
                    error:function(err){
                        console.log(err)
                    }
                })
            })


            $(document).on('change','#driver_type',function(){
                if($(this).val() == 1){
                    $('#company-div').show();
                }else{
                    $('#company-div').hide();
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
                        name:{
                            required:true
                        },
                        email:{
                            required:true,
                            email:true
                        },
                        password:{
                            required:true,
                        },
                        confirm_password:{
                            required:true,
                            equalTo:"#password"
                        },
                        dial_code:{
                            required:true
                        },
                        phone:{
                            required:true
                        },
                        mulkiya:{
                          required:true  
                        },
                        mulkiya_number:{
                          required:true  
                        },
                        emirates_id_or_passport:{
                          required:true  
                        },
                        emirates_id_or_passport_back:{
                          required:true  
                        },
                        driving_license_issued_by:{
                          required:true  
                        },
                        driving_license:{
                          required:true  
                        },
                        driving_license_number:{
                          required:true  
                        },
                        driving_license_expiry:{
                          required:true  
                        },
                        vehicle_plate_number:{
                          required:true  
                        },
                        vehicle_plate_place:{
                          required:true  
                        },
                        country:{
                          required:true  
                        },
                        zip_code:{
                          required:true  
                        },
                        city:{
                          required:true  
                        },
                        driver_type:{
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
                        error: function (e) {
                            form_in_progress = 0;
                            App.button_loading(false);
                            console.log(e);
                            App.alert( "Network error please try again", 'Oops!','error');
                        }
                    });
                });
            });
        })
$('.add_more_phone').on('click',function(){
    var counter = $('#total_phone').val();
    counter++;
     $('#total_phone').val(counter);
    var html  ='<div class = "row phone'+counter+'">'+
                    '<div class="col-md-4">'+
                        '<input type="hidden" name="phoneid[]" value="0">'+
                        '<select class="form-control-plaintext" required name = "dial_code[]"'+
                         'data-jqv-required="true">'+
                            $('#dial_code').html()+
                        '</select>'+
                    '</div>'+
                    '<div class="col-md-6">'+
                        
                       '<input type="text" name="adphone[]" required class="form-control-plaintext"  value="">'+
                    '</div><div class="col-md-2"><a href="javascript:void(0)" nw="1" phid="'+counter+'" class="btn delete_phone">Delete</a></div>'+
                '</div>';
    $('.additional_phone').append(html);
});

$(document).on('click','.delete_phone',function() {
    var phid = $(this).attr('phid'); 
    var nw = $(this).attr('nw'); 
    var phoneid =  $(this).attr('phoneid'); 
        $('.phone'+phid).remove();  
            
})
    </script>
@stop
