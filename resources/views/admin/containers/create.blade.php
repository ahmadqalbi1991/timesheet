@extends('admin.template.layout')
@section('header')
   
@stop
@section('content')
    <div class="card mb-5">
        <div class="card-body">
            <div class="col-xs-12">
                <form method="post" id="admin-form" action="{{ route('containers.store') }}" enctype="multipart/form-data"
                    data-parsley-validate="true">
                    <input type="hidden" name="id" id="cid" value="{{ $id }}">
                    @csrf()
                    <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label>Container Name<b class="text-danger">*</b></label>
                            <input type="text" name="truck_type" class="form-control" required
                                data-parsley-required-message="Enter Container Name" value="{{ $name }}">
                        </div>
                    </div>
                    
                    <div class="col-xs-12 col-sm-6 d-none">
                        <div class="mb-3">
                        <label class="form-label" for="bs-validation-name">Type<span class="text-danger">*</span> </label>
                        <select class="form-control jqv-input" data-jqv-required="true" name="type">
                            <option @if($type=='fcl') selected @endif value="fcl">FCL</option>
                            <option @if($type=='lcl') selected @endif value="lcl">LCL</option>
                        </select>

                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="mb-3">
                        <label class="form-label" for="bs-validation-name">Dimensions<span class="text-danger">*</span> </label>
                        <input
                            type="text"
                            class="form-control jqv-input" data-jqv-required="true"
                            id="dimension"
                            name="dimension"
                            value="{{$dimension}}"
                        />
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6">
                        <div class="mb-3">
                        <label class="form-label" for="bs-validation-name">Max Weight in Metric Tons<span class="text-danger">*</span> </label>
                        <input
                            type="text"
                            class="form-control jqv-input" data-jqv-required="true"
                            id="max_weigt"
                            name="max_weigt"
                            value="{{$max_weigt}}"
                        />

                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option <?= $status == 'active' ? 'selected' : '' ?> value="active">Active</option>
                                <option <?= $status == 'inactive' ? 'selected' : '' ?> value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Container Icon</label><br>
                            <img id="image-preview" style="width:100px; height:90px;" class="img-responsive"
                                @if ($icon) src="{{ asset($icon) }}" @endif>
                            <br><br>
                            <input type="file" name="icon" class="form-control" data-role="file-image" data-preview="image-preview" data-parsley-trigger="change"
                                data-parsley-fileextension="jpg,png,gif,jpeg"
                                data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported" data-parsley-max-file-size="5120" data-parsley-max-file-size-message="Max file size should be 5MB" >
                            <span class="text-info">Upload icon</span>
                        </div>
                    </div>

                    <div class="col-md-12 mt-2">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
            <div class="col-xs-12 col-sm-6">
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>

        $('#select2').select2();
        App.initFormView();
        // $(document).ready(function() {
        //     if (!$("#cid").val()) {
        //         $(".b_img_div").removeClass("d-none");
        //     }
        // });
        // $(".parent_cat").change(function() {
        //     if (!$(this).val()) {
        //         $(".b_img_div").removeClass("d-none");
        //     } else {
        //         $(".b_img_div").addClass("d-none");
        //     }
        // });
        $('body').off('submit', '#admin-form');
        $('body').on('submit', '#admin-form', function(e) {
            e.preventDefault();
            var $form = $(this);
            var formData = new FormData(this);
            $(".invalid-feedback").remove();

            App.loading(true);
            $form.find('button[type="submit"]')
                .text('Saving')
                .attr('disabled', true);

            var parent_tree = $('option:selected', "#parent_id").attr('data-tree');
            formData.append("parent_tree", parent_tree);

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: $form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                dataType: 'json',
                success: function(res) {
                    App.loading(false);

                    if (res['status'] == 0) {
                        if (typeof res['errors'] !== 'undefined') {
                            var error_def = $.Deferred();
                            var error_index = 0;
                            jQuery.each(res['errors'], function(e_field, e_message) {
                                if (e_message != '') {
                                    $('[name="' + e_field + '"]').eq(0).addClass('is-invalid');
                                    $('<div class="invalid-feedback">' + e_message + '</div>')
                                        .insertAfter($('[name="' + e_field + '"]').eq(0));
                                    if (error_index == 0) {
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
                            var m = res['message'] ||
                            'Unable to save category. Please try again later.';
                            App.alert(m, 'Oops!');
                        }
                    } else {
                        App.alert(res['message'], 'Success!');
                                setTimeout(function(){
                                    window.location.href = "{{ route('containers.list') }}";
                                },1500);
                       
                    }

                    $form.find('button[type="submit"]')
                        .text('Save')
                        .attr('disabled', false);
                },
                error: function(e) {
                    App.loading(false);
                    $form.find('button[type="submit"]')
                        .text('Save')
                        .attr('disabled', false);
                    App.alert(e.responseText, 'Oops!');
                }
            });
        });
    </script>
@stop
