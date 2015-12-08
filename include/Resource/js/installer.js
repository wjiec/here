'use strict';

$(function() {
    $(document).on('contextmenu', function() { return false; });
    $(document).on('selectstart', function() { return false; });
    
    $('#Next-Step-Btn').on('click', function() {
        $.ajax({
            url: '/controller/installer/step',
            type: 'POST',
            data: 'step=2',
            beforeSend: function() {
                $('#_Here-Replace-Container').toggleClass('Here-toggle-content-ing');
                $('#Next-Step-Btn').toggleClass('widget-cursor-disable').prop('focus');
            }
        });
    });
});
