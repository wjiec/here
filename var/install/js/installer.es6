$.ready(function() {
    let _document = new $(document)
    _document.on('contextmenu', function() { return false }, true)
    _document.on('selectstart', function() { return false }, true)
})
