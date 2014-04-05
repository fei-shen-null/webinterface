<div class="centered">
    <div class="left-box">
        <h2>Server Software</h2>

        <div class="cs-message">

            <table class="cs-message-content">
                <tr>
                    <td class="td-with-image">
                        Webserver
                    </td>
                    <td>
                        <div class="resourceheader">
                            <div class="title">
                                <img class="res-header-icon" src="<?php echo WPNXM_IMAGES_DIR; ?>nginx.png" alt="Nginx Icon" />
                                <a href="http://nginx.org/">
                                    <b>Nginx</b>
                                </a>
                                <span class="version"><?php echo $nginx_version; ?></span>
                            </div>
                            <div class="description">
                                <small>Nginx [engine x] is a high performance http and reverse proxy server, as well as a mail proxy server written by Igor Sysoev.</small>
                            </div>
                            <div class="license">
                                <p>
                                    License: <a href="http://nginx.org/LICENSE">2-clause BSD-like license</a>
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <table class="cs-message-content">
                <tr>
                    <td class="td-with-image">
                        Scripting Language
                    </td>
                    <td>
                        <div class="resourceheader">
                            <div class="title">
                                <img class="res-header-icon" src="<?php echo WPNXM_IMAGES_DIR; ?>php.png" alt="PHP Icon" />
                                <a href="http://php.net/">
                                    <b>PHP</b>
                                </a>
                                <span class="version"><?php echo $php_version; ?></span>
                            </div>
                            <div class="description"><small>PHP is a widely-used general-purpose scripting language that is especially suited for Web development and can be embedded into HTML.</small>
                            </div>
                            <div class="license"><p>
                                    License: <a href="http://php.net/license/index.php">PHP License</a>
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <table class="cs-message-content">
                <tr>
                    <td class="td-with-image">
                        SQL Database
                    </td>
                    <td>
                        <div class="resourceheader">
                            <div class="title">
                                <img class="res-header-icon" src="<?php echo WPNXM_IMAGES_DIR ?>mariadb.png" alt="MariaDB Icon" />
                                <a href="http://mariadb.org/">
                                    <b>MariaDB</b>
                                </a>
                                <span class="version"><?php echo $mariadb_version; ?></span>
                            </div>
                            <div class="description"><small>MariaDB is a fork of the world's most popular open source database MySQL by the original author. MariaDb is a binary drop-in replacement for MySQL.</small>
                            </div>
                            <div class="license"><p>
                                    License: <a href="http://kb.askmonty.org/en/mariadb-license/">GNU/GPL v2</a>
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

             <?php if ($mongodb_installed === true) { ?>
            <table class="cs-message-content">
                <tr>
                    <td class="td-with-image">
                        NoSQL Database
                    </td>
                    <td>
                        <div class="resourceheader">
                            <div class="title">
                                <img class="res-header-icon" src="<?php echo WPNXM_IMAGES_DIR; ?>mongodb.png" alt="MongoDB Icon" height="16" width="16" />
                                <a href="http://mongodb.org/">
                                    <b>MongoDB</b>
                                </a>
                                <span class="version"><?php echo $mongodb_version; ?></span>
                            </div>
                            <div class="description"><small>MongoDB (from "humongous") is a scalable, high-performance, open source NoSQL database. {name: "Mongo", type: "DB"}</small>
                            </div>
                            <div class="license"><p>
                                    License: <a href="http://www.mongodb.org/about/licensing/">GNU/AGPL v3</a>
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <?php } ?>

             <?php if ($memcached_installed === true) { ?>
            <table class="cs-message-content">
                <tr>
                    <td class="td-with-image">
                        Memory Cache
                    </td>
                    <td>
                        <div class="resourceheader">
                            <div class="title">
                                <img class="res-header-icon" src="<?php echo WPNXM_IMAGES_DIR; ?>report.png" alt="Report Icon" />
                                <a href="http://memcached.org/">
                                    <b>Memcached</b>
                                </a>
                                <span class="version"><?php echo $memcached_version; ?></span>
                            </div>
                            <div class="description"><small>Memcached is a high-performance, distributed memory object caching system. Originally intended for speeding up applications by alleviating database load.</small>
                            </div>
                            <div class="license"><p>
                                    License: <a href="https://github.com/memcached/memcached/blob/master/LICENSE/">New BSD License</a>
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <?php } ?>

            <table class="cs-message-content">
                <tr>
                    <td class="td-with-image">
                        Debugger &nbsp; &amp; Profiler
                    </td>
                    <td>
                        <div class="resourceheader">
                            <div class="title">
                                <img class="res-header-icon" src="<?php echo WPNXM_IMAGES_DIR; ?>xdebug.png" alt="Xdebug Icon" />
                                <a href="http://xdebug.org/">
                                    <b>Xdebug</b>
                                </a>
                                <span class="version"><?php echo $xdebug_version; ?></span>
                            </div>
                            <div class="description"><small>The Xdebug extension for PHP helps you debugging your scripts by providing a lot of valuable debug information.</small>
                            </div>
                            <div class="license"><p>
                                    License: <a href="http://xdebug.org/license.php">Xdebug License</a>
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

        </div>
    </div>

    <div class="right-box">
        <h2>Configuration</h2>
        <div class="cs-message">

            <table class="cs-message-content">
                <tr>
                    <td colspan="2">
                        <div class="resourceheader2 bold">
                            <?php echo $nginx_status; ?> Nginx
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Host : Port</td>
                    <td class="pull-right"><?php echo $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']; ?></td>
                </tr>
                <tr>
                    <td>Your IP</td>
                    <td class="pull-right"><?php echo $my_ip; ?></td>
                </tr>
                <tr>
                   <td colspan="2">
                        <span class="pull-left">Directory</span>
                        <span class="pull-right"><?php echo WPNXM_DIR . '\bin\nginx'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="pull-left">Config</span>
                        <span class="pull-right"><?php echo WPNXM_DIR . '\bin\nginx\conf\nginx.conf'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="right">

                        <a class="btn btn-default btn-sm pull-left"
                           href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=stop&daemon=nginx'; ?>">
                            <img alt="Start Nginx" src="/webinterface/assets/img/action_run.png" class="res-header-icon">
                        </a>

                        <a class="btn btn-default btn-sm btn-margin-left pull-left"
                           href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=start&daemon=nginx'; ?>">
                             <img alt="Stop Nginx" src="/webinterface/assets/img/action_stop.png" class="res-header-icon">
                        </a>

                        <a class="btn btn-default btn-sm"
                           href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=config#nginx'; ?>">Configure</a>

                        <a class="btn btn-default btn-sm"
                        <?php
                        if (!is_file(WPNXM_DIR . '\logs\access.log')) {
                            echo "onclick=\"alert('The Nginx Access Log not available. File was not found.'); return false;\"";
                        } else {
                            $url = WPNXM_WEBINTERFACE_ROOT . 'index.php?page=openfile&file=nginx-access-log';
                            echo "onclick=\"ajaxGET('$url')\"";
                        }
                        ?>
                        >Access Log</a>

                        <a class="btn btn-default btn-sm"
                        <?php
                        if (!is_file(WPNXM_DIR . '\logs\error.log')) {
                            echo "onclick=\"alert('The Nginx Error Log not available. File was not found.'); return false;\"";
                        } else {
                            $url = WPNXM_WEBINTERFACE_ROOT . 'index.php?page=openfile&file=nginx-error-log';
                            echo "onclick=\"ajaxGET('$url')\"";
                        }
                        ?>
                        >Error Log</a>

                    </td>
                </tr>
            </table>

            <table class="cs-message-content">
                <tr>
                    <td colspan="2">
                        <div class="resourceheader2 bold">
                        <?php echo $php_status; ?> PHP
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="width-40 left">Host : Port</td>
                    <td class="pull-right"><?php echo $_SERVER['SERVER_NAME'] .':'. $_SERVER['SERVER_PORT']; ?></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="pull-left">Directory</span>
                        <span class="pull-right"><?php echo WPNXM_DIR . '\bin\php'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="pull-left">Config</span>
                        <span class="pull-right"><?php echo get_cfg_var('cfg_file_path'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="right" colspan="2">
                        <a class="btn btn-default btn-sm pull-left" href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=start&daemon=php'; ?>">
                            <img alt="Start PHP" src="/webinterface/assets/img/action_run.png" class="res-header-icon">
                        </a>
                        <a class="btn btn-default btn-sm btn-margin-left pull-left" href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=stop&daemon=php'; ?>">
                            <img alt="Stop PHP" src="/webinterface/assets/img/action_stop.png" class="res-header-icon">
                        </a>
                        <a class="btn btn-default btn-sm" href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=config#php'; ?>">Configure</a>
                        <a class="btn btn-default btn-sm"
                        <?php
                        if (!is_file(WPNXM_DIR . '\logs\php_error.log')) {
                            echo "onclick=\"alert('The PHP Error Log is not available. File was not found.'); return false;\"";
                        } else {
                            $url = WPNXM_WEBINTERFACE_ROOT . 'index.php?page=openfile&file=php-error-log';
                            echo "onclick=\"ajaxGET('$url')\"";
                        }
                        ?>
                        >Show Log</a>

                        <a class="btn btn-default btn-sm" href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=phpinfo'; ?>">Show phpinfo()</a>
                    </td>
                </tr>
            </table>

            <table class="cs-message-content">
                <tr>
                    <td colspan="2">
                        <div class="resourceheader2 bold">
                        <?php echo $mariadb_status; ?> MariaDB
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="width-40 left">Host : Port</td>
                    <td class="pull-right">localhost:3306</td>
                </tr>
                <tr>
                    <td colspan="1">Username | Password</td>
                    <td class="pull-right"><span class="red">root</span> | <span class="red"><?php echo $mariadb_password; ?></span></td>
                </tr>
                <tr>
                     <td colspan="2">
                        <span class="pull-left">Directory</span>
                        <span class="pull-right"><?php echo WPNXM_DIR . '\bin\mariadb'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span class="pull-left">Config</span>
                        <span class="pull-right"><?php echo WPNXM_DIR . '\bin\mariadb\my.ini'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="right">
                        <a class="btn btn-default btn-sm pull-left" href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=start&daemon=mariadb'; ?>">
                            <img alt="Start MariaDb" src="/webinterface/assets/img/action_run.png" class="res-header-icon">
                        </a>

                        <a class="btn btn-default btn-sm btn-margin-left pull-left" href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=stop&daemon=mariadb'; ?>">
                            <img alt="Stop MariaDb" src="/webinterface/assets/img/action_stop.png" class="res-header-icon">
                        </a>
                        <a class="btn btn-default btn-sm" href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=config#mariadb'; ?>">Configure</a>

                        <a class="btn btn-default btn-sm"
                        <?php
                        if (!is_file(WPNXM_DIR . '\logs\mariadb_error.log')) {
                            echo "onclick=\"alert('The MariaDB Error Log is not available. File was not found.'); return false;\"";
                        } else {
                            $url = WPNXM_WEBINTERFACE_ROOT . 'index.php?page=openfile&file=mariadb-error-log';
                            echo "onclick=\"ajaxGET('$url')\"";
                        }
                        ?>
                        >Show Log</a>

                        <?php if (class_exists('mysqli')) { ?> <a class="btn btn-default btn-sm" href="index.php?page=resetpw" rel="modal:open">Reset Password</a> <?php } ?>
                    </td>
                </tr>
            </table>

            <?php if ($mongodb_installed === true) { ?>
            <table class="cs-message-content">
                <tr>
                    <td>
                        <div class="resourceheader2 bold">
                        <?php echo $mongodb_status; ?> <?php echo $phpext_mongo_status; ?> MongoDB
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><span class="pull-left">Host : Port</span>
                        <span class="pull-right">localhost:27017</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Username | Password</span>
                        <span class="red pull-right">root</span> | <span class="red"><?php echo $mongodb_password; ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Directory</span>
                        <span class="pull-right"><?php echo WPNXM_DIR . '\bin\mongodb'; ?></span>
                    </td>
                </tr>
                 <tr>
                    <td>
                        <span class="pull-left">Config</span>
                        <span class="pull-right"><?php echo WPNXM_DIR . '\bin\mongodb\mongodb.conf'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="right">
                        <a class="btn btn-default btn-sm pull-left" href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=start&daemon=php'; ?>">
                                <img alt="Start MongoDB" src="/webinterface/assets/img/action_run.png" class="res-header-icon">
                         </a>
                         <a class="btn btn-default btn-sm btn-margin-left pull-left" href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=stop&daemon=php'; ?>">
                            <img alt="Stop MongoDB" src="/webinterface/assets/img/action_stop.png" class="res-header-icon">
                         </a>
                        <a class="btn btn-default btn-sm" href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=config#mongodb'; ?>">Configure</a>
                        <a class="btn btn-default btn-sm"
                        <?php
                        if (!is_file(WPNXM_DIR . '\logs\mongodb.log')) {
                            echo " onclick=\"alert('The MongoDB Log is not available. File was not found.'); return false;\"";
                        } else {
                            $url = WPNXM_WEBINTERFACE_ROOT . 'index.php?page=openfile&file=mongodb-log';
                            echo "onclick=\"ajaxGET('$url')\"";
                        }
                        ?>
                        >Show Log</a>

                        <?php if (class_exists('mysqli')) { ?>
                            <a class="btn btn-default btn-sm" href="index.php?page=resetpw&amp;db=mongodb" rel="modal:open">Reset Password</a>
                        <?php } ?>

                    </td>
                </tr>
            </table>
            <?php } ?>

            <?php if ($memcached_installed === true) { ?>
            <table class="cs-message-content">
                <tr>
                    <td colspan="2">
                        <div class="resourceheader2 bold">
                        <?php echo $memcached_status; ?> <?php echo $phpext_memcached_status; ?> Memcached
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="width-40 left">Host : Port</td>
                    <td class="pull-right">localhost:11211</td>
                </tr>
                <tr>
                    <td>PHP Extension</td>
                    <td class="pull-right"><?php echo $phpext_memcached_installed; ?></td>
                </tr>
                <tr>
                    <td colspan="2" class="right">
                        <a class="btn btn-default btn-sm" href="index.php?page=config#memcached">Configure</a>
                    </td>
                </tr>
            </table>
            <?php } ?>

            <table class="cs-message-content">
                <tr>
                    <td colspan="2">
                        <div class="resourceheader2 bold">
                         <?php echo $xdebug_status; ?> Xdebug
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="width-40 left">Host : Port</td>
                    <td class="pull-right">localhost:9000</td>
                </tr>
                <tr>
                    <td>Installed &amp; Configured</td>
                    <td class="pull-right"><?php echo $phpext_xdebug_installed; ?>
                    </td>
                </tr>
                <tr>
                    <td>Extension Type</td>
                    <td class="pull-right"><?php echo $xdebug_extension_type; ?></td>
                </tr>
                <tr>
                    <td colspan="2" class="right">
                        <?php
                        if($xdebug_profiler_active == true) {
                            echo '<a class="btn btn-success btn-sm pull-left">Profiler On</a>';
                        } else {
                            echo '<a class="btn btn-default btn-sm pull-left">Profiler Off</a>';
                        }
                        ?>
                        <a class="btn btn-default btn-sm" href="<?php echo WPNXM_ROOT; ?>webgrind/">Open Webgrind</a>
                        <a class="btn btn-default btn-sm" href="index.php?page=config#xdebug">Configure</a>
                    </td>
                </tr>
            </table>

        </div>
    </div>

</div>
