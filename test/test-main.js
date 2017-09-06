'use strict';
var allTestFiles = [];
var TEST_REGEXP = /(spec|test)\.js$/i;

var pathToModule = function(path) {
    return path.replace(/^\/base\//, '../').replace(/\.js$/, '');
};

Object.keys(window.__karma__.files).forEach(function(file) {
    if (TEST_REGEXP.test(file)) {
        // Normalize paths to RequireJS module names.
        allTestFiles.push(pathToModule(file));
    }
});

require.config({
    baseUrl: '/base/bower_components',
    paths: {
        main: '../app/Resources/public/scripts/main',
        app: '../app/Resources/public/scripts/app',
        modules: '../app/Resources/public/scripts/modules',
        jquery: 'jquery/jquery',
        loglevel: 'loglevel/dist/loglevel.min',
        bootstrap: 'bootstrap/dist/js/bootstrap',
        'bootstrap/affix': 'bootstrap-sass-official/assets/javascripts/bootstrap/affix',
        'bootstrap/alert': 'bootstrap-sass-official/assets/javascripts/bootstrap/alert',
        'bootstrap/button': 'bootstrap-sass-official/assets/javascripts/bootstrap/button',
        'bootstrap/carousel': 'bootstrap-sass-official/assets/javascripts/bootstrap/carousel',
        'bootstrap/collapse': 'bootstrap-sass-official/assets/javascripts/bootstrap/collapse',
        'bootstrap/dropdown': 'bootstrap-sass-official/assets/javascripts/bootstrap/dropdown',
        'bootstrap/modal': 'bootstrap-sass-official/assets/javascripts/bootstrap/modal',
        'bootstrap/popover': 'bootstrap-sass-official/assets/javascripts/bootstrap/popover',
        'bootstrap/scrollspy': 'bootstrap-sass-official/assets/javascripts/bootstrap/scrollspy',
        'bootstrap/tab': 'bootstrap-sass-official/assets/javascripts/bootstrap/tab',
        'bootstrap/tooltip': 'bootstrap-sass-official/assets/javascripts/bootstrap/tooltip',
        'bootstrap/transition': 'bootstrap-sass-official/assets/javascripts/bootstrap/transition',
        picturefill: 'picturefill/dist/picturefill',
        'bootstrap3-ie10-viewport-bug-workaround': 'bootstrap3-ie10-viewport-bug-workaround/ie10-viewport-bug-workaround',
        retina: 'retina.js/build/js/retina-1.2.0',
        'jquery-unveil': 'jquery-unveil/jquery.unveil',
        'bootstrap-daterangepicker': 'bootstrap-daterangepicker/daterangepicker',
        'bootstrap-datetimepicker': 'bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min',
        'bootstrap-timepicker': 'bootstrap-timepicker/js/bootstrap-timepicker',
        'bootstrap3-wysihtml5-bower': 'bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min',
        dcjqaccordion: 'dcjqaccordion/js/jquery.dcjqaccordion.2.7.min',
        'jquery.scrollTo': 'jquery.scrollTo/jquery.scrollTo',
        'jquery.nicescroll': 'jquery.nicescroll/jquery.nicescroll',
        select2: 'select2/dist/js/select2',
        typeahead: 'typeahead.js/dist/typeahead.bundle',
        toastr: 'toastr/toastr',
        animatescroll: 'animatescroll/animatescroll',
        'jquery-hoverintent': 'jquery-hoverintent/jquery.hoverIntent',
        scrollup: 'scrollup/dist/jquery.scrollUp.min',
        'textarea-autosize': 'textarea-autosize/dist/jquery.textarea_autosize',
        tweenlite: 'tweenlite/TweenLite.min',
        wow: 'wow/dist/wow',
        moment: 'moment/moment',
        'datatables.net': 'datatables.net/js/jquery.dataTables',
        'datatables.net-bs': 'datatables.net-bs/js/dataTables.bootstrap',
        'datatables.net-select': 'datatables.net-select/js/dataTables.select',
        'datatables.net-responsive': 'datatables.net-responsive/js/dataTables.responsive',
        'datatables.net-responsive-bs': 'datatables.net-responsive-bs/js/responsive.bootstrap'
    },
    shim: {
        bootstrap: {
            exports: '$',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/affix': {
            exports: '$.fn.affix',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/alert': {
            exports: '$.fn.alert',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/button': {
            exports: '$.fn.button',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/carousel': {
            exports: '$.fn.carousel',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/collapse': {
            exports: '$.fn.collapse',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/dropdown': {
            exports: '$.fn.dropdown',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/modal': {
            exports: '$.fn.modal',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/popover': {
            exports: '$.fn.popover',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/scrollspy': {
            exports: '$.fn.scrollspy',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/tab': {
            exports: '$.fn.tab',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/tooltip': {
            exports: '$.fn.tooltip',
            deps: [
                'jquery'
            ]
        },
        'bootstrap/transition': {
            exports: '$.fn.transition',
            deps: [
                'jquery'
            ]
        }
    },
    packages: [

    ]
});

require(allTestFiles,window.__karma__.start);
