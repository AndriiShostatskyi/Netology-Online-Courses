module.exports = function(grunt) {

	grunt.initConfig({
		pkg : grunt.file.readJSON('package.json'),
		sass: {
		     dist: {
				 files: {
					'css/main.css': 'styles/main.scss'
				}
			}
		},
		ftp_push: {
		    demo: {
		    	options: {
		    		authKey: 'netology',
		    		host: 'university.netology.ru',
		    		dest: '/fbb-store/',
		    		port: 21
		    	},
		    	files: [{
		    		expand: true,
		    		cwd: '.',
		    		src: [
		    		      'index.html',
		    		      'css/main.css'
		    		]
		        }]
		    }
		 }
	});

	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-ftp-push');
	
	grunt.registerTask('default', ['sass', 'ftp_push']);
	grunt.registerTask('start', ['sass']);

};