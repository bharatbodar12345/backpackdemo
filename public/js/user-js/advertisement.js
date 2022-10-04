$(document).ready(function() {
    getform();
            $(document).on('change', '.select_category', function() {
                selected = $(this).find("option:selected").val();
                var ele = $(document).find('.htmlview');
                getform();

                $.ajax({
                    url: $(this).data('action'),
                    type: "GET",
                    data: { selected },
                    dataType: 'json',
                    success: function(data) {
                        console.log('ssss');
                        ele.add('.htmlview').html(data.view);
                        ele.removeClass('d-none');
                        $('form').attr('enctype', 'multipart/form-data');
                        $('.checklist input[type="checkbox"]').on('change', function() {
                            var el = $(this);
                            var element = el.closest('.checklist');
                            var hidden_input = el.closest('.checklist').find('input[type=hidden]');
                            var checkboxes = element.find('input[type=checkbox]');
                            var newValue = [];
                            checkboxes.each(function() {
                                if ($(this).is(':checked')) {
                                    var id = $(this).val();
                                    newValue.push(id);
                                }
                            });
                            hidden_input.val(JSON.stringify(newValue));
                        });
                        // $('body').on('click','.dz-remove',function() {
                            //     console.log($(this).closest('.dz-preview').html());
                            //     $(this).closest('.dz-preview').remove();
                            // });
                            console.log('sdcvsdfcvds');
                            
                            Dropzone.autoDiscover = false;
                            var uploaded = false;
                            var newValue = [];
                            var oldValue = [];
                            
                            var dropzone = new Dropzone(".dropzone", {
                                url: $('.ajaxUploadImages').data('action'),
                                uploadMultiple: true,
                                parallelUploads: 10,
                                addRemoveLinks: true,
                                sending: function(file, xhr, formData) {
                                    formData.append("_token", $('[name=_token').val());
                                },
                                error: function(file, response) {
                                    console.log('error');
                                    $(file.previewElement).find('.dz-error-message').remove();
                                    $(file.previewElement).remove();
                                },
                                removedfile: function(file) {
                                    // console.log(file.name);
                                $(this).closest('.dz-preview').remove();
                                $.ajax({
                                    url: $('.ajaxUploadImages').data('removeaction'),
                                    type: 'POST',
                                    data: {
                                        file: file.name,
                                    },
                                    success: function(response) {
                                        console.log('remove');
                                        $(this).closest('.dz-preview').remove();
                                        // console.log($(this).closest('.dz-preview'));
                                    }
                                });
                                var checkimage = $.inArray(file.name, newValue);
                                if (checkimage != -1) {
                                    newValue.splice(checkimage, 1);
                                    $('.dropzone_hidden').val(newValue);
                                    file.previewElement.remove();
                                }
                            },
                            success: function(file, status , response) {
                                var oldArr = [];
                                var number = 0;
                                var hidden_value = JSON.parse($('.dropzone_hidden').val() || '[]');
                                hidden_value.forEach(function(item) {
                                    oldArr.push(item);
                                });
                                console.log('23121',response.currentTarget.response);
                                var response_value = JSON.parse(response.currentTarget.response || '[]');
                                console.log('23121',response.currentTarget.response);
                                oldArr.push(response_value[number]);
                                $('.dropzone_hidden').val(JSON.stringify(oldArr));
                                oldArr = [];
                                if(number == response_value.lenght) {
                                    number = 0;
                                } else {
                                    number = parseInt(number) + 1;
                                }
                                console.log('sdvcfwv')
                            }
                        });
                        // Reorder images
                        $(".dropzone").sortable({
                            items: '.dz-preview',
                            cursor: 'move',
                            opacity: 0.5,
                            containment: '.dropzone',
                            distance: 20,
                            scroll: true,
                            tolerance: 'pointer',
                            stop: function(event, ui) {
                                var image_order = [];
                                $('.dz-preview').each(function() {
                                    var image_id = $(this).data('id');
                                    var image_path = $(this).data('path');
                                    image_order.push({ id: image_id, path: image_path });
                                });
                            }
                        });
                        // $(document).on('click', '.dz-preview a', function(e) {
                        //     alert('delete');
                        // });
                        getform();

                    }
                });
            });
            $(window).on("load", function() {
                getform();

            });
        });

        function getform() {
            var action = $('#action').data('action');
            var id = $('input[name=id]').val();
            selected = $(document).find("option:selected").val();
            var ele = $(document).find('.htmlview');
            $.ajax({
                    url: action,
                    type: "GET",
                    data: { selected, id },
                    dataType: 'json',
                    success: function(data) {
                        ele.add('.htmlview').html(data.view);
                        ele.removeClass('d-none');
                        $('form').attr('enctype', 'multipart/form-data');
                        $('.checklist input[type="checkbox"]').on('change', function() {
                            var el = $(this);
                            var element = el.closest('.checklist');
                            var hidden_input = el.closest('.checklist').find('input[type=hidden]');
                            var checkboxes = element.find('input[type=checkbox]');
                            var newValue = [];
                            checkboxes.each(function() {
                                if ($(this).is(':checked')) {
                                    var id = $(this).val();
                                    newValue.push(id);
                                }
                            });
                            hidden_input.val(JSON.stringify(newValue));
                        });
                        $(".checklist").each(function(index) {
                            var el = $(this);
                            var checkboxes = el.find('input[type=checkbox]');
                            var hidden_input = el.find('input[type=hidden]');
                            var selected_options = JSON.parse(hidden_input.val() || '[]');
                            checkboxes.each(function(key, option) {
                                var id = $(this).val();
                                if (selected_options.map(String).includes(id)) {
                                    $(this).prop('checked', 'checked');
                                } else {
                                    $(this).prop('checked', false);
                                }
                            });
                        });
                        var hidden_path = JSON.parse($(document).find('.dropzone_path').val());
                        var hidden = $(document).find('.dropzone_hidden');
                        var hidden_val = JSON.parse(hidden.val() || '[]');
                        // var img=url.toString().match(/\/\/[^\/]+\/([^\.]+)/)[1];
                        // console.log(li);

                        // console.log(hidden_val);
                        // console.log(hid_arr.pop());
                        // $.ajax({
                        //     url: $('.ajaxremoveImages').data('removeaction'),
                        //     type: 'POST',
                        //     data: {
                        //         file: file.name,
                        //     },
                        // });
                        $(hidden_path).each(function(key,image_path) {
                            url = image_path;
                            img_name = url.split("http://127.0.0.1:8000/admin/get-storage-path/image/");
                            // console.log(li[1]);
                            $('.dropzone').append('<div class="dz-preview dz-processing dz-image-preview dz-complete"> <div class="dz-image"><img data-dz-thumbnail="" alt="" src="'+ image_path +'"> </div> <div class="dz-details"> <div class="dz-size"><span data-dz-size=""><strong>51.7</strong> KB</span></div> <div class="dz-filename"><span data-dz-name="' + img_name[1] +'"></span></div> </div> <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span></div> <div class="dz-error-message"><span data-dz-errormessage=""></span></div> <div class="dz-success-mark"> <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"> <title>Check</title> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF"></path> </g> </svg> </div> <div class="dz-error-mark"> <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"> <title>Error</title> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475"> <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"> </path> </g> </g> </svg> </div><a class="dz-remove" href="javascript:undefined;" data-dz-remove="">Remove file</a> </div>');
                        });
                        $('body').on('click','.dz-remove',function() {
                            var file = $('.dz-image img').attr('src');
                            $(this).closest('.dz-preview').remove();
                            console.log($(this).closest('.dz-preview').find('.dz-filename'));
                            $.ajax({
                                url: $('.ajaxUploadImages').data('editremoveaction'),
                                type: 'POST',
                                data: {
                                    file: file,
                                },
                            });
                        });
                            Dropzone.autoDiscover = false;
                            var uploaded = false;
                            var newValue = [];
                            var oldValue = [];
                            var dropzone = new Dropzone(".dropzone", {
                                url: $('.ajaxUploadImages').data('action'),
                                uploadMultiple: true,
                                parallelUploads: 10,
                                addRemoveLinks: true,
                                sending: function(file, xhr, formData) {
                                    // console.log('uplode strat');
                                    formData.append("_token", $('[name=_token').val());
                                },
                                error: function(file, response) {
                                    console.log('error');
                                    $(file.previewElement).find('.dz-error-message').remove();
                                    $(file.previewElement).remove();
                                },
                                removedfile: function(file) {
                                    $(file.previewElement).remove();
                                    $.ajax({
                                        url: $('.ajaxUploadImages').data('removeaction'),
                                        type: 'POST',
                                        data: {
                                            file: file.name,
                                        },
                                    });
                                    var checkimage = $.inArray(file.name, newValue);
                                    if (checkimage != -1) {
                                        newValue.splice(checkimage, 1);
                                        $('.dropzone_hidden').val(newValue);
                                        file.previewElement.remove();
                                    }
                                },
                                success: function(file, status, response) {
                                    // console.log('fvdvfv',response);
                                    var oldArr = [];
                                    var number = 0;
                                    var hidden_value = JSON.parse($('.dropzone_hidden').val() || '[]');
                                    hidden_value.forEach(function(item) {
                                        oldArr.push(item);
                                    });
                                    var response_value = JSON.parse(response.currentTarget.response || '[]');
                                    oldArr.push(response_value[number]);
                                    $('.dropzone_hidden').val(JSON.stringify(oldArr));
                                    oldArr = [];
                                    if(number == response_value.lenght) {
                                        number = 0;
                                    } else {
                                        number = parseInt(number) + 1;
                                    }
                                    // console.log('success', hidden_val);
                                    // var value = file.name;

                                    // if (value != '') {
                                    //     hidden_val.push(value);
                                    // }
                                    // console.log(hidden_val);
                                    // $('.dropzone_hidden').val(hidden_val);
                                    // // console.log(newValue);
                                    // $.each(status.images, function(key, image_path) {
                                    //     $('.dropzone').append();
                                    // });
                                }
                            });
                            // Reorder images
                            $(".dropzone").sortable({
                                items: '.dz-preview',
                                cursor: 'move',
                                opacity: 0.5,
                                containment: '.dropzone',
                                distance: 20,
                                scroll: true,
                                tolerance: 'pointer',
                                stop: function(event, ui) {
                                    var image_order = [];
                                    $('.dz-preview').each(function() {
                                        var image_id = $(this).data('id');
                                        var image_path = $(this).data('path');
                                        image_order.push({ id: image_id, path: image_path });
                                    });
                                }
                            });
                        }
                    });

        }

        // function createform() {

        // }