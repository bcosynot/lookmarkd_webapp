define(function(require, exports) {
    'use strict';
    var $ = require('jquery');
    var log = require('loglevel');
    require('bootstrap');
    require('bootstrap/scrollspy');
    require('bootstrap/collapse');
    require('bootstrap3-ie10-viewport-bug-workaround');
    var WOW = require('wow');
    require('animatescroll');
    require('scrollup');

    exports.init = function init() {
        log.setLevel(0);
        new WOW().init();
        $('#hero-learn-more').click(function(e){
        	e.preventDefault();
        	$('#how-it-works-title').animatescroll();
        });
        $.scrollUp({'scrollText':'<i class="ion-chevron-up"></i>'});

        //Stack menu when collapsed
        $('#bs-example-navbar-collapse-1').on('show.bs.collapse', function() {
            $('.nav-pills').addClass('nav-stacked');
        });

        //Unstack menu when not collapsed
        $('#bs-example-navbar-collapse-1').on('hide.bs.collapse', function() {
            $('.nav-pills').removeClass('nav-stacked');
        });
    };
});
