(function() {
  angular
        .module('webServices')
        .factory('DomainsResource', function ($resource) {
          return $resource('http://localhost:8000/api/domains/');
        });
})();
