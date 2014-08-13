module.exports = function(grunt) {
	'use strict';

	grunt.util.linefeed = '\n';

	grunt.util.linefeed = '\n';

	grunt.initConfig(require('./utils/grunt/init')(grunt));
	require('./utils/grunt/packaging')(grunt);

	grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-contrib-compress');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-curl');
	grunt.loadNpmTasks('grunt-parallel');
	grunt.loadNpmTasks('grunt-recess');
	grunt.loadNpmTasks('grunt-replace');

	grunt.registerTask('buildjs', ['concat', 'uglify']);
	grunt.registerTask('dev', ['parallel:dev']);
	grunt.registerTask('makepot', ['parallel:fetch-wp-devel', 'parallel:makepot']);

	// build process - related tasks go on the same row
	grunt.registerTask('package', [
		'jshint', 'buildjs',
		'build-plugins',
		'parallel:composer',
		'check-api',
		'clean:build', 'clean:dist',
		'makepot', 'add-textdomain',
		'copy:theme',
		'prepare-skins', 'scp-download-samples', 'download-images', 'download-content-xml', 'download-sidebars-options', 'download-layerslider',
		'clean:post-copy',
		'replace:style-switcher',
		'compress:theme',
		'clean:build'
	]);
};