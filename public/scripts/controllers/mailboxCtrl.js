(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('mailboxCtrl', mailboxCtrl);

      function mailboxCtrl($http, $state, $rootScope) {
        var vm = this;

        vm.mailboxs;
        vm.mailboxDomains;
        vm.error;
        $("#create-error").hide();
        $("#not-match").hide();
        $("#pass-short").hide();

        if($rootScope.currentUser === undefined) {
          $state.go('login');
        }

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
          if(vm.new.password.length < 6) {
            $("#pass-short").show();
              setTimeout(function() {
                $("#pass-short").hide();
              }, 3000);
          }
          if(vm.new.password !== vm.new.repeatPass) {
            $("#not-match").show();
              setTimeout(function() {
                $("#not-match").hide();
              }, 3000);
          }
          $http.post('api/mailboxs/newMailbox', {data: data}).success(function () {
            $state.go('app.listMailbox');
          }).error(function(error) {
            if(error.error === 'mailbox_exists') {
              $("#create-error").show();
              setTimeout(function() {
                $("#create-error").hide();
              }, 3000);
            }
          });
        }
        vm.deleteMailbox = function (address) {
          $http.delete('api/mailboxs/{id}', {params: {id : address}}).success(function () {
              vm.getMailbox();
          }).error(function (error) {
            vm.error = error;
          })
        }

        vm.cancel = function () {
          $state.go('app.home');
        }
      }
})();
