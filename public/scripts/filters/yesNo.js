(function() {
  'use strict';

  angular
      .module('webServices')
      .filter('yesNo', function() {
          return function(input) {
            return input == 1 ? 'Si' : 'No';
          };
        });
})();
