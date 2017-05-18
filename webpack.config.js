// import `webpack` module
var webpack = require('webpack');
// import `path` module
var path = require('path');
// webpack configure
module.exports = {
    entry: {
        // here base javascript framework
        './var/default/js/library/here-base': [
            // utility module script
            './var/default/js/library/utils/utils.es6',
            // urlparse module script
            './var/default/js/library/history/urlparse.es6',
            // communication module script
            './var/default/js/library/history/communication.es6',
            // history module
            './var/default/js/library/history/history.es6',
            // event bus module script
            './var/default/js/library/event/event_bus.es6',
            // here base framework script
            './var/default/js/library/here-base.es6'
        ]
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
    },
    plugins: [
        /* uglify by gulp-uglify */
        // new webpack.optimize.UglifyJsPlugin({
        //     // Eliminate comments
        //     comments: false,
        //     // Compression specific options
        //     compress: {
        //         // remove warnings
        //         warnings: false,
        //         // Drop console statements
        //         drop_console: true
        //     },
        // })
    ]
}
