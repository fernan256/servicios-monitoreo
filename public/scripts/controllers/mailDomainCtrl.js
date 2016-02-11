(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('mailDomainCtrl', mailDomainCtrl);

      function mailDomainCtrl($http, $location) {
        var vm = this;

        vm.mailDomains;
        vm.error;
        vm.getMailDomain = function () {
          $http.get('api/mailboxs/domains').success(function(domains) {
            vm.mailDomains = domains;
          }).error(function(error) {
            vm.error = error;
          });
        }
        vm.getMailDomain();

        vm.add = function (data) {
          var data = vm.new;
          $http.post('api/mailDomain/new', {data: data}).success(function (mailbox) {
            $location.path('/mailDomains');
          }).error(function(error) {
            vm.error = error;
          });
        }
        vm.delete = function (id) {
          console.log(id);
          $http.delete('api/mailDomain/' + id).success(function (resp) {
            if(resp === 'ok') {
              vm.getMailDomain();
            } else {
              console.log('problem');
            }
          }).error(function (error) {
            vm.error = error;
          })
        }
        vm.edit = function (address) {
          $http.delete('api/mailDomain/' + id).success(function (resp) {
            if(resp === 'ok') {
              vm.getMailDomain();
            } else {
              console.log('problem');
            }
          }).error(function (error) {
            vm.error = error;
          })
        }

        vm.cancel = function () {
          $location.path('/mailDomains');
        }
      }
})();
