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

use Webinterface\Helper\INIReaderWriter;

/**
 * Wrapper for handling php.ini with ini class.
 */
class PHPINI
{
    /**
     * @return array $ini array structure = 'ini_file', 'ini_array'
     */
    public static function read()
    {
        $ini_file = php_ini_loaded_file();

        if ($ini_file === false) {
            throw new \Exception(
                'The path to the loaded php.ini file could not be retrieved. Check PHP folder for a "php.ini" file!'
            );
        }

        $ini = new INIReaderWriter($ini_file);
        $ini_array  = $ini->returnArray();

        return compact('ini_file', 'ini_array');
    }

    /**
     * @param string $section
     */
    public static function setDirective($section, $directive, $value)
    {
        $ini_file = php_ini_loaded_file();
        
        self::doBackup($ini_file);

        $ini = new INIReaderWriter($ini_file);
        $ini->set($section, $directive, $value);

        $ini->write($ini_file);

        return true;
    }

    /**
     * @param string $file
     */
    public static function doBackup($file)
    {
        $newFilename = str_replace('.ini', '', $file);
        $newFilename .= '-backup-' . date("dmy-His") . '.ini';
    
        // backup current registry
        copy($file, $newFilename);

        // keep last 3 files, remove older files
        self::removeOldBackupFiles();
        
        return true;
    }
    
    public static function removeOldBackupFiles()
    {
        $files = glob(WPNXM_BIN . 'php\php-backup-*.ini');
        $c = count($files);
        if ($c > 3) {
            rsort($files);            
            for ($i = 3; $i <= $c; $i++) {
                unlink(trim($files[$i]));
            }            
        }
    }

}
