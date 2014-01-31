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
 * WPN-XM Webinterface - Class for XDebug
 */
class XDebug extends AbstractComponent
{
    public $name = 'XDebug';
    
    public $registryName = 'phpext_xdebug';

    public $type = 'PHP Extension';

    public $installationFolder = '\bin\php\ext';

    public $files = array(
        '\bin\php\ext\php_xdebug.dll'
    );

    public $configFile = '\bin\php\php.ini';

     /**
     * Returns Xdebug Version.
     *
     * @return string Xdebug Version
     */
    public function getVersion()
    {
        $xdebug_version = 'false';
        $matches = '';
        $phpinfo = \Webinterface\Helper\PHPInfo::getPHPInfo(true);

        // Check phpinfo content for Xdebug as Zend Extension
        if (preg_match('/with\sXdebug\sv([0-9.rcdevalphabeta-]+),/', $phpinfo, $matches)) {
            $xdebug_version = $matches[1];
        }

        return $xdebug_version;
    }

    public static function getXDebugExtensionType()
    {
        $phpinfo = \Webinterface\Helper\PHPInfo::getPHPInfo(true);
        $matches = '';

        // Check phpinfo content for Xdebug as Zend Extension
        if (preg_match('/with\sXdebug\sv([0-9.rcdevalphabeta-]+),/', $phpinfo, $matches)) {
            return 'Zend Extension';
        }

        // Check phpinfo content for Xdebug as normal PHP extension
        if (preg_match('/xdebug support/', $phpinfo, $matches)) {
            return 'PHP Extension';
        }

        return ':( XDebug not loaded.';
    }

    public function disable()
    {
        // remove xdebug php extension
        $o = new PHPExtensionManager;
        $o->disable('xdebug');

        // restart php daemon
        Serverstack::restartDaemon('php');

        //echo 'Xdebug disabled.';
        header('Location: '.WPNXM_WEBINTERFACE_ROOT.'index.php?page=overview');
    }

    public function enable()
    {
        // add xdebug php extension
        $o = new PHPExtensionManager;
        $o->enable('xdebug');

        // restart php daemon
        Serverstack::restartDaemon('php');

        //echo 'Xdebug enabled.';
        header('Location: '.WPNXM_WEBINTERFACE_ROOT.'index.php?page=overview');
    }
}
