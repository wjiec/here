"use strict";

$(function() {
    $(document).on('contextmenu', function() { return false })
    $(document).on('selectstart', function() { return false })

    if (!(typeof FastClick == 'undefined')) {
        FastClick.attach(document.body)
    }
    $(document).on('focus', 'input', function(event) {
        $(this).removeClass('jax-input-require')
        $('#here-responsed').removeClass('jax-fail jax-done')
    })

    var index = 0
    var urls = [ // XXX: /step/3 /step/4
        { url:'/controller/installer/step/2' },
        { url:'/controller/installer/validate', type:'POST', data: formData, dataType:'json', container: '#here-responsed > p' },
        { url:'/controller/installer/step/3' },
        { url:'/controller/installer/addUser', type: 'PUT', data: formData, dataType:'json', container: '#here-responsed > p' },
        { url:'/controller/installer/step/4' },
        { url:'/controller/common/home' }
    ]

    $(document).jax('#next-step-btn', '#here-replace-container', {
        urlReplace: 'search',
        fullReplace: true,
        localStorage: false
    })
    $('#here-replace-container').on('jax:jax', function(event, options) {
        $.extend(options, urls[index])
    }).on('jax:beforeSend', function() {
        if (required('#here-replace-container input', function() { this.addClass('jax-input-require') })) {
            return false
        }

        $(this).addClass('Here-toggle-content-ing');
        $('#next-step-btn').addClass('widget-cursor-disable');
    }).on('jax:beforeReplace', function(event, data, options) {
        var container = $('#here-responsed')
        container.find('h3').removeClass()
        if (typeof data == 'object' && data.fail == 1) {
            --index
            container.addClass('jax-fail').find("h3[title='done']").addClass('widget-hidden')
        } else if (typeof data == 'object' && data.fail == 0) {
            container.addClass('jax-done').find("h3[title='fail']").addClass('widget-hidden')
            $('input').addClass('widget-cursor-disable').attr('disabled', 'disabled')
        }
    }).on('jax:success', function() {
        ++index
        $('#here-replace-container').removeClass()
        $('#next-step-btn').removeClass('widget-cursor-disable')
    })
});

function required(selector, callback) {
    var is = $(selector), flag = false
    if (is.length) {
        is.each(function(index, el) {
            el = $(el)
            if (!el.val().length) { callback.call(el), flag = true }
        })
    }
    return flag
}

function formData() {
    var data = {}
    $('input').each(function(inedx, el) {
        var el = $(el)
        data[el.attr('name')] = el.val()
    })
    return data
}