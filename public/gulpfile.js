const gulp = require('gulp');
const sass = require('gulp-sass');
const plumber = require('gulp-plumber');
const prefix = require('gulp-autoprefixer');
const rename = require('gulp-rename');
const clean = require('gulp-clean-css');
const rollup = require('rollup');
const { babel } = require('@rollup/plugin-babel');
const { terser } = require('rollup-plugin-terser');


gulp.task('scss', () => {
  return gulp.src('scss/**/*.scss')
    .pipe(plumber())
    .pipe(sass({outputStyle: 'compressed', sourceMap: false}))
    .pipe(prefix())
    .pipe(clean({level: 2}))
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest('static/'));
});

gulp.task('js', () => {
  return rollup.rollup({
    input: 'js/lib.js',
    plugins: [
      babel({
        presets: ['@babel/preset-env'],
        babelHelpers: 'bundled'
      }),
      terser()
    ]
  }).then((bundle) => {
    return bundle.write({
      file: './static/lib.min.js',
      format: 'iife',
      name: 'here',
    });
  })
});

gulp.task('default', gulp.parallel('scss', 'js'));
gulp.task('watch', () => {
  gulp.watch('scss/**/*.scss', gulp.series('scss'));
  gulp.watch('js/**/*.js', gulp.series('js'));
});
