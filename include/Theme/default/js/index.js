"use strict"

document.addEventListener('DOMContentLoaded', function() {
    document.oncontextmenu = function() { return false }
    document.onselectstart = function() { return false }

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
})
