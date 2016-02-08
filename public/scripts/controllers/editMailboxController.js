(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('editMailboxController', editMailboxController);

      function editMailboxController($http, $stateParams) {
        var vm = this;
        var address = $stateParams.address;

        vm.mailbox;
        vm.error;
        vm.getMailbox = function () {
          $http.get('api/mailboxs/{id}', {params: {id : address}}).success(function(mailbox) {
            console.log(mailbox);
            vm.mailbox = mailbox;
          }).error(function(error) {
            vm.error = error;
          });
        }
        vm.getMailbox();

        vm.editM = function () {
          var data = vm.edit;
          $http.post('api/mailboxs/{address}', {data: data}).success(function(mailbox) {
            console.log(mailbox);
            vm.mailbox = mailbox;
          }).error(function(error) {
            vm.error = error;
          });
        }
      }
})();
