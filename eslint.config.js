import js from '@eslint/js';
import babelParser from "@babel/eslint-parser";
import globals from "globals";
import stylisticJs from '@stylistic/eslint-plugin-js'
import licenseHeader from "eslint-plugin-license-header";
import { readFileSync } from 'fs';

function licenseHeaderText() {
    const extensionParams = JSON.parse(readFileSync('./extension.json', 'utf8'));
    const releaseYear = (new Date(extensionParams.releaseDate)).getFullYear();
    const currentYear = (new Date()).getFullYear();

    return [
        '/************************************************************************',
        `This file is part of the ${extensionParams.name} - EspoCRM extension.`,
        '',
        `${extensionParams.author}`,
        `Copyright (C) ${releaseYear}-${currentYear} ${extensionParams.authors.join(', ')}`,
        '',
        'This program is free software: you can redistribute it and/or modify',
        'it under the terms of the GNU General Public License as published by',
        'the Free Software Foundation, either version 3 of the License, or',
        '(at your option) any later version.',
        '',
        'This program is distributed in the hope that it will be useful,',
        'but WITHOUT ANY WARRANTY; without even the implied warranty of',
        'MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the',
        'GNU General Public License for more details.',
        '',
        'You should have received a copy of the GNU General Public License',
        'along with this program.  If not, see <https://www.gnu.org/licenses/>.',
        '************************************************************************/'
    ];
}

export default [
    {
        ignores: [
            'build/**',
            'site/**',
            'vendor/**',
            '**/lib/**',
            'build.js',
        ],
    },
    js.configs.recommended,
    {
        files: [
            'src/**/*.js',
            'Gruntfile.cjs',
        ],
        languageOptions: {
            sourceType: 'module',
            parser: babelParser,
            parserOptions: {
                requireConfigFile: false,
                babelOptions: {
                    babelrc: false,
                    configFile: false,
                    presets: ['@babel/preset-env'],
                }
            },
            globals: {
                ...globals.browser,
                ...globals.node,
                ...globals.jquery,
                Espo: 'readonly',
                _: 'readonly',
                Backbone: 'readonly',
                define: 'readonly',
            },
        },
        plugins: {
            '@stylistic/js': stylisticJs,
            'license-header': licenseHeader,
        },
        rules: {
            '@stylistic/js/block-spacing': ['error', 'always'],
            '@stylistic/js/comma-spacing': ['error', { 'before': false, 'after': true }],
            '@stylistic/js/indent': ['error', 4, { 'SwitchCase': 1 }],
            '@stylistic/js/padded-blocks': [
                'error',
                {
                    'classes': 'always'
                }
            ],
            '@stylistic/js/padding-line-between-statements': [
                'error',
                {
                    'blankLine': 'always',
                    'prev': '*',
                    'next': [
                        'return'
                    ]
                }
            ],
            '@stylistic/js/quotes': ['error', 'single', { 'avoidEscape': true }],
            'no-var': 'error',
            'prefer-arrow-callback': ['error', { 'allowUnboundThis': false }],
            'no-console': ['error', { 'allow': ['warn', 'error'] }],
            'no-unused-vars': 'warn',
            'license-header/header': ['error', licenseHeaderText()],
        }
    }
];
