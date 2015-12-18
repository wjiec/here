'use strict';

$(function() {
    $(document).on('contextmenu', function() { return false; });
    $(document).on('selectstart', function() { return false; });
    
    if (!(typeof FastClick == 'undefined')) {
        FastClick.attach(document.body);
    }
    $(document).delegate('input', 'focus', function(event) {
        $(this).removeClass('widget-pjax-input-require');
    });
    $('#Next-Step-Btn').on('click', function(event) {
        var inputs = $('#_Here-Replace-Container').find('input');
        if (inputs.length) {
            if (!validate(inputs, function(n){n.addClass('widget-pjax-input-require');})) {
                return false;
            }
            $.ajax({
                url: '/controller/installer/validate', type: 'post',
                data: {
                    host: $('#db-addr').val(), port: $('#db-port').val(),
                    user: $('#db-user').val(), pawd: $('#db-pawd').val(),
                    name: $('#db-name').val(), pref: $('#db-pref').val()
                }, datatype: 'json',
                beforeSend: beforeSend,
                success: function(data) {
                    data = $.parseJSON(data);
                    if (data.fail) {
                        disableloadingStatus();
                        $('#_Here-Setting-Error').addClass('widget-pjax-tips').removeClass('widget-hidden').find('p').html(data.data);
                    } else {
                        request({
                            url: '/controller/installer/step',
                            data: { step: $('#Next-Step-Btn').val() },
                            success: replaceContent
                        });
                    }
                }
            });
        } else {
            request({
                url: '/controller/installer/step',
                data: { step: $('#Next-Step-Btn').val() },
                success: replaceContent
            });
        }
    });
});

function request(options) {
    options = $.extend({
        url: null,
        type: null,
        data: {},
        success: $.noop
    }, options || {});

    $.ajax({
        url: options.url,
        type: options.type ? options.type : 'GET',
        data: options.data,
        datatype: 'html',
        beforeSend: beforeSend,
        success: options.success
    });
}

function validate(inputs, process) {
    var len = inputs.length; var flag = false;
    for (var i = 0; i < len; ++i) {
        if (!inputs.eq(i).val().length) {
            process(inputs.eq(i));
            flag = true;
        }
    }
    if (flag) { return false; }
    return true;
}

function beforeSend() {
    $('#_Here-Replace-Container').addClass('Here-toggle-content-ing');
    $('#Next-Step-Btn').addClass('widget-cursor-disable');
}

function disableloadingStatus() {
    $('#_Here-Replace-Container').removeClass('Here-toggle-content-ing');
    $('#Next-Step-Btn').removeClass('widget-cursor-disable');
}

function replaceContent(data) {
    $('#_Here-Replace-Container').removeClass().addClass('Here-content-hidden').html(data).removeClass();
    $('#Next-Step-Btn').removeClass('widget-cursor-disable').val(parseInt($('#Next-Step-Btn').val()) + 1);
}