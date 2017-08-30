var gulp = require('gulp');
var plugin = require("gulp-load-plugins")(
    {
        pattern: ['gulp-*', 'gulp.*', 'main-bower-files'],
        replaceString: /\bgulp[\-.]/,
        rename: {
            'gulp-inject-file': 'injectFile'
        }
    }
);
var browserSync = require('browser-sync').create();

var root = "site/";
var destination = "dest/";
var paths = {
    watch: {
        scss: root + "**/*.scss",
        js:   root + "**/*.js",
        html: root + "**/*.html"
    },
    compile: {
        scss: root + "pages/**/*.scss",
        js:   root + "pages/**/*.js",
        html: root + "pages/**/*.html"
    }
};

// Compile Our Sass
gulp.task('scss', function() {
    return gulp.src(paths.compile.scss)
        .pipe(plugin.sass())
        .pipe(plugin.flatten())
        .pipe(gulp.dest(destination))
        .pipe(browserSync.stream());
});

// Move our html to the destination folder
gulp.task('html', function() {
    return gulp.src(paths.compile.html)
        .pipe(plugin.injectFile())
        .pipe(plugin.flatten())
        .pipe(gulp.dest(destination))
        .pipe(browserSync.stream());
});

// Concatenate & Minify JS
gulp.task('scripts', function() {
    return gulp.src(paths.compile.js)
        .pipe(plugin.flatten())
        .pipe(gulp.dest(destination))
        .pipe(browserSync.stream());
});

// serve up the page on a browser
gulp.task('serve', function() {
    browserSync.init({
        server: {
            baseDir: destination
        },
        browser: "google chrome"
    });
    gulp.watch(paths.watch.js, gulp.series('scripts'));
    gulp.watch(paths.watch.scss, gulp.series('scss'));
    gulp.watch(paths.watch.html, gulp.series('html'));
});

// Watch Files For Changes
gulp.task('watch', function() {
    gulp.watch(paths.watch.js, gulp.series('scripts'));
    gulp.watch(paths.watch.scss, gulp.series('scss'));
    gulp.watch(paths.watch.html, gulp.series('html'));
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
gulp.task('build', gulp.parallel('scss', 'scripts', 'html'));
gulp.task('clean', gulp.parallel('clean:ds', 'clean:dest'));
gulp.task('rebuild', gulp.series('clean', 'build'));

gulp.task('default', gulp.series('build', 'serve'));
