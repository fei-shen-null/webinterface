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
     * Returns an array with all domain conf files
     * associated with their loading state.
     */
    public static function listDomains()
    {
        // get all domain config files
        $domainFiles = glob(NGINX_DOMAINS_DIR . '*.conf');

        // enhance the array structure a bit, by adding pure filenames
        $domains = array();
        foreach ($domainFiles as $key => $fqpn) {
            $domains[] = array(
                'fqpn' => $fqpn,
                'filename' => basename($fqpn)
            );
        }
        unset($domainFiles);

        // ensure the domain.conf is included in nginx.conf
        if (self::isDomainsConfIncludedInNginxConf()) {
            $loaded_domains = array();

            $domain_conf_lines = file(NGINX_CONF_DIR . 'domains.conf');

            // examine each line
            foreach ($domain_conf_lines as $domain_conf_line) {
                // and match all lines with string "included domains", but not the ones commented out/off
                // on match, $matches[1] contains the "filename.conf"
                if (preg_match('/[^;#]include domains\/(.*\\.conf)/', $domain_conf_line, $matches)) {
                    // add the conf to the loaded domains array
                    $loaded_domains['filename'] = $matches[1];
                }
            }
        } else {
            throw new \Exception(
                NGINX_CONF_DIR . 'nginx.conf misses to load the domains configuration. Add "include domains.conf;".'
            );
        }

        // loop over all available domain files and each loaded_domain
        foreach ($domains as $key => $domain) {
            foreach ($loaded_domains as $loaded_domain) {
                // compare the filenames and mark the loaded files
                if ($domain['filename'] === $loaded_domain) {
                    $domains[$key]['loaded'] = true;
                }
            }
        }

        return $domains;
    }

    public static function isDomainsConfIncludedInNginxConf()
    {
        $nginxConfigLines = file(NGINX_CONF_DIR . 'nginx.conf');

        foreach ($nginxConfigLines as $nginx_conf_line) {
            if (strpos($nginx_conf_line, 'include domains.conf;') !== false) {
                return true;
            }
        }

        return false;
    }

}