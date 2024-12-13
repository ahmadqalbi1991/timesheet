@extends("admin.template.layout")
<style>
    .img-view{
        cursor: zoom-in;
    }
</style>
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">


              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{$page_heading}}</h5>

                </div>
                <form id="admin_form" method="post" action="{{route('company.submit')}}" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">

                                @csrf()
                                <input type="hidden" name="id" value="{{$id}}">
                                    <label class="form-label" for="bs-validation-name">Name<span class="text-danger">*</span> </label>
                                    <input
                                        type="text"
                                        class="form-control-plaintext" data-jqv-required="true"
                                        id="company_name"
                                        name="company_name"
                                        value="{{$company_name}}"
                                    />

                            </div>

                            <div class="col-xs-12 col-sm-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type = "email" class="form-control-plaintext" name = "email" value = "{{$company_email ?? ''}}" data-jqv-required="true">
                            </div>
                            <div class="col-xs-12 col-sm-6 mb-3">
                                <label class="form-label">Password</label>
                                <input type = "password" class="form-control-plaintext" name = "password" value = "" id = "password" data-jqv-required="true">
                            </div>
                            <div class="col-xs-12 col-sm-6 mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type = "password" class="form-control-plaintext" name = "confirm_password" value = "" id = "confirm_password" data-jqv-required="true">
                                <span id='password-message'></span>
                            </div>
                            <div class="col-xs-4 col-sm-2 mb-3">
                                <label class="form-label">Phone</label>
                                <select class="form-control-plaintext" name = "dial_code" data-jqv-required="true">
                                    <option value = "">Dial Code</option>
                                    @foreach(dial_codes() as $key => $country)
                                    <option value = "{{$key}}" 
                                        @if($dial_code != '')
                                        {{ $key == $dial_code?'selected':'' }}                             
                                        @else
                                        {{$key == 971?'selected':''}}             
                                        @endif
                                   >{{'+'.$key}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xs-8 col-sm-4 mb-3">
                                <label class="form-label">Number</label>
                                <input type = "number" class="form-control-plaintext" name = "phone" value = "{{ $phone ?? '' }}" data-jqv-required="true">
                            </div>


                            <div class="col-xs-12 col-sm-6 mb-3">
                                <label class="form-label">Company Status<span class="text-danger">*</span></label>
                                <select class="form-control jqv-input" data-jqv-required="true" name="company_status">
                                    <option @if($company_status=='active') selected @endif value="active">Active</option>
                                    <option @if($company_status=='inactive') selected @endif value="inactive">InActive</option>
                                </select>
                            </div>

                           

                                <div class="col-md-6">
                                    @if($logo != null)
                                    <img src = "{{ $logo }}" style="height: 50px; width: 50px" data-toggle="modal" data-target="#exampleModalCenter" class = "img-view img-thumbnail">
                                    @endif
                                    <label class="form-label">Company Logo<span class="text-danger">*</span></label>
                                    <input type = "file"  name = "logo" class = "form-control-plaintext" accept="image/*">
                                </div>


                                <div class="col-md-6 mb-3">
                                    @if($company_license != null)
                                    <img src = "{{ $company_license}}" style="height: 50px; width: 50px" data-toggle="modal" data-target="#exampleModalCenter" class = "img-view img-thumbnail">
                                    @endif
                                    <label class="form-label">Company License <span class="text-danger">*</span></label>
                                    <input type = "file"  name = "company_license" class = "form-control-plaintext" accept="image/*">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">License Expiry</label>
                                    <input type = "date" class="form-control-plaintext" name = "license_expiry" value = "{{ $license_expiry ?? '' }}" data-jqv-required="true">
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
                                            <option value = "{{$country}}" {{ isset($company->country) && $company->country == $country ?'selected':'' }}>{{$country}}</option>
                                            @endforeach
                                        </select>    
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">City</label>
                                        <select class="form-control-plaintext" name = "city" data-jqv-required="true" id = "cities">
                                            @foreach(get_cities() as $key => $city)
                                            <option value = "{{$city}}" {{isset($company->city) && $company->city == $city ? 'selected':''}}>{{$city}}</option>
                                            @endforeach
                                        </select>    
                                        
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Zip Code</label>
                                        <input type = "number" name = "zip_code" class="form-control" placeholder = "" value = "{{ $company->zip_code ?? ''}}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Address (Optional)</label>
                                        <input type = "text" name = "address_2" class="form-control" placeholder = "5th Floor, 304 Apartment" value = "{{ $company->address_2 ?? ''}}">
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group" value = "{{$company->address ?? ''}}">

                                            <x-elements.map-location  
                                            addressFieldName="address"
                                            :lat="$company->latitude ?? ''"
                                            :lng="$company->longitude ?? ''"
                                            :address="$company->address ?? ''"
                                            
                                            />
                                        </div>
                                    </div>
                                </div>


                            <div class="col-12">
                                <button type="submit" class="main-btn primary-btn btn-hover" disabled>
                                    Submit
                                </button>
                            </div>

                        </div>
                </form>
              </div>




</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
      <img src = "" width = "100%" class = "img img-thumbnail" id = "display-image">                  

    </div>
  </div>
</div>

@stop

@section('script')
<script>

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

    $(document).on('click','.img-view',function(){
        let src = $(this).attr('src');
        $('#display-image').attr('src',src);
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

    @if($id == '')    
        $form.validate({
            rules: {
                company_name:{
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
                company_license:{
                  required:true  
                },
                logo:{
                  required:true  
                },
                license_expiry:{
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
    @else
    $form.validate({
            rules: {
                company_name:{
                    required:true
                },
                email:{
                    required:true,
                    email:true
                },
                confirm_password:{
                    equalTo:"#password"
                },
                dial_code:{
                    required:true
                },
                phone:{
                    required:true
                },
                license_expiry:{
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
    
    @endif    

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
