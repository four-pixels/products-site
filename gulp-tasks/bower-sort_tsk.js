

/*========================================
=  TASK TO SORT BOWER COMPONENTS INTO PROPER FOLDER  =
========================================*/




//require gulp
var gulp = require('gulp');

// define plugins
var gulpFilter = require('gulp-filter');
//retrieves main bower files from bower.json
var mainBowerFiles = require('main-bower-files');

//output folder path name
var destPath = 'libs';

//task to sort bower components into output folder inside proper folder based on type of file 
gulp.task('bower-sort', function() {
  // extension filters (i.e. .js, .css)
  var jsFilter = gulpFilter('*.js', {restore: true});
  var cssFilter = gulpFilter('*.css', {restore: true});
  var scssFilter = gulpFilter('*.scss', {restore: true});

  //retrieve bower main files
  return gulp.src(mainBowerFiles())
  //filter out .js files
  .pipe(jsFilter)
  //push to js folder into destination path (destPath)
  .pipe(gulp.dest(destPath + '/js'))
  //return mainBowerFiles
  .pipe(jsFilter.restore)

  //filter out .css files
  .pipe(cssFilter)
  //push to css folder into destination path (destPath)
  .pipe(gulp.dest(destPath + '/css'))
  //return mainBowerFiles
  .pipe(cssFilter.restore)

  //filter out .scss files
  .pipe(scssFilter)
  //push to css folder into destination path (destPath)
  .pipe(gulp.dest(destPath + '/scss'))
  //return mainBowerFiles
  .pipe(scssFilter.restore);
  
/*=====  End of BOWER SORT TASK  ======*/
                  
        
});