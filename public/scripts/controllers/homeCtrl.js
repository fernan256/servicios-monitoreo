(function () {
  angular
        .module('webServices')
        .controller('homeCtrl', homeCtrl);

  function homeCtrl($http, $state, $auth, $rootScope) {
    var vm = this;

    vm.user;
    vm.error;

    vm.getUser = function() {
      $http.get('api/authenticate').success(function(users) {
          vm.users = users;
      }).error(function(error) {
          vm.error = error;
      });
    }

    vm.logout = function() {

      $auth.logout().then(function() {

          // Remove the authenticated user from local storage
          localStorage.removeItem('user');

          // Flip authenticated to false so that we no longer
          // show UI elements dependant on the user being logged in
          $rootScope.authenticated = false;

          // Remove the current user info from rootscope
          $rootScope.currentUser = null;

          $state.go('login');
      });
    }
  }
})();
