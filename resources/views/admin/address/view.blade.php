@extends("admin.template.layout")
<style>
    .form-control-plaintext {
        padding-left: 7px;
        border: 1px solid #990253 !important;
        border-radius: 10px !important;
        color: #212529 !important;
        text-align: left;
        margin-bottom: 15px;
    }

    .form-label {
        margin-bottom: 5px;
    }


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
                                    <label class="form-label" for="bs-validation-name">Name </label>
                                    <div class = "form-control-plaintext">{{$company_name}}</div>
                                    
                            </div>

                            <div class="col-xs-12 col-sm-6 mb-3">
                                <label class="form-label">Email</label>
                                <div class = "form-control-plaintext">{{$company_email ?? ''}}</div>
                            </div>
                            <div class="col-xs-12 col-sm-6 mb-3">
                                <label class="form-label">Phone</label>
                                <div class = "form-control-plaintext">{{'+'.$dial_code." ".$phone}}</div>
                            </div>


                            <div class="col-xs-12 col-sm-6 mb-3">
                                <label class="form-label">Company Status<span class="text-danger">*</span></label>
                                <div class = "form-control-plaintext">
                                    @if($company_status=='active')
                                        {{'Active'}}
                                    @else
                                    {{'Inctive'}}
                                    @endif
                                </div>
                            </div>

                           

                                <div class="col-md-6">
                                    @if($logo != null)
                                    <img src = "{{ $logo }}" style="height: 50px; width: 50px" data-toggle="modal" data-target="#exampleModalCenter" class = "img-view img-thumbnail">
                                    @endif
                                    <label class="form-label">Company Logo <span class="text-danger">*</span></label>
                                </div>


                                <div class="col-md-6 mb-3">
                                    @if($company_license != null)
                                    <img src = "{{ $company_license}}" style="height: 50px; width: 50px" data-toggle="modal" data-target="#exampleModalCenter" class = "img-view img-thumbnail">
                                    @endif
                                    <label class="form-label">Company License </label>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">License Expiry</label>
                                    <div class = "form-control-plaintext"> {{ date('d/m/Y',strtotime($license_expiry)) }} </div>
                                </div>

                            <div class="col-md-12">
                                <div class="form-group" value = "{{$address ?? ''}}">

                                <x-elements.map-location  
                                addressFieldName="address"
                                :lat="$latitude ?? ''"
                                :lng="$longitude ?? ''"
                                :address="$address ?? ''"
                                
                                />
                                </div>
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
