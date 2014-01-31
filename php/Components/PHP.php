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
    |    WPИ-XM Server Stack is free software; you can redistribute it and/or modify   |
    |    it under the terms of the GNU General Public License as published by          |
    |    the Free Software Foundation; either version 2 of the License, or             |
    |    (at your option) any later version.                                           |
    |                                                                                  |
    |    WPИ-XM Server Stack is distributed in the hope that it will be useful,        |
    |    but WITHOUT ANY WARRANTY; without even the implied warranty of                |
    |    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                 |
    |    GNU General Public License for more details.                                  |
    |                                                                                  |
    |    You should have received a copy of the GNU General Public License             |
    |    along with this program; if not, write to the Free Software                   |
    |    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA    |
    |                                                                                  |
    +----------------------------------------------------------------------------------+
    */

namespace Webinterface\Components;

/**
 * WPN-XM Webinterface - Class for PHP
 */
class PHP extends AbstractComponent
{
    public $name = 'PHP';
    
    public $registryName = 'php';
    
    public $installationFolder = '\bin\nginx';

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
        $matches = '';
        $extensionDir = '';

        if (preg_match('/extension_dir([ =>\t]*)([^ =>\t]+)/', $phpinfo, $matches)) {
            $extensionDir = $matches[2];
        }

        return $extensionDir;
    }
}
