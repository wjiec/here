$(function() {
//    document.oncontextmenu = function() { return false }
//    document.onselectstart = function() { return false }

    var leftHeight = $('#here-index-left').height()

    $(window).scroll(function() {
        if (($(window).scrollTop() + $(window).height()) > $('#here-index-left').height()) {
            $('#here-index-left').css({
                'position': 'fixed',
                'bottom': 0
            })
        } else if ($(window).scrollTop() < $('#here-index-left').height()) {
            console.log($(window).scrollTop() + $(window).height())
            $('#here-index-left').attr('style', '')
        }
    })
})