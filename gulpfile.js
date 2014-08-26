// Node stuff
var exec = require('child_process').exec,
    sys = require('sys');


// Gulp Requires
var gulp = require('gulp'),
    gutil = require('gulp-util'),
    uglify = require('gulp-uglify'),
    notify = require('gulp-notify'),
    sass = require('gulp-sass'),
    scsslint = require('gulp-scss-lint'),
    livereload = require('gulp-livereload'),
    rjs = require('gulp-requirejs');


// Directories
var SRC = 'app',
    DIST = '.';


// SCSS Compiling and Minification
gulp.task('scss', function(){
  return gulp.src(SRC + '/style.scss')
    .pipe(scsslint({
      'config': '.scsslint.yml'
    }))
    .pipe(
      sass({
        outputStyle: 'expanded',
        debugInfo: true,
        lineNumbers: true,
        errLogToConsole: false,
        onSuccess: function(){
          notify().write({ message: "SCSS Compiled successfully!" });
        },
        onError: function(err) {
          gutil.beep();
          notify().write(err);
        }
      })
    )
    .pipe( gulp.dest(DIST + '/') )
    .pipe(livereload());
});

// Build JS through R.js
gulp.task('requirejsBuild', function() {
  rjs({
      baseUrl: SRC + '/js/',
      mainConfigFile: SRC + '/js/app.js',
      paths: {
        jquery: 'empty:',
        _common: 'modules/_common'
      },
      optimize: "uglify2",
      name: 'main',
      out: 'main.min.js'
  })
  .pipe(uglify())
  .pipe(gulp.dest(DIST + '/js'));
});


// Fonts
gulp.task('fonts', function() {
  gulp.src(SRC + '/fonts/**/*')
  .pipe(gulp.dest(DIST + '/fonts'));
});


// Gulp Watcher
gulp.task('watch', function() {
  gulp.watch(SRC + '/scss/**/*.scss', ['scss']);
  gulp.watch(SRC + '/scss/*.scss', ['scss']);
});


// Gulp Default Task
gulp.task('default', ['scss', 'fonts', 'watch']);
gulp.task('jsBuild', ['requirejsBuild']);
