/*global module:false*/
module.exports = function(grunt) {
    grunt.initConfig({
        qunit: {
            all: ['Tests/js/index.html']
        }
    });
    grunt.loadNpmTasks('grunt-contrib-qunit');

    grunt.registerTask('default', 'qunit');
    grunt.registerTask('test', 'qunit');
};