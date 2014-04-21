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

namespace Webinterface\Helper;

class OpenFile
{
   /**
    * Opens the file (in a background process)
    * @param string $file The file to open.
    */
   public static function openFile($file)
   {
       pclose(popen("start /B notepad ". $file, "r")); 
       /*
       
      // extension check
      if (!class_exists('COM') and !extension_loaded("com_dotnet")) {
          throw new \Exception(
              'The \COM class was not found. The PHP Extension "php_com_dotnet.dll" is required.'
          );
      }

      // file check
      if (false === is_file($file)) {
          throw new \InvalidArgumentException(
              sprintf('File not found: "%s".', $file)
          );
      }

      // tool of choice
      // @todo ask user for the tool, for now open with notepad
      $tool = 'notepad';

       //* Notice, that we are not using exec() here.
       //* Using exec() would leave the page loading, till the executed application window is closed.
       //* Running via WScript.Shell will launch the process in the background.
      $WshShell = new \COM("WScript.Shell");
      $WshShell->run('cmd /c ' . $tool . ' ' . $file, 0, false);
      */
   }
}
