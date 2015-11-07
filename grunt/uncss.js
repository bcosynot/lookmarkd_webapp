'use strict';
module.exports = {
    dist: {
        options: {
            stylesheets: ['../.tmp/styles/main.css'],
            ignore: [
                /* ignore classes which are not present at dom load */
                /\.fade/,
                /\.collapse/,
                /\.collapsing/,
                /\.modal/,
                /\.alert/,
                /\.open/,
                /\.in/
            ]
        },
        files: {
            '.tmp/styles/main.css': ['.tmp/*.html']
        }
    }
};
