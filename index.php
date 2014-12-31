<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - onwards, Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

include 'bootstrap.php';

// page controller
$page = @$_GET['page'] ?: 'projects';
$pagecontroller = WPNXM_CONTROLLER_DIR . $page . '.php';
if (is_file($pagecontroller)) { include $pagecontroller; } else { throw new \Exception('Error: PageController "' . $page . '" not found (' . $pagecontroller . ').'); }

// automatically load helper file if existing
$helper = WPNXM_HELPER_DIR . $page . '.php';
if (is_file($helper)) { include $helper; }

// action controller
$action = @$_GET['action'] ?: 'index';
$action = strtr($action, '-', '_'); // minus to underscore conversion
if (!is_callable($action)) { throw new \Exception('Error: Action "' . $action . '" not found in PageController "' . $page . '".'); }
$action();

// view renderer (dynamic)
function render($view = 'page-action', $template_vars = array())
{
    // fallback to current page, if called empty
    global $page, $action; if ($view === 'page-action') { $view = ucfirst($page) . DS . $action; }
    extract($template_vars);
    ob_start();
    include WPNXM_HELPER_DIR . 'Viewhelper.php';
    if (!isset($no_layout) or $no_layout === false) { include WPNXM_VIEW_DIR . 'header.php'; }
    $view_file = WPNXM_VIEW_DIR . $view . '.php';
    if (is_file($view_file)) { include $view_file; } else { throw new \Exception('Error: View "' . $view_file . '" not found.'.$view); }
    if (!isset($no_layout) or $no_layout === false) { include WPNXM_VIEW_DIR . 'footer.php'; }

    return ob_end_flush();
}
