module.exports = {
    trailingComma: "es5",
    tabWidth: 4,
    semi: false,
    singleQuote: true,
    overrides: [
        {
            "files": "src/**/*.json",
            "options": {
                "parser": "json"
            }
        }
    ]
};
