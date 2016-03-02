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
        $("#findOk").hide();
        $("#findNoOk").hide();

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
          $http.delete('api/process/' + pid).success(function (resp) {
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
              vm.launch = resp.result;
              $("#launchOk").show();
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
        vm.findProcess = function (pid) {
          console.log(pid);
          $http.get('api/process/' + pid).success(function (resp) {
            console.log(resp);
            if(resp.status === '200') {
              vm.founded = resp.result;
              $("#findOk").show();
            } else {
              $("#findNoOk").show();
              setTimeout(function() {
                $("#findNoOk").hide();
              }, 3000);
            }
          }).error(function (error) {
            vm.error = error;
          })
        }
      }
})();
