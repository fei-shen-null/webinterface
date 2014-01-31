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
}
