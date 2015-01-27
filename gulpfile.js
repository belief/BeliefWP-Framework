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

//theme slug
var themeSlug = 'beliefWP';

// Directories
var SRC = 'belief/',
    DIST = 'public/wp-content/themes/'+themeSlug+'/',
    PLUGINS = 'public/wp-content/plugins/';


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

// clean the views directory
gulp.task('cleanWPFiles', function(){
  return gulp.src([DIST+'*.php'], {read:false})
    .pipe(clean());
});

// clean the views directory
gulp.task('cleanPlugins', function(){
  return gulp.src([PLUGINS], {read:false})
    .pipe(clean());
});

//move Templates
gulp.task('moveTemplates',['cleanViews','cleanWPFiles'], function() {
  gulp.src(SRC+'templates/**/*.*', { base: SRC+'templates'})
  .pipe(gulp.dest(DIST+'app/views'));
  notify().write({ message: "Moved Templates!" });

  gulp.src(SRC+'wp_theme_files/*.php', { base: SRC+'wp_theme_files'})
  .pipe(gulp.dest(DIST+''));
  notify().write({ message: "Moved Wordpress Theme Files!" });
});

//move Plugins
gulp.task('movePlugins',['cleanPlugins'], function() {
  gulp.src('dependant-plugins/**/*.*', { base: 'dependant-plugins/'})
  .pipe(gulp.dest(PLUGINS))

  notify().write({ message: "Moved Plugins!" });
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
      baseUrl: SRC + '/js',
      mainConfigFile: SRC + '/js/app.js',
      optimize: "uglify2",
      name: 'main',
      out: 'main.min.js'
  })
  .pipe(uglify())
  .pipe(gulp.dest(DIST + 'assets/js'));
});

//notify js is compiled
gulp.task('jsNotify', function() {
    notify().write({ message: "JS Compiled successfully!" });
});

//move vendor files
gulp.task('movejsVendor', function() {
  return gulp.src( SRC + 'js/vendor/*.js')
    .pipe(uglify())
    .pipe((gulp.dest( DIST + 'assets/js/vendor/')));

});

//move module files
gulp.task('movejsModules', function() {
  return gulp.src( SRC + 'js/modules/*.js')
    .pipe(uglify())
    .pipe((gulp.dest( DIST + 'assets/js/modules/')));

});

//Notify initial build success
gulp.task('buildSuccess', function() {
    notify().write({ message: "Build was Successful!" });
});

// Gulp Watchers
gulp.task('watchSCSS', function() {
  gulp.watch(SRC + 'scss/**/*.scss', ['scss']);
  gulp.watch(SRC + 'scss/*.scss', ['scss']);
});

gulp.task('watchJS', function() {
  gulp.watch(SRC + 'js/**/*.js', ['requirejsBuild','jsNotify']);
  gulp.watch(SRC + 'js/*.js', ['requirejsBuild','jsNotify']);
});

gulp.task('watchMove', function() {
  gulp.watch(SRC + 'app/**/*.*', ['move']);
  gulp.watch(SRC + 'static/**/*.*', ['move']);
  gulp.watch(SRC + 'static/*.*', ['move']);
  gulp.watch(SRC + 'app/*.*', ['move']);

  gulp.watch(SRC + 'templates/*.*', ['moveTemplates']);
  gulp.watch(SRC + 'templates/**/*.*', ['moveTemplates']);
  gulp.watch(SRC + 'wp_theme_files/*.php', ['moveTemplates']);

  gulp.watch('dependant-plugins/**/*.*', ['movePlugins']);
  gulp.watch('dependant-plugins/**/*.*', ['movePlugins']);
});


// Gulp Default Task
gulp.task('scssBuild', ['scss', 'watchSCSS']);
gulp.task('jsBuild', ['movejsVendor','movejsModules','requirejsBuild', 'jsNotify','watchJS']);
gulp.task('moveBuild', ['move', 'moveTemplates', 'movePlugins', 'watchMove']);
gulp.task('default', ['scssBuild', 'moveBuild','jsBuild','buildSuccess']);
