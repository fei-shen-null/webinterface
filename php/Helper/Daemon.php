<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - onwards, Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

namespace Webinterface\Helper;

/**
 * WPN-XM Server Stack - Helper class for handling evil daemons.
 */
class Daemon
{
    /**
     * @param string $daemon
     */
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
            case 'postgresql':
                $process_name = 'pgsql.exe';
                break;
             default:
                throw new \InvalidArgumentException(
                    sprintf(__METHOD__. '() has no command for the daemon: "%s"', $daemon)
                );
        }

        // lookup daemon executable in process list
        static $output = '';
        if ($output === '') {
            $process = WPNXM_DIR . 'bin\tools\process.exe';
            $output = shell_exec($process);
        }

        if (strpos($output, $process_name) !== false) {
            return true;
        }

        return false;
    }

    public static function startDaemon($daemon, $options = '')
    {
        $hide_console = WPNXM_DIR . 'bin\tools\RunHiddenConsole.exe ';

        switch ($daemon) {
            case 'nginx':
                $nginx_folder = WPNXM_DIR . 'bin\nginx';
                chdir($nginx_folder); //requierd for nginx
                exec("start $hide_console nginx.exe $options");
                break;

            case 'php':
                $folder = WPNXM_DIR . 'bin\php';
                chdir($folder); //requierd for nginx
                exec("start $hide_console php-cgi.exe -b localhost:9100 $options");
                break;

            case 'mariadb':
                $mysqld_folder = WPNXM_DIR . 'bin\mariadb\bin';
                chdir($mysqld_folder); //change to folder
                exec("start $hide_console mysqld.exe $options");
                break;

            case 'memcached':
                $memcached_daemon = WPNXM_DIR . 'bin\memcached\memcached.exe ';
                exec($hide_console . $memcached_daemon . $options);
                break;

            default:
                throw new \InvalidArgumentException(
                    sprintf(__METHOD__. '() has no command for the daemon: "%s"', $daemon)
                );
        }
    }

    public static function stopDaemon($daemon)
    {
        $hide_console = WPNXM_DIR . 'bin\tools\RunHiddenConsole.exe ';
        $process_kill = WPNXM_DIR . 'bin\tools\Process.exe -k  ';

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
     * @param  string                    $daemon
     * @throws \InvalidArgumentException
     */
    public static function restartDaemon($daemon)
    {
        chdir(WPNXM_DIR);

        if (file_exists('restart-wpnxm.bat')) {
            $restart = 'restart-wpnxm.bat ';
        } elseif (file_exists('restart.bat')) {
            $restart = 'restart.bat ';
        } else {
            die('restart.bat not found, please manually restart ' . $daemon);
        }

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
