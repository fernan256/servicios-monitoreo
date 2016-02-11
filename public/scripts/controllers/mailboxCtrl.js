(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('mailboxCtrl', mailboxCtrl);

      function mailboxCtrl($http, $location) {
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

        vm.add = function (ndata) {
          var data = vm.new;
          $http.post('api/mailboxs/newMailbox', {data: data}).success(function (res) {
            $location.path('/mailboxs');
          }).error(function(error) {
            vm.error = error;
          });
        }
        vm.deleteMailbox = function (address) {
          $http.delete('api/mailboxs/{id}', {params: {id : address}}).success(function (resp) {
            if(resp === 'ok') {
              vm.getMailbox();
            } else {
              console.log('problem');
            }
          }).error(function (error) {
            vm.error = error;
          })
        }

        vm.cancel = function () {
          $location.path('/');
        }
      }
})();
