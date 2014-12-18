<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - 2014 Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', -1);
date_default_timezone_set('Europe/Berlin');

// drop request and globals
unset($_REQUEST);
unset($GLOBALS);

/**
 * Definition of Constants
 *
 * Check constants via "index.php?page=debug".
 */
if (!defined('WPNXM_DIR')) {
    // WPNXM Version String (major.minor.buildnumber) replaced automatically during build
    define('WPNXM_VERSION', '@APPVERSION@');

    define('DS', DIRECTORY_SEPARATOR);

    // Path Constants -> "c:/.."
    if (defined('PHPUNIT_TESTSUITE_TRAVIS') or (DS === '/')) {
        // Linux Paths
        define('WPNXM_DIR', dirname(__DIR__)); # only the webinterface folder exists on travis
        define('WPNXM_WWW_DIR', WPNXM_DIR . DS); # no www folder
        define('WPNXM_CONTROLLER_DIR', WPNXM_WWW_DIR . 'webinterface/php/Controller/');
        define('WPNXM_COMPONENTS_DIR', WPNXM_WWW_DIR . 'webinterface/php/Components/');
        define('WPNXM_HELPER_DIR', WPNXM_WWW_DIR . 'webinterface/php/Helper/');
        define('WPNXM_VIEW_DIR', WPNXM_WWW_DIR . 'webinterface/php/View/');
        define('WPNXM_DATA_DIR', WPNXM_WWW_DIR . 'webinterface/php/data/');
    } else {
        // Windows Paths
        define('WPNXM_DIR', dirname(dirname(dirname(__DIR__))) . DS);
        define('WPNXM_WWW_DIR', WPNXM_DIR . 'www' . DS);
        define('WPNXM_CONTROLLER_DIR', WPNXM_WWW_DIR . 'tools\webinterface\php\Controller' . DS);
        define('WPNXM_COMPONENTS_DIR', WPNXM_WWW_DIR . 'tools\webinterface\php\Components' . DS);
        define('WPNXM_HELPER_DIR', WPNXM_WWW_DIR . 'tools\webinterface\php\Helper' . DS);
        define('WPNXM_VIEW_DIR', WPNXM_WWW_DIR . 'tools\webinterface\php\View' . DS);
        define('WPNXM_DATA_DIR', WPNXM_WWW_DIR . 'tools\webinterface\php\data' . DS);
    }

    // Web Path Constants -> "http://.."
    $port = ($_SERVER['SERVER_PORT'] !== '80') ? (':' . $_SERVER['SERVER_PORT']) : ''; // add embedded webserver port, in case its running
    define('SERVER_URL', 'http://' . $_SERVER['SERVER_NAME'] . $port);
    define('WPNXM_ROOT', SERVER_URL . ltrim(dirname(dirname(dirname($_SERVER['PHP_SELF']))), '\\') . '/');
    define('WPNXM_WWW_ROOT', WPNXM_ROOT . 'www/');
    define('WPNXM_WEBINTERFACE_ROOT', '/tools/webinterface/');
    define('WPNXM_ASSETS', '/tools/webinterface/assets/');
    define('WPNXM_IMAGES_DIR', '/tools/webinterface/assets/img/');

    // WPNXM Configuration File
    define('WPNXM_INI', WPNXM_DIR . 'wpn-xm.ini');
    define('WPNXM_BIN', WPNXM_DIR . 'bin' . DS);
    define('WPNXM_TEMP', WPNXM_DIR . 'temp' . DS);

    /**
     * Feature Flags
     *
     * Some features are "work in progress". Therefore they are disabled in release versions.
     * If you want to contribute to the project, set the toggle true and search for "FEATURE_x"
     * to start hacking. If a feature is implemented, you can remove the feature flag.
     */
    $toggle = false;
    define('FEATURE_1', $toggle); // "create new project dialog" in php/view/projects-index.php
    define('FEATURE_2', $toggle); // tools -> updater [components are fetched, but not extracted and installed into their folders]
    define('FEATURE_3', $toggle); // Configuration Tabs Nginx, Nginx Domains, MariaDB, Xdebug
    define('FEATURE_4', $toggle); // create nginx domains directly from project list [depends on nginx-conf parser]
}

if (!function_exists('showConstants')) {

    /**
     * Returns all user defined constants.
     * Supports several display modes (raw,export, dump).
     *
     * @param string $return The display mode: "raw", "export", "dump" (default).
     * @return
     */
    function showConstants($return = 'dump')
    {
        $array = get_defined_constants(true);
        $user_constants = $array['user'];

        switch ($return) {
            case 'raw':
                return $user_constants;
            case 'export':
                return var_export($user_constants, true);
            case 'dump':
            default:
                exit('<pre>' . var_dump($user_constants) . '</pre>');
        }
    }

}

/**
 * Check if the current request is an Ajax request.
 *
 * @return boolean True, if Ajax Request. Otherwise, false.
 */
function isAjaxRequest()
{
    if (!empty($_SERVER['X-Requested-With']) and $_SERVER['X-Requested-With'] === 'XMLHttpRequest') {
        return true;
    }

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) and $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        return true;
    }

    return false;
}

/**
 * Redirect to Url.
 *
 * @param string $url
 */
function redirect($url)
{
    header('Location: ' . $url);
    exit;
}

/**
 * The autoloading function includes classes based on
 * a 1:1 mapping from namespace to directory structure.
 *
 * @param string The classname to include.
 */
function autoload($class)
{
    // return early, if class already loaded
    if (class_exists($class) === true) {
        return;
    }

    // replace namespace separator with directory separator
    $class = strtr($class, '\\', DS);
    $class = str_replace('Webinterface\\', '', $class);
    $class = str_replace('Webinterface/', '', $class); # for linux, no PSR-0 structure

    // get full name of file containing the required class
    $file = __DIR__ . DS . 'php' . DS . $class . '.php';

    if (is_file($file) === true) {
        include_once $file;
    } else {
        throw new \Exception(
            sprintf('Autoloading Failure! Class "%s" requested, but file "%s" not found.', $class, $file)
        );
    }
}

spl_autoload_register('autoload');

function exception_handler(Exception $e)
{
    $trace = str_replace(
        array('#','):'),
        array('<br>#',"):<br>&nbsp;&nbsp;&rarr;"),
        $e->getTraceAsString()
    );

    include WPNXM_VIEW_DIR . 'header.php';

    $html = '<h2 class="heading">Exception</h2>';
    $html .= '<div class="centered"><div class="cs-message">';
    $html .= '<div class="cs-message-content" style="width: 100%; font-size: 16px; height: auto !important;">';
    $html .= '<div class="error"><h2>Something Bad Happened</h3>';
    $html .= '<p>' . $e->getMessage() . '</p>';
    $html .= '<p>' . $trace . '</p>';
    $html .= '</div></div></div></div>';
    echo $html;

    include WPNXM_VIEW_DIR . 'footer.php';
}

set_exception_handler('exception_handler');
