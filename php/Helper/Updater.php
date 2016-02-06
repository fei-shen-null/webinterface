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

class Updater
{
    public static function updateRegistry()
    {
        // WPN-XM Software Registry - Latest Version @ GitHub
        $url = 'https://raw.githubusercontent.com/WPN-XM/registry/master/wpnxm-software-registry.php';

        // fetch date header (doing a simple HEAD request)
        stream_context_set_default([
            'http' => [
                'method' => 'HEAD'
            ]
        ]);

        // silenced: throws warning, if offline
        $headers = @get_headers($url, 1);

        // we are offline
        if(empty($headers) === true) {
            return false;
        }

        $file = WPNXM_DATA_DIR . 'wpnxm-software-registry.php';

        // parse header date
        $date = \DateTime::createFromFormat('D, d M Y H:i:s O', $headers['Date']);
        $last_modified = filemtime($file);

        // update condition, older than 1 week
        $needsUpdate = $date->getTimestamp() >= $last_modified + (7 * 24 * 60 * 60);

        // do update
        $updated = false;
        if($needsUpdate === true) {

            // set request method back to GET, to fetch the file
            stream_context_set_default([
                'http' => [
                    'method' => 'GET'
                ]
            ]);

           $updated = file_put_contents($file, file_get_contents($url));
        }

        return $updated;
    }
}
