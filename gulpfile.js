'use strict';

var gulp = require('gulp');
var exec = require('child_process').exec;

gulp.task('default', function() {
    // Run the dependency gulp file first
    exec('gulp --gulpfile ./resources/assets/metronic/default/tools/gulpfile.js', function(error, stdout, stderr) {
        console.log('./metronic/default/tools/gulpfile.js:');
        console.log(stdout);
        if(error) {
            console.log(error, stderr);
        }
    });
});

gulp.task('watch', function() {
    // Run the dependency gulp file first
    exec('gulp --gulpfile ./resources/assets/metronic/default/tools/gulpfile.js watch', function(error, stdout, stderr) {
        console.log('./metronic/default/tools/gulpfile.js:');
        console.log(stdout);
        if(error) {
            console.log(error, stderr);
        }
    });
});