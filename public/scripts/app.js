// 'use strict';
//
// var app = angular.module('webServices', [])
//         .constant('API_URL', 'http://localhost/www/finales/api-servicios/public/api/');
'use strict';

angular
      .module('webServices', ['ui.router', 'mgcrea.ngStrap'])
      .config(function($stateProvider, $urlRouterProvider) {

        $urlRouterProvider.otherwise('/home');

        $stateProvider
          .state('app', {
            abstract:true,
            views: {
              '': {
                templateUrl: './views/content/content.html'
                //controller: 'ContentController as Content'
              },
              'nav': {
                templateUrl: './views/navbar/navbar.html',
                controller: 'homeCtrl as home'
              }
            }
          })
          .state('app.home', {
            url: '/home',
            templateUrl: './views/index.html',
            controller: 'homeCtrl as home'
          })
          .state('app.domains', {
            url: '/domains',
            templateUrl: './views/domains/domainView.html',
            controller: 'domainCtrl as domain'
          })
          .state('app.records', {
            url: '/records/:id',
            templateUrl: './views/records/recordView.html',
            controller: 'recordCtrl as record'
          })
          .state('app.addRecords', {
            url: '/records/add/:id',
            templateUrl: './views/records/addRecordView.html',
            controller: 'recordCtrl as record'
          })
          .state('app.editRecord', {
            url: '/records/edit/:id',
            templateUrl: './views/records/editRecordView.html',
            controller: 'editRecordCtrl as editRecord'
          })
          .state('app.addMasterZone', {
            url: '/domains/addMasterZone',
            templateUrl: './views/zones/addMasterZoneView.html',
            controller: 'addZoneCtrl as addZone'
          })
          .state('app.addSlaveZone', {
            url: '/domains/addSlaveZone',
            templateUrl: './views/zones/addSlaveZoneView.html',
            controller: 'addZoneCtrl as addZone'
          })
          .state('app.listMailbox', {
            url: '/mailboxs',
            templateUrl: './views/mailbox/listMailboxView.html',
            controller: 'mailboxCtrl as mailbox'
          })
          .state('app.addMailbox', {
            url: '/mailbox/new',
            templateUrl: './views/mailbox/addMailboxView.html',
            controller: 'mailboxCtrl as mailbox'
          })
          .state('app.editMailbox', {
            url: '/mailbox/edit/:address',
            templateUrl: './views/mailbox/editMailboxView.html',
            controller: 'editMailboxCtrl as editMailbox'
          })
          .state('app.listMailDomain', {
            url: '/mailDomains',
            templateUrl: './views/mailDomain/listMailDomainView.html',
            controller: 'mailDomainCtrl as mailDomain'
          })
          .state('app.addMailDomain', {
            url: '/mailDomain/addDomain',
            templateUrl: './views/mailDomain/addMailDomainView.html',
            controller: 'mailDomainCtrl as mailDomain'
          })
          .state('app.editMailDomain', {
            url: '/mailDomain/editDomain/:id',
            templateUrl: './views/mailDomain/editMailDomainView.html',
            controller: 'editMailDomainCtrl as editMDomain'
          });
      });
