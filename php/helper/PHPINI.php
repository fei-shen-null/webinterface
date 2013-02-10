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
    * @copyright  Jens-André Koch (2010 - 2012)
    * @link       http://wpn-xm.org/
    */

namespace Webinterface\Helper;

use Webinterface\Helper\INIReaderWriter;

/**
 * Wrapper for handling php.ini with ini class.
 */
class PHPINI
{
    public static function read()
    {
        $ini_file = php_ini_loaded_file();

        $ini = new INIReaderWriter();
        $ini->read($ini_file);
        $ini_array  = $ini->returnArray();

        return compact('ini_file', 'ini_array');
    }

    public static function setDirective($section, $directive, $value)
    {
        // $this->doBackup(); @todo add backup functionality, before writing

        $ini_file = php_ini_loaded_file();
        $ini = new INIReaderWriter();
        $ini->read($ini_file);
        $ini->set($section, $directive, $value);
        $ini->write($ini_file);

        return true;
    }

    public static function doBackup()
    {
        // copy whole file

        // add date/time to new file name

        // keep last 3 files, remove older files
        return true;
    }
}
