(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('editMailboxCtrl', editMailboxCtrl);

      function editMailboxCtrl($http, $stateParams, $location) {
        var vm = this;
        var address = $stateParams.address;

        vm.mailbox;
        vm.check;
        vm.error;
        vm.getMailbox = function () {
          $http.get('api/mailboxs/' + address).success(function(mailbox) {
            vm.mailbox = mailbox;
          }).error(function(error) {
            vm.error = error;
          });
        }
        vm.getMailbox();

        vm.editMailbox = function () {
          var dataMail = vm.mailbox;
          if(vm.check === undefined) {
            if(vm.mailbox.enabled === '1') {
              dataMail['enabled'] = vm.mailbox.enabled;
            } else {
              dataMail['enabled'] = vm.check;
            }
          } else {
            dataMail['enabled'] = vm.check.enabled;
          }
          dataMail['address'] = vm.mailbox.address;
          $http.patch('api/mailboxs', {data: dataMail}).success(function(mailbox) {
            $location.path('/mailboxs');
          }).error(function(error) {
            vm.error = error;
          });
        }

        vm.cancel = function() {
          $location.path('/mailboxs');
        }
      }
})();
