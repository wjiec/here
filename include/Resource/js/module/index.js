$(function() {
//    document.oncontextmenu = function() { return false }
//    document.onselectstart = function() { return false }

    var leftContents  = document.querySelector('#here-left-contents')
    var rightContents = document.querySelector('#here-right-contents')

    window.onscroll = function(event) {
        if (window.scrollY + document.documentElement.clientHeight > leftContents.clientHeight) {
            leftContents.style.position = 'fixed'
            leftContents.style.bottom   = 0
        } else if (window.scrollY < leftContents.clientHeight) {
            leftContents.setAttribute('style', '')
        }
    }
})