(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('editMailDomainCtrl', editMailDomainCtrl);

      function editMailDomainCtrl($http, $stateParams, $state, $rootScope) {
        var vm = this;
        var domId = $stateParams.id;

        vm.mailbox;
        vm.check;
        vm.error;

        if($rootScope.currentUser === undefined) {
          $state.go('login');
        }

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
            $state.go('app.mailDomains');
          }).error(function(error) {
            vm.error = error;
          });
        }

        vm.cancel = function() {
          $state.go('app.mailDomains');
        }
      }
})();
