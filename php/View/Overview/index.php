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

            <?php if ($postgresql_installed === true) { ?>
            <table class="cs-message-content">
                <tr>
                    <td class="td-with-image">
                        SQL Database
                    </td>
                    <td>
                        <div class="resourceheader">
                            <div class="title">
                                <img class="res-header-icon" src="<?php echo WPNXM_IMAGES_DIR; ?>postgresql.png" alt="PostgreSQL Icon" height="16" width="16" />
                                <a href="http://www.postgresql.org/">
                                    <b>PostgreSQL</b>
                                </a>
                                <span class="version"><?php echo $postgresql_version; ?></span>
                            </div>
                            <div class="description"><small>PostgreSQL is a powerful, open source object-relational database system.</small>
                            </div>
                            <div class="license"><p>
                                    License: <a href="http://www.postgresql.org/about/licence/">PostgreSQL Licence</a>
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

            <?php if ($xdebug_installed === true) { ?>
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
            <?php } ?>

        </div>
    </div>

    <div class="right-box">
        <h2>Configuration</h2>
        <div class="cs-message">

            <table class="cs-message-content">
                <tr>
                    <td>
                        <span class="resourceheader2 bold"> <?php echo $nginx_status_icon; ?> Nginx</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Host : Port</span>
                        <span class="pull-right"><?php echo $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']; ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Your IP</span>
                        <span class="pull-right"><?php echo $my_ip; ?></span>
                    </td>
                </tr>
                <tr>
                   <td>
                        <span class="pull-left">Directory</span>
                        <span class="pull-right"><?php echo WPNXM_DIR . 'bin\nginx'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Config</span>
                        <span class="pull-right"><?php echo WPNXM_DIR . 'bin\nginx\conf\nginx.conf'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="right">

                        <?php if($server_is_nginx === false) { var_dump($php_status_icon); ?>
                        <a class="btn btn-default btn-sm pull-left"
                           rel="tooltip" data-original-title="Start Nginx"
                           href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=stop&daemon=nginx'; ?>">
                           <img alt="Start Nginx" src="<?=WPNXM_IMAGES_DIR?>action_run.png" class="res-header-icon">
                        </a>

                        <a class="btn btn-default btn-sm btn-margin-left pull-left"
                           rel="tooltip" data-original-title="Stop Nginx"
                           href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=start&daemon=nginx'; ?>">
                           <img alt="Stop Nginx" src="<?=WPNXM_IMAGES_DIR?>action_stop.png" class="res-header-icon">
                        </a>
                        <?php } else { ?>
                         <a class="btn btn-default btn-sm btn-margin-left pull-left restart-btn"
                            rel="tooltip" data-original-title="Restart Nginx"
                            href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=restart&daemon=nginx'; ?>">
                            <img alt="Restart Nginx" src="<?=WPNXM_IMAGES_DIR?>action_restart.png" class="res-header-icon">
                        </a>
                        <?php } ?>

                        <a class="btn btn-default btn-sm"
                        <?php
                        if (!is_file(WPNXM_DIR . 'logs\access.log')) {
                            echo "onclick=\"alert('The Nginx Access Log not available. File was not found.'); return false;\"";
                        } else {
                            $url = WPNXM_WEBINTERFACE_ROOT . 'index.php?page=openfile&file=nginx-access-log';
                            echo "onclick=\"ajaxGET('$url')\"";
                        }
                        ?>
                        >Access Log</a>

                        <a class="btn btn-default btn-sm"
                        <?php
                        if (!is_file(WPNXM_DIR . 'logs\error.log')) {
                            echo "onclick=\"alert('The Nginx Error Log not available. File was not found.'); return false;\"";
                        } else {
                            $url = WPNXM_WEBINTERFACE_ROOT . 'index.php?page=openfile&file=nginx-error-log';
                            echo "onclick=\"ajaxGET('$url')\"";
                        }
                        ?>
                        >Error Log</a>

                        <?php if (FEATURE_3 === true) { ?>
                        <a class="btn btn-default btn-sm"
                           href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=config#nginx'; ?>">Configure</a>
                        <?php } ?>
                    </td>
                </tr>
            </table>

            <table class="cs-message-content">
                <tr>
                    <td>
                        <span class="resourceheader2 bold"> <?php echo $php_status_icon; ?> PHP</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Host : Port</span>
                        <span class="pull-right"><?php echo $_SERVER['SERVER_NAME'] .':'. $_SERVER['SERVER_PORT']; ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Directory</span>
                        <span class="pull-right"><?php echo WPNXM_DIR . 'bin\php'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Config</span>
                        <span class="pull-right"><?php echo get_cfg_var('cfg_file_path'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="right">
                        <?php if($server_is_nginx === false) { ?>
                        <a class="btn btn-default btn-sm pull-left"
                           rel="tooltip" data-original-title="Start PHP"
                           href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=start&daemon=php'; ?>">
                           <img alt="Start PHP" src="<?=WPNXM_IMAGES_DIR?>action_run.png" class="res-header-icon">
                        </a>
                        <a class="btn btn-default btn-sm btn-margin-left pull-left"
                           rel="tooltip" data-original-title="Stop PHP"
                           href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=stop&daemon=php'; ?>">
                           <img alt="Stop PHP" src="<?=WPNXM_IMAGES_DIR?>action_stop.png" class="res-header-icon">
                        </a>
                        <?php } else { ?>
                         <a class="btn btn-default btn-sm btn-margin-left pull-left restart-btn"
                            rel="tooltip" data-original-title="Restart PHP"
                            href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=restart&daemon=php'; ?>">
                             <img alt="Restart Nginx" src="<?=WPNXM_IMAGES_DIR?>action_restart.png" class="res-header-icon">
                        </a>
                        <?php } ?>

                        <a class="btn btn-default btn-sm" href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=phpinfo'; ?>">Show phpinfo()</a>
                        <a class="btn btn-default btn-sm"
                        <?php
                        if (!is_file(WPNXM_DIR . 'logs\php_error.log')) {
                            echo "onclick=\"alert('The PHP Error Log is not available. File was not found.'); return false;\"";
                        } else {
                            $url = WPNXM_WEBINTERFACE_ROOT . 'index.php?page=openfile&file=php-error-log';
                            echo "onclick=\"ajaxGET('$url')\"";
                        }
                        ?>
                        >Show Log</a>
                        <a class="btn btn-default btn-sm" href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=config#php'; ?>">Configure</a>
                    </td>
                </tr>
            </table>

            <table class="cs-message-content">
                <tr>
                    <td>
                        <span class="resourceheader2 bold"><?php echo $mariadb_status_icon; ?> MariaDB</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Host : Port</span>
                        <span class="pull-right">localhost:3306</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Username | Password</span>
                        <span class="pull-right"><span class="red">root</span> | <span class="red"><?php echo $mariadb_password; ?></span></span>
                    </td>
                </tr>
                <tr>
                     <td>
                        <span class="pull-left">Directory</span>
                        <span class="pull-right"><?php echo WPNXM_DIR . 'bin\mariadb'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Config</span>
                        <span class="pull-right"><?php echo WPNXM_DIR . 'bin\mariadb\my.ini'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="right">
                        <?php if($server_is_nginx === false) { ?>
                        <a class="btn btn-default btn-sm pull-left"
                           rel="tooltip" data-original-title="Start MariaDb"
                           href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=start&daemon=mariadb'; ?>">
                           <img alt="Start MariaDb" src="<?=WPNXM_IMAGES_DIR?>action_run.png" class="res-header-icon">
                        </a>
                        <a class="btn btn-default btn-sm btn-margin-left pull-left"
                           rel="tooltip" data-original-title="Stop MariaDb"
                           href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=stop&daemon=mariadb'; ?>">
                           <img alt="Stop MariaDb" src="<?=WPNXM_IMAGES_DIR?>action_stop.png" class="res-header-icon">
                        </a>
                        <?php } else { ?>
                         <a class="btn btn-default btn-sm btn-margin-left pull-left restart-btn"
                            rel="tooltip" data-original-title="Restart MariaDb"
                            href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=restart&daemon=mariadb'; ?>">
                            <img alt="Restart Nginx" src="<?=WPNXM_IMAGES_DIR?>action_restart.png" class="res-header-icon">
                        </a>
                        <?php } ?>

                        <?php if (class_exists('mysqli', false)) { ?>
                            <a class="btn btn-default btn-sm" href="index.php?page=resetpw&component=mariadb"
                               data-toggle="modal" data-target="#myModal">Reset Password</a>
                        <?php } ?>

                        <a class="btn btn-default btn-sm"
                        <?php
                        if (!is_file(WPNXM_DIR . 'logs\mariadb_error.log')) {
                            echo "onclick=\"alert('The MariaDB Error Log is not available. File was not found.'); return false;\"";
                        } else {
                            $url = WPNXM_WEBINTERFACE_ROOT . 'index.php?page=openfile&file=mariadb-error-log';
                            echo "onclick=\"ajaxGET('$url')\"";
                        }
                        ?>
                        >Show Log</a>

                        <?php if (FEATURE_3 === true) { ?>
                        <a class="btn btn-default btn-sm" href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=config#mariadb'; ?>">Configure</a>
                        <?php } ?>
                    </td>
                </tr>
            </table>

            <?php if ($mongodb_installed === true) { ?>
            <table class="cs-message-content">
                <tr>
                    <td>
                        <span class="resourceheader2 bold"><?php echo $mongodb_status_icon; ?> <?php echo $phpext_mongo_status_icon; ?> MongoDB</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Host : Port</span>
                        <span class="pull-right">localhost:27017</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Username | Password</span>
                        <span class="pull-right"><span class="red">root</span> | <span class="red"><?php # echo $mongodb_password; ?></span></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Directory</span>
                        <span class="pull-right"><?php echo WPNXM_DIR . 'bin\mongodb'; ?></span>
                    </td>
                </tr>
                 <tr>
                    <td>
                        <span class="pull-left">Config</span>
                        <span class="pull-right"><?php echo WPNXM_DIR . 'bin\mongodb\mongodb.conf'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="right">
                        <?php if($server_is_nginx === false) { ?>
                        <a class="btn btn-default btn-sm pull-left"
                           rel="tooltip" data-original-title="Start MongoDb"
                           href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=start&daemon=mongodb'; ?>">
                           <img alt="Start MongoDB" src="<?=WPNXM_IMAGES_DIR?>action_run.png" class="res-header-icon">
                        </a>
                        <a class="btn btn-default btn-sm btn-margin-left pull-left"
                           rel="tooltip" data-original-title="Stop MongoDb"
                           href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=stop&daemon=mongodb'; ?>">
                           <img alt="Stop MongoDB" src="<?=WPNXM_IMAGES_DIR?>action_stop.png" class="res-header-icon">
                        </a>
                        <?php } else { ?>
                         <a class="btn btn-default btn-sm btn-margin-left pull-left restart-btn"
                            rel="tooltip" data-original-title="Restart MongoDb."
                            href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=restart&daemon=mongodb'; ?>">
                            <img alt="Restart Nginx" src="<?=WPNXM_IMAGES_DIR?>action_restart.png" class="res-header-icon">
                        </a>
                        <?php } ?>

                        <?php if (\Webinterface\Helper\Daemon::isRunning('mongodb')) { ?>
                            <a class="btn btn-default btn-sm" href="http://localhost:28017/">Show WebAdmin</a>
                        <?php } ?>

                        <?php if (class_exists('mysqli', false)) { ?>
                            <a class="btn btn-default btn-sm" href="index.php?page=resetpw&amp;component=mongodb"
                               data-toggle="modal" data-target="#myModal">Reset Password</a>
                        <?php } ?>

                        <a class="btn btn-default btn-sm"
                        <?php
                        if (!is_file(WPNXM_DIR . 'logs\mongodb.log')) {
                            echo " onclick=\"alert('The MongoDB Log is not available. File was not found.'); return false;\"";
                        } else {
                            $url = WPNXM_WEBINTERFACE_ROOT . 'index.php?page=openfile&file=mongodb-log';
                            echo "onclick=\"ajaxGET('$url')\"";
                        }
                        ?>
                        >Show Log</a>

                        <?php if (FEATURE_3 === true) { ?>
                        <a class="btn btn-default btn-sm" href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=config#mongodb'; ?>">Configure</a>
                        <?php } ?>
                    </td>
                </tr>
            </table>
            <?php } ?>

            <?php if ($postgresql_installed === true) { ?>
            <table class="cs-message-content">
                <tr>
                    <td>
                        <span class="resourceheader2 bold"><?php echo $postgresql_status_icon; ?> PostgreSQL</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Host : Port</span>
                        <span class="pull-right">localhost:5432</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Username | Password</span>
                        <span class="pull-right"><span class="red">root</span> | <span class="red"><?php echo $postgresql_password; ?></span></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Directory</span>
                        <span class="pull-right"><?php echo WPNXM_DIR . 'bin\pgsql'; ?></span>
                    </td>
                </tr>
                 <tr>
                    <td>
                        <span class="pull-left">Config</span>
                        <span class="pull-right"><?php echo WPNXM_DIR . 'bin\pgsql\pgsql.conf'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="right">
                        <?php if($server_is_nginx === false) { ?>
                        <a class="btn btn-default btn-sm pull-left"
                           rel="tooltip" data-original-title="Start PostgreSQL"
                           href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=start&daemon=postgresql'; ?>">
                           <img alt="Start PgSQL" src="<?=WPNXM_IMAGES_DIR?>action_run.png" class="res-header-icon">
                        </a>
                        <a class="btn btn-default btn-sm btn-margin-left pull-left restart-btn"
                           rel="tooltip" data-original-title="Stop PostgreSQL"
                           href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=stop&daemon=postgresql'; ?>">
                            <img alt="Stop PgSQL" src="<?=WPNXM_IMAGES_DIR?>action_stop.png" class="res-header-icon">
                        </a>
                        <?php } else { ?>
                        <a class="btn btn-default btn-sm btn-margin-left pull-left"
                           rel="tooltip" data-original-title="Restart PostgreSQL"
                           href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview&action=restart&daemon=postgresql'; ?>">
                           <img alt="Restart Nginx" src="<?=WPNXM_IMAGES_DIR?>action_restart.png" class="res-header-icon">
                        </a>
                        <?php } ?>

                        <?php #if (class_exists('mysqli', false)) { ?>
                           <!-- <a class="btn btn-default btn-sm" href="index.php?page=resetpw&amp;component=postgresql"
                               data-toggle="modal" data-target="#myModal">Reset Password</a>
                           -->
                        <?php #} ?>

                        <a class="btn btn-default btn-sm"
                        <?php
                        if (!is_file(WPNXM_DIR . 'logs\pgsql.log')) {
                            echo " onclick=\"alert('The PostgreSQL Log is not available. File was not found.'); return false;\"";
                        } else {
                            $url = WPNXM_WEBINTERFACE_ROOT . 'index.php?page=openfile&file=postgresql-log';
                            echo "onclick=\"ajaxGET('$url')\"";
                        }
                        ?>
                        >Show Log</a>

                        <a class="btn btn-default btn-sm" href="<?php echo WPNXM_WEBINTERFACE_ROOT . 'index.php?page=config#postgresql'; ?>">Configure</a>
                    </td>
                </tr>
            </table>
            <?php } ?>

            <?php if ($memcached_installed === true) { ?>
            <table class="cs-message-content">
                <tr>
                    <td>
                        <span class="resourceheader2 bold">
                        <?php echo $memcached_status_icon; ?> <?php echo $phpext_memcached_status_icon; ?> Memcached
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Host : Port</span>
                        <span class="pull-right">localhost:11211</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class)"pull-left">PHP Extension</span>
                        <span class="pull-right"><?php echo ($phpext_memcached_installed === true) ? 'loaded': 'not loaded'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="right">
                        <a class="btn btn-default btn-sm" href="index.php?page=config#memcached">Configure</a>
                    </td>
                </tr>
            </table>
            <?php } ?>

            <?php if ($xdebug_installed === true) { ?>
            <table class="cs-message-content">
                <tr>
                    <td>
                        <span class="resourceheader2 bold"> <?php echo $xdebug_status_icon; ?> Xdebug </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Host : Port</span>
                        <span class="pull-right">localhost:9000</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Extension Type</span>
                        <span class="pull-right"><?php echo $xdebug_extension_type; ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="pull-left">Installed &amp; Configured</span>
                        <span class="pull-right"><?php echo $phpext_xdebug_installed; ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="right">
                        <a class="btn btn-success btn-sm pull-left"><?php echo ($xdebug_profiler_active === true) ? 'Profiler On' : 'Profiler Off'; ?></a>
                        <a class="btn btn-default btn-sm" href="<?php echo WPNXM_ROOT; ?>/tools/webgrind/">Open Webgrind</a>
                        <a class="btn btn-default btn-sm" href="index.php?page=config#xdebug">Configure</a>
                    </td>
                </tr>
            </table>
            <?php } ?>

        </div>
    </div>

</div>

<script>
$(function(){

    // test, if script on the server is available with a timeout request
    // if the timeout is not reached, we assume the server is running and do the "non-timeout" call to href
    function doGetRequestIfServerIsRunning(title)
    {
        $.ajax({
          url: "index.php",
          type: "HEAD",
          timeout: 2000, // set timeout to 2 sec
          cache: false,
          statusCode: {
              200: function (response) {
                  console.log('Successful restart. ' + title);
                  statusIndicator(title, 'on');
              },
              400: function (response) {
                  alert("Request Timeout!\n\nEnsure Server & PHP are up!");
              },
              0: function (response) {
                  alert("Request Timeout!\n\nEnsure Server & PHP are up!");
              }
          }
        });
    }

    function statusIndicator(name, state)
    {
        var serverName = name.slice(8, -1);
        var msg_running = serverName + " is running.",
            msg_not_running = serverName + " is not running.";
        var stop_icon = "/tools/webinterface/assets/img/status_stop.png",
            start_icon = "/tools/webinterface/assets/img/status_run.png";
        var indicator = $('img[data-original-title^="'+serverName+'"]');

        if(state === 'off') {
          indicator.attr("src", stop_icon).attr("alt", msg_not_running).attr("data-original-title", msg_not_running);
        }

        if(state === 'on') {
          indicator.attr("src", start_icon).attr("alt", msg_running).attr("data-original-title", msg_running);
        }
    }

    function actionRestartDaemon(event)
    {
        var $this = $(this),
            url = $this.attr('href'),
            title = $this.attr('data-original-title');

        $.ajax({
          url: url,
          type: "GET",
          cache: false,
          beforeSend: function() { // set status indicator to off
            statusIndicator(title, 'off')
          }
        }).always(function() {
          setTimeout(console.log("Waiting... 2,5sec"), 2500);
          // run timer, to check if the server is up again
          doGetRequestIfServerIsRunning(title);
        });

        event.preventDefault();
    };

    $("a.restart-btn").click(actionRestartDaemon);
});
</script>
