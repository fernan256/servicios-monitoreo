(function () {
  'use strict';

  angular
      .module('webServices')
      .controller('recordCtrl', recordCtrl);

      function recordCtrl($http, $stateParams, $location) {
        var vm = this;
        var id = $stateParams.id;

        vm.types = ['A', 'AAAA', 'CNAME', 'MX', 'NAPTR', 'NS', 'PTR', 'SOA', 'SPF', 'SRV', 'SSHFP', 'TXT', 'RP'];
        vm.priority = [0,1,2,3,4,5,6,7,8,9,10];

        vm.error;
        vm.getRecords = function (id) {
          $http.get('api/domains/records/' + id).success(function(records) {
            vm.records = records;
          }).error(function(error) {
            vm.error = error;
          });
        }
        vm.getRecords(id);

        vm.getDom = function (id) {
          $http.get('api/domains/' + id).success(function(domain) {
            vm.domain = domain[0];
          }).error(function(error) {
            vm.error = error;
          })
        }
        vm.getDom(id);

        vm.addRecord = function () {
          var addData = vm.add;
          addData['domain'] = vm.domain.name;
          addData['domain_id'] = vm.domain.id;
          $http.post('api/records/', {data: addData}).success(function(records) {
            vm.records = records;
            $location.path('/domains');
          }).error(function(error) {
            vm.error = error;
          });
        }

        vm.deleteRecord = function (rid) {

          $http.delete('api/records/' + rid).success(function (domain) {
            vm.getRecords(id);
          }).error(function (error) {
            vm.error = error;
          })
        }

        vm.cancel = function() {
          $location.path('/domains');
        }
      }
})();
