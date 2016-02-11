(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('editMailDomainCtrl', editMailDomainCtrl);

      function editMailDomainCtrl($http, $stateParams, $location) {
        var vm = this;
        var domId = $stateParams.id;

        vm.mailbox;
        vm.check;
        vm.error;
        vm.getOne = function () {
          $http.get('api/mailDomain/' + domId).success(function(domain) {
            vm.domain = domain[0];
          }).error(function(error) {
            vm.error = error;
          });
        }
        vm.getOne();

        vm.editDomain = function () {
          var dataMail = vm.domain;
          if(vm.check === undefined) {
            if(vm.domain.enabled === '1') {
              dataMail['enabled'] = vm.domain.enabled;
            } else {
              dataMail['enabled'] = vm.check;
            }
          } else {
            dataMail['enabled'] = vm.check.enabled;
          }
          $http.patch('api/mailDomain', {data: dataMail}).success(function(mailbox) {
            $location.path('/mailDomains');
          }).error(function(error) {
            vm.error = error;
          });
        }

        vm.cancel = function() {
          $location.path('/mailDomains');
        }
      }
})();
