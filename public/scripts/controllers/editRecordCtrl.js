(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('editRecordCtrl', editRecordCtrl);

      function editRecordCtrl($http, $stateParams, $location) {
        var vm = this;
        var id = $stateParams.id;

        vm.types = ['A', 'AAAA', 'CNAME', 'MX', 'NAPTR', 'NS', 'PTR', 'SOA', 'SPF', 'SRV', 'SSHFP', 'TXT', 'RP'];
        vm.priority = [0,1,2,3,4,5,6,7,8,9,10];
        vm.error;

        vm.getRecord = function (id) {
          $http.get('api/records/' + id).success(function (record) {
            vm.record = record[0];
          }).error(function(error) {
            vm.error = error;
          });
        }

        vm.getRecord(id);

        vm.edit = function () {
          var editData = vm.record;
          editData['id'] = vm.record.id;
          $http.patch('api/records', {data: editData}).success(function(record) {
            $location.path('/records' + id);
          }).error(function(error) {
            vm.error = error;
          });
        }
        vm.cancel = function(did) {
          $location.path('/records/' + did);
        }
      }
})();
