(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('domainCtrl', domainCtrl);

      function domainCtrl($http, $state, $rootScope) {
        var vm = this;

        vm.domains;
        vm.error;
        $("#domain-err").hide();

        if($rootScope.currentUser === undefined) {
          $state.go('login');
        }

        vm.getDomains = function () {
          $http.get('api/domains').success(function(domains) {
            vm.domains = domains;
          }).error(function(error) {
            vm.error = error;
          });
        }
        vm.getDomains();

        vm.deleteDomain = function (id) {

          $http.delete('api/domains/' + id).success(function () {
              vm.getDomains();
          }).error(function (error) {
            if(error.error === 'domain_does_not_existe') {
              $("#domain-err").show();
              setTimeout(function() {
                $("#domain-err").hide();
              }, 3000);
            }
            vm.error = error;
          });
        }
      }
})();
