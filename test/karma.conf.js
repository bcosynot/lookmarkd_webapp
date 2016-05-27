// Karma configuration
// Generated on Thu May 07 2015 20:08:12 GMT+0200 (CEST)
'use strict';
module.exports = function(config) {
    config.set({

        // base path that will be used to resolve all patterns (eg. files, exclude)
        basePath: '..',

        plugins: [
            'karma-mocha',
            'karma-requirejs',
            'karma-chai',
            'karma-phantomjs-launcher',
            'karma-mocha-reporter'
        ],

        // frameworks to use
        // available frameworks: https://npmjs.org/browse/keyword/karma-adapter
        frameworks: ['mocha', 'requirejs', 'chai'],

        // list of files / patterns to load in the browser
        files: [
            'test/test-main.js',
            //bower:
            {pattern: 'bower_components/modernizr/modernizr.js', included: false},
            {pattern: 'bower_components/jquery/jquery.js', included: false},
            {pattern: 'bower_components/bootstrap-sass-official/assets/javascripts/bootstrap.js', included: false},
            {pattern: 'bower_components/requirejs/require.js', included: false},
            {pattern: 'bower_components/almond/almond.js', included: false},
            {pattern: 'bower_components/loglevel/dist/loglevel.min.js', included: false},
            {pattern: 'bower_components/picturefill/dist/picturefill.js', included: false},
            {pattern: 'bower_components/typeahead.js/dist/typeahead.bundle.js', included: false},
            {pattern: 'bower_components/moment/moment.js', included: false},
            {pattern: 'bower_components/datatables.net/js/jquery.dataTables.js', included: false},
            {pattern: 'bower_components/datatables.net-bs/js/dataTables.bootstrap.js', included: false},
            {pattern: 'bower_components/datatables.net-select/js/dataTables.select.js', included: false},
            {pattern: 'bower_components/datatables.net-responsive/js/dataTables.responsive.js', included: false},
            {pattern: 'bower_components/datatables.net-responsive-bs/js/responsive.bootstrap.js', included: false},
            //endbower
            {pattern: 'app/Resources/public/scripts/**/*.js', included: false},
            /*{pattern: 'test/**/*Spec.js', included: false}*/

        ],

        // list of files to exclude
        exclude: [],

        // preprocess matching files before serving them to the browser
        // available preprocessors: https://npmjs.org/browse/keyword/karma-preprocessor
        preprocessors: {},

        // test results reporter to use
        // possible values: 'dots', 'progress'
        // available reporters: https://npmjs.org/browse/keyword/karma-reporter
        reporters: ['mocha'],

        // web server port
        port: 9876,

        // enable / disable colors in the output (reporters and logs)
        colors: true,

        // level of logging
        // possible values: config.LOG_DISABLE || config.LOG_ERROR || config.LOG_WARN || config.LOG_INFO || config.LOG_DEBUG
        logLevel: config.LOG_INFO,

        // enable / disable watching file and executing tests whenever any file changes
        autoWatch: true,

        // start these browsers
        // available browser launchers: https://npmjs.org/browse/keyword/karma-launcher
        browsers: ['PhantomJS'],

        // Continuous Integration mode
        // if true, Karma captures browsers, runs the tests and exits
        singleRun: false
    });
};
