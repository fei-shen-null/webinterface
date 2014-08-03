<?php
namespace Webinterface\Helper;

class PHPVersionSwitch
{
    public static function switchVersion($newVersion)
    {
        $targetFolder     = WPNXM_BIN . 'php';
        $newVersionFolder = WPNXM_BIN . 'php-' . $newVersion;
        $oldVersionFolder = WPNXM_BIN . 'php-' . PHP_VERSION;

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

        return true;
    }

    public static function getFolders()
    {
        return glob(WPNXM_BIN . 'php*', GLOB_ONLYDIR);
    }

    public static function getFolderVersion($dir)
    {
        $enableErrorLogging = ' -d log_errors=on -d error_log=' . WPNXM_DIR . 'logs/php_error.log';

        $out = shell_exec($dir . '\php.exe -v' . $enableErrorLogging);

        return trim(substr($out, 4, 6));
    }

    public static function getCurrentVersion()
    {
        return self::getFolderVersion(WPNXM_BIN . 'php');
    }

    public static function getVersions()
    {
        self::renameFoldersVersionized();

        return self::determinePhpVersions();
    }

    public static function determinePhpVersions()
    {
        $dirs = self::getFolders();

        // fetch php version from all php folders
        foreach($dirs as $key => $dir) {
            $php_version = self::getFolderVersion($dir);
            $dirs[$key] = array(
                'dir' => $dir,
                'php-version' => $php_version
            );
        }

        return $dirs;
    }

    /**
     * Automatically renames all folders starting with "bin\php*" to "php-x.y.z".
     */
    public static function renameFoldersVersionized()
    {
        $folders = self::determinePhpVersions();

        array_shift($folders); // pop first item, its "bin\php"

        foreach($folders as $key => $folder) {
            if(false === strpos($folder['dir'], $folder['php-version'])) {
                $newFolderName = WPNXM_BIN .'\php-' . $folder['php-version'];

                // chmod, because the folder might be hidden or write protected
                self::chmodDeep($folder['dir'], 0755);

                rename($folder['dir'], $newFolderName);
            }
        }
    }

    public static function chmodDeep($path, $perms = 0777)
    {
        $dir = new \DirectoryIterator($path);
        foreach ($dir as $item) {
            chmod($item->getPathname(), $perms);
            if ($item->isDir() && !$item->isDot()) {
                self::chmodDeep($item->getPathname());
            }
        }
    }
}
