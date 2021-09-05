// Initialize modules
// Importing specific gulp API functions lets us write them below as series() instead of gulp.series()
const { src, dest, watch, series, parallel } = require('gulp');
// Importing all the Gulp-related packages we want to use
const sourcemaps = require('gulp-sourcemaps');
const sass = require('gulp-sass');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
var replace = require('gulp-replace');

// File paths
const files = { 
    scssPath: 'src/assets/scss/*.scss'
}

// Sass task: compiles the style.scss file into style.css
function scssTask(){    
    return src(files.scssPath)
        .pipe(sourcemaps.init()) // initialize sourcemaps first
        .pipe(sass()) // compile SCSS to CSS
        .pipe(postcss([ autoprefixer(), cssnano() ])) // PostCSS plugins
        .pipe(sourcemaps.write('.')) // write sourcemaps file in current directory
        .pipe(dest('dist/assets/css')
    ); // put final CSS in dist folder
}

// Cachebust
function cacheBustTask(){
    var cbString = new Date().getTime();
    return src(['functions.php'])
        .pipe(replace(/cb=\d+/g, 'cb=' + cbString))
        .pipe(dest('.'));
}

// Watch task: watch SCSS files for changes
// If any change, run scss task
function watchTask(){
    watch([files.scssPath],
        {interval: 1000, usePolling: true}, //Makes docker work
        series(
            scssTask
        )
    );
}

// Export the default Gulp task so it can be run
// Runs the scss and js tasks simultaneously
// then runs cacheBust, then watch task
exports.default = series(
    scssTask,
    watchTask
);