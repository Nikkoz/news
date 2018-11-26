let selectSlider = 0;
let selectVideo = 0;
let position = 0;

$(document).ready(function() {
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-purple',
        radioClass   : 'iradio_minimal-purple'
    });

    $('.news-add_slider').on('click', function () {
        let a = $(this);
        let number = a.attr('data-number');

        $.ajax({
            type: 'GET',
            url: '/posts/sliders/form',
            data: {number: number},
            success: function(response) {
                $('#sliderContent').append(response);

                //let id = $('#slidersform-' + number + '-pictures').attr('data-krajee-fileinput');
                $('#slidersform-' + number + '-pictures').fileinput({
                    'language': 'ru',
                    'theme': 'fa',
                    'allowedFileExtensions': ['jpg', 'jpeg', 'png', 'gif'],
                    'showCaption': false,
                    'showRemove': false,
                    'showUpload': false,
                    'browseClass': 'btn btn-primary btn-block',
                    'browseIcon': '<i class="glyphicon glyphicon-camera"></i>',
                    'initialPreviewAsData': true,
                    'overwriteInitial': true,
                    'fileActionSettings': {
                        'showDrag': false
                    }
                });

                a.attr('data-number', ++number);
            }
        });
    });

    $('.news-add_video').on('click', function() {
        let a = $(this);
        let number = a.attr('data-number');

        $.ajax({
            type: 'GET',
            url: '/posts/videos/form',
            data: {number: number},
            success: function(response) {
                $('#videoContent').append(response);

                $('#videosform-' + number + '-picture').fileinput({
                    'multiple': false,
                    'language': 'ru',
                    'theme': 'fa',
                    'allowedFileExtensions': ['jpg', 'jpeg', 'png', 'gif'],
                    'showCaption': false,
                    'showRemove': false,
                    'showUpload': false,
                    'browseClass': 'btn btn-primary btn-block',
                    'browseIcon': '<i class="glyphicon glyphicon-camera"></i>',
                    'initialPreviewAsData': true,
                    'overwriteInitial': true,
                    'fileActionSettings': {
                        'showDrag': false
                    }
                });

                a.attr('data-number', ++number);
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

    $(document).on('click', '.text__block .remove-block', function () {
        let parent = $(this).parent();
        let type = parent.attr('data-type');
        let position = parent.attr('data-position');

        parent.remove();
        $('#text.tab-pane').find('input[value=' + type +'_' + position + ']').remove();
    });

    $('#sliderSelect').on('show.bs.modal', function() {
        const modal = $(this);

        let block = modal.parent().find('form #sliderContent .slider__block');
        let list = '';

        block.each(function() {
            let name = $(this).find('[data-input-name]').val();
            let description = $(this).find('[data-input-description]').val();

            if(name !== '') {
                list += '<div class="slider">\
                            <div>\
                                <div class="slider-name">' + name + '</div>\
                                <div class="slider-description">' + description + '</div>\
                            </div>\
                        </div>';
            }
        });

        modal.find('.modal-content .content').html(list);
    });

    $('#videoSelect').on('show.bs.modal', function() {
        const modal = $(this);

        let block = modal.parent().find('form #videoContent .video__block');
        let list = '';

        block.each(function() {
            let link = $(this).find('[data-input-link]').val();
            let name = $(this).find('[data-input-name]').val();
            let site = $(this).find('[data-input-site]').val();

            if(link !== '') {
                list += '<div class="video">\
                            <div>\
                                <div class="slider-name">' + name + '</div>\
                                <div class="slider-description">' + site + '</div>\
                            </div>\
                        </div>';
            }
        });

        modal.find('.modal-content .content').html(list);
    });

    $('#tizerSelect').on('show.bs.modal', function() {
        const modal = $(this);

        let current = $(this).attr('data-news');

        $.ajax({
            type: 'GET',
            url: '/posts/news/list',
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

    $(document).on('click', '.text__block.slider', function (e) {
        let remove = $(this).find('.remove-block');

        if(!remove.is(e.target) && remove.has(e.target).length === 0) {
            let position = $(this).attr('data-position');
            selectSlider = position;

            $('#sliderSelect').modal('show');
        }
    });

    $(document).on('click', '.text__block.video', function (e) {
        let remove = $(this).find('.remove-block');

        if(!remove.is(e.target) && remove.has(e.target).length === 0) {
            let position = $(this).attr('data-position');
            selectVideo = position;

            $('#videoSelect').modal('show');
        }
    });

    $(document).on('click','#sliderSelect .content .slider',function (e) {
        e.preventDefault();

        let name = $(this).find('.slider-name').text();

        if(selectSlider) {
            $('.text__block.slider[data-position=' + selectSlider + ']').html('Фотогалерея "' + name + '"\
                                                                              <input type="hidden" name="slider_' + selectSlider + '" value="' + name + '" />\
                                                                              <span class="remove-block">×</span>');

            selectSlider = 0;
        } else {
            $('#text_constructor').append('<div class="text__block slider" data-position="' + position + '" data-type="slider">\
                                               Фотогалерея "' + name + '"\
                                               <input type="hidden" name="slider_' + position + '" value="' + name + '" />\
                                               <span class="remove-block">×</span>\
                                           </div>');
            $('#text.tab-pane').append('<input type="hidden" name="order[]" value="slider_' + position + '" />');

            position++;
        }

        $(this).parents('.modal').modal('hide');
    });

    $(document).on('click','#videoSelect .content .video',function (e) {
        e.preventDefault();

        let name = $(this).find('.slider-name').text();

        if(selectVideo) {
            $('.text__block.video[data-position=' + selectVideo + ']').html('Видеоролик "' + name + '"\
                                                                              <input type="hidden" name="video_' + selectVideo + '" value="' + name + '" />\
                                                                              <span class="remove-block">×</span>');

            selectVideo = 0;
        } else {
            $('#text_constructor').append('<div class="text__block video" data-position="' + position + '" data-type="video">\
                                               Видеоролик "' + name + '"\
                                               <input type="hidden" name="video_' + position + '" value="' + name + '" />\
                                               <span class="remove-block">×</span>\
                                           </div>');
            $('#text.tab-pane').append('<input type="hidden" name="order[]" value="video_' + position + '" />');

            position++;
        }

        $(this).parents('.modal').modal('hide');
    });

    $(document).on('click','#tizerSelect .content .news',function (e) {
        e.preventDefault();

        let id = $(this).attr('data-id'),
            name = $(this).find('.slider-name').text(),
            pos = position - 1;


        $('#text_constructor').find('.text__block.tizer[data-position=' + pos + '] .tizer__select').append('<input type="hidden" name="tizer_' + pos + '" value="' + id + '" />')
            .find('span').text(name);

        $(this).parents('.modal').modal('hide');
    });

    $(document).on('click','.news-update_slider', function (e) {
        e.preventDefault();

        let btn = $(this);

        $.ajax({
            type: 'POST',
            url: '/posts/news/update-slider/?id=' + btn.attr('data-id'),
            data: btn.parents('form').serialize(),
            success: function (response) {
                //console.log(response);
            }
        });
    });

    $(document).on('click','.news-remove_slider', function (e) {
        e.preventDefault();

        let btn = $(this);

        $.ajax({
            type: 'POST',
            url: '/posts/news/remove-slider/?id=' + btn.attr('data-id'),
            dataType: 'json',
            success: function (response) {
                btn.parents('.slider__block').remove();
                //$('.news-add_slider').attr('data-number', $('.news-add_slider').attr('data-number') - 1);
            }
        });
    });

    $(document).on('click','.news-update_video', function (e) {
        e.preventDefault();

        let btn = $(this);

        $.ajax({
            type: 'POST',
            url: '/posts/news/update-video/?id=' + btn.attr('data-id'),
            data: btn.parents('form').serialize(),
            success: function (response) {
                //console.log(response);
            }
        });
    });

    $(document).on('click','.news-remove_video', function (e) {
        e.preventDefault();

        let btn = $(this);

        $.ajax({
            type: 'POST',
            url: '/posts/news/remove-video/?id=' + btn.attr('data-id'),
            dataType: 'json',
            success: function (response) {
                btn.parents('.video__block').remove();
            }
        });
    });

    $("#rubricsform-rubrics").select2().on('select2:select', function(e){
        let element = e.params.data.element;
        let $element = $(element);

        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
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