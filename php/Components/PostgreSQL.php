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
    |    WPИ-XM Serverstack is free software; you can redistribute it and/or modify    |
    |    it under the terms of the GNU General Public License as published by          |
    |    the Free Software Foundation; either version 2 of the License, or             |
    |    (at your option) any later version.                                           |
    |                                                                                  |
    |    WPИ-XM Serverstack is distributed in the hope that it will be useful,         |
    |    but WITHOUT ANY WARRANTY; without even the implied warranty of                |
    |    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                 |
    |    GNU General Public License for more details.                                  |
    |                                                                                  |
    |    You should have received a copy of the GNU General Public License             |
    |    along with this program; if not, write to the Free Software                   |
    |    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA    |
    |                                                                                  |
    +----------------------------------------------------------------------------------+
    *
    * @license    GNU/GPL v2 or (at your option) any later version..
    * @author     Jens-André Koch <jakoch@web.de>
    * @copyright  Jens-André Koch (2010 - onwards)
    * @link       http://wpn-xm.org/
    */

namespace Webinterface\Components;

/**
 * WPN-XM Webinterface - Class for PostgreSQL
 */
class PostgreSQL extends AbstractComponent
{
    /**
     * Init:    initdb.exe <datafolderpath>
     * Start:   pg_ctl.exe -D "<datafolderpath>" -l logfile start
     */

    public $installationFolder = '\bin\postgresql';

    public $files = array(
        // Note: the folder was renamed from "pgsql" (name in the original zip) to "postgresql"
        '\bin\postgresql\bin\initdb.exe',
        '\bin\postgresql\bin\postgresql.conf',
        '\bin\postgresql\bin\pg_ctl.exe' // http://www.postgresql.org/docs/9.3/static/app-pg-ctl.html
    );

    public $configFile = '\bin\postgresql\bin\postgresql.conf';

    /**
     * Returns Version.
     *
     * @return string Version
     */
    public function getVersion()
    {
        return \Webinterface\Helper\Serverstack::printExclamationMark('Not implemented yet!');
    }
}
