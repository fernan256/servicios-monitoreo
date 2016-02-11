(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('domainCtrl', domainCtrl);

      function domainCtrl($http) {
        var vm = this;

        vm.domains;
        vm.error;
        vm.getDomains = function () {
          $http.get('api/domains').success(function(domains) {
            vm.domains = domains;
          }).error(function(error) {
            vm.error = error;
          });
        }
        vm.getDomains();

        vm.deleteDomain = function (id) {

          $http.delete('api/domains/' + id).success(function (resp) {
            if(resp = 'success') {
              vm.getDomains();
            }
          }).error(function (error) {
            vm.error = error;
          });
        }
      }
})();
