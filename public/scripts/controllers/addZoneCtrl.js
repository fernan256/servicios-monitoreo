(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('addZoneCtrl', addZoneCtrl);

      function addZoneCtrl($http, $location) {
        var vm = this;

        vm.masterZone;
        vm.error;

        vm.addMasterZone = function () {
          var masterData = vm.masterZone;

          $http.post('api/domains/newMasterZone', {data: masterData}).success(function(masterZone) {
            $location.path('/domains');
          }).error(function(error) {
            vm.error = error;
          });
        }

        vm.addSlaveZone = function () {
          var slaveData = vm.slaveZone;

          $http.post('api/domains/newSlaveZone', {data: slaveData}).success(function(slaveZone) {
            $location.path('/domains');
          }).error(function(error) {
            vm.error = error;
          });
        }

        vm.cancel = function () {
          $location.path('/domains');
        }
      }
})();
