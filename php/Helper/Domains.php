<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - onwards, Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
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
                    Please add "include domains-enabled/*;" to "nginx.conf".</div>',
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
            if (preg_match('/(.*)include domains-enabled\/\*/', $line, $matches)) {
                $comment = trim($matches[1]);

                return ($comment === ';' or $comment === '#') ? false : true;
            }
        }

        return false;
    }

}
