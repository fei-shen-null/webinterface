<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - 2014 Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
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
