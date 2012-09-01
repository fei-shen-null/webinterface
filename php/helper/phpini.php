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

/**
 * Wrapper for handling php.ini with ini class.
 */
class phpini
{
    public static function read()
    {
        $ini_file = php_ini_loaded_file();

        $ini = new ini();
        $ini->read(php_ini_loaded_file());
        $ini_array  = $ini->returnArray();

        return compact('ini_file', 'ini_array');
    }

    public static function setDirective($section, $directive, $value)
    {
        // $this->doBackup(); @todo add backup functionality, before writing

        $ini_file = php_ini_loaded_file();

        $ini = new ini();
        $ini->read($ini_file);

        $ini->set($section, $directive, $value);

        $ini->write(php_ini_loaded_file());

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

/**
 * INI Reader and Writer
 * The file content is in array $lines.
 */
class ini
{
    protected $lines;
    protected $file;

    public function __construct($file = '')
    {
        if ($file != '') {
            $this->file = $file;
            $this->read($file);
        }
    }

    public function read($file)
    {
        $this->lines = array();

        $section = '';

        foreach (file($file) as $line) {
            // comment or whitespace
            if (preg_match('/^\s*(;.*)?$/', $line)) {
                $this->lines[] = array('type' => 'comment', 'data' => $line);
            // section
            } elseif (preg_match('/\[(.*)\]/', $line, $match)) {
                $section = $match[1];
                $this->lines[] = array('type' => 'section', 'data' => $line, 'section' => $section);
            // entry
            } elseif (preg_match('/^\s*(.*?)\s*=\s*(.*?)\s*$/', $line, $match)) {
                $this->lines[] = array('type' => 'entry', 'data' => $line, 'section' => $section, 'key' => $match[1], 'value' => $match[2]);
            }
        }

        return $this;
    }

    public function get($section, $key)
    {
        foreach ($this->lines as $line) {
            if($line['type'] != 'entry') continue;
            //if($line['section'] != $section) continue;
            if($line['key'] != $key) continue;

            return $line['value'];
        }

        //throw new Exception('Missing Section or Key');
    }

    public function set($section, $key, $value)
    {
        foreach ($this->lines as &$line) {
            if($line['type'] != 'entry') continue;
            //if($line['section'] != $section) continue;
            if($line['key'] != $key) continue;
            $line['value'] = $value;
            $line['data'] = $key . " = " . $value . "\r\n";

            return;
        }

        throw new Exception('Missing Section or Key');
    }

    public function write($file = '')
    {
        if ($file == '') {
            $file = $this->file;
        }

        $fp = fopen($file, 'w');

        foreach ($this->lines as $line) {
            fwrite($fp, $line['data']);
        }

        fclose($fp);
    }

    public function returnArray()
    {
        return $this->lines;
    }
}

/**
 * Wrapper for handling php extensions and the php.ini extension section.
 */
class phpextension
{
    public $content = '';

    public function read_ini()
    {
        if ($this->content === '') {
            $this->content = file(php_ini_loaded_file());
        }

        return $this->content;
    }

    public function write_ini($content)
    {
        return file_put_contents(php_ini_loaded_file(), $content);
    }

    public function disable($name)
    {
        if ($name === 'xdebug') {
            if (!$this->uncomment_xdebug(false)) {
               $this->addXdebugExtension();
            }
        }

        if (!$this->comment($name)) {
            $this->addExtension($name, false);
        }
    }

    public function enable($name)
    {
        if ($name === 'xdebug') {
            if (!$this->uncomment_xdebug(true)) {
                $this->addXdebugExtension();
            }
        }

        $this->checkExtensionDirSet();

        if (!$this->uncomment($name)) {
            $this->addExtension($name, true);
        }
    }

    public function addExtension($name, $enabled = true)
    {
        # nah, do not add xdebug as as normal extension
        if ($name === 'xdebug') {
            $this->addXDebugExtension();

            return;
        }

        # prepare line to insert
        $new_line = ($enabled === true) ? '' : ';';
        $new_line .= 'extension=php_' . $name . '.dll' . "\n";

        # read php.ini and determine position of last extension entry
        $lines = array();
        $lines = $this->read_ini();
        $index = $this->getIndexOfLastExtensionEntry($lines);

        # insert new line after the last extension entry
        array_splice($lines, $index + 1, 0, $new_line);

        # write php.ini
        $content = array();
        $content = implode('', $lines);

        return $this->write_ini($content);
    }

    public function addXdebugExtension()
    {
        # read php.ini
        $lines = array();
        $lines = $this->read_ini();
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
        $replace = array(WPNXM_DIR . 'bin\php\ext\\', WPNXM_DIR . 'temp');
        $content = str_replace($search, $replace, $tpl_content);

        $new_line =  $content . "\n\n" . $phpiniEOF;

        return $this->replaceLineInPHPINI($phpiniEOF, $new_line);
    }

    public function uncomment_xdebug($enabled = true)
    {
        # @todo activating xdebug, means also to disable Zend Optimizer
        # ;zend_extension_manager.optimizer_ts

        # read php.ini
        $lines = array();
        $lines = $this->read_ini();

        # prepare line to insert
        $new_line = ($enabled === true) ? '' : ';';
        $new_line .= 'zend_extension="'.WPNXM_DIR.'php\ext\php_xdebug.dll"' . "\n";

        # prepare line to look for in php.ini
        if ($enabled === true) {
            $old_line = ';zend_extension="'.WPNXM_DIR.'php\ext\php_xdebug.dll"';
        } else {
            $old_line = 'zend_extension="'.WPNXM_DIR.'php\ext\php_xdebug.dll"';
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

        return $this->write_ini($content);
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
        if ($old_line === null) { return false; }

        # extension found, do comment, if line uncommented
        if (strpos($old_line, ';extension') !== false) {
            $new_line = ';' . $line;
            $this->replaceLineInPHPINI($old_line, $new_line);
        }

        return true;
    }

    private function uncomment($name)
    {
        $old_line = $this->getExtensionLineFromPHPINI($name);

        # extension not found, return early
        if ($old_line === null) { return false; }

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
        $content = $this->read_ini();
        $content_replaced = str_replace($old_line, $new_line, $content);

        return $this->write_ini($content_replaced);
    }

    public function getExtensionDirFileList()
    {
        $glob = $list = array(); // PHP SYNTAX reminder $glob, $list = array();

        $glob = glob(WPNXM_DIR ."bin/php/ext/*.dll");

        foreach ($glob as $key => $file) {
            // $list array has the following structure
            // key = filename without suffix
            // value = filename with suffix
            // e.g. $list = array ( 'php_apc' => 'php_apc.dll' )
            $list[ basename($file, '.dll') ] = basename($file);
        }

        unset($glob);

        return $list;
    }

    public static function getEnabledExtensions()
    {
        $enabled_extensions = array();

        // read php.ini
        $ini_file = php_ini_loaded_file();
        $ini = new ini();
        $ini->read($ini_file);
        $lines = $ini->returnArray();

        // check php.ini array for extension entries
        foreach ($lines as $line) {
            if($line['type'] != 'entry') continue;
            if($line['key'] != 'extension') continue;
            // and stuff them in the array
            $enabled_extensions[] = $line['value'];
        }

        // do a key/value flip, to get rid of the numeric index.
        // this is for being able to easily check for a extension filename with isset in foreach.
        $enabled_extensions = array_flip($enabled_extensions);

        return $enabled_extensions;
    }

    /**
     * Ensures that 'extension_dir' directive is not commented.
     */
    public function checkExtensionDirSet()
    {
        // look for ### ; extension_dir = "ext" ###
        // and uncomment the line

        $lines = array();
        $lines = $this->read_ini();

        foreach ($lines as $line) {
            if (strpos($line, '; extension_dir = "ext"') !== false) {
                $new_line = ltrim($line, '; ');
                $this->replaceLineInPHPINI($line, $new_line);
            }
        }
    }
}
