/*!
 * gulp
 */

// Load plugins
var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    imagemin = require('gulp-imagemin'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    livereload = require('gulp-livereload'),
    del = require('del');


// Builder Scripts
gulp.task('builder-scripts', function() {
  return gulp.src('src/builder-scripts/**/*.js')
    .pipe(jshint('.jshintrc'))
    .pipe(jshint.reporter('default'))
    .pipe(concat('builder.js'))
    .pipe(gulp.dest('assets/js'))
    .pipe(rename({ suffix: '.min' }))
    .pipe(uglify())
    .pipe(gulp.dest('assets/js'))
    .pipe(notify({ message: 'Builder Scripts task complete' }));
});

// Main Scripts
gulp.task('main-scripts', function() {
  return gulp.src('src/main-scripts/**/*.js')
    .pipe(jshint('.jshintrc'))
    .pipe(jshint.reporter('default'))
    .pipe(concat('main.js'))
    .pipe(gulp.dest('assets/js'))
    .pipe(rename({ suffix: '.min' }))
    .pipe(uglify())
    .pipe(gulp.dest('assets/js'))
    .pipe(notify({ message: 'Main Scripts task complete' }));
});

// Clean
gulp.task('clean', function() {
  return del(['assets/css', 'assets/js']);
});

// Default task
gulp.task('default', ['clean'], function() {
  gulp.start('builder-scripts', 'main-scripts');
});

// Watch
gulp.task('watch', function() {

  // Watch builder-scripts
  gulp.watch('src/builder-scripts/**/*.js', ['builder-scripts']);
  
  // Watch main-scripts
  gulp.watch('src/main-scripts/**/*.js', ['main-scripts']);

  // Create LiveReload server
  livereload.listen();

  // Watch any files in assets/, reload on change
  gulp.watch(['assets/**']).on('change', livereload.changed);

});