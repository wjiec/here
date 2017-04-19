module.exports = {
    entry: {
        // here base javascript framework
        './var/default/js/library/here-base': './var/default/js/library/here-base.es6',

        // here index page script
        './var/default/js/index': './var/default/js/index.es6',

        // here installer guide script
        './var/install/js/installer': './var/install/js/installer.es6',

        // utility module script
        './var/default/js/library/utils': './var/default/js/library/utils.es6'
    },
    output: {
        filename: '[name].js'
    },
    module: {
        loaders: [
            {
                test: /.*\.es6$/,
                exclude: /node_modules/,
                loader: 'babel-loader?presets[]=es2015'
            }
        ]
    }
}
