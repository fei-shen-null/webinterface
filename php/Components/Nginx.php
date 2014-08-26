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
 * WPN-XM Webinterface - Class for Nginx
 */
class Nginx extends AbstractComponent
{
    public $name = 'Nginx';

    public $registryName = 'nginx';

    public $installationFolder = '\bin\nginx';

    public $files = array(
        '\bin\nginx\conf\nginx.conf',
        '\bin\nginx\bin\nginx.exe'
    );

    public $configFile = '\bin\nginx\conf\nginx.conf';

    /**
     * Returns Version.
     *
     * @return string Version
     */
    public function getVersion()
    {
        if (strpos($_SERVER["SERVER_SOFTWARE"], 'Apache') !== false) {
            return \Webinterface\Helper\Serverstack::printExclamationMark('Traitor - you are using Apache!');
        }

        if (strpos($_SERVER["SERVER_SOFTWARE"], 'Development Server') !== false) {
            return \Webinterface\Helper\Serverstack::printExclamationMark('The webinterface is served via the embedded PHP Development Server!');
        }

        return substr($_SERVER["SERVER_SOFTWARE"], 6);
    }

    public function install()
    {
        $this->unzip($file, $installationFolder);
    }
}
