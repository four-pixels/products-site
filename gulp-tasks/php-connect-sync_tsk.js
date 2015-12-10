// =======================================
// PHP TASK
// =======================================

var gulp = require('gulp'),
    connect = require('gulp-connect-php'),
    browserSync = require('browser-sync');
 
gulp.task('php-connect-sync', function() {
  connect.server({}, function (){
   browserSync.init({
        proxy: "products.4pixles.localhost.co",
        host:'localhost'
    });
  });
 
  gulp.watch('**/*.php').on('change', function () {
    browserSync.reload();
  });
});