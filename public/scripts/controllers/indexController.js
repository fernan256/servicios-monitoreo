(function () {
  angular
        .module('webServices')
        .controller('indexController', indexController);

  function indexController($scope, $window) {
    $scope.roundcube = 'http://htagro.info/roundcube/';
    $scope.monitoreo = 'https://htagro.info:10443';

    $scope.linkModelFunc = function (url){
      $window.open(url);
    }
  }
})();
