(function() {
'use strict';

  angular
    .module('webServices')
    .controller('authenticateCtrl', authenticateCtrl)

    	function authenticateCtrl($auth, $state, $http, $rootScope) {

        var vm = this;

        vm.loginError = false;
        vm.loginErrorText;
        $('#login-error').hide();
        vm.login = function() {

            var credentials = {
                email: vm.email,
                password: vm.password
            }

            $auth.login(credentials).then(function() {
              return $http.get('api/authenticate/user');
            }, function(error) {
                vm.loginError = true;
                vm.loginErrorText = error.data.error;
                if(vm.loginErrorText === 'invalid_credentials') {
                  $("#login-error").show();
                  setTimeout(function() {
                    $("#login-error").hide();
                  }, 3000);
                }

            }).then(function(response) {

              if(response !== undefined) {
                var user = JSON.stringify(response.data.user);
                localStorage.setItem('user', user);
                $rootScope.authenticated = true;
                $rootScope.currentUser = response.data.user;
                $state.go('app.home');
              }
            });
        }
    }

})();