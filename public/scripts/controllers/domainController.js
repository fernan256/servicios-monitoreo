(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('domainController', domainController);

      function domainController($http) {
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
          console.log(id);
          //$http.delete('api/domains/{id}', {params: {id : id}}).success(function (domain) {
        //    console.log(domain);
        //  }).error(function (error) {
        //    vm.error = error;
        //  })
        }
      }
})();
