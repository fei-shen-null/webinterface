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

namespace Webinterface\Helper;

class Viewhelper
{
    public static function showMenu()
    {
        // closure
        $phpmyadmin_link = function () {
           // is phpmyadmin installed?
           if (is_dir(WPNXM_WWW_DIR.'phpmyadmin') === true) {
               $password = \Webinterface\Helper\Serverstack::getPassword('mariadb');
               $href = WPNXM_ROOT.'phpmyadmin/index.php?lang=en&server=1&pma_username=root&pma_password='.$password;

               return '<a href="'.$href.'">phpMyAdmin</a>';
           }
        };

        // closure
        $adminer_link = function () {
            // is adminer installed?
            if (is_dir(WPNXM_WWW_DIR . 'adminer') === true) {
                return '<a href="' . WPNXM_ROOT . 'adminer/adminer.php?server=localhost&amp;username=root">Adminer</a>';
            }
        };

        $menu = '<div class="main_menu navbar">
                 <ul class="nav">
                    <li class="first"><a href="' . WPNXM_WEBINTERFACE_ROOT .'index.php?page=overview">Overview</a></li>
                    <li><a href="'.WPNXM_WEBINTERFACE_ROOT.'index.php?page=config">Configuration</a></li>
                    <li><a class="active" href="'.WPNXM_WEBINTERFACE_ROOT.'index.php?page=projects">Projects & Tools</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tools <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                             <li>'.$phpmyadmin_link().'</li>
                             <li>'.$adminer_link().'</li>
                             <li class="divider"></li>
                             <li><a href="'.WPNXM_WEBINTERFACE_ROOT.'index.php?page=update">Update</a></li>'.
                            /* '<li><a href="#">Filter2</a></li>
                             <li class="divider"></li>
                             <li class="nav-header">Nav header</li>
                             <li><a href="#">Filter1</a></li>
                             <li><a href="#">Filter2</a></li>*/
                        '</ul>
                    </li>
                    <li class="last"><a href="'.WPNXM_WEBINTERFACE_ROOT.'index.php?page=phpinfo">PHP Info</a></li>
                </ul>
             </div>';

        echo $menu;
    }

    public static function showWelcome()
    {
        if (self::fileCounter(WPNXM_DATA_DIR . '/welcomeMsgCounter.txt', 3) === true) {
            return;
        } else {
            echo '<h4 class="info">Welcome to the WPИ-XM Server Stack!
                  <p>Congratulations: You have successfully installed WPИ-XM on this system.</p>
                  </h4>';
        }
    }

    /**
     * Uses a file for counting the display times of the welcome message.
     *
     * @param  string  $file       The file containing the counter.
     * @param  int     $max_counts The number of times to return false.
     * @return boolean When the number of max_displays is reached, method will return true; else false;
     */
    public static function fileCounter($file, $max_counts)
    {
        $max_counts = (int) $max_counts;

        // file to write
        $file = (string) $file;

        // if file not existing, create and start counting with 1
        if (is_file($file) === false) {
            file_put_contents($file, 1);
        } else {
            // read file
            $current = file_get_contents($file);

            // comparison
            if ($current == $max_counts) {
                return true;
            }

            // increase counter
            if ($current < $max_counts) {
                $current++;
                file_put_contents($file, $current);
            }
        }

        return false;
    }
}
