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
                                    <b>NGINX</b>
                                </a>
                                <span class="version"><?= $nginx_version ?></span>
                            </div>
                            <div class="description">
                                <small>NGINX [engine x] is a high performance http and reverse proxy server, as well as a mail proxy server written by Igor Sysoev.</small>
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
                    <td class="width-20">Host : Port</td>
                    <td class="right"><?= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] ?></td>
                </tr>
                <tr>
                    <td>Your IP</td>
                    <td class="right"><?= $my_ip ?></td>
                </tr>
                <tr>
                    <td>Directory</td>
                    <td class="right"><?= WPNXM_WWW_DIR . 'bin\nginx' ?></td>
                </tr>
                <tr>
                    <td>Config</td>
                    <td class="right"><?= WPNXM_WWW_DIR . 'bin\nginx\conf\nginx.conf' ?></td>
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
                    <td class="width-42 left">Host : Port</td>
                    <td class="right"><?= $_SERVER['SERVER_NAME'] ?>:<?= $_SERVER['SERVER_PORT'] ?></td>
                </tr>
                <tr>
                    <td>Directory</td>
                    <td class="right"><?= WPNXM_WWW_DIR . 'bin\php' ?></td>
                </tr>
                <tr>
                    <td>Config</td>
                    <td class="right"><?= get_cfg_var('cfg_file_path') ?></td>
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
                    <td colspan="2">
                        <div class="resourceheader2 bold">
                        <?= $mariadb_status ?> MariaDB
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="width-42 left">Host : Port</td>
                    <td class="right">localhost:3306</td>
                </tr>
                <tr>
                    <td>Username | Password</td>
                    <td class="right"><span class="red">root</span> | <span class="red"><?= $mariadb_password ?></span></td>
                </tr>
                <tr>
                    <td>Directory</td>
                    <td class="right"><?= WPNXM_WWW_DIR . 'bin\mariadb'; ?></td>
                </tr>
                <tr>
                    <td>Config</td>
                    <td class="right"><?= WPNXM_WWW_DIR . 'mariadb\my.ini'; ?></td>
                </tr>
                <tr>
                    <td colspan="2" class="right">
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

            <table class="cs-message-content">
                <tr>
                    <td colspan="2">
                        <div class="resourceheader2 bold">
                        <?= $memcached_status ?> Memcached
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="width-42 left">Host : Port</td>
                    <td class="right">localhost:11211</td>
                </tr>
                <tr>
                    <td>PHP Extension</td>
                    <td class="right"><?= Serverstack::assertExtensionInstalled('memcached'); ?></td>
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

            <table class="cs-message-content">
                <tr>
                    <td colspan="2">
                        <div class="resourceheader2 bold">
                         <?= $xdebug_status ?> Xdebug
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="width-42 left">Host : Port</td>
                    <td class="right">localhost:9000</td>
                </tr>
                <tr>
                    <td>Installed &amp; Configured</td>
                    <td class="right"><?= Serverstack::assertExtensionInstalled('xdebug'); ?></td>
                </tr>
                <tr>
                    <td>Extension Type</td>
                    <td class="right"><?= Serverstack::getXdebugExtensionType(); ?></td>
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