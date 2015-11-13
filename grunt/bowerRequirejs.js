'use strict';
module.exports = {
    options: {
        exclude: ['modernizr', 'requirejs', 'almond', 'bootstrap-sass-official'],
        baseUrl: 'bower_components'
    },
    dist: {
        rjsConfig: '<%= paths.app %>/requirejs-config/config.js'
    },
    test: {
        rjsConfig: 'test/test-main.js'
    }
};
