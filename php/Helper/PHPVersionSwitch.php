<?php
namespace Webinterface\Helper;

class PHPVersionSwitch
{
    public static function switchVersion($newVersion)
    {
        $targetFolder     = WPNXM_BIN . '\php';
        $newVersionFolder = WPNXM_BIN . '\php-' . $newVersion;
        $oldVersionFolder = WPNXM_BIN . '\php-' . PHP_VERSION;

        if (is_dir($targetFolder) === false) {
            throw new \Exception(sprintf(
                'Folder (%s) is missing. Check your environment.', $targetFolder)
            );
        }

        if (is_dir($oldVersionFolder) === true) {
            throw new \Exception(sprintf(
                'The folder (%s) for the current version already exists.', $oldVersionFolder)
            );
        }

        if (is_dir($newVersionFolder) === false) {
            throw new \Exception(sprintf(
                'You are trying to switch to a PHP version not existing (%s).', $newVersionFolder)
            );
        }
        
        if (rename($targetFolder, $oldVersionFolder) === false) {
            throw new \Exception(sprintf('Renaming (%s) to (%s) failed.', $targetFolder, $oldVersionFolder));
        }

        if (rename($newVersionFolder, $targetFolder) === false) {
            throw new \Exception(sprintf('Renaming (%s) to (%s) failed.', $newVersionFolder, $targetFolder));
        }
    }
}