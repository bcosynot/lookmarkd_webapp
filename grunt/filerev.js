'use strict';
module.exports = {
    dist: {
        src: [
            '<%= paths.dist %>/img/**/*.{jpg,jpeg,gif,png,webp}',
            '<%= paths.dist %>/styles/*.css',
            '<%= paths.dist %>/scripts/*.js'
        ]
    }
};
