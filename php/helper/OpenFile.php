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

namespace Webinterface\Helper;

/**
 * Opens the file (in a background process)
 * @param $file The file to open.
 */
function openFile($file)
{
    if (false === is_file($file)) {
        echo 'Error - File "' . $file . '" not found.';

        return;
    }

    // @todo ask user for the tool to use, for now open with notepad
    $tool = 'notepad';

    // check for "COM" (php_com_dotnet.dll)
    if (!class_exists('COM') and !extension_loaded("com_dotnet")) {
        $msg = 'COM class not found. Enable the extension by adding "extension=php_com_dotnet.dll" to your php.ini.';
        throw new Exception($msg);
    }

    /**
     * Notice, that we are not using exec() here.
     * Using exec() would leave the page loading, till the executed app window is closed.
     * Running via WScript.Shell will launch the process in the background.
     */
    $WshShell = new COM("WScript.Shell");
    $WshShell->run('cmd /c ' . $tool . ' ' . $file, 0, false);
}
