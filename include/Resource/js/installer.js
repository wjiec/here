'use strict';

$(function() {
    $(document).on('contextmenu', function() { return false; });
    $(document).on('selectstart', function() { return false; });
    
    $('#Next-Step-Btn').on('click', function() {
//        $.ajax({
//            type: 'POST',
//            url: 'install.php',
//            data: 'step=2',
//            context: $('#_Here-Replace-Container'),
//            async: true,
//            beforeSend: function(XHR) {
//                this.css({'opacity':'.35'});
//            },
//            success: function(data){
//                this.html(data);
//                this.css({'opacity':'1'});
//            }
//        });
    });
});
