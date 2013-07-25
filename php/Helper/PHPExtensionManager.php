<?php

namespace Webinterface\Helper;

/**
 * Wrapper for handling php extensions and the php.ini extension section.
 */
class PHPExtensionManager
{
    public $content = '';

    public function readIni()
    {
        if ($this->content === '') {
            $this->content = file(php_ini_loaded_file());
        }

        return $this->content;
    }

    public function writeIni($content)
    {
        return file_put_contents(php_ini_loaded_file(), $content);
    }

    public function disable($name)
    {
        if ($name === 'xdebug') {
            if (!$this->uncommentXdebug(false)) {
               $this->addXdebugExtension();
            }
        }

        if ($this->comment($name) === false) {
             echo 'Disabling '. $name;
            $this->addExtension($name, false);
        }
    }

    public function disableAll()
    {
        $enabledExtensions = $this->getEnabledExtensions();
        var_dump($enabledExtensions);
        foreach($enabledExtensions as $name => $file)
        {

        }
    }

    public function enable($name)
    {
        if ($name === 'xdebug') {
            if (!$this->uncommentXdebug(true)) {
                $this->addXdebugExtension();
            }
        }

        //$this->checkExtensionDirSet();

        if ($this->uncomment($name) === false) {
            echo 'Enabling '. $name;
            $this->addExtension($name, true);
        }
    }

    public function addExtension($name, $enabled = true)
    {
        #  do not add xdebug as as normal extension
        if ($name === 'xdebug') {
            return $this->addXDebugExtension();
        }

        # prepare line to insert
        $new_line = ($enabled === true) ? '' : ';';
        $new_line .= 'extension=' . $name . "\n";

        # read php.ini and determine position of last extension entry
        $lines = array();
        $lines = $this->readIni();
        $index = $this->getIndexOfLastExtensionEntry($lines);

        # insert new line after the last extension entry
        array_splice($lines, $index + 1, 0, $new_line);

        # write php.ini
        $content = array();
        $content = implode('', $lines);

        return $this->writeIni($content);
    }

    public function addXdebugExtension()
    {
        # read php.ini
        $lines = array();
        $lines = $this->readIni();
        # ensure that php.ini contains [Xdebug] section
        foreach ($lines as $index => $line) {
            if(strpos($line, '[XDebug]') !== false) return; # if found, end.
        }
        unset($lines);

        # xdebug section missing; insert XDebug extension template somewhere near php.ini EOF
        $phpiniEOF = '; Local Variables:';

        # load and prepare xdebug php.ini template
        $tpl_content = file_get_contents(WPNXM_DATA_DIR . '/config-templates/xdebug-section-phpini.tpl');
        $search = array('%PHP_EXT_DIR%', '%TEMP_DIR%');
        $replace = array(WPNXM_DIR . '\bin\php\ext\\', WPNXM_DIR . '\temp');
        $content = str_replace($search, $replace, $tpl_content);

        $new_line =  $content . "\n\n" . $phpiniEOF;

        return $this->replaceLineInPHPINI($phpiniEOF, $new_line);
    }

    public function uncommentXdebug($enabled = true)
    {
        # @todo activating xdebug, means also to disable Zend Optimizer
        # ;zend_extension_manager.optimizer_ts

        # read php.ini
        $lines = array();
        $lines = $this->readIni();

        # prepare line to insert
        $new_line = ($enabled === true) ? '' : ';';
        $new_line .= 'zend_extension="'.WPNXM_DIR.'\php\ext\php_xdebug.dll"' . "\n";

        # prepare line to look for in php.ini
        if ($enabled === true) {
            $old_line = ';zend_extension="'.WPNXM_DIR.'\php\ext\php_xdebug.dll"';
        } else {
            $old_line = 'zend_extension="'.WPNXM_DIR.'\php\ext\php_xdebug.dll"';
        }

        # iterate over php.ini lines
        foreach ($lines as $index => $line) {
            if (strpos($line, $old_line) !== false) {
                $lines[$index] = $new_line; # line replace
            }
        }

        # write php.ini
        $content = array();
        $content = implode('', $lines);

        return $this->writeIni($content);
    }

    private function getIndexOfLastExtensionEntry(array $lines)
    {
        $index_last_extension = 0;
        $last_extension_index = '';

        foreach ($lines as $index => $line) {
            // look for extensions=; but not zend_extension
            if ( (strpos($line, 'extension=') !== false) and (strpos($line, 'zend_extension=') === false)) {
                // lookahead parsing (1 line); look for extensions=; but not zend_extension
                if ( (strpos($lines[$index + 1], 'extension=') !== false) and (strpos($line, 'zend_extension=') === false)) {
                    # not the last element
                    continue;
                } else {
                    # found a possible last "extension=" entry.
                    # is overwritten, till end of $lines.
                    $last_extension_index = $index;
                }
            }
        }

        return $last_extension_index;
    }

    private function comment($name)
    {
        $old_line = $this->getExtensionLineFromPHPINI($name);

        # extension not found, return early
        if ($old_line === null) {
            return false;
        }

        $old_line = trim($old_line);

        # extension found, do comment, if line uncommented
         if (strpos($old_line, 'extension=') !== false) {
            $new_line = ';' . $old_line;
            $this->replaceLineInPHPINI($old_line, $new_line);
        }

        return true;
    }

    private function uncomment($name)
    {
        $old_line = $this->getExtensionLineFromPHPINI($name);

        # extension not found, return early
        if ($old_line === null) {
            return false;
        }

        # extension found, do uncomment, if line commented
        if (strpos($old_line, ';extension=') !== false) {
            $new_line = ltrim($old_line, ';');
            $this->replaceLineInPHPINI($old_line, $new_line);
        }

        return true;
    }

    /**
     * Fetches the line from php.ini where the php extension is found.
     */
    private function getExtensionLineFromPHPINI($name)
    {
        $lines = file(php_ini_loaded_file());
        foreach ($lines as $line) {
            if (strpos($line, $name) !== false) {
                return $line;
            }
        }
    }

    private function replaceLineInPHPINI($old_line, $new_line)
    {
        $content = $this->readIni();
        $content_replaced = str_replace($old_line, $new_line, $content);

        return $this->writeIni($content_replaced);
    }

    public function getExtensionDirFileList()
    {
        $files = array();
        $list = array();

        $files = glob(WPNXM_DIR . '/bin/php/ext/*.dll');

        foreach ($files as $key => $file) {
            // $list array has the following structure
            // key = filename without suffix
            // value = filename with suffix
            // e.g. $list = array ( 'php_apc' => 'php_apc.dll' )
            $list[ basename($file, '.dll') ] = basename($file);
        }

        return $list;
    }

    public function getExtensionsLoaded()
    {
        $extFiles = $this->getExtensionDirFileList();
        foreach ($extFiles as $key => $value) {
            $value = str_replace(array('php_', '.dll'), '', $value);
            $list[$value] = extension_loaded($value);
        }
        return $list;
    }

    public static function getEnabledExtensionsFromIni()
    {
        $enabled_extensions = array();
        $extension = '';

        // read php.ini
        $ini_file = php_ini_loaded_file();

        $ini = new \Webinterface\Helper\INIReaderWriter($ini_file);
        $ini->read($ini_file);
        $lines = $ini->returnArray();

        // check php.ini array for extension entries
        foreach ($lines as $line) {
            if ($line['type'] != 'entry') {
                continue;
            }
            if ($line['key'] != 'extension') {
                continue;
            }

            $extension = $line['value'];

            // cut everything of after ".dll"
            // as there might be comments on the line (; #)
            $extension = substr($extension, 0, strpos($extension, '.dll'));

            // and stuff them in the array
            $enabled_extensions[] = $extension . '.dll';
        }

        asort($enabled_extensions);

        // do a key/value flip, to get rid of the numeric index.
        // this is for being able to easily check for a extension filename with isset in foreach.
        return array_flip($enabled_extensions);
    }

    /**
     * This method ensures that the 'extension_dir' directive is not commented in php.ini.
     * Otherwise PHP will not load any extensions.
     */
    public function checkExtensionDirSet()
    {
        $lines = $this->readIni();

        foreach ($lines as $line) {
            if (strpos($line, '; extension_dir = "ext"') !== false) {
                // uncomment the line
                $new_line = ltrim($line, '; ');
                $this->replaceLineInPHPINI($line, $new_line);
                break;
            }
        }
    }
}
