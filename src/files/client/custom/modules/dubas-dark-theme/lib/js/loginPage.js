define('dubas-dark-theme:views/login', 'views/login', function (Dep) {

    return Dep.extend({

        // specify your custom template
        template: 'dubas-dark-theme:login',

        // include the custom values in the standard "data" function which will provide the placeholder values to the template
        // the values for "logoSrc" and "showForgotPassword" are the standard values specified in the core login script
        data: function () {
            return{        
                logoSrc: this.getLogoSrc(),
                showForgotPassword: this.getConfig().get('passwordRecoveryEnabled'),
                applicationName: this.getConfig().get('applicationName'),
                anotherUser: this.anotherUser,
                hasSignIn: !!this.handler,
                hasFallback: !!this.handler && this.fallback,
                method: this.method,
                signInText: this.signInText,
                logInText: this.logInText,
           };          
        },

        setup: function () {
            this.anotherUser = this.options.anotherUser || null;

            let loginData = this.getConfig().get('loginData') || {};

            this.fallback = !!loginData.fallback;
            this.method = loginData.method;

            if (loginData.handler) {
                this.wait(
                    Espo.loader
                        .requirePromise(loginData.handler)
                        .then(Handler => {
                            this.handler = new Handler(this, loginData.data || {});
                        })
                );

                this.signInText = this.getLanguage().has(this.method, 'signInLabels', 'Global') ?
                    this.translate(this.method, 'signInLabels') :
                    this.translate('Sign in');
            }

            if (this.getLanguage().has('Log in', 'labels', 'Global')) {
                this.logInText = this.translate('Log in');
            }

            this.logInText = this.getLanguage().has('Log in', 'labels', 'Global') ?
                this.translate('Log in') :
                this.translate('Login');
        },


    });
});