// 'use strict';
//
// var app = angular.module('webServices', [])
//         .constant('API_URL', 'http://localhost/www/finales/api-servicios/public/api/');
'use strict';

angular
      .module('webServices', ['ui.router'])
      .config(function($stateProvider, $urlRouterProvider) {

        $urlRouterProvider.otherwise('/home');

        $stateProvider
          .state('index', {
            url: '/home',
            templateUrl: './views/index.html',
            controller: 'indexController as index'
          })
          .state('domains', {
            url: '/domains',
            templateUrl: './views/domains/domainView.html',
            controller: 'domainController as domain'
          })
          .state('records', {
            url: '/records/:id',
            templateUrl: './views/zones/recordView.html',
            controller: 'recordController as record'
          })
          .state('addMasterZone', {
            url: '/domains/addMasterZone',
            templateUrl: './views/zones/addMasterZoneView.html',
            controller: 'addMasterZoneCtrl as addMaster'
          })
          .state('addSlaveZone', {
            url: '/domains/addSlaveZone',
            templateUrl: './views/zones/addSlaveZoneView.html',
            controller: 'addSlaveZoneCtrl as addSlave'
          });
      });
