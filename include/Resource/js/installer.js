'use strict';

$(function() {
    $(document).on('contextmenu', function() { return false; });
    $(document).on('selectstart', function() { return false; });
    
    if (!(typeof FastClick == 'undefined')) {
        FastClick.attach(document.body);
    }
    
    $('#Next-Step-Btn').on('click', function() {
        $.ajax({
            url: '/controller/installer/step',
            type: 'post',
            data: 'step=' + $('#Next-Step-Btn').val(),
            datatype: 'html',
            beforeSend: function() {
                $('#_Here-Replace-Container').toggleClass('Here-toggle-content-ing');
                $('#Next-Step-Btn').toggleClass('widget-cursor-disable');
            }
        }).done(function(data) {
            $('#_Here-Replace-Container').removeClass().addClass('Here-content-hidden').html(data).removeClass();
            $('#Next-Step-Btn').toggleClass('widget-cursor-disable widget-loading').val(3);
        }).error(function() {
        });
    });
    
    $.pjax({
        selector:'p',
        container: '#_Here-Replace-Container',
        data: {
            step: 2
        }
    });
});
