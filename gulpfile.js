var fs = require('fs')
var gulp = require('gulp')
var path = require('path')
var babel = require('gulp-babel')
var clean = require('gulp-clean')
var uglify = require('gulp-uglify')
var rename = require('gulp-rename')
var compass = require('gulp-compass')
var webpack = require('webpack-stream')
var clean_css = require('gulp-clean-css');

var gulp_script_files = [
    // installer guide script
    './var/installer/js/installer.es6',
    // home page script
    './var/default/js/index.es6'
    // waiting other script file
];

// compass compile
gulp.task('compass', function() {
    return gulp.src('')
        .pipe(compass({
            config_file: './config.rb',
            css: './var/',
            sass: './var/',
            style: 'expanded',
            logging: false
        }))
})

// styles uglify
gulp.task('styles', ['compass'], function() {
    return gulp.src(['./var/**/*.css', '!./var/**/*.min.css'])
        .pipe(clean_css())
        .pipe(rename({ extname: '.min.css' }))
        .pipe(gulp.dest('./var/'));
})

// webpack: build `here base framework`
gulp.task('webpack', function() {
    // read webpack.config.js configure, not definition in gulp
    return gulp.src('')
        .pipe(webpack(require('./webpack.config.js')))
        .pipe(gulp.dest(''))
        /* Uglify by task[scripts] */
})

// babel convert ES6 to ES5
gulp.task('babel', function() {
    // for each all scripts
    gulp_script_files.forEach(function(file_name) {
        // check script exists
        if (fs.existsSync(file_name)) {
            // babel convert ES6 to ES5
            gulp.src(file_name)
                .pipe(babel())
                .pipe(gulp.dest(path.dirname(file_name)))
        } else {
            console.warn(file_name + ' not found')
        }
    })
})

// uglify *.js script
gulp.task('scripts', ['babel', 'webpack'], function() {
    gulp.src(['./var/**/*.js', '!./var/**/*.min.js'])
        .pipe(uglify())
        .pipe(rename({ extname: '.min.js' }))
        .pipe(gulp.dest('./var'))
})

// clean environment
gulp.task('clean', function() {
    return gulp.src(['./var/**/*.css','./var/**/*.js'], { read: false })
        .pipe(clean({force: true}));
})

// start all task
gulp.task('default', ['clean'], function () {
    gulp.start('styles', 'webpack', 'scripts')
});

// watch static file changed
gulp.task('watch', function() {
    gulp.watch('./var/**/*.scss', ['styles'])
    gulp.watch('./var/**/*.es6', ['scripts'])
})
