'use strict';
module.exports = {
    styles: {
        files: ['<%= paths.app %>/styles/{,*/}*.{scss,sass}'],
        tasks: ['sass','autoprefixer']
    },
    scripts: {
        files: ['<%= paths.app %>/scripts/**/*.js'],
        tasks: ['jshint']
    }
};
