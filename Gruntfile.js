module.exports = function (grunt) {

	// All upfront configurations
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		concat: {
			options: {
				separator: ';'
			},
			dist: {
				// the source file
				src: ['assets/js/*.js'],
				//the destination file like main.js
				dest: '<%= assetsFolder %>/main.js'
			}
		},
		// uglify to concat, minify, and make source maps
		uglify: {
			dist: {
				options: {
					sourceMap: 'assets/js/*.js'
				},
				files: {
					'assets/js/main.js': [
						'assets/js/main.js'
					]
				}
			}
		},
		// image optimization
		imagemin: {
			dist: {
				options: {
					optimizationLevel: 7,
					progressive: true
				},
				files: [{
						expand: true,
						cwd: 'assets/images/',
						src: '**/*',
						dest: 'assets/images/'
					}]
			}
		},
		jshint: {
			files: ['assets/js/*.js'],
			options: {
				globals: {
					jQuery: true
				},
				"bitwise": true,
				"curly": true,
				"eqeqeq": true,
				"forin": true,
				"latedef": true,
				"maxparams": 3,
				"noarg": true,
				"nonew": true,
				"shadow": true,
				"strict": true,
				"undef": true,
				"unused": true,
				"browser": true,
			}


		},
		watch: {
			files: ['<%= jshint.files %>'],
			tasks: ['jshint']
		}

	});

	//Load Plugins
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');

	// Task List
	grunt.registerTask('build', ['concate']);

	// default task
	grunt.registerTask('default', ['jshint', 'concat', 'uglify', 'watch']);
};