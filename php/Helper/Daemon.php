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
    * @copyright  Jens-André Koch (2010 - onwards)
    * @link       http://wpn-xm.org/
    */

namespace Webinterface\Helper;

/**
 * WPN-XM Server Stack - Helper class for handling evil daemons.
 */
class Daemon
{
    public static function isRunning($daemon)
    {
        // shorthands to daemon names; also handle xdebug extension
        switch ($daemon) {
            case 'phpext_xdebug':
            case 'xdebug':
                return extension_loaded('xdebug');
                break;
            case 'phpext_mongo':
                return extension_loaded('mongo');
                break;
            case 'phpext_memcache':
                return extension_loaded('memcache');
                break;
            case 'php':
                $process_name = 'php-cgi.exe';
                break;
            case 'mariadb':
                $process_name = 'mysqld.exe';
            break;
            case 'mongodb':
                $process_name = 'mongod.exe';
                break;
            case 'nginx':
                $process_name = 'nginx.exe';
                break;
            case 'memcached':
                $process_name = 'memcached.exe';
                break;
             default:
                throw new \InvalidArgumentException(
                    sprintf(__METHOD__. '() has no command for the daemon: "%s"', $daemon)
                );
        }

        // lookup daemon executable in process list
        static $output = '';
        if ($output === '') {
            $process = WPNXM_DIR . '\bin\tools\process.exe';
            $output = shell_exec($process);
        }

        if (strpos($output, $process_name) !== false) {
            return true;
        }

        return false;
    }

    public static function startDaemon($daemon, $options = '')
    {
        $hide_console = WPNXM_DIR . '\bin\tools\RunhHiddenConsole.exe ';

        switch ($daemon) {
            case 'nginx':
                $nginx_daemon = WPNXM_DIR . '\bin\nginx\bin\nginx.exe ';
                exec($hide_console . $nginx_daemon . $options);
                break;
            case 'mariadb':
                $mysqld_daemon = WPNXM_DIR . '\bin\mariadb\bin\mysqld.exe ';
                exec($hide_console . $mysqld_daemon . $options);
                break;
            case 'memcached':
                $memcached_daemon = WPNXM_DIR . '\bin\memcached\bin\memcached.exe ';
                exec($hide_console . $memcached_daemon . $options);
                break;
            case 'php':
                $php_daemon = WPNXM_DIR . '\bin\php\bin\php-cgi.exe ';
                exec($hide_console . $php_daemon . $options);
                break;
            default:
                throw new \InvalidArgumentException(
                    sprintf(__METHOD__. '() has no command for the daemon: "%s"', $daemon)
                );
        }
    }

    public static function stopDaemon($daemon)
    {
        $hide_console = WPNXM_DIR . '\bin\tools\RunhHiddenConsole.exe ';
        $process_kill = WPNXM_DIR . '\bin\tools\Process.exe -k  ';

        switch ($daemon) {
            case 'nginx':
                exec($hide_console . $process_kill . 'nginx.exe');
                break;
            case 'mariadb':
                exec($hide_console . $process_kill . 'mysqld.exe');
                break;
            case 'memcached':
                exec($hide_console . $process_kill . 'memcached.exe');
                break;
            case 'php':
                exec($hide_console . $process_kill . 'php-cgi.exe');
                break;
            default:
                throw new \InvalidArgumentException(
                    sprintf(__METHOD__. '() has no command for the daemon: "%s"', $daemon)
                );
        }
    }

    /**
     * Restarts a daemon by utilizing "restart-wpnxm.bat".
     * Especially the php daemon must (re)-started from the outside.
     *
     * @param string $daemon
     * @throws \InvalidArgumentException
     */
    public static function restartDaemon($daemon)
    {
        $restart = WPNXM_DIR . '\restart-wpnxm.bat ';

        switch ($daemon) {
            case 'nginx':
                exec($restart . 'nginx');
                break;
            case 'mariadb':
                exec($restart . 'mariadb');
                break;
            case 'memcached':
                exec($restart . 'memcached');
                break;
            case 'php':
                exec($restart . 'php');
                break;
            default:
                throw new \InvalidArgumentException(
                    sprintf(__METHOD__. '() has no command for the daemon: "%s"', $daemon)
                );
        }
    }

}
