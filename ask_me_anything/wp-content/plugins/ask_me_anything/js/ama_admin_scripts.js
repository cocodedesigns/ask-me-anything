(function ($) {
    'use strict';
    if (typeof $.ui.sortable === 'function') {
        $('#wpa_loop-fields').sortable({
            cursor: 'move',
            revert: true,
            opacity: 0.5,
            distance: 5,
            placeholder: 'sortable-placeholder',
            start: function (e, ui) {
                ui.placeholder.height(ui.item.outerHeight());
            }
        });
    }
    $('#wpa_loop-fields').on('click', '.toggle_fields', function () {
        $(this).toggleClass('closed');
        $(this).parent().find('.field_container.active').toggle();
        return false;
    });


    $('#change_shortcode').change(function () {
        if ($(this).val() === "form") {
            $("#shortcode_copy_form").show();
            $("#shortcode_copy_discussion").hide();
        } else {
            $("#shortcode_copy_discussion").show();
            $("#shortcode_copy_form").hide();
        }
    });


    $('#wpa_loop-fields').on('change', '[data-id="select_type"]', function () {
        $(this).next('.toggle_fields:hidden').show();
        var selected_field_type = $(this).val();
        var parent_container = $(this).parent();
        if (selected_field_type.length) {
            $(parent_container).find('.field_container.active :input').val('').removeAttr('checked');
            $(parent_container).find('.field_container').hide().removeClass('active');
            $(parent_container).find('.field_container.type_' + selected_field_type + '').show().addClass('active');
        } else {
            $(parent_container).find('.toggle_fields, .active').hide().removeClass('closed');
        }
    });
    $('#wpa_loop-fields').on('click', '.example', function () {
        var text_area = $(this).parent().next('textarea');
        var new_line = $(text_area).val() !== '' ? '\n' : '';
        $(text_area).val($(text_area).val() + new_line + 'yes|Have you used WordPress before?');
        return false;
    });
    $('[name=ama_form_meta\\[redirect\\]]').change(function () {
        if ($(this).attr('id') === 'redirect') {
            $('#redirect_page_post').show();
            $('#redirect_external').hide();
        } else if ($(this).attr('id') === 'redirect_url') {
            $('#redirect_external').show();
            $('#redirect_page_post').hide();
        } else {
            $('#redirect_external, #redirect_page_post').hide();
        }
    });
    var field_set = $('.wpa_group');
    for (var i = 0; i < field_set.length; i++) {
        if ($('select', $(field_set[i])).val() !== '') {
            var field_type = $('select', $(field_set[i])).val();
            $('.field_container.type_' + field_type + '', field_set[i]).show().addClass('active');
            $('.toggle_fields').show();
        }
    }
    if ($('[name=ama_form_meta\\[redirect\\]]:checked').length) {
        var redirect_option_choice = $('[name=ama_form_meta\\[redirect\\]]:checked').val();
        if (redirect_option_choice === 'redirect') {
            $('#redirect_page_post').show();
        } else if (redirect_option_choice === 'redirect_url') {
            $('#redirect_external').show();
        }
    }
    var modal_wrap = $('#live_style_preview');
    $('.custom_color_field').wpColorPicker({
        palettes: true,
        change: function (event, ui) {
            var modal_node = $(this).data('node-map');
            switch (modal_node) {
            case 'modal_bg':
                $('[data-node-map=' + modal_node + ']', modal_wrap).eq(0).css({
                    'background': ui.color.toString(),
                    'border-color': ui.color.toString()
                });
                break;
            case 'modal_font_color':
                $('[data-node-map=modal_bg]', modal_wrap).eq(0).css('color', ui.color.toString());
                break;
            case 'title':
                $('[data-node-map=' + modal_node + ']', modal_wrap).eq(0).css({
                    'color': ui.color.toString(),
                    'border-bottom-color': ui.color.toString()
                });
                break;
            case 'submit_button_font_color':
                $('[data-node-map=submit_btn]', modal_wrap).eq(0).css('color', ui.color.toString());
                break;
            case 'submit_button_color':
                $('[data-node-map=submit_btn]', modal_wrap).eq(0).css('background', ui.color.toString());
                break;
            }
        }
    });
    $('.style_section select').change(function () {
        var modal_node = $(this).attr('name');
        var value = $(this).val();
        var target;
        switch (modal_node) {
        case 'ama_form_style[general_alignment]':
        case 'ama_form_style[button_alignment]':
            target = modal_node === 'ama_form_style[general_alignment]' ? 'modal_bg' : 'button_alignment';
            $('[data-node-map=' + target + ']', modal_wrap).eq(0).css('text-align', value);
            if (target.indexOf('button_alignment') > -1) {
                break;
            }
            if (value === 'left' || value === 'right') {
                $('input:radio, input:checkbox', modal_wrap).css('float', value);
            } else {
                $('input:radio, input:checkbox', modal_wrap).css('float', 'none');
            }
            break;
        case 'ama_form_style[general_font]':
        case 'ama_form_style[title_font]':
            var node = modal_node === 'ama_form_style[title_font]' ? 'title' : 'modal_bg';
            $('[data-node-map=' + node + ']', modal_wrap).eq(0).css('font-family', value);
            break;
        case 'ama_form_style[title_font_style]':
        case 'ama_form_style[labels_font_style]':
        case 'ama_form_style[button_font_style]':
            if (modal_node === 'ama_form_style[title_font_style]') {
                target = 'title';
            } else if (modal_node === 'ama_form_style[labels_font_style]') {
                target = 'form_fields';
            } else if (modal_node === 'ama_form_style[button_font_style]') {
                target = 'submit_btn';
            }
            if (value.indexOf('_') > -1) {
                $('[data-node-map=' + target + ']', modal_wrap).eq(0).css({
                    'font-weight': value.split('_')[0],
                    'font-style': value.split('_')[1]
                });
            } else {
                $('[data-node-map=' + target + ']', modal_wrap).eq(0).css({
                    'font-weight': value,
                    'font-style': ''
                });
            }
            break;
        }
    });
    var submit_btn_text_field = $('[data-node-map=submit_btn]', '.my_style_control');
    $(submit_btn_text_field).keyup(function () {
        var new_but_text = $(this).val() === '' ? 'Submit' : $(this).val();
        $('[data-node-map=submit_btn]', modal_wrap).text(new_but_text);
    });
    $(submit_btn_text_field).blur(function () {
        if ($(this).val() === '') {
            $(this).val('Submit');
        }
    });
    $('.size_down, .size_up').click(function () {
        var target = $(this.parentNode).data('node-map');
        var actual_node = $('[data-node-map=' + target + ']', modal_wrap).eq(0);
        var current_font_size = $(actual_node).css('font-size');
        if ($(this).hasClass('size_up')) {
            var new_font_ems = (parseInt(current_font_size, 10) + 2) / 16;
        } else {
            var new_font_ems = (parseInt(current_font_size, 10) - 2) / 16;
        }
        $(actual_node).css('font-size', new_font_ems + 'em');
        $(this.parentNode.parentNode).find('input:hidden').val(new_font_ems);
        return false;
    });
    if (document.getElementById('live_style_preview') && window.location.href.indexOf('action=edit') > -1) {
        styleModalPreview($('#style_meta').data('meta'));
    }
    function styleModalPreview(meta_style_object) {
        var modal_wrap = $('#live_style_preview');
        for (var key in meta_style_object) {
            if (meta_style_object.hasOwnProperty(key)) {
                switch (key) {
                case 'bg_color':
                    $('[data-node-map=modal_bg]', modal_wrap).eq(0).css({
                        'background': meta_style_object[key],
                        'border-color': meta_style_object[key]
                    });
                    break;
                case 'general_alignment':
                    $('[data-node-map=modal_bg]', modal_wrap).eq(0).css('text-align', meta_style_object[key]);
                    if (meta_style_object[key] === 'left' || meta_style_object[key] === 'right') {
                        $('input:radio, input:checkbox', modal_wrap).css('float', meta_style_object[key]);
                    } else {
                        $('input:radio, input:checkbox', modal_wrap).css('float', 'none');
                    }
                    break;
                case 'font_color_general':
                    $('[data-node-map=modal_bg]', modal_wrap).eq(0).css({ 'color': meta_style_object[key] });
                    break;
                case 'button_alignment':
                    $('[data-node-map=' + key + ']', modal_wrap).eq(0).css('text-align', meta_style_object[key]);
                    break;
                case 'button_color':
                case 'font_color_submit':
                    var attribute = key === 'button_color' ? 'background' : 'color';
                    $('[data-node-map=submit_btn]', modal_wrap).eq(0).css(attribute, meta_style_object[key]);
                    break;
                case 'button_text':
                    $('[data-node-map=submit_btn]', modal_wrap).eq(0).val(meta_style_object[key]).end().text(meta_style_object[key]);
                    break;
                case 'font_color_title':
                    $('[data-node-map=title]', modal_wrap).eq(0).css({
                        'color': meta_style_object[key],
                        'border-bottom-color': meta_style_object[key]
                    });
                    break;
                case 'font_size_labels':
                case 'font_size_title':
                case 'font_size_submit':
                    if (key === 'font_size_labels') {
                        var hidden_field = 'ama_form_style[font_size_labels]';
                        var node = 'form_fields';
                    } else if (key === 'font_size_title') {
                        var hidden_field = 'ama_form_style[font_size_title]';
                        var node = 'title';
                    } else if (key === 'font_size_submit') {
                        var hidden_field = 'ama_form_style[font_size_submit]';
                        var node = 'submit_btn';
                    }
                    $('[data-node-map=' + node + ']', modal_wrap).css('font-size', meta_style_object[key] + 'em');
                    $('[name=\'' + hidden_field + '\']', modal_wrap).val(meta_style_object[key]);
                    break;
                case 'general_font':
                case 'title_font':
                    var node = key === 'title_font' ? 'title' : 'modal_bg';
                    $('[data-node-map=' + node + ']', modal_wrap).eq(0).css('font-family', meta_style_object[key]);
                    break;
                case 'title_font_style':
                case 'labels_font_style':
                case 'button_font_style':
                    if (key === 'title_font_style') {
                        var target = 'title';
                    } else if (key === 'labels_font_style') {
                        var target = 'form_fields';
                    } else if (key === 'button_font_style') {
                        var target = 'submit_btn';
                    }
                    var value = meta_style_object[key];
                    if (value.indexOf('_') > -1) {
                        $('[data-node-map=' + target + ']', modal_wrap).eq(0).css({
                            'font-weight': value.split('_')[0],
                            'font-style': value.split('_')[1]
                        });
                    } else {
                        $('[data-node-map=' + target + ']', modal_wrap).eq(0).css({ 'font-weight': value });
                    }
                    break;
                }
            }
        }
    }
    
    $('#widgets-right .custom_color_field_widget').wpColorPicker({
        palettes: true,
        change: function (event, ui) {
            liveWidgetChange(ui, this);
        }
    });

    $(document).ajaxSuccess(function (e, xhr, settings) {
        if (window.location.pathname.indexOf('wp-admin/widgets.php') > -1) {
            if (settings.data.indexOf('id_base=ama_widget') > -1 && settings.data.indexOf('action=save-widget') > -1) {
                $('#widgets-right .custom_color_field_widget').wpColorPicker({
                    palettes: true,
                    change: function (event, ui) {
                        liveWidgetChange(ui, this);
                    }
                });
            }
            trackLiveModalBtnText();
        }
    });
    function liveWidgetChange(ui, this_node) {
        var node_id = $(this_node).data('node-map');
        var attribute = node_id.indexOf('button_color') > -1 ? 'background' : 'color';
        var widget_id = node_id.split('_')[node_id.split('_').length - 1];
        $('#preview_button_' + widget_id).css(attribute, ui.color.toString());
    }
    function trackLiveModalBtnText() {
        var modal_btn_text_field = $('#widgets-right [data-node-map=button_text]');
        $(modal_btn_text_field).keyup(function () {
            var new_but_text = $(this).val() === '' ? 'Open Modal' : $(this).val();
            var node_id = $(this).attr('id');
            var widget_id = node_id.split('_')[node_id.split('_').length - 1];
            $('#preview_button_' + widget_id).text(new_but_text);
            if ($(this).val() === '') {
                $(this).val('Open Modal');
            }
        });
    }
    trackLiveModalBtnText();
    $('#widgets-right').on('click', '.ama_modal_launch_btn', function () {
        return false;
    });
    $('body.post-type-ama_questions #submitpost input[type=submit]').click(function () {
        if (!tinymce.activeEditor.getContent()) {
            var settings = {
                    animation: 500,
                    buttons: {
                        cancel: {
                            action: function () {
                                Apprise('close');
                            },
                            className: null,
                            text: 'OK'
                        }
                    },
                    input: false,
                    override: true
                };
            Apprise('<h2 class="error">Missing Answer</h2>You must provide an answer to the question before you can publish.', settings);
            return false;
        }
    });
}(jQuery));