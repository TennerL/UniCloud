<?php
$approot = (implode('/', array_slice(explode('/',  $_SERVER['PHP_SELF']), 0, 2)));

session_start();
 if (isset($_GET['token'])){
   $_SESSION['id'] = $_GET['token'];
   $_SESSION['return_uri'] = $_SERVER['PHP_SELF'];
   header('Location: '.$approot.'/Authorization/confirm.php');}
   else if (!isset($_SESSION['loggedin'])) {
   $_SESSION['return_uri'] = $_SERVER['PHP_SELF'];
   header('Location: '.$approot.'/Authorization/authenticate.php');
   exit();
}
?>

<!doctype html>
<html lang="de">
  <head>
    <?php include($headContent); ?>

    <link rel="icon" type="image/x-icon" href="<?php echo $approot ?>/ressources/images/favicon.png" />

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="ressources/images/android-desktop.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Material Design Lite">
    <link rel="apple-touch-icon-precomposed" href="ressources/images/ios-desktop.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="ressources/images/touch/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#3372DF">

    <link rel="shortcut icon" href="/../ressources/images/favicon.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.grey-teal.min.css" /> 
    <link rel="stylesheet" type="text/css" href="<?php echo $approot ?>/ressources/css/styleMaster.css">

    <?php include($clientscriptBlock); ?>
  </head>

  <body>
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
      <header class="demo-header mdl-layout__header mdl-color--grey-100 mdl-color-text--grey-600">
        <div style="background-color:#404040" class="mdl-layout__header-row">
          <span style="color:white;" class="mdl-layout-title"> UniCloud :: TEST S001 </span>
          <div class="mdl-layout-spacer"></div>
          <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
            <label class="mdl-button mdl-js-button mdl-button--icon" for="search">
              <i class="material-icons">search</i>
            </label>
            <div class="mdl-textfield__expandable-holder">
              <input class="mdl-textfield__input" type="text" id="search">
              <label class="mdl-textfield__label" for="search">Enter your query...</label>
            </div>
          </div>
          <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
            <i class="material-icons">more_vert</i>
          </button>
          <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
            <li class="mdl-menu__item">Legal information</li>
          </ul>
        </div>
      </header>
      <div class="demo-drawer mdl-layout__drawer mdl-color--grey-900 mdl-color-text--grey-50">
        <header class="demo-drawer-header">
          <img src="<?php echo $approot ?>/ressources/images/SMPTE_Color_Bars.svg.png" width="200px" /> 
          <div class="demo-avatar-dropdown">
            <span><?php if(isset($_SESSION['name'])){echo $_SESSION['name'];}?></span>
            <div class="mdl-layout-spacer"></div>
            <button id="accbtn" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon">
              <i class="material-icons" role="presentation">arrow_drop_down</i>
              <span class="visuallyhidden">Accounts</span>
            </button>
            <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" id="drawer" for="accbtn">
            <li class="mdl-menu__item"><a a class="mdl-navigation__link dialog-button"><i class="mdl-color-text--grey-400 material-icons" role="presentation">qr_code_2</i>QR-Code anzeigen</a></li>
              <li class="mdl-menu__item"><a a class="mdl-navigation__link" href="../../Authorization/logout.php"><i class="mdl-color-text--grey-400 material-icons" role="presentation">logout</i>Logout</a></li>
            </ul>
          </div>
        </header>
        <nav class="demo-navigation mdl-navigation mdl-color--grey-800">
          <a class="mdl-navigation__link" href="../FileManagement/"><i class="mdl-color-text material-icons" role="presentation">upload</i>File Management</a>
          <div class="mdl-layout-spacer"></div>
        </nav>
      </div>
      <main class="mdl-layout__content mdl-color--grey-100" style="background-color:#323232 !important;">
      <!-- <img style="margin:auto; margin-top: 25px; display:block" src="<?php echo $approot ?>/ressources/images/ooii.gif" width="400px" />  -->
      <?php include($mainContent); ?>
      </main>
      <dialog id="dialog" class="mdl-dialog">
              <div class="mdl-dialog__content">
                <img src="https://api.qrserver.com/v1/create-qr-code/?data=https://nihonsaba.net<?php echo ($_SERVER['PHP_SELF'].'?token='.$_SESSION["id"]);?>&amp;size=200x200" alt="" title="HELLO" />
              </div>
              <div class="mdl-dialog__actions">
                <button style="margin:auto;"type="button" class="mdl-button">Close</button>
              </div>
            </dialog>
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <script>
      (function() {
        'use strict';
        var dialogButton = document.querySelector('.dialog-button');
        var dialog = document.querySelector('#dialog');
        if (! dialog.showModal) {
          dialogPolyfill.registerDialog(dialog);
        }
        dialogButton.addEventListener('click', function() {
          dialog.showModal();
        });
        dialog.querySelector('button:not([disabled])')
        .addEventListener('click', function() {
          dialog.close();
        });
      }());
      <?php include($startupScript); ?>
    </script>
  </body>
</html>
