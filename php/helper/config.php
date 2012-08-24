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

function disable_memcached()
{
    include WPNXM_HELPER_DIR . 'phpini.php';
    include WPNXM_HELPER_DIR . 'serverstack.php';

    // kill running memcached daemon
    Serverstack::stopDaemon('memcached');

    // remove memcached php extension
    // note: extension name is "memcache", daemon name is "memcached"
    (new phpextension)->enable('memcache');
    // restart php daemon
    Serverstack::startDaemon('memcached');

    Serverstack::restartDaemon('php');

    //header('Msg: Memcached disabled.');
    header('Location: index.php?page=overview');
}

function enable_memcached()
{
    include WPNXM_HELPER_DIR . 'phpini.php';
    include WPNXM_HELPER_DIR . 'serverstack.php';

    // add memcached php extension
    // note: extension name is "memcache", daemon name is "memcached"
    (new phpextension)->enable('memcache');

    // restart php daemon
    Serverstack::restartDaemon('php');

    // start memcached daemon
    Serverstack::startDaemon('memcached');

    //echo 'Memcached enabled.';
    header('Location: index.php?page=overview');
}

function disable_xdebug()
{
    include WPNXM_HELPER_DIR . 'phpini.php';
    include WPNXM_HELPER_DIR . 'serverstack.php';

    // remove xdebug php extension
    (new phpextension)->disable('xdebug');

    // restart php daemon
    Serverstack::restartDaemon('php');

    //echo 'Xdebug disabled.';
    header('Location: index.php?page=overview');
}

function enable_xdebug()
{
    include WPNXM_HELPER_DIR . 'phpini.php';
    include WPNXM_HELPER_DIR . 'serverstack.php';

    // add xdebug php extension
    (new phpextension)->enable('xdebug');

    // restart php daemon
    Serverstack::restartDaemon('php');

    //echo 'Xdebug enabled.';
    header('Location: index.php?page=overview');
}

function xdebug_ini_keys()
{
    $ini_xdebug = ini_get_all('xdebug');
}

/**
 * Returns an array with all vhost conf files
 * associated with their loading state.
 */
function getVhosts()
{
    // fetch all vhosts config files
    $vhost_files = array();
    $vhost_files = glob( NGINX_VHOSTS_DIR . '*.conf' );

    // enhance the array structure a bit, by adding pure filenames
    $vhosts = array();
    foreach ($vhost_files as $key => $fqpn) {
        $vhosts[] = array(
            'fqpn' => $fqpn,
            'filename' => basename($fqpn)
        );
    }
    unset($vhost_files);

    // ensure the vhost.conf is included in nginx.conf
    if (isVhostsConfIncludedInNginxConf()) {
        // we might have some vhosts loaded
        $loaded_vhosts = array();

        // take a look at vhost.conf
        $vhost_conf_lines = file( NGINX_CONF_DIR . 'vhosts.conf' );

        // examine each line
        foreach ($vhost_conf_lines as $vhost_conf_line) {
            // and match all lines with string "included vhosts", but not the ones commented out/off
            // on match, $matches[1] contains the "filename.conf"
            if (preg_match('/[^;#]include vhosts\/(.*\\.conf)/', $vhost_conf_line, $matches)) {
                // add the conf to the loaded vhosts array
                $loaded_vhosts['filename'] = $matches[1];
            }
        }
    } else {
        throw new Exception('Line missing in nginx.conf to load the vhosts configuration. Add "include vhosts.conf;".');
    }

    // loop over all available files
    foreach ($vhosts as $key => $vhost) {
        // loop over each loaded_vhost
        foreach ($loaded_vhosts as $loaded_vhost) {
            // compare the filenames
            if ($vhost['filename'] === $loaded_vhost) {
                // mark the loaded files
                $vhosts[$key]['loaded'] = true;
            }
        }
    }

    return $vhosts;
}

function isVhostsConfIncludedInNginxConf()
{
    $nginx_conf_lines = file( NGINX_CONF_DIR . 'nginx.conf' );

    foreach ($nginx_conf_lines as $nginx_conf_line) {
       if (strpos($nginx_conf_line, 'include vhosts.conf;') !== false) {
            return true;
       }
    }

    return false;
}
