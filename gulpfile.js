var gulp = require('gulp');
var sass = require('gulp-sass');
var cssmin = require('gulp-cssmin');
var rename = require('gulp-rename');

gulp.task('sass', function(){
  return gulp.src('assets/styles/**/*.scss')
    .pipe(sass()) // Converts Sass to CSS with gulp-sass
    .pipe(gulp.dest('assets/styles'))
});

gulp.task('minify', function () {
    gulp.src('assets/styles/*.css')
        .pipe(cssmin())
        .pipe(rename({suffix: '-min'}))
        .pipe(gulp.dest('assets/styles'));
});

gulp.task('watch', function(){
  gulp.watch('assets/styles/**/*.scss', ['sass']);
	gulp.watch('assets/styles/*.scss', ['minify']);  
});

gulp.task('default', ['minify', 'watch']);