var gulp = require("gulp")
var babel = require("gulp-babel")
var uglify = require("gulp-uglify")
var rename = require("gulp-rename")
var compass = require('gulp-compass')
var webpack = require("gulp-webpack")
var clean_css = require('gulp-clean-css');

var gulp_script_files = [
    // installer guide script
    './var/installer/js/installer.es6',
    // home page script
    './var/default/js/index.es6'
];

// script:
gulp.task('scripts', function() {
    gulp.src("./var/installer/js/installer.es6")
        .pipe(babel())
        .pipe(gulp.dest("./var/installer/js"))
        .pipe(uglify())
        .pipe(rename({ extname: '.min.js' }))
        .pipe(gulp.dest("./var/installer/js"));
})

// styles uglify
gulp.task('styles', ['compass'], function() {
    return gulp.src('./var/**/*.css')
        .pipe(clean_css())
        .pipe(rename({ extname: '.min.css' }))
        .pipe(gulp.dest('./var/'));
})

// compass compile
gulp.task('compass', function() {
    return gulp.src('')
        .pipe(compass({
            config_file: './config.rb',
            css: './var/',
            sass: './var/',
            style: 'expanded'
        }))
})

// webpack: build here base framework
gulp.task('webpack', function() {
    return gulp.src('')
        .pipe(webpack(require('./webpack.config.js')))
        .pipe(gulp.dest(''))
        .pipe(uglify())
        .pipe(rename({ extname: '.min.js' }))
        .pipe(gulp.dest(''))
})

// start all task
gulp.task('default', function () {
    gulp.start('scripts', 'styles', 'webpack')
});

