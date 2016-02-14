(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('editMailboxCtrl', editMailboxCtrl);

      function editMailboxCtrl($http, $stateParams, $state, $rootScope) {
        var vm = this;
        var address = $stateParams.address;

        vm.mailbox;
        vm.check;
        vm.error;
        $("#not-match").hide();
        $("#pass-short").hide();

        if($rootScope.currentUser === undefined) {
          $state.go('login');
        }

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
          if(vm.mailbox.password.length < 6) {
            $("#pass-short").show();
              setTimeout(function() {
                $("#pass-short").hide();
              }, 3000);
          } else if(vm.mailbox.password !== vm.mailbox.repeatPass) {
            $("#not-match").show();
              setTimeout(function() {
                $("#not-match").hide();
              }, 3000);
          } else {
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
            $http.patch('api/mailboxs', {data: dataMail}).success(function() {
              $state.go('app.listMailbox');
            }).error(function(error) {
              vm.error = error;
            });
          }
        }

        vm.cancel = function() {
          $state.go('app.mailboxs');
        }
      }
})();
