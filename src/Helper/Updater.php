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

use Webinterface\Helper\Downloader;

class Updater
{
    public static function updateRegistries()
    {
        // WPN-XM Software Registry
        Downloader::downloadIfNotExistsOrOld(
            'https://raw.githubusercontent.com/WPN-XM/registry/master/wpnxm-software-registry.php',
            WPNXM_DATA_DIR.'wpnxm-software-registry.php'
        );
        
        // WPN-XM Software Registry Metadata
        /*Downloader::downloadIfNotExistsOrOld(
            'https://raw.githubusercontent.com/WPN-XM/registry/master/wpnxm-registry-metadata.php',
            WPNXM_DATA_DIR.'wpnxm-registry-metadata.php'
        );*/
           
        // WPN-XM PHP Software Registry
        Downloader::downloadIfNotExistsOrOld(    
            'https://raw.githubusercontent.com/WPN-XM/registry/master/wpnxm-php-software-registry.php',   
            WPNXM_DATA_DIR.'wpnxm-php-software-registry.php'
        );
        
        // PHP Extensions on PECL
        Downloader::downloadIfNotExistsOrOld(
            'https://raw.githubusercontent.com/WPN-XM/registry/master/php-extensions-on-pecl.json',
            WPNXM_DATA_DIR.'php-extensions-on-pecl.json'
        );                    
    }
}
