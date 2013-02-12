<?php
use Webinterface\Helper\Serverstack;
?>

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
                                <img class="res-header-icon" src="<?= WPNXM_IMAGES_DIR ?>/nginx.png" alt="Report Icon" />
                                <a href="http://nginx.org/">
                                    <b>Nginx</b>
                                </a>
                                <span class="version"><?= $nginx_version ?></span>
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
                                <img class="res-header-icon" src="<?= WPNXM_IMAGES_DIR ?>/php.png" alt="Report Icon" />
                                <a href="http://php.net/">
                                    <b>PHP</b>
                                </a>
                                <span class="version"><?= $php_version ?></span>
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
                        Database
                    </td>
                    <td>
                        <div class="resourceheader">
                            <div class="title">
                                <img class="res-header-icon" src="<?= WPNXM_IMAGES_DIR ?>/mariadb.png" alt="Report Icon" />
                                <a href="http://mariadb.org/">
                                    <b>MariaDB</b>
                                </a>
                                <span class="version"><?= $mariadb_version; ?></span>
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

             <?php if(Serverstack::isInstalled('MongoDB') === true) { ?>
            <table class="cs-message-content">
                <tr>
                    <td class="td-with-image">
                        Database
                    </td>
                    <td>
                        <div class="resourceheader">
                            <div class="title">
                                <img class="res-header-icon" src="<?= WPNXM_IMAGES_DIR ?>/mongodb.png" alt="Report Icon" height="16" width="16" />
                                <a href="http://mongodb.org/">
                                    <b>MongoDB</b>
                                </a>
                                <span class="version"><?= $mongodb_version ?></span>
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

             <?php if(Serverstack::isInstalled('Memcached') === true) { ?>
            <table class="cs-message-content">
                <tr>
                    <td class="td-with-image">
                        Memory Cache
                    </td>
                    <td>
                        <div class="resourceheader">
                            <div class="title">
                                <img class="res-header-icon" src="<?= WPNXM_IMAGES_DIR ?>/report.png" alt="Report Icon" />
                                <a href="http://memcached.org/">
                                    <b>Memcached</b>
                                </a>
                                <span class="version"><?= $memcached_version ?></span>
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
                        Debugger Profiler
                    </td>
                    <td>
                        <div class="resourceheader">
                            <div class="title">
                                <img class="res-header-icon" src="<?= WPNXM_IMAGES_DIR ?>/xdebug.png" alt="Report Icon" />
                                <a href="http://xdebug.org/">
                                    <b>Xdebug</b>
                                </a>
                                <span class="version"><?= $xdebug_version ?></span>
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
                            <?= $nginx_status ?> Nginx
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Host : Port</td>
                    <td class="right"><?= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] ?></td>
                </tr>
                <tr>
                    <td>Your IP</td>
                    <td class="right"><?= $my_ip ?></td>
                </tr>
                <tr>
                   <td colspan="5">
                        <span class="floatleft">Directory</span>
                        <span class="floatright"><?= WPNXM_DIR . '\bin\nginx' ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <span class="floatleft">Config</span>
                        <span class="floatright"><?= WPNXM_DIR . '\bin\nginx\conf\nginx.conf' ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="right">
                        <a class="aButton" href="<?= WPNXM_WEBINTERFACE_ROOT . 'index.php?page=config#nginx' ?>">Configure</a>
                        <a class="aButton"
                        <?php
                        if (!is_file(WPNXM_DIR . 'logs\access.log')) {
                            echo "onclick=\"alert('Nginx Access Log not available. File not found.'); return false;\"";
                        }
                        if(!$canOpenLogfileWithEditor()) {
                            echo "onclick=\"alert('Enable the extension by adding extension=php_com_dotnet.dll to your php.ini.'); return false;\"";
                        }
                        ?>
                           href="<?= WPNXM_WEBINTERFACE_ROOT . 'index.php?page=openfile&file=nginx-access-log' ?>">Access Log</a>
                        <a class="aButton"
                        <?php
                        if (!is_file(WPNXM_DIR . 'logs\error.log')) {
                            echo "onclick=\"alert('Nginx Error Log not available. File not found.'); return false;\"";
                        }
                        if(!$canOpenLogfileWithEditor()) {
                            echo "onclick=\"alert('Enable the extension by adding extension=php_com_dotnet.dll to your php.ini.'); return false;\"";
                        }
                        ?>
                           href="<?= WPNXM_WEBINTERFACE_ROOT . 'index.php?page=openfile&file=nginx-error-log' ?>">Error Log</a>
                    </td>
                </tr>
            </table>

            <table class="cs-message-content">
                <tr>
                    <td colspan="2">
                        <div class="resourceheader2 bold">
                        <?= $php_status ?> PHP
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="width-40 left">Host : Port</td>
                    <td class="right"><?= $_SERVER['SERVER_NAME'] ?>:<?= $_SERVER['SERVER_PORT'] ?></td>
                </tr>
                <tr>
                    <td colspan="5">
                        <span class="floatleft">Directory</span>
                        <span class="floatright"><?= WPNXM_WWW_DIR . 'bin\php' ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <span class="floatleft">Config</span>
                        <span class="floatright"><?= get_cfg_var('cfg_file_path') ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="right">
                        <a class="aButton" href="<?= WPNXM_WEBINTERFACE_ROOT . 'index.php?page=config#php' ?>">Configure</a>
                        <a class="aButton"
                        <?php
                        if (!is_file(WPNXM_DIR . 'logs\php_error.log')) {
                            echo "onclick=\"alert('PHP Error Log not available. File not found.'); return false;\"";
                        }
                        if(!$canOpenLogfileWithEditor()) {
                            echo "onclick=\"alert('Enable the extension by adding extension=php_com_dotnet.dll to your php.ini.'); return false;\"";
                        }
                        ?>
                           href="<?= WPNXM_WEBINTERFACE_ROOT . 'index.php?page=openfile&file=php-error-log' ?>">Show Log</a>
                        <a class="aButton" href="<?= WPNXM_WEBINTERFACE_ROOT . 'index.php?page=phpinfo' ?>">Show phpinfo()</a>
                    </td>
                </tr>
            </table>

            <table class="cs-message-content">
                <tr>
                    <td colspan="5">
                        <div class="resourceheader2 bold">
                        <?= $mariadb_status ?> MariaDB
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Host : Port</td>
                    <td colspan="4" class="right">localhost:3306</td>
                </tr>
                <tr>
                    <td colspan="2">Username | Password</td>
                    <td colspan="3" class="right"><span class="red">root</span> | <span class="red"><?= $mariadb_password ?></span></td>
                </tr>
                <tr>
                     <td colspan="5">
                        <span class="floatleft">Directory</span>
                        <span class="floatright"><?= WPNXM_WWW_DIR . 'bin\mariadb'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                        <span class="floatleft">Config</span>
                        <span class="floatright"><?= WPNXM_WWW_DIR . 'mariadb\my.ini'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="right">
                        <a class="aButton" href="<?= WPNXM_WEBINTERFACE_ROOT . 'index.php?page=config#mariadb' ?>">Configure</a>
                        <a class="aButton"
                        <?php
                        if (!is_file(WPNXM_DIR . 'logs\mariadb_error.log')) {
                            echo "onclick=\"alert('MariaDB Error Log not available. File not found.'); return false;\"";
                        }
                        if(!$canOpenLogfileWithEditor()) {
                            echo "onclick=\"alert('Enable the extension by adding extension=php_com_dotnet.dll to your php.ini.'); return false;\"";
                        }
                        ?>
                           href="<?= WPNXM_WEBINTERFACE_ROOT . 'index.php?page=openfile&file=mariadb-error-log' ?>">Show Log</a>
                        <?php if (class_exists('mysqli')) { ?> <a class="aButton" href="index.php?page=resetpw" rel="modal:open">Reset Password</a> <?php } ?>
                    </td>
                </tr>
            </table>

            <?php if(Serverstack::isInstalled('MongoDB') === true) { ?>
            <table class="cs-message-content">
                <tr>
                    <td colspan="5">
                        <div class="resourceheader2 bold">
                        <?= $mongodb_status ?> MongoDB
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Host : Port</td>
                    <td colspan="4" class="right">localhost:27017</td>
                </tr>
                <tr>
                    <td colspan="2">Username | Password</td>
                    <td colspan="3" class="right"><span class="red">root</span> | <span class="red"><?= $mongodb_password ?></span></td>
                </tr>
                <tr>
                    <td colspan="5">
                        <span class="floatleft">Directory</span>
                        <span class="floatright"><?= WPNXM_DIR . '\bin\mongodb'; ?></span>
                    </td>
                </tr>
                 <tr>
                    <td colspan="5">
                        <span class="floatleft">Config</span>
                        <span class="floatright"><?= WPNXM_DIR . '\bin\mongodb\mongodb.conf'; ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="right">
                        <a class="aButton" href="<?= WPNXM_WEBINTERFACE_ROOT . 'index.php?page=config#mongodb' ?>">Configure</a>
                        <a class="aButton"
                        <?php
                        if (!is_file(WPNXM_DIR . 'logs\mongodb.log')) {
                            echo "onclick=\"alert('MongoDB Log not available. File not found.'); return false;\"";
                        }
                        if(!$canOpenLogfileWithEditor()) {
                            echo "onclick=\"alert('Enable the extension by adding extension=php_com_dotnet.dll to your php.ini.'); return false;\"";
                        }
                        ?>
                           href="<?= WPNXM_WEBINTERFACE_ROOT . 'index.php?page=openfile&file=mongodb-log' ?>">Show Log</a>
                        <?php if (class_exists('mysqli')) { ?>
                        <a class="aButton" href="index.php?page=resetpw&amp;db=mongodb" rel="modal:open">Reset Password</a>
                        <?php } ?>
                    </td>
                </tr>
            </table>
            <?php } ?>

            <?php if(Serverstack::isExtensionInstalled('memcached') === true) { ?>
            <table class="cs-message-content">
                <tr>
                    <td colspan="2">
                        <div class="resourceheader2 bold">
                        <?= $memcached_status ?> Memcached
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="width-40 left">Host : Port</td>
                    <td class="right">localhost:11211</td>
                </tr>
                <tr>
                    <td>PHP Extension</td>
                    <td class="right"><?= Serverstack::isExtensionInstalled('memcached'); ?></td>
                </tr>
                <tr>
                    <td colspan="2" class="right">
                        <?php if (FEATURE_2 == true) { ?>
                            <a class="aButton" href="index.php?page=config#memcached">Configure</a>
                        <a class="aButton"
                        <?php
                        if (extension_loaded('memcached') === true) {
                            # if memcached is loaded, the button must say and turn Memcached off
                            $button_text = 'Switch off';
                            $url = WPNXM_WEBINTERFACE_ROOT . 'index.php?page=config&action=disable-memcached';
                        } else {
                            $button_text = 'Switch on';
                            $url = WPNXM_WEBINTERFACE_ROOT . 'index.php?page=config&action=enable-memcached';
                        }
                        ?>
                           href="<?= $url ?>"><?= $button_text ?>
                        </a>
                        <?php } ?>
                    </td>
                </tr>
            </table>
            <?php } ?>

            <table class="cs-message-content">
                <tr>
                    <td colspan="2">
                        <div class="resourceheader2 bold">
                         <?= $xdebug_status ?> Xdebug
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="width-40 left">Host : Port</td>
                    <td class="right">localhost:9000</td>
                </tr>
                <tr>
                    <td>Installed &amp; Configured</td>
                    <td class="right"><?= Serverstack::isExtensionInstalled('xdebug'); ?></td>
                </tr>
                <tr>
                    <td>Extension Type</td>
                    <td class="right"><?= \Webinterface\Components\XDebug::getXDebugExtensionType(); ?></td>
                </tr>
                <tr>
                    <td colspan="2" class="right">
                        <?php if (FEATURE_5 == true) { ?>
                        <a class="aButton" href="index.php?page=config#xdebug">Configure</a>
                        <a class="aButton"
                            <?php
                            if (function_exists('xdebug_call_file') === true) {
                                # if xdebug is loaded, the button must say and turn Xdebug off
                                $button_text = 'Switch off';
                                $url = WPNXM_WEBINTERFACE_ROOT . 'index.php?page=config&action=disable-xdebug';
                            } else {
                                $button_text = 'Switch on';
                                $url = WPNXM_WEBINTERFACE_ROOT . 'index.php?page=config&action=enable-xdebug';
                            }
                            ?>
                           href="<?= $url ?>"><?= $button_text ?>
                        </a>
                        <?php } ?>
                    </td>
                </tr>
            </table>

        </div>
    </div>

</div>