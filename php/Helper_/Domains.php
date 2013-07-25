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

namespace Webinterface\Helper;

/**
 * Domains
 *
 * VirtualHosts are a term and functionality found on Apache Servers.
 * The VirtualHosts concept is unknown to Nginx.
 * For Nginx it's simply a new server directive.
 * In fact, it's simply a "local domain name".
 * That's why WPN-XM calls this Domain.
 */
class Domains
{
    /**
     * Get a list of all domain config files and their loading state.
     *
     * @return array Array of all domain conf files and their loading state.
     */
    public static function listDomains()
    {
        if (false === self::areEnabledDomainsLoadedByNginxConf()) {
            // tell the world that "nginx.conf" misses "include domains.conf;"
            exit(sprintf('<div class="error bold" style="font-size: 13px; width: 500px;">
                %snginx.conf does not include the config files of the domains-enabled folder.<br><br>
                    Please add "include bin/nginx/conf/domains-enabled/*;" to "nginx.conf".</div>',
                WPNXM_DIR . '\bin\nginx\conf\\'));
        }

        $enabledDomains = glob(WPNXM_DIR . '\bin\nginx\conf\domains-enabled\*.conf');

        $disabledDomains = glob(WPNXM_DIR . '\bin\nginx\conf\domains-disabled\*.conf');

        $domains = array();

        foreach ($enabledDomains as $idx => $file) {
            $domain = basename($file, '.conf');
            $domains[$domain] = array(
                'fullpath' => $file,
                'filename' => basename($file),
                'enabled' => true
            );
        }

        foreach ($disabledDomains as $idx => $file) {
            $domain = basename($file, '.conf');
            $domains[$domain] = array(
                'fullpath' => $file,
                'filename' => basename($file),
                'enabled' => false
            );
        }

        return $domains;
    }

    /**
     * Check, if nginx.conf contains the line to load all enabled domains.
     *
     * @return boolean True, if line exists, so domains get loaded. Otherwise, false.
     */
    public static function areEnabledDomainsLoadedByNginxConf()
    {
        $lines = file(WPNXM_DIR . '\bin\nginx\conf\nginx.conf');

        foreach ($lines as $line) {
            // return true, if the line exists and is not commented
            if (preg_match('/(.*)include bin\/nginx\/conf\/domains-enabled\/\*/', $line, $matches)) {
                $comment = trim($matches[1]);
                return ($comment === ';' or $comment === '#') ? false : true;
            }
        }
        return false;
    }

}