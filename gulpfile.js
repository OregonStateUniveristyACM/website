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
    gulp.watch(paths.js, ['scripts']);
    gulp.watch(paths.scss, ['scss']);
});

//remove .DS_Store files
gulp.task( 'clean:ds', function() {
  return gulp.src(root+"/**/.DS_Store", { read: false })
    .pipe( rm() );
})

// Default Task
gulp.task('default', gulp.series('scss', 'scripts', 'watch'));
