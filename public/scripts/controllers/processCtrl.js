(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('processCtrl', processCtrl);

      function processCtrl($http, $state, $rootScope, $anchorScroll) {
        var vm = this;

        vm.error;
        $("#reOk").hide();
        $("#reNoOk").hide();
        $("#killOk").hide();
        $("#killNoOk").hide();
        $("#launchOk").hide();
        $("#launchNoOk").hide();

        if($rootScope.currentUser === undefined) {
          $state.go('login');
        }

        vm.getProcess = function () {
          $http.get('api/process/').success(function (process) {
            vm.process = process;
          }).error(function(error) {
            vm.error = error;
          });
        }

        vm.repriorizeProcess = function (data) {

          $http.put('api/process/{process}', {data: data}).success(function (resp) {
            if(resp.status === '200') {
              vm.repriorize = resp.result[0];
              $("#reOk").show();
              setTimeout(function() {
                $("#reOk").hide();
              }, 3000);
            } else {
              $("#reNoOk").show();
              setTimeout(function() {
                $("#reNoOk").hide();
              }, 3000);
            }
          }).error(function(error) {
            vm.error = error;
          });
        }
        vm.killProcess = function (pid) {
          $http.delete('api/process/{process}', {params: {pid:pid}}).success(function (resp) {
            if(resp.status === '200') {
              $anchorScroll();
              $("#killOk").show();
              setTimeout(function() {
                $("#killOk").hide();
              }, 3000);
              vm.getProcess();
            } else {
              $("#killNoOk").show();
              setTimeout(function() {
                $("#killNoOk").hide();
              }, 3000);
            }
          }).error(function (error) {
            vm.error = error;
          })
        }
        vm.launchProcess = function (cmd) {
          $http.post('api/process', {cmd: cmd}).success(function (resp) {
            if(resp.status === '200') {
              console.log(resp.result);
              vm.launch = resp.result;
              $("#launchOk").show();
              setTimeout(function() {
                $("#launchOk").hide();
              }, 3000);
            } else {
              $("#launchNoOk").show();
              setTimeout(function() {
                $("#launchNoOk").hide();
              }, 3000);
            }
          }).error(function (error) {
            vm.error = error;
          })
        }
        vm.findProcess = function (address) {
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
          $state.go('app.home');
        }
      }
})();
