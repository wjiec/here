// import `path` module
var path = require('path');
// webpack configure
module.exports = {
    entry: {
        // here base javascript framework
        './var/default/js/library/here-base': [
            // utility module script
            './var/default/js/library/utils.es6',
            // urlparse module script
            './var/default/js/library/urlparse.es6',
            // communication module script
            './var/default/js/library/communication.es6',
            // history module
            './var/default/js/library/history.es6',
            // here base framework script
            './var/default/js/library/here-base.es6'
        ],

        // here index page script
        './var/default/js/index': './var/default/js/index.es6',

        // here installer guide script
        './var/install/js/installer': './var/install/js/installer.es6',
    },
    output: {
        filename: '[name].js'
    },
    module: {
        loaders: [
            {
                test: /\.es6$/,
                exclude: /node_modules/,
                loader: 'babel-loader?presets[]=es2015'
            }
        ]
    }
}
