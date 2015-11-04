// Generated on 2015-10-21 using
// generator-grunt-symfony 0.5.2
module.exports = function(grunt) {
    require('jit-grunt')(grunt);
    var _ = require('lodash');
    var fs = require('fs');
    var path = require('path');
    var env = _.defaults(fs.existsSync('.envrc') && grunt.file.readJSON('.envrc') || {},{
        port: parseInt(grunt.option('port'), 10) || 8000,
    });
    

    console.log(grunt.option('useproxy'));
    var useproxy = grunt.option('useproxy');
    console.log(grunt.option('proxy'));
    var proxy =  grunt.option('proxy');


    var paths = {
        app: 'app/Resources/public',
        dist: 'web'
    };


    // load grunt config
    require('load-grunt-config')(grunt, {
        // path to task.js files, defaults to grunt dir
        configPath: path.join(process.cwd(), 'grunt'),

        // auto grunt.initConfig
        init: true,

        // data passed into config.
        data: {
            paths: paths,
            env: env,
            useproxy: useproxy,
            proxy: proxy
        },

        jitGrunt: true
    });
};
