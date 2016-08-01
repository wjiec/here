"use strict"

document.oncontextmenu = function() { return false }
document.onselectstart = function() { return false }
document.addEventListener('DOMContentLoaded', function() {
    var leftContents = document.querySelector('#left-screen')
    var mainContents = document.querySelector('#main-screen')

    document.querySelector('#jax-loader-bar').addEventListener("transitionend", function(event) {
        if (event.propertyName == 'width') {
            this.style.opacity = 0
        } else if (event.propertyName == 'opacity') {
            this.classList.remove('is-loading')
            this.removeAttribute('style')
        }
    }, true);

    document.querySelector('#touch-toggle').addEventListener('click', function() {
        leftContents.classList.toggle('screen-show')
    }, true)

    document.querySelectorAll('#index-paging div[id]').forEach(function(element) {
        if (element.classList.contains('paging-disable')) {
            return
        }
        element.addEventListener('click', function() {
            console.log(this)
        })
    })
})
