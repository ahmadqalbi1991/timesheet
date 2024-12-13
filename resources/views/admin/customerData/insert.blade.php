@extends("admin.template.layout")

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">


              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{$page_heading}}</h5>

                </div>
                <form id="admin_form" method="post" action="{{route('customer.insert')}}" enctype="multipart/form-data">
                @csrf()
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">

                                <div class="mb-3">
                                <input type="hidden" name="id" value="{{$id}}">

                                    <label class="form-label" for="bs-validation-name">Customer Name<span class="text-danger">*</span> </label>
                                        <input
                                            type="text"
                                            class="form-control jqv-input" data-jqv-required="true"
                                            id="customer_name"
                                            name="customer_name"
                                            value="{{$name}}"
                                        />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">


                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Customer Email<span class="text-danger">*</span> </label>
                                        <input
                                            type="gmail"
                                            class="form-control jqv-input" data-jqv-required="true"
                                            id="customer_email"
                                            name="customer_email"
                                            value="{{$email}}"
                                        />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">



                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Dial Code<span class="text-danger">*</span> </label>
                                        <input
                                            type="text"
                                            class="form-control jqv-input" data-jqv-required="true"
                                            id="dial_code"
                                            name="dial_code"
                                            value="{{$dial_code}}"
                                        />
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6">


                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Phone<span class="text-danger">*</span> </label>
                                        <input
                                            type="text"
                                            class="form-control jqv-input" data-jqv-required="true"
                                            id="phone"
                                            name="phone"
                                            value="{{$phone}}"
                                        />
                                </div> 
                            </div>
                            <div class="col-xs-12 col-sm-6">


                                <div class="mb-3">
                                    <label class="form-label" for="bs-validation-name">Password<span class="text-danger">*</span> </label>

                                        <input
                                            type="text"
                                            class="form-control jqv-input typing" data-jqv-required="true"
                                        />
                                        <input
                                            type="hidden"
                                            class="form-control jqv-input written" data-jqv-required="true"
                                            id="password"
                                            name="password"
                                            value="{{$password}}"
                                        />
                                </div> 
                            </div>



                                <div class="col-xs-12 col-sm-6">
                                    <label class="form-label">Customer Status<span class="text-danger">*</span></label>
                                        <select class="form-control jqv-input" data-jqv-required="true" name="status">
                                            <option @if($status=='active') selected @endif value="active">Active</option>
                                            <option @if($status=='inactive') selected @endif value="inactive">InActive</option>
                                        </select>
                                </div>


                            </div>
                           
                            
                                <!-- Address Section -->
                                <div class = "row">
                                    <div class = "col-md-12">
                                            <hr />
                                    </div>
                                    <div class="col-md-6" style="display:none;">
                                        <label class="form-label">Country</label>
                                        <select class="form-control-plaintext" name = "country">
                                            @foreach(get_countries() as $key => $country)
                                            <option value = "{{$country}}" {{ isset($user->country_id) && $user->country_id == $country ?'selected':'' }}>{{$country}}</option>
                                            @endforeach
                                        </select>    
                                    </div>

                                    <div class="col-md-6" style="display:none;">
                                        <label class="form-label">City</label>
                                        @if(isset($user->country_id))
                                        @php $cities =  \DB::table('cities')->where('city_status',1)->where('country_id',$user->country_id)->get();;

                                         @endphp
                                         @else
                                         @php 
                                            $cities =  \DB::table('cities')->where('city_status',1)->get();;
                                         @endphp
                                         @endif
                                         <select class="form-control-plaintext" name = "country" >
                                            @foreach($cities as $key => $city)
                                            <option value = "{{$city->id}}" {{ isset($user->city_id) && $user->city_id == $city->id ?'selected':'' }}>{{$city->city_name}}</option>
                                            @endforeach
                                        </select>  
                                        <!-- <input type = "text" name = "city" class="form-control" placeholder = "" value = "{{ $user->city ?? ''}}"> -->
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Trade license number</label>
                                        <input type = "text" class="form-control-plaintext" name = "trade_licence_number" value = "{{ $user->trade_licence_number ?? '' }}">
                                    </div> 

                                    <div class="col-md-6">
                                       @if(!empty($user->trade_licence_doc))
                                            <img src = "{{ $user->trade_licence_doc }}" width = 100 data-toggle="modal" data-target="#exampleModalCenter" class = "img-view img-thumbnail">
                                        @endif
                                        <label class="form-label">Trade license</label>
                                        <input type = "file" name = "trade_licence_doc" class = "form-control-plaintext" >
                                    </div>

                                    <div class="col-md-6" style="display:none;">
                                        <label class="form-label">Zip Code</label>
                                        <input type = "number" name = "zip_code" class="form-control" placeholder = "" value = "{{ $user->zip_code ?? ''}}">
                                    </div>

                                    <div class="col-md-6" style="display:none;">
                                        <label class="form-label">Address (Optional)</label>
                                        <input type = "text" name = "address_2" class="form-control" placeholder = "5th Floor, 304 Apartment" value = "{{ $user->address_2 ?? ''}}">
                                    </div>
                                    <?php 
                                    $address = '';
                                    if(!empty($user->address_2))
                                    {
                                        $address  = $user->address_2;
                                    } ?>
                                    <div class="col-md-12">
                                    <div class="form-group" value = "{{$address}}">

                                        <x-elements.map-location  
                                        addressFieldName="address"
                                        :lat="$user->lattitude ?? ''"
                                        :lng="$user->longitude ?? ''"
                                        :address="$address"
                                        
                                        />
                                    </div>
                                </div>    
                        




                            
                            <div class="col-12 mt-3">
                                <button type="submit" class="main-btn primary-btn btn-hover" disabled>
                                    Submit
                                </button>
                            </div>

                        </div>
                </form>
              </div>




</div>
@stop

@section('script')
<script>

        $(".typing").keyup(function() {
            var pass = $(this).val();
            $('.written').val(pass);
        });

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

   

</script>
@stop
