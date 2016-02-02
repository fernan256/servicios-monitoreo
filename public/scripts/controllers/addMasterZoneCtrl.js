(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('addMasterZoneCtrl', addMasterZoneCtrl);

      function addMasterZoneCtrl($http) {
        var vm = this;

        vm.masterZone;
        vm.error;

        vm.addMasterZone = function () {
          var data = vm.masterZone;
          console.log(data);
          $http.post('api/domains/newMasterZone', {data: data}).success(function(masterZone) {
            vm.showZone = masterZone;
          }).error(function(error) {
            vm.error = error;
          });
        }
      }
})();
