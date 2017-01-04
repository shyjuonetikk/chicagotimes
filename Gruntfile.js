module.exports = function( grunt ) {

    "use strict";

    // Project configuration
    grunt.initConfig({

        pkg: grunt.file.readJSON("package.json"),

        // JS Minification & Concatenation
        uglify: {

            dev: {
                options: {
                    preserveComments: true,
                    sourceMap: function (destination) {
                        return destination + ".map";
                    },
                    sourceMappingURL: function (destination) {
                        return destination.replace(/^.*[\\\/]/, "") + ".map";
                    },
                    sourceMapRoot: "/",
                    beautify: true
                },
                files: {
                    // 'assets/js/theme.js': ['assets/js/src/script1.js']
                }
            },

            prod: {
                options: {
                    preserveComments: false,
                    banner: "/* <%= pkg.homepage %> * Copyright (c) <%= grunt.template.today(\"yyyy\") %> */\n",
                    mangle: {except: ["jQuery"]}
                },
                files: {
                    // 'assets/js/theme.min.js': ['assets/js/src/script1.js']
                }
            }

        },

        // Compile SASS
        sass: {

            compile: {
                files: {
                    "assets/css/theme.css": "assets/css/scss/theme.scss"
                }
            }

        },

        // Watch for changes
        watch: {

            sass: {
                files: ["assets/css/*/**/*.scss"],
                tasks: ["sass"],
                options: {
                    debounceDelay: 500,
                    livereload: true
                }
            },

            scripts: {
                files: ["assets/js/*/**/*.js"],
                tasks: ["uglify"],
                options: {
                    debounceDelay: 500
                }
            }

        }
    });

    grunt.loadNpmTasks("grunt-contrib-uglify");
    grunt.loadNpmTasks("grunt-sass");
    grunt.loadNpmTasks("grunt-contrib-watch");

    // Default task.
    grunt.registerTask("default", ["uglify", "sass"]);

    grunt.util.linefeed = "\n";

};