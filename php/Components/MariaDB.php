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
    
    /**
     * Resets the MariaDB Password
     *
     * The procedure is described in:
     * http://dev.mysql.com/doc/mysql-windows-excerpt/5.0/en/resetting-permissions-windows.html
     */
    public function setPassword($password)
    {
        // commands
        $stop_mariadb = "taskkill /f /IM mysqld.exe 1>nul 2>nul";
        $mysqld_exe = /*WPNXM_DIR . '\bin\\tools\\RunHiddenConsole.exe ' .*/ WPNXM_DIR . "\bin\\mariadb\\bin\\mysqld.exe";
        $start_mariadb_change_pw = $mysqld_exe . " --defaults-file=" . WPNXM_DIR . '\bin\\mariadb\\my.ini --init-file=' . WPNXM_DIR . '\bin\\mariadb\\init_passwd_change.txt';
        $start_mariadb_normal = $mysqld_exe . " --defaults-file=" . WPNXM_DIR . '\bin\\mariadb\\my.ini';

        // create the init-file with the password update query
        file_put_contents(
            WPNXM_DIR . '\bin\mariadb\init_passwd_change.txt',
            "UPDATE mysql.user SET PASSWORD=PASSWORD('$password') WHERE User='root';\nFLUSH PRIVILEGES;"
        );

        // start mysqld and execute the init-file
        exec($stop_mariadb);
        exec($start_mariadb_change_pw);
        sleep(1);
        exec($stop_mariadb);
        exec($start_mariadb_normal);
        sleep(1);

        unlink(WPNXM_DIR . '\bin\mariadb\init_passwd_change.txt');

        // test connection with new password
        $connection = new \mysqli("localhost", "root", $password, "mysql");

        if (mysqli_connect_errno()) {
            $response = '<div class="alert alert-danger">Database Connection with new password FAILED.';
            $response .= '(MySQL ["' . mysqli_connect_errno() . '"]"' . mysqli_connect_error() . '")</div>';
        } else {
            $response = '<div class="alert alert-success">Password changed SUCCESSFULLY.</div>';

            // write new password to wpn-xm ini
            $ini = new \Webinterface\Helper\INIReaderWriter(WPNXM_INI);
            $ini->set('MariaDB', 'password', $password);
            $ini->write();
        }

        $connection->close();
        unset($connection);
        
        return $response;
    }

    public function getDataDir()
    {
        $myini_array = file(WPNXM_DIR . $this->configFile);

        $array = preg_grep("/^datadir/", $myini_array);
        $key_datadir = key($array);        
        $mysql_datadir_array = explode("\"", $myini_array[$key_datadir]);
        $mysql_datadir = str_replace("/", "\\", $mysql_datadir_array[1]);

        return $mysql_datadir;
    }
}
