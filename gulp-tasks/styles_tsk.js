

/*========================================
=            SASS STYLES TASK            =
========================================*/

var gulp           = require('gulp'),
    plumber        = require('gulp-plumber'),
    browserSync    = require('browser-sync'),
    reload         = browserSync.reload,
    autoprefixer   = require('gulp-autoprefixer'),
    sourcemaps     = require('gulp-sourcemaps'),
    sass           = require('gulp-sass');



gulp.task('styles', function(){
  gulp.src('scss/**/*.scss')
      .pipe(sourcemaps.init())
      .pipe(plumber())
      .pipe(sass({
        outputStyle: 'expanded'
      }))
      .pipe(autoprefixer('last 2 versions'))
      .pipe(sourcemaps.write())
      .pipe(gulp.dest('styles/'))
      .pipe(reload({stream: true}));

});