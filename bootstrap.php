<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - onwards, Jens-André Koch <jakoch@web.de>
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

    // WPNXM Version String
    // The placeholder is replaced during the build of the Installers by the TRAVIS_TAG.
    // The versioning scheme is "major.minor.buildnumber".
    define('WPNXM_VERSION', '@APPVERSION@');

    // Webinterface Version String
    // The placeholder is replaced during the build of the webinterface by the TRAVIS_TAG.
    // The versioning scheme is either "master" or for a tagged release: "major.minor.buildnumber".
    define('WEBINTERFACE_VERSION', '@WEBINTERFACE_VERSION@');

    define('DS', DIRECTORY_SEPARATOR);
    define('NL', "\n");

    // Path Constants -> "c:/.."
    if (defined('PHPUNIT_TESTSUITE_TRAVIS') or (DS === '/')) {
        // Linux Paths
        define('WPNXM_DIR', dirname(__DIR__)); # only the webinterface folder exists on travis
        define('WPNXM_WWW_DIR', WPNXM_DIR.DS); # no www folder
        define('WPNXM_CONTROLLER_DIR', WPNXM_WWW_DIR.'webinterface/src/Controller/');        
        define('WPNXM_HELPER_DIR', WPNXM_WWW_DIR.'webinterface/src/Helper/');
        define('WPNXM_VIEW_DIR', WPNXM_WWW_DIR.'webinterface/src/View/');
        define('WPNXM_DATA_DIR', WPNXM_WWW_DIR.'webinterface/data/');
    } else {
        // Windows Paths
        define('WPNXM_DIR', dirname(dirname(dirname(__DIR__))).DS);
        define('WPNXM_WWW_DIR', WPNXM_DIR.'www'.DS);
        define('WPNXM_CONTROLLER_DIR', WPNXM_WWW_DIR.'tools\webinterface\src\Controller'.DS);
        define('WPNXM_HELPER_DIR', WPNXM_WWW_DIR.'tools\webinterface\src\Helper'.DS);
        define('WPNXM_VIEW_DIR', WPNXM_WWW_DIR.'tools\webinterface\src\View'.DS);
        define('WPNXM_DATA_DIR', WPNXM_WWW_DIR.'tools\webinterface\data'.DS);
    }

    // Web Path Constants -> "http://.."
    $port = ($_SERVER['SERVER_PORT'] !== '80') ? (':'.$_SERVER['SERVER_PORT']) : ''; // add embedded webserver port, in case its running
    define('SERVER_URL', 'http://'.$_SERVER['SERVER_NAME'].$port);
    define('WPNXM_ROOT', SERVER_URL.ltrim(dirname(dirname(dirname($_SERVER['PHP_SELF']))), '\\').'/');
    define('WPNXM_WWW_ROOT', WPNXM_ROOT.'www/');
    define('WPNXM_WEBINTERFACE_ROOT', '/tools/webinterface/');
    define('WPNXM_ASSETS', '/tools/webinterface/assets/');
    define('WPNXM_IMAGES_DIR', '/tools/webinterface/assets/img/');

    // WPNXM Configuration File
    define('WPNXM_INI',     WPNXM_DIR.'wpn-xm.ini');
    define('WPNXM_BIN',     WPNXM_DIR.'bin'.DS);
    define('WPNXM_TEMP',    WPNXM_DIR.'temp'.DS);

    // Nginx Configurations
    define('WPNXM_NGINX_CONF',                  WPNXM_BIN. 'nginx/conf/nginx.conf');
    define('WPNXM_NGINX_DOMAINS_ENABLED_DIR',   WPNXM_BIN. 'nginx/conf/domains-enabled'.DS);
    define('WPNXM_NGINX_DOMAINS_DISABLED_DIR',  WPNXM_BIN. 'nginx/conf/domains-disabled'.DS);

    // Composer managed Vendor folder
    define('VENDOR_DIR', __DIR__.DS.'vendor'.DS);
}

// Register Composer Autoloader
if (!is_file(VENDOR_DIR.'autoload.php')) {
    throw new \RuntimeException(
        'Could not find "vendor/autoload.php".'.PHP_EOL.
        'Did you forget to run "composer install --dev"?'.PHP_EOL
    );
}
require VENDOR_DIR.'autoload.php';

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
        $array          = get_defined_constants(true);
        $user_constants = $array['user'];

        switch ($return) {
            case 'raw':
                return $user_constants;
            case 'export':
                return var_export($user_constants, true);
            case 'dump':
            default:
                exit('<pre>'.var_dump($user_constants).'</pre>');
        }
    }
}

/**
 * Check if the current request is an Ajax request.
 *
 * @return bool True, if Ajax Request. Otherwise, false.
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
    header('Location: '.$url);
    exit;
}

spl_autoload_register('Autoloader::autoloadSoftware');
spl_autoload_register('Autoloader::autoloadSoftwarePHPExtension');
spl_autoload_register('Autoloader::autoload');
//spl_autoload_register('Autoloader::autoloadPHPSoftware');

/**
 * Custom & PSR-4 Autoloader
 *
 * @param string The classname to include.
 */
class Autoloader
{
	public static function autoload($class)
	{
		var_dump('autoload webinterface:', $class).NL;

	    // return early, if class already loaded
	    if (class_exists($class, false)) {
	        return true;
	    }

	    // the project-specific namespace prefix
	    $prefix = 'WPNXM\Webinterface\\';

	    // is this a request for one of our classes, else exit early from this autoloader
		if(strpos($class, $prefix) === false) {
			return false;
		}	   

	    // base directory for the namespace prefix (normally "/src/")
	    $base_dir = __DIR__.DS.'src'.DS;

	    // does the class use the namespace prefix?
	    $len = strlen($prefix);
	    if (strncmp($prefix, $class, $len) !== 0) {
	        // no, move to the next registered autoloader
	        return;
	    }

	    // get the relative class name
	    $relative_class = substr($class, $len);

	    // replace the namespace prefix with the base directory,
	    // replace namespace separators with directory separators in the relative class name,
	    // append with .php
	    $file = $base_dir.str_replace('\\', DS, $relative_class).'.php';

	    // if the file exists, require it
	    if (file_exists($file) === true) {
	        require $file;
	    } else {
	        /*throw new \Exception(
	            sprintf('Autoloading Failure! Class "%s" requested, but file "%s" not found.', $class, $file)
	        );*/
	        return false;
	    }
	}

	/**
	 * Instantiate class for a software by name
	 * 
	 * Software, e.g. '\WPNXM\Webinterface\Software\Nginx'  
	 *
	 * @param  string $software
	 * @return object
	 */
	public static function autoloadSoftware($software)
	{		
		// return early, if class already loaded
	    if (class_exists($software, false)) {
	    	echo 'class exists' . $software.NL;
	        return true;
	    }

		$software = strtolower($software);		
	    $nsArray  = explode('\\', $software);
	    $nsCount  = count($nsArray);

		// Nginx
	    if($nsCount === 1) {
	    	// software = software = $nsArray[0]
	    	$class = $software;
	    }
	    // \WPNXM\Webinterface\Software\Nginx
	    elseif($nsCount === 4) {
			$software  = $nsArray[3];   
		    $class     = $nsArray[3];
		}
		// \WPNXM\Webinterface\Software\Nginx\NginxConfig
		elseif(count($nsArray) === 5) { 
			$software  = $nsArray[3]; 
		    $class     = $nsArray[4]; 
		}

		$class = ucfirst($class);
	    $file = VENDOR_DIR . 'wpn-xm\software\\'.$software.'\scripts\webinterface\\'.$class.'.php';

	    if(is_file($file)) {
	    	include $file;
	    	return true;
		}    
	}

	/**
	 * Instantiate a PHP Extensions class from the Software repository
	 *
	 * PHP Extension, e.g. '\WPNXM\Webinterface\Software\PHPExtension\Xdebug'
	 *
	 * @param  string $software
	 * @return object
	 */
	public static function autoloadSoftwarePHPExtension($software)
	{		
		// return early, if class already loaded
	    if (class_exists($software, false)) {
	        return true;
	    }

		$software  = str_replace('WPNXM\Webinterface\Software\PHPExtension\\', '', $software);
	    $dir       = strtolower($software);
	    $class     = ucfirst($software);

	    $file = VENDOR_DIR . 'wpn-xm\software\PHPExtension\\'.$dir.'\scripts\webinterface\\'.$class.'.php'; 

	    if(is_file($file)) {
	    	include $file;
	    	return true;
		}
	}
}



function exception_handler($e) /** Throwable **/
{
    $html = '<div class="centered" style="font-size: 16px;">';
    $html .= '<div class="panel panel-red">';
    $html .= '  <div class="panel-heading">';
    $html .= '    <h3 class="panel-title">Error</h3>';
    $html .= '  </div>';
    $html .= '  <div class="panel-body">';
    $html .= '    <b>'.$e->getMessage().'</b>';
    $html .= '    <p><pre>'.$e->getTraceAsString().'</pre></p>';
    $html .= '  </div>';
    $html .= '</div>';
    $html .= '</div>';

    echo $html;
}

/**
 * Convert Errors to ErrorException.
 */
function error_handler($errno, $errstr, $errfile, $errline, array $errcontext)
{
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }

    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

set_error_handler('error_handler');
set_exception_handler('exception_handler');

// create tools menu (cached html menu)
if (!file_exists(WPNXM_DATA_DIR.'tools-topmenu.html')) {
    $projects = new WPNXM\Webinterface\Helper\Projects;
    $projects->listTools();
    unset($projects);
}

$request = new WPNXM\Webinterface\Core\Request();