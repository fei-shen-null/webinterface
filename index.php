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

// common bootstrap file with paths, constants, etc.
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
    global $page, $action; if ($view === 'page-action') { $view = $page . '-' . $action; }
    extract($template_vars);
    ob_start();
    include WPNXM_HELPER_DIR . 'Viewhelper.php';
    if (!isset($no_layout) or $no_layout === false) { include WPNXM_VIEW_DIR . 'header.php'; }
    $view_file = WPNXM_VIEW_DIR . $view . '.php';
    if (is_file($view_file)) { include $view_file; } else { throw new \Exception('Error: View "' . $view_file . '" not found.'); }
    if (!isset($no_layout) or $no_layout === false) { include WPNXM_VIEW_DIR . 'footer.php'; }

    return ob_end_flush();
}
