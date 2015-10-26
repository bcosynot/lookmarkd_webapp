'use strict';
module.exports = {
    options: {
        includePaths: ['bower_components']
    },
    all: {
        files: {
            '.tmp/sass/main.css': '<%= paths.app %>/styles/main.scss'
        }
    }
};
