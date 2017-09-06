/* jshint -W098,-W079 */
var require = {
    baseUrl: '/bower_components',
    paths: {
        main: '../app/Resources/public/scripts/main',
        controllers: '../app/Resources/public/scripts/controllers',
        modules: '../app/Resources/public/scripts/modules',
        jquery: 'jquery/jquery',
        loglevel: 'loglevel/dist/loglevel.min',
        bootstrap: 'bootstrap-sass-official/assets/javascripts/bootstrap',
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
        appScripts: '../app/Resources/public/scripts/',
        select2: 'select2/dist/js/select2',
        typeahead: 'typeahead.js/dist/typeahead.bundle',
        bloodhound: 'typeahead.js/dist/bloodhound.min',
        toastr: 'toastr/toastr',
        wow: 'wow/dist/wow',
        animatescroll: 'animatescroll/animatescroll',
        scrollup: 'scrollup/dist/jquery.scrollUp.min',
        tweenlite: 'tweenlite/TweenLite.min',
        'jquery-hoverintent': 'jquery-hoverintent/jquery.hoverIntent',
        'jquery.cookie': 'jquery.cookie/jquery.cookie',
        moment: 'moment/moment',
        'textarea-autosize': 'textarea-autosize/dist/jquery.textarea_autosize',
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
        },
        'jquery-unveil': {
            exports: '$.fn.unveil',
            deps: [
                'jquery'
            ]
        },
        dcjqaccordion: {
            exports: '$',
            deps: [
                'jquery',
                'jquery.cookie',
                'jquery-hoverintent'
            ]
        },
        'jquery.scrollTo': {
            exports: '$',
            deps: [
                'jquery'
            ]
        },
        'jquery.nicescroll': {
            exports: '$',
            deps: [
                'jquery'
            ]
        },
        'modules/common-scripts': {
            exports: '$',
            deps: [
                'jquery',
                'jquery.nicescroll',
                'jquery.scrollTo',
                'bootstrap/dropdown'
            ]
        },
        typeahead: {
            deps: [
                'jquery'
            ],
            exports: '$.fn.typeahead'
        },
        bloodhound: {
            exports: 'Bloodhound',
            deps: [
                'jquery'
            ]
        },
        toastr: {
            exports: '$',
            deps: [
                'jquery'
            ]
        },
        wow: {
            exports: 'WOW'
        },
        animatescroll: {
            exports: '$',
            deps: [
                'jquery'
            ]
        },
        scrollup: {
            exports: '$',
            deps: [
                'jquery'
            ]
        },
        tweenlite: {
            exports: '$',
            deps: [
                'jquery'
            ]
        },
        'bootstrap-datetimepicker': {
            exports: '$',
            deps: [
                'jquery'
            ]
        },
        'bootstrap-daterangepicker': {
            exports: '$',
            deps: [
                'jquery',
                'moment',
                'bootstrap'
            ]
        },
        'textarea-autosize': {
            exports: '$',
            deps: [
                'jquery'
            ]
        },
        moment: {
            exports: '$',
            deps: [
                'jquery'
            ]
        },
        'datatables.net': {
            exports: '$',
            deps: [
                'jquery'
            ]
        },
        'datatables.net-bs': {
            exports: '$',
            deps: [
                'jquery',
                'datatables.net'
            ]
        },
        'datatables.net-select': {
            exports: '$',
            deps: [
                'jquery',
                'datatables.net'
            ]
        },
        'datatables.net-responsive': {
            exports: '$',
            deps: [
                'jquery',
                'datatables.net'
            ]
        },
        'datatables.net-responsive-bs': {
            exports: '$',
            deps: [
                'jquery',
                'datatables.net',
                'datatables.net-responsive'
            ]
        }
    },
    packages: [

    ]
};
