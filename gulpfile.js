/**
 *
 * THIS IS THE DEFAULT TASK
 *
 */


var gulp = require('gulp');
var requireDir = require('require-dir');

//points to "gulp tasks" folder to check for additional tasks
requireDir('gulp-tasks/');




gulp.task('watch', function(){
  gulp.watch('scss/**/*.scss', ['styles']);
  gulp.watch('bower.json', ['bower-sort']);
});

//gulp default task

//(task order)
//1. runs "bower-sort" task
//2. runs watch on bower.json and on change calls "bower-sort" task
gulp.task('default', ['styles', 'php-connect-sync', 'bower-sort', 'watch']);

