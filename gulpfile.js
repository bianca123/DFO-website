var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', function(){
  return gulp.src('assets/styles/**/*.scss')
    .pipe(sass()) // Converts Sass to CSS with gulp-sass
    .pipe(gulp.dest('assets/styles'))
});

gulp.task('watch', function(){
  gulp.watch('assets/styles/**/*.scss', ['sass']); 
  // Other watchers
})