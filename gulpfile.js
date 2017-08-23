var gulp = require('gulp');
var plugin = require('gulp-load-plugins')();

var root = "site/";
var destination = "dest/";
var paths = {
    scss: root + "**/*.scss",
    js:   root + "**/.js",
    html: root + "**/.html"
};

// Compile Our Sass
gulp.task('scss', function() {
    return gulp.src(paths.scss)
        .pipe(plugin.sass())
        .pipe(gulp.dest(destination));
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
    return gulp.src(paths.js)
        .pipe(gulp.dest(destination));
});

// Watch Files For Changes
gulp.task('watch', function() {
    gulp.watch(paths.js, gulp.series('scripts'));
    gulp.watch(paths.scss, gulp.series('scss'));
});

//remove .DS_Store files
gulp.task('clean:ds', function() {
  return gulp.src(root+"/**/.DS_Store", { read: false })
    .pipe( plugin.clean() );
});

//remove the destination folder
gulp.task('clean:dest', function() {
   return gulp.src(destination, {read: false})
      .pipe(plugin.clean());
});

// Default Task
gulp.task('default', gulp.series('scss', 'scripts', 'watch'));
gulp.task('clean', gulp.parallel('clean:ds', 'clean:dest'));
