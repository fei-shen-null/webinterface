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

namespace Webinterface\Helper;

class Serverstack
{
    /**
     * Prints the Exclaimation Mark Icon with title text.
     *
     * @param  string $image_title_text
     * @return string HTML
     */
    public static function printExclamationMark($image_title_text = '')
    {
        return sprintf('<img style="float:right;" src="%s/exclamation-red-frame.png" alt="" title="%s">',  WPNXM_IMAGES_DIR, htmlspecialchars($image_title_text));
    }

    public static function get_MySQL_datadir()
    {
        $myini_array = file("../mysql/my.ini");
        $key_datadir = key(preg_grep("/^datadir/", $myini_array));
        $mysql_datadir_array = explode("\"", $myini_array[$key_datadir]);
        $mysql_datadir = str_replace("/", "\\", $mysql_datadir_array[1]);

        return $mysql_datadir;
    }

    /**
     * Returns MariaDB Version.
     *
     * @return string MariaDB Version
     */
    public static function getMariaDBVersion()
    {
        # fail safe, for unconfigured php.ini files
        if (!function_exists('mysqli_connect')) {
            return self::printExclamationMark('Enable mysqli extension in php.ini.');
        }

        $connection = @mysqli_connect('localhost', 'root', self::getMariaDBPassword());

        if (false === $connection) {
           # Daemon running? Login credentials correct?
           #echo ('MySQLi Connection error' . mysqli_connect_errno());

           return self::printExclamationMark('MySQL Connection not possible. Access denied. Check credentials.');
        } else {
            # $mysqli->server_info returns e.g. "5.3.0-maria"
            $arr = explode('-', $connection->server_info);

            return $arr[0];

            // @todo printSuccessMark('MariaDB is up. Connection successful.')

            $connection->close();
        }
    }

    public static function getMariaDBPassword()
    {
        $ini = new INIReaderWriter(WPNXM_INI);

        return $ini->get('MariaDB', 'password');
    }

    /**
     * Returns PHP Version.
     *
     * @return string PHP Version
     */
    public static function getPHPVersion()
    {
        return PHP_VERSION;
    }

    /**
     * Returns Nginx Version.
     *
     * @return string Nginx Version
     */
    public static function getNGINXVersion()
    {
        if (strpos($_SERVER["SERVER_SOFTWARE"], 'Apache') !== false) {
            return self::printExclamationMark('Traitor - you are using Apache!');
        }

        return substr($_SERVER["SERVER_SOFTWARE"], 6);
    }

    /**
     * Returns Xdebug Version.
     *
     * @return string Xdebug Version
     */
    public static function getXdebugVersion()
    {
        $xdebug_version = false;
        $matches = '';
        $phpinfo = self::fetchPHPInfo(true);

        // Check phpinfo content for Xdebug as Zend Extension
        if (preg_match('/with\sXdebug\sv([0-9.rcdevalphabeta-]+),/', $phpinfo, $matches)) {
            $xdebug_version = $matches[1];
        }

        return $xdebug_version;
    }


    public static function getMongoDBVersion()
    {
        if(!extension_loaded('mongo')) {
            return self::printExclamationMark('The PHP Extension "Mongo" is required.');
        }

        $m = new Mongo();
        // $db = $m->admin; //require admin priviledge

        //$mongodb_info = $db->command(array('buildinfo'=>true));
        //$mongodb_version = $mongodb_info['version'];

        $mongodb_version = $db->execute('return db.version()');

        return $mongodb_version;
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
            'apc'       => 'bin\php\ext\php_apc.dll',
            'xdebug'    => 'bin\php\ext\php_xdebug.dll',
            'xhprof'    => 'bin\php\ext\php_xhprof.dll',
            'memcached' => 'bin\php\ext\php_memcache.dll', # file without D
            'zeromq'    => 'bin\php\ext\php_zmq.dll',
            'mongodb'   => 'bin\php\ext\php_mongo.dll',
            'nginx'     => 'bin\nginx\nginx.conf',
            'mariadb'   => 'bin\mariadb\my.ini',
            'php'       => 'bin\php\php.ini',
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

        $phpinfo = self::fetchPHPInfo();

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
                $loaded =  (preg_match('/zeromq/', $phpinfo, $matches)) ? true : false;
                break;
            case "mongo":
                $loaded =  (preg_match('/mongo/', $phpinfo, $matches)) ? true : false;
                break;
            default:
                throw new \InvalidArgumentException(sprintf('There is no assertion for the extension: %s', $extension));
        }

        unset($phpinfo);

        return $loaded;
    }

    public static function getXdebugExtensionType()
    {
        $phpinfo = self::fetchPHPInfo(true);
        $matches = '';

        // Check phpinfo content for Xdebug as Zend Extension
        if (preg_match('/with\sXdebug\sv([0-9.rcdevalphabeta-]+),/', $phpinfo, $matches)) {
            return 'Zend Extension';
        }

        // Check phpinfo content for Xdebug as normal PHP extension
        if (preg_match('/xdebug support/', $phpinfo, $matches)) {
            return 'PHP Extension';
        }

        return ':( XDebug not loaded.';
    }

    public static function getPHPExtensionDirectory()
    {
        $phpinfo = self::fetchPHPInfo(true);
        $matches = '';

        if (preg_match('/extension_dir([ =>\t]*)([^ =>\t]+)/', $phpinfo, $matches)) {
            $extensionDir = $m[2];
        }

        return $extensionDir;
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
    public static function assertExtensionInstalled($extension)
    {
        if(self::assertExtensionFileFound($extension) === true and
           self::assertExtensionConfigured($extension) === true) {
            return true;
        }

        return false;
    }

    /**
     * Returns memcached Version.
     *
     * @return string memcached Version
     */
    public static function getMemcachedVersion()
    {
        if (extension_loaded('memcache') === false) {
            return self::printExclamationMark('The PHP Extension "memcache" is required.');
        }

        $matches = new Memcache;
        $matches->addServer('localhost', 11211);

        return $matches->getVersion();
    }

    /**
     * Returns the (full) content of phpinfo().
     *
     * @return string Content of phpinfo()
     */
    public static function getPHPInfoContent()
    {
        # fetch the output of phpinfo into a buffer and assign it to a variable
        ob_start();
        phpinfo();
        $buffered_phpinfo = ob_get_contents();
        ob_end_clean();

        return $buffered_phpinfo;
    }

    /**
     * Returns only the body content of phpinfo().
     *
     * When settings $strip_tags true, the phpinfo body content is
     * further reduced for better and faster processing with preg_match().
     *
     * @param boolean Strips tags from content when true.
     * @return string phpinfo
     */
    public static function fetchPHPInfo($strip_tags = false)
    {
        $matches = '';
        $buffered_phpinfo = self::getPHPInfoContent();

        # only the body content
        preg_match_all("=<body[^>]*>(.*)</body>=siU", $buffered_phpinfo, $matches);
        $phpinfo = $matches[1][0];

        # enhance the readability of semicolon separated items
        $phpinfo = str_replace(";", "; ", $phpinfo);
        $phpinfo = str_replace('&quot;', '"', $phpinfo);

        if ($strip_tags === true) {
            $phpinfo = strip_tags($phpinfo);
            $phpinfo = str_replace('&nbsp;', ' ', $phpinfo);
            $phpinfo = str_replace('  ', ' ', $phpinfo);
        }

        # colorize keywords green/red
        $phpinfo = preg_replace('#>(yes|on|enabled|active)#i', '><span style="color:#090; font-weight: bold;">$1</span>', $phpinfo);
        $phpinfo = preg_replace('#>(no|off|disabled)#i', '><span style="color:#f00; font-weight: bold;">$1</span>', $phpinfo);

        # grab all php extensions for display in an additional table
        preg_match_all("^(?:module_)(.*)\"^", $buffered_phpinfo, $match_modules, PREG_SET_ORDER);

        // create 4 lists from the whole extensions result set
        $modlists = array();
        $i = 0;
        foreach ($match_modules as $mod) {
            $modlists[($i % 4)][] = $mod;
            $i++;
        }

        // create html table listing the extensions
        $html = '';
        $html .= '<div class="center"><h1>PHP Extensions</h1>';
        $html .= '<table style="width: 600px";>';

        foreach ($modlists as $modlist) {
            $html .= '<td valign="top"><ul>';
            foreach ($modlist as $mod) {
                $html .= '<li><a href="#module_' . $mod[1] . '">' . $mod[1] . '</a></li>';
            }
            $html .= '</ul></td>';
        }
        $html .= '</tr></table></div><br>';

        return $html . $phpinfo;
    }

    public static function determinePort($daemon)
    {
        switch ($daemon) {
            case 'nginx':
                # code...
                # read from 1) config file, 2) startup parameter or 3) getPortByServiceName() ?
                break;
            case 'mariadb':
                # code...
                break;
            case 'memcached':
                # code...
                break;
            case 'xdebug':
                # code...
                break;
            case 'php':
                # code...
                break;
            default:
                throw new \InvalidArgumentException(sprintf('There is no assertion for the daemon: %s', $daemon));
        }
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
                return self::checkPort('127.0.0.1', '27017'); // remember: port 27018 is the admin interface of mongo
                break;
            default:
                throw new \InvalidArgumentException(sprintf('There is no assertion for the daemon: %s', $daemon));
        }
    }

    public static function getStatus($daemon)
    {
        if (!self::isDaemonRunning($daemon)) {
            $img = WPNXM_IMAGES_DIR . '/status_stop.png';
            $title = $daemon . ' not running!';
        } else {
            $img = WPNXM_IMAGES_DIR . '/status_run.png';
            $title = $daemon . ' running.';
        }

        return '<img style="float:right;" src="'.$img.'" alt="" title="'.$title.'">';
    }

    public static function isDaemonRunning($daemon)
    {
        // shorthands to daemon names; also handle xdebug extension
        if ($daemon === 'xdebug') { return extension_loaded('xdebug'); }
        if ($daemon === 'php') { $daemon = 'php-cgi'; }
        if ($daemon === 'mariadb') { $daemon = 'mysqld'; }
        if ($daemon === 'mongodb') { $daemon = 'mongod'; }

        // lookup daemon executable in process list
        static $output = '';
        $process = WPNXM_DIR . 'bin\tools\process.exe';
        if ($output == '') { $output = shell_exec($process); }
        if (strpos($output, $daemon . '.exe') !== false) { return true; }

        return false;
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

    public static function stopDaemon($daemon)
    {
        $hide_console = WPNXM_DIR . 'bin\tools\runhiddenconsole.exe ';
        $process_kill = WPNXM_DIR . 'bin\tools\process.exe -k  ';

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
                throw new \InvalidArgumentException(sprintf('There is no stopDaemon command for the daemon: %s', $daemon));
        }
    }

    public static function startDaemon($daemon, $options = '')
    {
        $hide_console = WPNXM_DIR . 'bin\tools\runhiddenconsole.exe ';

        switch ($daemon) {
            case 'nginx':
                $nginx_daemon = WPNXM_DIR . 'bin\nginx\bin\nginx.exe ';
                exec($hide_console . $nginx_daemon . $options);
                break;
            case 'mariadb':
                $mysqld_daemon = WPNXM_DIR . 'bin\mariadb\bin\mysqld.exe ';
                exec($hide_console . $mysqld_daemon . $options);
                break;
            case 'memcached':
                $memcached_daemon = WPNXM_DIR . 'bin\memcached\bin\memcached.exe ';
                exec($hide_console . $memcached_daemon . $options);
                break;
            case 'php':
                $php_daemon = WPNXM_DIR . 'bin\php\bin\php-cgi.exe ';
                exec($hide_console . $php_daemon . $options);
                break;
            default:
                throw new \InvalidArgumentException(sprintf('There is no startDaemon command for the daemon: %s', $daemon));
        }
    }

    public static function restartDaemon($daemon)
    {
        $hide_console = WPNXM_DIR . 'bin\tools\runhiddenconsole.exe ';
        $restart = 'restart-wpnxm.exe ';

        switch ($daemon) {
            case 'nginx':
                exec($hide_console . $restart . 'nginx');
                break;
            case 'mariadb':
                exec($hide_console . $restart . 'mariadb');
                break;
            case 'memcached':
                exec($hide_console . $restart . 'memcached');
                break;
            case 'php':
                exec($hide_console . $restart . 'php');
                break;
            default:
                throw new \InvalidArgumentException(sprintf('There is no restartDaemon command for the daemon: %s', $daemon));
        }
    }
}
