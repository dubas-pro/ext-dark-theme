const extensionParams = require('./extension.json');
const releaseYear = (new Date(extensionParams.releaseDate)).getFullYear();
const currentYear = (new Date()).getFullYear();
const copyrightHeader = [
    '***********************************************************************',
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
    '***********************************************************************'
];

module.exports = {
    extends: 'eslint:recommended',
    env: {
        'browser': true,
        'node': true,
        'es2021': true,
        'jquery': true,
    },
    globals: {
        'Espo': 'readonly',
        'define': 'readonly',
        '_': 'readonly',
        'moment': 'readonly',
        'Backbone': 'readonly',
        'Html5QrcodeScanner': 'readonly',
    },
    parserOptions: {
        'ecmaVersion': 12,
        'sourceType': 'module'
    },
    plugins: [
        'header'
    ],
    ignorePatterns: [
        '/site/**',
        'src/**/lib/**'
    ],
    rules: {
        'no-var': 'error',
        'prefer-arrow-callback': ['error', { 'allowUnboundThis': false }],
        'no-console': 'error',
        'block-spacing': ['error', 'always'],
        'indent': ['error', 4, { 'SwitchCase': 1 }],
        'no-unused-vars': 'warn',
        'comma-spacing': ['error', { 'before': false, 'after': true }],
        'quotes': ['error', 'single', { 'avoidEscape': true }],
        'padding-line-between-statements': [
            'error',
            {
                'blankLine': 'always',
                'prev': '*',
                'next': [
                    'return'
                ]
            }
        ],
        'padded-blocks': [
            'error',
            {
                'classes': 'always'
            }
        ],
    },
    overrides: [
        {
            files: ['src/**/*.js'],
            extends: 'eslint:recommended',
            rules: {
                'header/header': ['error', 'block', copyrightHeader]
            }
        },
    ]
};
