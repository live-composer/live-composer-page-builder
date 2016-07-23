module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		uglify: {
			options: {
				compress: true,
				manage: false,
			},
			js_builder_minify : {
				src : 'js/builder/*.js',
				dest : 'js/builder.all.min.js'
			},
			js_iframe_minify : {
				src : 'js/iframe/*.js',
				dest : 'js/iframe.all.min.js'
			},
			js_main_minify : {
				src : 'js/common/main.js',
				dest : 'js/common/main.min.js'
			},
		},
	});

	grunt.loadNpmTasks('grunt-contrib-uglify');

	grunt.registerTask('default', ['uglify']);
};