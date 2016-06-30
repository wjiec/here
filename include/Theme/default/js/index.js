$(function() {
    document.oncontextmenu = function() { return false }
    document.onselectstart = function() { return false }

    var leftContents = document.querySelector('#left-screen')
    var mainContents = document.querySelector('#main-screen')

    window.onscroll = function(event) {
        if (window.scrollY + document.documentElement.clientHeight > leftContents.clientHeight) {
            leftContents.style.position = 'fixed'
            leftContents.style.bottom   = 0
        } else if (window.scrollY < leftContents.clientHeight) {
            leftContents.removeAttribute('style')
        }
    }
})