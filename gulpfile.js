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
var SRC = 'belief/',
    DIST = 'public/';


// Regular Files to Move
var filesToMove = [
      SRC+'app/**/*.*',
      SRC+'assets/**/*.*'
    ];

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

//move Templates
gulp.task('moveTemplates', function() {
  gulp.src(SRC+'templates/**/*.*', { base: SRC+'templates'})
  .pipe(gulp.dest(DIST+'app/views'));

});

//move app files
gulp.task('move',['clean'], function(){
  gulp.src(filesToMove, { base: SRC+'/dist/' })
  .pipe(gulp.dest(DIST+'/dist/'));
});

// SCSS Compiling and Minification
gulp.task('scss', function(){
  return gulp.src(SRC + 'scss/app.scss')
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
    .pipe(rename({ suffix: '.min' }))
    .pipe(minifycss())
    .pipe( gulp.dest(DIST + 'assets/css/') )
    .pipe(livereload());
});

//Build JS through R.js
gulp.task('requirejsBuild', function() {
  rjs({
      baseUrl: SRC + 'js/',
      mainConfigFile: SRC + '/js/app.js',
      optimize: "uglify2",
      name: 'main',
      out: 'main.min.js'
  })
  .pipe(uglify())
  .pipe(gulp.dest(DIST + 'assets/js'));
});

gulp.task('jsNotify', function() {
    notify().write({ message: "JS Compiled successfully!" });
});

//move vendor files
gulp.task('movejsVendor', function() {
  return gulp.src( SRC + '/js/vendor/*.js')
    .pipe(uglify())
    .pipe((gulp.dest( DIST + 'assets/js/vendor/')));

});

//move module files
gulp.task('movejsVendor', function() {
  return gulp.src( SRC + '/js/modules/*.js')
    .pipe(uglify())
    .pipe((gulp.dest( DIST + 'assets/js/modules/')));

});

// Gulp Watchers
gulp.task('watchSCSS', function() {
  gulp.watch(SRC + 'scss/**/*.scss', ['scss']);
  gulp.watch(SRC + 'scss/*.scss', ['scss']);
});

gulp.task('watchJS', function() {
  gulp.watch(SRC + 'js/**/*.js', ['requirejsBuild']);
  gulp.watch(SRC + 'js/*.js', ['requirejsBuild']);
});

gulp.task('watchMove', function() {
  gulp.watch(SRC + 'app/**/*.*', ['move']);
  gulp.watch(SRC + 'static/**/*.*', ['move']);
  gulp.watch(SRC + 'static/*.*', ['move']);
  gulp.watch(SRC + 'app/*.*', ['move']);
});

gulp.task('watchTemplates', function() {
  gulp.watch(SRC + 'templates/*.*', ['moveTemplates']);
  gulp.watch(SRC + 'templates/**/*.*', ['moveTemplates']);
});


// Gulp Default Task
gulp.task('scssBuild', ['scss', 'watchSCSS']);
gulp.task('jsBuild', ['requirejsBuild', 'movejsVendor','movejsVendor','jsNotify','watchJS']);
gulp.task('moveBuild', ['move', 'watchMove']);
gulp.task('templatesBuild', ['moveTemplates', 'watchTemplates']);
gulp.task('default', ['scssBuild', 'moveBuild','templatesBuild','jsBuild']);
