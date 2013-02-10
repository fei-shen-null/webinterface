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

class Viewhelper
{
    public static function renderMenu()
    {
        $menu = '<div class="main_menu">
                 <ul>
                    <li class="first 1"><a href="index.php?page=overview">Overview</a></li>
                    <li class="2"><a href="index.php?page=config">Configuration</a></li>
                    <li class="3"><a href="index.php?page=projects">Projects & Tools</a></li>';

                // enter the number from the class attribute above
                $item_number = 3;

                // is phpmyadmin installed?
                if (is_dir(WPNXM_WWW_DIR.'phpmyadmin') === true) {
                    $item_number = $item_number + 1;
                    include_once WPNXM_HELPER_DIR.'serverstack.php';
                    $password = serverstack::getMariaDBPassword();
                    $href = WPNXM_ROOT.'phpmyadmin/index.php?lang=en&server=1&pma_username=root&pma_password='.$password;
                    $menu .= '<li class="'.$item_number.'"><a href="'.$href.'">PHPMyAdmin</a></li>';
                }

                // is adminer installed?
                if (is_dir(WPNXM_WWW_DIR.'adminer') === true) {
                    $item_number = $item_number + 1;
                    $menu .= '<li class="'.$item_number.'"><a href="'.WPNXM_ROOT.'adminer/adminer.php?server=localhost&amp;username=root">Adminer</a></li>';
                }

                $item_number = $item_number + 1;
                $menu .= '<li class="last '.$item_number.'"><a href="index.php?page=phpinfo">PHP Info</a></li>
                </ul>
             </div>';

        echo $menu;
    }

    public static function renderWelcome()
    {
        if (self::fileCounter(WPNXM_DATA_DIR . '/welcomeMsgCounter.txt', 10) === true) {
            return;
        } else {
            echo '<h1>Welcome to the WPИ-XM server stack!</h1>';
        }
    }

    /**
     * Uses a file for counting the display of the welcome message.
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
