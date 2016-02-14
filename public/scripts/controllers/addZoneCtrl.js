(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('addZoneCtrl', addZoneCtrl);

      function addZoneCtrl($http, $state, $rootScope) {
        var vm = this;

        vm.masterZone;
        vm.error;
        $("#zone-exists").hide();
        $("#zoneSlave-exists").hide();

        if($rootScope.currentUser === undefined) {
          $state.go('login');
        }
        vm.addMasterZone = function () {
          var masterData = vm.masterZone;

          $http.post('api/domains/newMasterZone', {data: masterData}).success(function(masterZone) {
            $state.go('app.domains');
          }).error(function(error) {
            if(error.error === 'zone_exists') {
              $("#zone-exists").show();
              setTimeout(function() {
                $("#zone-exists").hide();
              }, 3000);
            }
            vm.error = error;
          });
        }

        vm.addSlaveZone = function () {
          var slaveData = vm.slaveZone;

          $http.post('api/domains/newSlaveZone', {data: slaveData}).success(function(slaveZone) {
            $state.go('app.domains');
          }).error(function(error) {
            if(error.error === 'zoneSlave_exists') {
              $("#zoneSlave-exists").show();
              setTimeout(function() {
                $("#zone-exists").hide();
              }, 3000);
            }
            vm.error = error;
          });
        }

        vm.cancel = function () {
          $state.go('app.domains');
        }
      }
})();
