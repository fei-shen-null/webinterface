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
    |    WPИ-XM Server Stack is free software; you can redistribute it and/or modify   |
    |    it under the terms of the GNU General Public License as published by          |
    |    the Free Software Foundation; either version 2 of the License, or             |
    |    (at your option) any later version.                                           |
    |                                                                                  |
    |    WPИ-XM Server Stack is distributed in the hope that it will be useful,        |
    |    but WITHOUT ANY WARRANTY; without even the implied warranty of                |
    |    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                 |
    |    GNU General Public License for more details.                                  |
    |                                                                                  |
    |    You should have received a copy of the GNU General Public License             |
    |    along with this program; if not, write to the Free Software                   |
    |    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA    |
    |                                                                                  |
    +----------------------------------------------------------------------------------+
    */

namespace Webinterface\Components;

/**
 * WPN-XM Webinterface - Class for MariaDB
 */
class MariaDb extends AbstractComponent
{
    public $name = 'MariaDb';
    
    public $registryName = 'mariadb';
    
    public $installationFolder = '\bin\mariadb';

    public $files = array(
        '\bin\mariadb\my.ini',
        '\bin\mariadb\bin\mysqld.exe'
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
            return \Webinterface\Helper\Serverstack::printExclamationMark('The PHP Extension "mysqli" is required.');
        }

        $connection = @mysqli_connect('localhost', 'root', $this->getPassword());

        if (false === $connection) {
           return \Webinterface\Helper\Serverstack::printExclamationMark(
               sprintf(
                   'MariaDB Connection not possible. Access denied. Check credentials. Error: "%s"',
                   mysqli_connect_error()
               )
           );
        } else {
            $arr = explode('-', $connection->server_info);
            $connection->close();

            return $arr[0];
        }
    }

    public function getPassword()
    {
        $ini = new \Webinterface\Helper\INIReaderWriter(WPNXM_INI);

        return $ini->get('MariaDB', 'password');
    }

    public function getDataDir()
    {
        $myini_array = file(WPNXM_DIR . $this->configFile);

        $key_datadir = key(preg_grep("/^datadir/", $myini_array));
        $mysql_datadir_array = explode("\"", $myini_array[$key_datadir]);
        $mysql_datadir = str_replace("/", "\\", $mysql_datadir_array[1]);

        return $mysql_datadir;
    }
}
