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
 * WPN-XM Webinterface - Class for Memcached
 */
class Memcached extends AbstractComponent
{
    public $name = 'Memcached';
    
    public $registryName = 'memcached';
    
    public $installationFolder = '\bin\memcached';

    public $files = array(
        '\bin\memcached\memcached.exe',
        '\bin\memcached\pthreadGC2.dll'
    );

    /**
     * Returns memcached Version.
     *
     * @return string memcached Version
     */
    public function getVersion()
    {
        if (extension_loaded('memcache') === false) {
            return \Webinterface\Helper\Serverstack::printExclamationMark(
                'The PHP Extension "memcache" is required.'
            );
        }

        // hardcoded for now
        $server = 'localhost';
        $port = 11211;

        $memcache = new \Memcache;
        $memcache->addServer($server, $port);

        $version = @$memcache->getVersion();
        $available = (bool) $version;

        if ($available && @$memcache->connect($host, $port)) {
            return $version;
        } else {
            return \Webinterface\Helper\Serverstack::printExclamationMark(
                'Please wake the Memcache daemon.'
            );
        }
    }

    public function getPassword()
    {
        $ini = new \Webinterface\Helper\INIReaderWriter(WPNXM_INI);

        return $ini->get('MariaDB', 'password');
    }

    public function disable()
    {
        // kill running memcached daemon
        Serverstack::stopDaemon('memcached');

        // remove memcached php extension
        // note: extension name is "memcache", daemon name is "memcached"
        $o = new PHPExtensionManager;
        $o->enable('memcache');

        // restart php daemon
        Serverstack::startDaemon('memcached');

        Serverstack::restartDaemon('php');

        //header('Msg: Memcached disabled.');
        header('Location: '.WPNXM_WEBINTERFACE_ROOT.'index.php?page=overview');
    }

    public function enable()
    {
        // add memcached php extension
        // note: extension name is "memcache", daemon name is "memcached"
        $o = new PHPExtensionManager;
        $o->enable('memcache');

        // restart php daemon
        Serverstack::restartDaemon('php');

        // start memcached daemon
        Serverstack::startDaemon('memcached');

        //echo 'Memcached enabled.';
        header('Location: '.WPNXM_WEBINTERFACE_ROOT.'index.php?page=overview');
    }
}
