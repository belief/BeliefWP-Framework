'use strict';

// Node stuff
var exec = require('child_process').exec,
    sys = require('sys');


// Gulp Requires
var gulp = require('gulp'),
    gutil = require('gulp-util'),
    uglify = require('gulp-uglify'),
    clean = require('gulp-clean'),
    notify = require('gulp-notify'),
    jshint = require('gulp-jshint'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    rename = require('gulp-rename'),
    sass = require('gulp-sass'),
    scsslint = require('gulp-scss-lint'),
    livereload = require('gulp-livereload'),
    rjs = require('gulp-requirejs'),
    lr = require('tiny-lr'),
    server = lr();

// Directories
var SRC = 'dev/',
    DIST = 'assets/',

// clean the dist directory
gulp.task('clean', function(){
  return gulp.src([DIST+'dist/**/*'], {read:false})
    .pipe(clean());
});

// clean the views directory
gulp.task('cleanViews', function(){
  return gulp.src([DIST+'app/views/**/*'], {read:false})
    .pipe(clean());
});

// clean the views directory
gulp.task('cleanWPFiles', function(){
  return gulp.src([DIST+'*.php'], {read:false})
    .pipe(clean());
});

// SCSS Compiling and Minification
gulp.task('scss', function(){
  return gulp.src(SRC + '/scss/app.scss')
    .pipe(scsslint({
      'config': '.scsslint.yml'
    }))
    .pipe(
      sass({
        outputStyle: 'expanded',
        debugInfo: true,
        lineNumbers: true,
        errLogToConsole: true,
        onSuccess: function(){
          notify().write({ message: "SCSS Compiled successfully!" });
        },
        onError: function(err) {
          gutil.beep();
          notify().write(err);
        }
      })
    )
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .on('error', errorHandler)
    // .pipe(rename({ suffix: '.min' }))
    // .pipe(minifycss())
    .pipe(gulp.dest(DIST + '/styles') )
    .pipe(livereload(server.listen(44455)));
});


//js linter
gulp.task('js', function() {
  return gulp.src(SRC+ '/js/app.js')
    .pipe(include())
      .on('error', console.log)
    // .pipe(jshint())
    // .pipe(jshint.reporter('default', { verbose: true }))
    .pipe(uglify())
    .pipe(gulp.dest(DIST + '/js') )
    .pipe(livereload(server.listen(44455)));
});

// Clean dist directory for rebuild
gulp.task('clean', function() {
  return gulp.src(DIST, {read: false})
    .pipe(clean());
});


// Gulp Watchers
gulp.task('watchSCSS', function() {
  gulp.watch(SRC + 'scss/**/*.scss', ['scss']);
  gulp.watch(SRC + 'scss/*.scss', ['scss']);
});

gulp.task('watchJS', function() {
  gulp.watch(SRC + 'js/**/*.js', ['js']);
  gulp.watch(SRC + 'js/*.js', ['js']);
});

// Gulp Default Task
gulp.task('scssBuild', ['scss', 'watchSCSS']);
gulp.task('jsBuild', ['js','watchJS']);


// Handle the error
function errorHandler (error) {
  console.log(error.toString());
  this.emit('end');
}