const fs = require('fs');
const modulePath = './src/files/custom/Espo/Modules/DubasDarkTheme';
const clientModulePath = './src/files/client/custom/modules/dubas-dark-theme';

module.exports = grunt => {

    let themeList = [];

    fs.readdirSync(modulePath + '/Resources/metadata/themes').forEach(file => {
        themeList.push(file.substring(0, file.length - 5));
    });

    let cssminFilesData = {};

    let lessData = {};

    themeList.forEach(theme => {
        let name = camelCaseToHyphen(theme);

        let files = {};

        files[clientModulePath + '/css/espo/' + name + '.css'] = 'frontend/less/' + name + '/main.less';
        files[clientModulePath + '/css/espo/' + name + '-iframe.css'] = 'frontend/less/' + name + '/iframe/main.less';

        cssminFilesData[clientModulePath + '/css/espo/' + name + '.css'] = clientModulePath + '/css/espo/' + name + '.css';
        cssminFilesData[clientModulePath + '/css/espo/' + name + '-iframe.css'] = clientModulePath + '/css/espo/' + name + '-iframe.css';

        let o = {
            options: {
                yuicompress: true,
            },
            files: files,
        };

        lessData[theme] = o;
    });

    grunt.initConfig({
        clean: {
            start: [
                clientModulePath + '/fonts/*',
                clientModulePath + '/css/*',
            ],
        },

        less: lessData,

        cssmin: {
            themes: {
                files: cssminFilesData,
            },
        },

        copy: {
            options: {
                mode: true,
            },
            fonts: {
                expand: true,
                flatten: true,
                dest: clientModulePath + '/fonts/',
                src: [
                    'site/client/fonts/summernote.ttf',
                    'site/client/fonts/summernote.woff',
                    'site/client/fonts/summernote.woff2',
                ],
            },
        }
    });

    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-less');

    grunt.registerTask('css', [
        'less',
        'cssmin',
        'copy',
    ]);

    grunt.registerTask('default', [
        'css',
    ]);
};

function camelCaseToHyphen(string) {
    if (string === null) {
        return string;
    }

    return string.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();
}
