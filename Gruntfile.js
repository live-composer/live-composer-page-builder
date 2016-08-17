module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		uglify: {
			options: {
				compress: false,
				manage: false,
			},
			js_builder_minify : {
				src : ['js/builder/*.js', '!js/builder/builder.plugins.js'],
				dest : 'js/builder.all.min.js'
			},
			js_iframe_minify : {
				src : 'js/builder.frontend/*.js',
				dest : 'js/builder.frontend.all.min.js'
			},
			js_frontend_minify : {
				src : 'js/frontend/*.js',
				dest : 'js/frontend.all.min.js'
			},
			js_pluginoptions_minify : {
				src : 'includes/plugin-options-framework/js/main.js',
				dest : 'includes/plugin-options-framework/js/main.min.js'
			},
			js_postoptions_minify : {
				src : 'includes/post-options-framework/js/main.js',
				dest : 'includes/post-options-framework/js/main.min.js'
			},
		},

		cssmin: {
			target: {
				files: {
					'css/frontend.min.css': ['css/frontend/*.css'],
					'css/builder.min.css': ['css/builder/*.css'],
					'includes/plugin-options-framework/css/main.min.css': ['includes/plugin-options-framework/css/main.css'],
					'includes/post-options-framework/css/main.min.css': ['includes/post-options-framework/css/main.css']
				}
			}
		},
	});

	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');

	grunt.registerTask('default', ['uglify', 'cssmin']);
};