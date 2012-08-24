<?php
   /**
    * WPИ-XM Server Stack - Webinterface
    * Jens-André Koch © 2010 - onwards
    * http://wpn-xm.org/
    *
    *        _\|/_
    *        (o o)
    +-----oOO-{_}-OOo------------------------------------------------------------------+
    |                                                                                  |
    |    LICENSE                                                                       |
    |                                                                                  |
    |    WPИ-XM Serverstack is free software; you can redistribute it and/or modify    |
    |    it under the terms of the GNU General Public License as published by          |
    |    the Free Software Foundation; either version 2 of the License, or             |
    |    (at your option) any later version.                                           |
    |                                                                                  |
    |    WPИ-XM Serverstack is distributed in the hope that it will be useful,         |
    |    but WITHOUT ANY WARRANTY; without even the implied warranty of                |
    |    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                 |
    |    GNU General Public License for more details.                                  |
    |                                                                                  |
    |    You should have received a copy of the GNU General Public License             |
    |    along with this program; if not, write to the Free Software                   |
    |    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA    |
    |                                                                                  |
    +----------------------------------------------------------------------------------+
    *
    * @license    GNU/GPL v2 or (at your option) any later version..
    * @author     Jens-André Koch <jakoch@web.de>
    * @copyright  Jens-André Koch (2010 - 2012)
    * @link       http://wpn-xm.org/
    */
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>WPИ-XM Serverstack for Windows</title>
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <meta name="description" content="WPИ-XM Serverstack for Windows - Webinterface.">
    <link rel="shortcut icon" href="http://wpn-xm.org/favicon.ico" />
    <link type="text/css" href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/style.css"  media="screen, projection" />
    <script type="text/javascript" src="assets/js/wpnxm.js"></script>   
    <?php if(isset($load_jquery) && $load_jquery === true) { ?>
    <!-- jQuery & jQuery UI -->
    <script type="text/javascript" src="assets/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <!-- jQuery Plugins -->
    <script type="text/javascript" src="assets/js/jquery.organicTabs.js"></script>
    <script type="text/javascript" src="assets/js/jquery.treeTable.js"></script>
    <script type="text/javascript" src="assets/js/jquery.jeditable.js"></script>
    <script type="text/javascript" src="assets/js/jquery.modal.js"></script>
    <link type="text/css" href="assets/css/jquery.treeTable.css" rel="stylesheet" />
    <?php } ?>
</head>
<body>

<!-- This css style will come alive only, when javascript is disabled.
     Its for displaying a message for all the security nerds with disabled javascript.
     We need this reminder, because the WPN-XM configuration pages depend on AJAX. -->
<noscript><style type="text/css">
  #page{ display:none; }
  #javascript-off-errorbox { display:block; font-size:20px; color:red; }
</style></noscript>

<div class="page-wrapper">

    <div class="center">

        <h1 class="headline">
            WPИ-XM<br/>
            Serverstack for Windows<br/>
            <small>Version <?php echo WPNXM_VERSION; ?></small>
        </h1>

        <?php           
            viewhelper::renderMenu();
            viewhelper::renderWelcome();
        ?>

        <div id="javascript-off-errorbox">
          <div class="error">
          Please enable "javascript" in your browser in order to use this application.
          </div>
        </div>

        <div class="content-centered">
