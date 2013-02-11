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

namespace Webinterface\Components;

/**
 * WPN-XM Webinterface - Class for MariaDB
 */
class MariaDB extends AbstractComponent
{
    public $installationFolder = '\bin\mariadb';

    public $files = array(
        '\bin\mariadb\my.cnf',
        '\bin\nginx\bin\mysqld.exe'
    );

    public $configFile = '\bin\mariadb\my.cnf';

    /**
     * Returns MariaDB Version.
     *
     * @return string MariaDB Version
     */
    public function getVersion()
    {
        # fail safe, for unconfigured php.ini files
        if (!function_exists('mysqli_connect')) {
            return self::printExclamationMark('Enable mysqli extension in php.ini.');
        }

        $connection = @mysqli_connect('localhost', 'root', $this->getPassword());

        if (false === $connection) {
           # Daemon running? Login credentials correct?
           #echo ('MySQLi Connection error' . mysqli_connect_errno());

           return \Webinterface\Helper\Serverstack::printExclamationMark(
               'MySQL Connection not possible. Access denied. Check credentials.'
           );
        } else {
            # $mysqli->server_info returns e.g. "5.3.0-maria"
            $arr = explode('-', $connection->server_info);

            return $arr[0];

            // @todo printSuccessMark('MariaDB is up. Connection successful.')

            $connection->close();
        }
    }

    public function getPassword()
    {
        $ini = new \Webinterface\Helper\INIReaderWriter(WPNXM_INI);

        return $ini->get('MariaDB', 'password');
    }
}