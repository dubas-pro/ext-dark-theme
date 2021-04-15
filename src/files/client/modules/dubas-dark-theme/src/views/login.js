define('dubas-dark-theme:views/login', 'views/login', function (Dep) {

    return Dep.extend({

        template: 'dubas-dark-theme:login',

        data: function () {
            return{        
              logoSrc: this.getLogoSrc(),
              showForgotPassword: this.getConfig().get('passwordRecoveryEnabled'),
              applicationName: this.getConfig().get('applicationName')
           };          
        }

    });
});
