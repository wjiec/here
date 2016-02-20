"use strict";

$(function() {
    $(document).on('contextmenu', function() { return false })
    $(document).on('selectstart', function() { return false })

    if (!(typeof FastClick == 'undefined')) {
        FastClick.attach(document.body)
    }
    $(document).on('input', 'input', function(event) {
        $(this).removeClass('widget-pjax-input-require')
    })

    var index = 0
    var urls = [
        { url:'/controller/installer/step/2' },
        { url:'/controller/installer/validate', type:'POST', data:{} },
        { url:'/controller/installer/step/3' },
        { url:'/controller/installer/addUser', type: 'PUT', data:{} },
        { url:'/controller/installer/step/4' },
        { url:'/controller/common/home' }
    ]

    $(document).jax('#Next-Step-Btn', '#_Here-Replace-Container', {
        urlReplace: 'search',
        fullReplace: true,
        localStorage: false
    })
    $('#_Here-Replace-Container').on('jax:start', function(event, options) {
        $.extend(options, {
            type: 'GET'
        }, urls[index])
    })
    .on('jax:beforeSend', function() {
        var inputs = $('#_Here-Replace-Container').find('input');
        if (inputs.length) {
            if (!validate(inputs, function(n){ n.addClass('widget-pjax-input-require') })) {
                return false
            }
        }

        $(this).addClass('Here-toggle-content-ing');
        $('#Next-Step-Btn').addClass('widget-cursor-disable');
    }).on('jax:success', function() {
        index += 1
        $('#_Here-Replace-Container').removeClass()
        $('#Next-Step-Btn').removeClass('widget-cursor-disable')
    })
});

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

function makeData(data) {
    var is = $('input');
    data.action = ($('#Next-Step-Btn').val() <= '3') ? 'db' : 'user';
    
    is.each(function(i, n) {
        data[$(n).attr('name')] = $(n).val();
    });
}