<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Web Services</title>
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css">
  </head>
  <body ng-app="webServices">
      <!--<div ui-view=></div>-->

      <ui-view name="nav"></ui-view>
      <ui-view></ui-view>
  </body>
  <script src="bower_components/angular/angular.min.js"></script>
  <script src="bower_components/angular-animate/angular-animate.min.js"></script>
  <script src="bower_components/angular-strap/dist/angular-strap.min.js"></script>
  <script src="bower_components/angular-strap/dist/angular-strap.tpl.min.js"></script>
  <script src="bower_components/angular-ui-router/release/angular-ui-router.min.js"></script>
  <script src="bower_components/ng-resource/dist/ng-resource.min.js"></script>
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="bower_components/satellizer/satellizer.js"></script>
  <script src="scripts/app.js"></script>
  <script src="scripts/controllers/authenticateCtrl.js"></script>
  <script src="scripts/controllers/domainCtrl.js"></script>
  <script src="scripts/controllers/homeCtrl.js"></script>
  <script src="scripts/controllers/recordCtrl.js"></script>
  <script src="scripts/controllers/addZoneCtrl.js"></script>
  <script src="scripts/controllers/mailboxCtrl.js"></script>
  <script src="scripts/controllers/editMailboxCtrl.js"></script>
  <script src="scripts/controllers/editRecordCtrl.js"></script>
  <script src="scripts/controllers/mailDomainCtrl.js"></script>
  <script src="scripts/controllers/editMailDomainCtrl.js"></script>
  <script src="scripts/directives/numberConverter.js"></script>
  <script src="scripts/filters/yesNo.js"></script>
</html>
