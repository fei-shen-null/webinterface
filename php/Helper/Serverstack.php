<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - 2014 Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

namespace Webinterface\Helper;

class Serverstack
{
    /**
     * Prints the Exclamation Mark Icon.
     * Uses a tooltip (rel="tootip") show the title text.
     *
     * @param  string $image_title_text
     * @return string HTML
     */
    public static function printExclamationMark($image_title_text = '')
    {
        return sprintf(
            '<img style="float:right;" src="%sexclamation-red-frame.png" rel="tooltip" alt="%s" title="%s">',
            WPNXM_IMAGES_DIR,
            htmlspecialchars($image_title_text),
            htmlspecialchars($image_title_text)
        );
    }

    public static function printExclamationMarkLeft($image_title_text = '')
    {
        return sprintf(
            '<img src="%sexclamation-red-frame.png" rel="tooltip" alt="%s" title="%s">',
            WPNXM_IMAGES_DIR,
            htmlspecialchars($image_title_text),
            htmlspecialchars($image_title_text)
        );
    }

    public static function getInstalledComponents()
    {
        $classes = array();

        $files = glob(WPNXM_COMPONENTS_DIR . '*.php');

        foreach ($files as $file) {
            $pi = pathinfo($file);
            if ($pi['filename'] === 'AbstractComponent') {
                continue;
            }
            $classes[] = $pi['filename']; // get rid of extension
        }

        return $classes;
    }

    public static function instantiateInstalledComponents()
    {
        $components = array();

        $classes = self::getInstalledComponents();

        foreach ($classes as $class) {
            $component = '\Webinterface\Components\\' . $class;
            $components[] = new $component;
        }

        return $components;
    }

    /**
     * Get Version - Facade.
     *
     * @param  string $componentName
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function getVersion($componentName)
    {
        $componentClass = '\Webinterface\Components\\' . $componentName;
        $component      = new $componentClass;

        return $component->getVersion();
    }

    /**
     * Tests, if the extension file is found.
     *
     * @param  string $extension Extension name, e.g. xdebug, memcached.
     * @return bool   True if $extension file is found, false otherwise.
     */
    public static function assertExtensionFileFound($extension)
    {
        $files = array(
            'apc' => 'bin\php\ext\php_apc.dll',
            'xdebug' => 'bin\php\ext\php_xdebug.dll',
            'xhprof' => 'bin\php\ext\php_xhprof.dll',
            'memcached' => 'bin\php\ext\php_memcache.dll', # file without D
            'zeromq' => 'bin\php\ext\php_zmq.dll',
            'mongodb' => 'bin\php\ext\php_mongo.dll',
            'nginx' => 'bin\nginx\nginx.conf',
            'mariadb' => 'bin\mariadb\my.ini',
            'php' => 'bin\php\php.ini',
        );

        $file = WPNXM_DIR . $files[$extension];

        return is_file($file);
    }

    /**
     * Tests, if an extension is installed.
     * The extension file has to exist and the extensions must be loaded.
     *
     * @param  string $extension Extension to check.
     * @return bool   True if installed, false otherwise.
     */
    public static function isExtensionInstalled($extension)
    {
        if (self::assertExtensionFileFound($extension) === true and extension_loaded($extension)) {
            return true;
        }

        return false;
    }

    /**
     * Attempts to establish a connection to the specified port (on localhost)
     *
     * @param  string  $daemon Daemon/Service name.
     * @return boolean|null
     * @throws \InvalidArgumentException
     */
    public static function portCheck($daemon)
    {
        switch ($daemon) {
            case 'nginx':
                return self::checkPort('127.0.0.1', '80');
                break;
            case 'mariadb':
                return self::checkPort('127.0.0.1', '3306');
                break;
            case 'memcached':
                return self::checkPort('127.0.0.1', '11211');
                break;
            case 'php':
                return self::checkPort('127.0.0.1', '9000');
                break;
            case 'xdebug':
                return self::checkPort('127.0.0.1', '9100');
                break;
            case 'mongodb':
                return self::checkPort('127.0.0.1', '27017');
                break;
            case 'mongodb-admin':
                return self::checkPort('127.0.0.1', '27018');
                break;
            default:
                throw new \InvalidArgumentException(sprintf('There is no assertion for the daemon: %s', $daemon));
        }
    }

    /**
     * Displays the status of the daemon (running or not) by icon.
     * Shows the daemon status text as tooltip, when hovering.
     *
     * @param  string $daemon Name of the daemon.
     * @return string Embeddable image tag with tooltip.
     */
    public static function getStatus($daemon)
    {
        // extension are loaded and daemons are running
        $stateText = (strpos($daemon, 'phpext') !== false) ? 'loaded' : 'running';

        if (Daemon::isRunning($daemon) === false) {
            $img = WPNXM_IMAGES_DIR . 'status_stop.png';
            $title = self::getDaemonName($daemon) . ' is not ' . $stateText . '!';
        } else {
            $img = WPNXM_IMAGES_DIR . 'status_run.png';
            $title = self::getDaemonName($daemon) . ' is ' . $stateText . '.';
        }

        return sprintf(
            '<img style="float:right;" src="%s" alt="%s" title="%s" rel="tooltip">',
            $img, $title, $title
        );
    }

    /**
     * @param string $daemon
     */
    public static function getDaemonName($daemon)
    {
        switch ($daemon) {
            case 'phpext_memcache':
                return 'PHP Extension Memcache';
            case 'phpext_mongo':
                return 'PHP Extension Mongo';
            case 'nginx':
                return 'Nginx';
            case 'mariadb':
                return 'MariaDB';
            case 'memcached':
                return 'Memcached';
            case 'php':
                return 'PHP';
            case 'xdebug':
                return 'PHP Extension XDebug';
            case 'mongodb':
                return 'MongoDB';
            case 'postgresql':
                return 'PostgreSQL';
            default:
                throw new \InvalidArgumentException(sprintf(__METHOD__ . '() no name for the daemon: "%s"', $daemon));
        }
    }

    /**
     * Checks, if a component is installed.
     * A component is installed, when all its files exists.
     *
     * @param string $component
     * @return boolean
     * @throws \InvalidArgumentException
     */
    public static function isInstalled($component)
    {
        switch ($component) {
            case 'php':
            case 'nginx':
            case 'mariadb':
                return true; // always installed - base of the server stack
            case 'xdebug':
                $o = new \Webinterface\Components\XDebug;
                return $o->isInstalled();
            case 'mongodb':
                $o = new \Webinterface\Components\Mongodb;
                return $o->isInstalled();
            case 'memcached':
                $o = new \Webinterface\Components\Memcached;
                return $o->isInstalled();
            case 'postgresql':
                $o = new \Webinterface\Components\PostgreSQL;
                return $o->isInstalled();
            default:
                throw new \InvalidArgumentException(sprintf(__METHOD__ . '() has no case for the daemon: "%s"', $component));
        }
    }

    /**
     * Check if there is a service available at a certain port.
     *
     * This function tries to open a connection to the port
     * $port on the machine $host. If the connection can be
     * established, there is a service listening on the port.
     * If the connection fails, there is no service.
     *
     * @param  string  $host    Hostname
     * @param  integer $port    Portnumber
     * @param  integer $timeout Timeout for socket connection in seconds (default is 30).
     * @return boolean
     */
    public static function checkPort($host, $port, $timeout = 30)
    {
        $socket = fsockopen($host, $port, $errorNumber, $errorString, $timeout);

        echo $host . $port;
        echo $socket;

        if (!$socket) {
            return false;
        }

        @fclose($socket);

        return true;
    }

    /**
     * Get name of the service that is listening on a certain port.
     *
     * self::getServiceNameByPort('80')
     *
     * @param  integer $port     Portnumber
     * @param  string  $protocol Protocol (Is either tcp or udp. Default is tcp.)
     * @return string  Name of the Internet service associated with $service
     */
    public static function getServiceNameByPort($port, $protocol = "tcp")
    {
        return @getservbyport($port, $protocol);
    }

    /**
     * Get port that a certain service uses.
     *
     * @param  string  $service  Name of the service
     * @param  string  $protocol Protocol (Is either tcp or udp. Default is tcp.)
     * @return integer Internet port which corresponds to $service
     */
    public static function getPortByServiceName($service, $protocol = "tcp")
    {
        return @getservbyname($service, $protocol);
    }

    /**
     * Returns the current IP of the user by asking the WPN-XM webserver.
     *
     * @return string the current IP of the user.
     */
    public static function getMyIP()
    {
        $ip = @file_get_contents('http://wpn-xm.org/myip.php');
        if (preg_match('/^\d+\.\d+\.\d+\.\d+$/', $ip) === 1) {
            return $ip;
        } else {
            return '0.0.0.0';
        }
    }

    /**
     * Get Password - Facade.
     *
     * @param  string                    $component
     * @return string                    The Password.
     * @throws \InvalidArgumentException
     */
    public static function getPassword($component)
    {
        switch ($component) {
            case 'mariadb':
                $o = new \Webinterface\Components\Mariadb;
                return $o->getPassword();
            case 'mongodb':
                $o = new \Webinterface\Components\Mongodb;
                return $o->getPassword();
            default:
                throw new \InvalidArgumentException(sprintf('There is no password method for the daemon: %s', $component));
        }
    }

    public static function getWindowsVersion()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];

        $regexps = array(
            'Win 311'         => 'Win16',
            'Win 95'          => '(Windows 95)|(Win95)|(Windows_95)',
            'Win ME'          => '(Windows 98)|(Win 9x 4.90)|(Windows ME)',
            'Win 98'          => '(Windows 98)|(Win98)',
            'Win 2000'        => '(Windows NT 5.0)|(Windows 2000)',
            'Win XP'          => '(Windows NT 5.1)|(Windows XP)',
            'Win Server 2003' => '(Windows NT 5.2)',
            'Win Vista'       => '(Windows NT 6.0)',
            'Windows 7'       => '(Windows NT 6.1)',
            'Windows 8'       => '(Windows NT 6.2)',
            'WinNT'           => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)'
        );

        foreach ($regexps as $name => $pattern) {
            if (preg_match('/' . $pattern . '/i', $useragent)) {
                return $name;
            }
        }

        return 'Unknown (' . $useragent . ')';
    }

    /**
     * Returns the Bit-Size as integer.
     *
     * @return integer
     */
    public static function getBitSize()
    {
        if (PHP_INT_SIZE === 4) {
            return 32;
        }

        if (PHP_INT_SIZE === 8) {
            return 64;
        }

        return PHP_INT_SIZE; // 16-bit?
    }

    /**
     * Returns Bit-Size as string.
     *
     * @return string 32bit, 64bit
     */
    public static function getBitSizeString()
    {
        return self::getBitSize() . 'bit';
    }

}
