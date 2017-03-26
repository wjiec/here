"use strict";

$.ready(function() {
    $(document).on('contextmenu', function() { return false })
    $(document).on('selectstart', function() { return false })
})
