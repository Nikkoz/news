let selectSlider = 0;
let selectVideo = 0;
let position = 0;

$(document).ready(function(){
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-purple',
        radioClass   : 'iradio_minimal-purple'
    });

    /*$('input[data-image-toggle]').parents('label').on('click', function(){
        let checkbox = $(this).find('input[data-image-toggle]'),
            id = checkbox.data('image-toggle');

        if(checkbox.is(':checked')) {
            $('#' + id).removeClass('hide');
        } else {
            $('#' + id).addClass('hide');
        }
    });*/



    $(document).on('submit', 'form.ajax-popup-form', function(e) {
        let form = $(this),
            field = form.attr('data-field'),
            modal = form.attr('data-modal'),
            images = form.attr('data-images'),
            file = $(images),
            form_data = new FormData(this);

        if(file.prop('files').length) {
            form_data.append('pictures', file.prop('files'));
        }

        $.ajax({
            type: form.attr('method'),
            url: form.attr('action'),
            processData: false,
            contentType: false,
            cache: false,
            data: form_data,
            dataType: 'json',
            success: function(result) {
                console.log(result);
                if(result.success === 'Y') {
                    $(field).append(result.form);
                    $(modal).modal('hide');

                    $(field).parents('form').append('<input type="hidden" name="News[' + result.is + '][]" value="' + result.id + '" />');
                } else {
                    $(modal + ' .modal-content .content').html(result.html);
                }
            }
        });

        e.preventDefault();
    });

    $(document).on('click', '.btns__block-slider > a', function(e){
        e.preventDefault();

        let action = $(this).attr('rel');
        let type = $(this).parent().attr('data-type');
        let attrData;

        $.ajax({
            type: 'POST',
            url: $(this).attr('href'),
            dataType: 'json',
            success: function(response) {
                if(action === 'update') {
                    /*$('#sliderUpdate .modal-content .content').html(response.html);
                    $('#sliderUpdate').modal('show');*/
                } else if(action === 'delete') {
                    if(response.success === 'Y') {
                        if(type === 'slider') {
                            attrData = 'data-slider-id';
                        } else {
                            attrData = 'data-video-id';
                        }
                        $('.slider__block[' + attrData + '="' + response.id + '"]').remove();
                    }
                }
            }
        });
    });



    $('#tizerSelect').on('show.bs.modal', function() {
        const modal = $(this);

        let current = $(this).attr('data-news');

        $.ajax({
            type: 'GET',
            url: '/news/list',
            data: {current: current},
            dataType: 'json',
            success: function(response) {
                if(response.success === 'Y') {
                    modal.find('.modal-content .content').html(response.list);
                } else {
                    return false;
                }
            }
        });
    });

    $('.tab-content #text a.btn').on('click', function (e) {
        e.preventDefault();

        let type = $(this).attr('rel');

        if(type === 'text') {
            $('#text_constructor').append('<div class="text__block text" data-position="' + position + '" data-type="text">\
                                               <textarea name="text_' + position + '" id="text-field-' + position + '"></textarea>\
                                               <span class="remove-block">×</span>\
                                           </div>');
            $('#text.tab-pane').append('<input type="hidden" name="order[]" value="text_' + position + '" />');

            $('#text-field-' + position).redactor({
                "lang":"ru",
                "minHeight":100,
                "maxHeight":300,
                "plugins": ["clips","fullscreen"],

            });

            position++;
        }

        if(type === 'slider') {
            $('#sliderSelect').modal('show');
        }

        if(type === 'video') {
            $('#videoSelect').modal('show');
        }

        if(type === 'tizer') {
            $('#text_constructor').append('<div class="text__block tizer" data-position="' + position + '" data-type="tizer">\
                                               <div class="tizer__select"  data-toggle="modal" data-target="#tizerSelect"><span>выберите новость</span></div> \
                                               <textarea name="text_' + position + '" id="text-field-' + position + '"></textarea>\
                                               <span class="remove-block">×</span>\
                                           </div>');
            $('#text.tab-pane').append('<input type="hidden" name="order[]" value="tizer_' + position + '" />');

            $('#text-field-' + position).redactor({
                "lang":"ru",
                "minHeight":100,
                "maxHeight":300,
                "plugins": ["clips","fullscreen"],

            });

            position++;
        }
    });








    $(document).on('click', '.text__block.slider', function (e) {
        let remove = $(this).find('.remove-block');

        if(!remove.is(e.target) && remove.has(e.target).length === 0) {
            let position = $(this).attr('data-position');
            selectSlider = position;

            $('#sliderSelect').modal('show');
        }
    });



    $(document).on('click', function () {

    })
});

$(window).on('load',function () {
    if($('#text.tab-pane > input').length) {
        position = $('#text.tab-pane > input').length;
    }

    if($('#text_constructor textarea').length) {
        $('#text_constructor textarea').redactor({
            "lang":"ru",
            "minHeight":100,
            "maxHeight":300,
            "plugins": ["clips","fullscreen"],
        });
    }
});