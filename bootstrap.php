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

// errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// memory
ini_set('memory_limit', -1);

// timezone
date_default_timezone_set('Europe/Berlin');

// drop request and globals
unset($_REQUEST);
unset($GLOBALS);

/**
 * Definition of Constants
 *
 * WPNXM_VERSION    -> major.minor.buildnumber
 *
 * Path Constants
 * --------------
 * WPNXM_DIR        -> wpn-xm/ Root Folder (bin, configs, ....)
 * WPNXM_WWW_DIR    -> wpn-xm/www
 * WPNXM_HELPER_DIR -> wpn-xm/www/webinterface/helper
 * WPNXM_WWW_ROOT   -> www path (http:// to the www folder)
 */
if (!defined('WPNXM_DIR')) {
    // WPNXM Version String (replaced automatically during build)
    define('WPNXM_VERSION', '@APPVERSION@');

    define('DS', DIRECTORY_SEPARATOR);

    // Path Constants -> "c:/.."
    define('WPNXM_DIR', dirname(dirname(__DIR__)));
    define('WPNXM_WWW_DIR', WPNXM_DIR . '\www' . DS);
    define('WPNXM_CONTROLLER_DIR', WPNXM_WWW_DIR . 'webinterface\php\controller' . DS);
    define('WPNXM_COMPONENTS_DIR', WPNXM_WWW_DIR . 'webinterface\php\components' . DS);
    define('WPNXM_HELPER_DIR', WPNXM_WWW_DIR . 'webinterface\php\helper' . DS);
    define('WPNXM_VIEW_DIR', WPNXM_WWW_DIR . 'webinterface\php\view' . DS);
    define('WPNXM_DATA_DIR', WPNXM_WWW_DIR . 'webinterface\php\data' . DS);

    // Web Path Constants -> "http://.."
    define('SERVER_URL', 'http://' . $_SERVER['SERVER_NAME']);
    define('WPNXM_ROOT', SERVER_URL . ltrim(dirname(dirname(dirname($_SERVER['PHP_SELF']))), '\\') . '/');
    define('WPNXM_WWW_ROOT', WPNXM_ROOT . 'www/');
    define('WPNXM_WEBINTERFACE_ROOT', WPNXM_ROOT . 'webinterface/');
    define('WPNXM_IMAGES_DIR', WPNXM_WEBINTERFACE_ROOT . 'assets/img/');

    // WPNXM Configuration File
    define('WPNXM_INI', WPNXM_DIR . '\wpnxm.ini');

    /**
     * Feature Flags
     */
    $toggle = false;
    define('FEATURE_1', $toggle); // "create new project dialog" in php/view/projects-index.php
    define('FEATURE_2', $toggle); // memcached configure button and dialog and switch on/off
    define('FEATURE_3', $toggle); // Configuration Tabs Nginx, Nginx Domains, MariaDB, Xdebug
    define('FEATURE_4', $toggle); // create nginx domains directly from project list
    define('FEATURE_5', $toggle); // xdebug configure and switch on/off
}

if (!function_exists('showConstants')) {

    function showConstants($return = 'dump')
    {
        $array = get_defined_constants(true);
        $user_constants = $array['user'];

        switch ($return) {
            case 'raw':
                return $user_constants;
                break;
            case 'export':
                return var_export($user_constants, true);
                break;
            case 'dump':
            default:
                exit('<pre>' . var_dump($user_constants) . '</pre>');
                break;
        }
    }

}

function isAjaxRequest()
{
    if(!empty($_SERVER['X-Requested-With']) and $_SERVER['X-Requested-With'] === 'XMLHttpRequest') {
        return true;
    }

    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        return true;
    }

    return false;
}

// autoload classes based on a 1:1 mapping from namespace to directory structure.
function autoload($class)
{
    // return early, if class already loaded
    if (class_exists($class)) {
        return;
    }
    // replace namespace separator with directory separator
    $class = strtr($class, '\\', DS);
    $class = str_replace('Webinterface\\', '', $class);
    // get full name of file containing the required class
    $file = __DIR__ . DS . 'php' . DS . $class . '.php';
    //echo 'Autoloading Try -> ' . $file;
    if (is_file($file)) {
        include_once $file;
    }
}

spl_autoload_register('autoload');
