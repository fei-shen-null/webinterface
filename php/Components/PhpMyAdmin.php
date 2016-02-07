<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - onwards, Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

namespace Webinterface\Components;

class PhpMyAdmin extends AbstractComponent
{
    public $name = 'phpMyAdmin';

    public $registryName = 'phpmyadmin';

    public $files = [
        '\www\tools\phpmyadmin\libraries\Config.class.php',
        '\www\tools\phpmyadmin\index.php',
    ];

    public function getVersion()
    {
        if ($this->isInstalled() === false) {
            return 'not installed';
        }

        $file = WPNXM_DIR.$this->files[0];

        $maxLines = 120; // read only the first few lines of the file

        $file_handle = fopen($file, 'r');

        for ($i = 0; $i < $maxLines && !feof($file_handle); $i++) {
            $line = fgets($file_handle, 1024);
            // lets grab the version from this line:
            // $this->set('PMA_VERSION', '4.0.0-beta1');
            preg_match("#PMA_VERSION', '(.*)'#", $line, $matches);

            if (isset($matches[0])) {
                break;
            }
        }
        fclose($file_handle);

        return $matches[1];
    }

    public static function getLink()
    {
        // is phpmyadmin installed?
       if (is_dir(WPNXM_WWW_DIR.'phpmyadmin') === true) {
           $password = \Webinterface\Helper\Serverstack::getPassword('mariadb');
           $href     = WPNXM_ROOT.'tools/phpmyadmin/index.php?lang=en&server=1&pma_username=root&pma_password='.$password;

           return '<a href="'.$href.'">phpMyAdmin</a>';
       }
    }
}
