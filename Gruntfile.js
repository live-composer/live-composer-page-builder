module.exports = function(grunt) {

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		uglify: {
			options: {
				compress: true,
				manage: false,
			},
			all_src : {
				src : 'js/builder/*.js',
				dest : 'js/builder.all.min.js'
		   }
		},
	});

	grunt.loadNpmTasks('grunt-contrib-uglify');

};