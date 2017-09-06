'use strict';
module.exports = function(grunt, options) {

	grunt.log.writeln('imhere');
	var files = grunt.file.expand(options.paths.app+'/scripts/*.js');
    var requirejsOptions = {};
    files.forEach(function(file) {
        var filename = file.split('/').pop();
        requirejsOptions[filename.split('.')[0]] = {
            options: {
                baseUrl: 'bower_components',
                name: 'almond/almond',
                include: 'appScripts/'+filename.split('.')[0],
                out: options.paths.dist+'/scripts/'+filename,
                mainConfigFile: options.paths.app+'/requirejs-config/config.js',
                preserveLicenseComments: false,
                useStrict: true,
                wrap: true,
                optimize: 'uglify2',
                generateSourceMaps: false,
            }
        };
    });
    return requirejsOptions;
};
