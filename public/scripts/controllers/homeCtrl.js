(function () {
  angular
        .module('webServices')
        .controller('homeCtrl', homeCtrl);

  function homeCtrl($http) {
    var vm = this;

    vm.user;
    vm.error;

    vm.getUser = function() {
      $http.get('api/users').success(function (user) {
        console.log(user);
      }).error(function(error) {
        vm.error = error;
      });
    }
  }
})();
