(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('mailboxController', mailboxController);

      function mailboxController($http) {
        var vm = this;

        vm.mailboxs;
        vm.mailboxDomains;
        vm.error;
        vm.getMailbox = function () {
          $http.get('api/mailboxs').success(function(mailboxs) {
            vm.mailboxs = mailboxs;
          }).error(function(error) {
            vm.error = error;
          });
        }
        vm.getMailbox();

        vm.getDomMailbox = function () {
          $http.get('api/mailboxs/domains').success(function (domains) {
            vm.mailboxDomains = domains;
          }).error(function(error) {
            vm.error = error;
          });
        }
        vm.getDomMailbox();

        vm.addMailbox = function (ndata) {
          var data = vm.newMailbox;
          console.log(vm.newMailbox);

          $http.post('api/mailboxs/newMailbox', {data: data}).success(function (mailbox) {
            //console.log(mailbox);
            vm.mailboxDomains = mailbox;
          }).error(function(error) {
            vm.error = error;
          });
        }
        vm.deleteMailbox = function (address) {
          console.log(address);
          $http.delete('api/mailboxs/{id}', {params: {id : address}}).success(function (domain) {
            console.log(domain);
          }).error(function (error) {
            vm.error = error;
          })
        }
      }
})();
