(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('mailDomainCtrl', mailDomainCtrl);

      function mailDomainCtrl($http, $state, $rootScope) {
        var vm = this;

        vm.mailDomains;
        vm.error;
        $("#domain-error").hide();

        if($rootScope.currentUser === undefined) {
          $state.go('login');
        }

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
          $http.post('api/mailDomain/new', {data: data}).success(function () {
            $state.go('app.mailDomains');
          }).error(function(error) {
            if(vm.new.password !== vm.new.repeatPass) {
              $("#domain-error").show();
              setTimeout(function() {
                $("#domain-error").hide();
              }, 3000);
            }
            vm.error = error;
          });
        }
        vm.delete = function (id) {
          $http.delete('api/mailDomain/' + id).success(function () {
            vm.getMailDomain();
          }).error(function (error) {
            vm.error = error;
          })
        }
        vm.edit = function (address) {
          $http.delete('api/mailDomain/' + id).success(function () {
            vm.getMailDomain();
          }).error(function (error) {
            vm.error = error;
          })
        }

        vm.cancel = function () {
          $state.go('app.mailDomains');
        }
      }
})();
