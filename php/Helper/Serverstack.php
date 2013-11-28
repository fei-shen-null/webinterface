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

class Serverstack
{
    /**
     * Prints the Exclaimation Mark Icon.
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
            $fqcn = '\Webinterface\Components\\' . $class;
            $components[] = $object_{$class} = new $fqcn;
        }

        return $components;
    }

    /**
     * Get Version - Facade.
     *
     * @param  string                    $component
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function getVersion($component)
    {
        switch ($component) {
            case 'nginx':
                $o = new \Webinterface\Components\Nginx;

                return $o->getVersion();
                break;
            case 'mariadb':
                $o = new \Webinterface\Components\Mariadb;

                return $o->getVersion();
                break;
             case 'mongodb':
                $o = new \Webinterface\Components\Mongodb;

                return $o->getVersion();
                break;
            case 'memcached':
                $o = new \Webinterface\Components\Memcached;

                return $o->getVersion();
                break;
            case 'xdebug':
                $o = new \Webinterface\Components\Xdebug;

                return $o->getVersion();
                break;
            case 'php':
                $o = new \Webinterface\Components\Php;

                return $o->getVersion();
                break;
            default:
                throw new \InvalidArgumentException(sprintf('There is no assertion for the daemon: %s', $component));
        }
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
     * Tests, if an extension is correctly configured.
     * An Extension is configured, when it gets loaded.
     * An Extension is loaded, when the PHP Screen says so.
     *
     * @param  string $extension Extension to check.
     * @return bool   True if loaded, false otherwise.
     */
    public static function assertExtensionConfigured($extension)
    {
        $loaded = false;
        $matches = '';

        $phpinfo = PHPInfo::getPHPInfo();

        switch ($extension) {
            case "xdebug":
                // Check phpinfo content for Xdebug as Zend Extension
                $loaded = (preg_match('/with\sXdebug\sv([0-9.rcdevalphabeta-]+),/', $phpinfo, $matches)) ? true : false;

                // Check phpinfo content for Xdebug as normal PHP extension (?)
                $loaded = (preg_match('/xdebug support/', $phpinfo, $matches)) ? true : false;
                break;
            case "memcached":
                $loaded = (preg_match('/memcache/', $phpinfo, $matches)) ? true : false;
                break;
            case "apc":
                $loaded = (preg_match('/apc/', $phpinfo, $matches)) ? true : false;
                break;
            case "zeromq":
                $loaded = (preg_match('/zeromq/', $phpinfo, $matches)) ? true : false;
                break;
            case "mongo":
                $loaded = (preg_match('/mongo/', $phpinfo, $matches)) ? true : false;
                break;
            default:
                throw new \InvalidArgumentException(sprintf('There is no assertion for the extension: %s', $extension));
        }

        unset($phpinfo);

        return $loaded;
    }

    /**
     * Tests, if an extension is installed,
     * by ensuring that the extension file exists and is correctly configured.
     * Installed: when files exist.
     * Loaded: when PHP Infos Screen says so.
     *
     * @param  string $extension Extension to check.
     * @return bool   True if installed, false otherwise.
     */
    public static function isExtensionInstalled($extension)
    {
        if (self::assertExtensionFileFound($extension) === true and
            self::assertExtensionConfigured($extension) === true) {
            return true;
        }

        return false;
    }

    /**
     * Attempts to establish a connection to the specified port (on localhost)
     *
     * @param  string  $daemon Daemon/Service name.
     * @return boolean
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
        // extension are loaded; daemons are running
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

    public static function getDaemonName($daemon)
    {
        switch ($daemon) {
            case 'phpext_memcache':
                return 'PHP Extension Memcache';
            case 'phpext_mongo':
                return 'PHP Extension Mongo';
            case 'nginx':
                return 'Nginx';
                break;
            case 'mariadb':
                return 'MariaDB';
                break;
            case 'memcached':
                return 'Memcached';
                break;
            case 'php':
                return 'PHP';
                break;
            case 'xdebug':
                return 'PHP Extension XDebug';
                break;
            case 'mongodb':
                return 'MongoDB';
                break;
            default:
                throw new \InvalidArgumentException(sprintf(__METHOD__ . '() no name for the daemon: "%s"', $daemon));
        }
    }

    public static function isInstalled($component)
    {
        switch ($component) {
            case 'php':
            case 'nginx':
            case 'mariadb':
                return true; // always installed - base of the server stack
                break;
            case 'xdebug':
                $o = new \Webinterface\Components\XDebug;

                return $o->isInstalled();
                break;
            case 'mongodb':
                $o = new \Webinterface\Components\Mongodb;

                return $o->isInstalled();
                break;
            case 'memcached':
                $o = new \Webinterface\Components\Memcached;

                return $o->isInstalled();
                break;
            default:
                throw new \InvalidArgumentException(sprintf(__METHOD__ . '() has no case for the daemon: "%s"', $daemon));
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
     * @return string
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
     * @return the current IP of the user.
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
                break;
            case 'mongodb':
                $o = new \Webinterface\Components\Mongodb;

                return $o->getPassword();
                break;
            default:
                throw new \InvalidArgumentException(sprintf('There is no password method for the daemon: %s', $component));
        }
    }
}
