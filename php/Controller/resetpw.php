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

function index()
{
    render('page-action', array('no_layout' => true));
}

function update()
{
    /**
     * Resets the MariaDB Password
     *
     * The procedure is described in:
     * http://dev.mysql.com/doc/mysql-windows-excerpt/5.0/en/resetting-permissions-windows.html
     */

    $newPassword = filter_input(INPUT_GET, 'newPassword', FILTER_SANITIZE_STRING);

    if (!empty($newPassword)) {
        // commands
        $stop_mariadb = "taskkill /f /IM mysqld.exe 1>nul 2>nul";
        $mysqld_exe = /*WPNXM_DIR . '\bin\\tools\\RunHiddenConsole.exe ' .*/ WPNXM_DIR . "\bin\\mariadb\\bin\\mysqld.exe";
        $start_mariadb_change_pw = $mysqld_exe . " --defaults-file=" . WPNXM_DIR . '\bin\\mariadb\\my.ini --init-file=' . WPNXM_DIR . '\bin\\mariadb\\init_passwd_change.txt';
        $start_mariadb_normal = $mysqld_exe . " --defaults-file=" . WPNXM_DIR . '\bin\\mariadb\\my.ini';

        // create the init-file with passwd update query
        file_put_contents(
            WPNXM_DIR . '\bin\mariadb\init_passwd_change.txt',
            "UPDATE mysql.user SET PASSWORD=PASSWORD('$newPassword') WHERE User='root';\nFLUSH PRIVILEGES;"
        );

        // start mysqld again with init-file to change password
        exec($stop_mariadb);
        exec($start_mariadb_change_pw);
        sleep("5");

        exec($stop_mariadb);
        exec($start_mariadb_normal);
        sleep("3");

        unlink(WPNXM_DIR . '\bin\mariadb\init_passwd_change.txt');

        $connection = new \mysqli("localhost", "root", $newPassword, "mysql");

        if (mysqli_connect_errno()) {
            $return = '<div class="error">Database Connection with new password FAILED.<br/>';
            $return .= '(MySQL ["' . mysqli_connect_errno() . '"]"' . mysqli_connect_error() . '")';
        } else {
            $return = '<div class="success">Password changed SUCCESSFULLY.';

            // write new password
            $ini = new \Webinterface\Helper\INIReaderWriter(WPNXM_INI);
            $ini->set('MariaDB', 'password', $newPassword);
            $ini->write();
        }

        $return .= '<br/><a class="aButton" rel="modal:close" href="#">Close</a></div>'; // provide close button for modal window

        unset($connection);

        echo $return; // ajax response
    }
}
