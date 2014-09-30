<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - 2014 Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

namespace Webinterface\Components;

/**
 * WPN-XM Webinterface - Class for PHP
 */
class PHP extends AbstractComponent
{
    public $name = 'PHP';

    public $registryName = 'php';

    public $installationFolder = '\bin\php';

    public $files = array(
        '\bin\php\php.ini',
        '\bin\php\php.exe'
    );

    public $configFile = '\bin\php\php.ini';

    /**
     * Returns PHP Version.
     *
     * @return string PHP Version
     */
    public function getVersion()
    {
        return PHP_VERSION;
    }

    public static function getPHPExtensionDirectory()
    {
        $phpinfo = \Webinterface\Helper\PHPInfo::getPHPInfo(true);

        $extensionDir = '';

        if (preg_match('/extension_dir([ =>\t]*)([^ =>\t]+)/', $phpinfo, $matches)) {
            $extensionDir = $matches[2];
        }

        return $extensionDir;
    }
}
