(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('recordController', recordController);

      function recordController($http, $stateParams) {
        var vm = this;
        var id = $stateParams.id;
        vm.domains;
        vm.error;
        vm.getRecords = function (id) {
          $http.get('api/domains/showRecord', {params: {id : id}}).success(function(records) {
            vm.records = records;
          }).error(function(error) {
            vm.error = error;
          });
        }
        vm.getRecords(id);
      }
})();
