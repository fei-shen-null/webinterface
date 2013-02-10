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

/**
 * Virtual Hosts (Local Domains)
 *
 * VirtualHosts are a term and functionality found on Apache Servers.
 * The VirtualHosts concept is unknown to Nginx.
 * For Nginx it's simply a new server directive - in fact it's a local domain name.
 */
class VirtualHosts {

    public function listVirtualHosts()
    {
        $vhosts = array();
        $handle = opendir(NGINX_VHOSTS_DIR);
        while ($dir = readdir($handle)) {
            if ($dir == "." or $dir == "..") { continue; }
            $vhosts[] = $dir;
        }
        closedir($handle);
        asort($vhosts);

        return $vhosts; /* array: fqpn, filename, loaded */
    }
}