'use strict';
module.exports = {
    options: {
        browsers: ['> 5%', 'last 2 versions', 'ie 9'],
        map: {
            prev: '.tmp/styles/'
        }
    },
    dist: {
        files: [{
            expand: true,
            cwd: '.tmp/sass/',
            src: '{,*/}*.css',
            dest: '.tmp/styles/'
        }]
    }
};
