const fs = require('fs');

module.exports = grunt => {

    let themeList = [];

    fs.readdirSync('../../../../custom/Espo/Modules/DubasDarkTheme/Resources/metadata/themes').forEach(file => {
        themeList.push(file.substring(0, file.length - 5));
    });

    let cssminFilesData = {
        'css/espo/espo.css': 'css/espo/espo.css',
    };

    let lessData = {
        'Espo': {
            options: {
                yuicompress: true,
            },
            files: {
                'css/espo/espo.css': 'node_modules/espocrm/frontend/less/espo/main.less'
            },
        }
    };

    themeList.forEach(theme => {
        let name = camelCaseToHyphen(theme);

        let files = {};

        files['css/espo/'+name+'.css'] = 'frontend/less/'+name+'/main.less';
        files['css/espo/'+name+'-iframe.css'] = 'frontend/less/'+name+'/iframe/main.less';

        cssminFilesData['css/espo/'+name+'.css'] = 'css/espo/'+name+'.css';
        cssminFilesData['css/espo/'+name+'-iframe.css'] = 'css/espo/'+name+'-iframe.css';

        let o = {
            options: {
                yuicompress: true,
            },
            files: files,
        };

        lessData[theme] = o;
    });

    grunt.initConfig({
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
                cwd: 'node_modules/espocrm/client/fonts',
                src: '**',
                dest: 'fonts/',
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

function camelCaseToHyphen(string){
    if (string === null) {
        return string;
    }

    return string.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();
}
