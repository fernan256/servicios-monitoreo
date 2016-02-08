<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Web Services</title>
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css">
  </head>
  <body ng-app="webServices">
    <nav class="navbar navbar-default">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Servicios y Monitoreo</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Home</a></li>
            <li><a href="#">DNS</a></li>
            <li><a href="#">Mail</a></li>
          </ul>
          <ul class="collapse nav navbar-nav nav-collapse" id="nav-collapse1">
            <li><a href="#">Web design</a></li>
            <li><a href="#">Development</a></li>
            <li><a href="#">Graphic design</a></li>
            <li><a href="#">Print</a></li>
            <li><a href="#">Motion</a></li>
            <li><a href="#">Mobile apps</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->
    <div class="container">
      <div ui-view></div>
    </div>
  </body>
  <script src="bower_components/angular/angular.min.js"></script>
  <script src="bower_components/angular-animate/angular-animate.min.js"></script>
  <script src="bower_components/angular-strap/dist/angular-strap.min.js"></script>
  <script src="bower_components/angular-strap/dist/angular-strap.tpl.min.js"></script>
  <script src="bower_components/angular-ui-router/release/angular-ui-router.min.js"></script>
  <script src="bower_components/ng-resource/dist/ng-resource.min.js"></script>
  <script src="scripts/app.js"></script>
  <script src="scripts/controllers/domainController.js"></script>
  <script src="scripts/controllers/indexController.js"></script>
  <script src="scripts/controllers/recordController.js"></script>
  <script src="scripts/controllers/addMasterZoneCtrl.js"></script>
  <script src="scripts/controllers/addSlaveZoneCtrl.js"></script>
  <script src="scripts/controllers/mailboxController.js"></script>
  <script src="scripts/controllers/editMailboxController.js"></script>
  <script src="scripts/filters/yesNo.js"></script>
</html>
