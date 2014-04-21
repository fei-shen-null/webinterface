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

namespace Webinterface\Components;

class PEAR
{
    public $name = 'PEAR';

    public $registryName = 'PEAR';

    public $installationFolder = '\bin\php\PEAR';

    /**
     * Returns PHP Version.
     *
     * @return string PHP Version
     */
    public function getVersion()
    {
        // load and parse a PEAR file to get the version, alternative to "pear.bat -V"
        $file = WPNXM_BIN . '\php\PEAR\pear\PEAR\Autoloader.php';

        # fail safe, if PEAR not installed
        if (is_file($file) === false) {
            return \Webinterface\Helper\Serverstack::printExclamationMark('The PHP Extension "mysqli" is required.');
        }

        $maxLines = 60; // read only the first few lines of the file

        $file_handle = fopen($file, "r");

        for ($i = 1; $i < $maxLines && !feof($file_handle); $i++) {
            $line_of_text = fgetcsv($file_handle, 1024);
            if(strpos($line_of_text[0], '@version')) {
                // lets grab the version from the phpdoc tag
                preg_match('/\/* @version[\s]+Release: (\d+.\d+.\d+)/', $line_of_text[0], $matches);
            }
        }
        fclose($file_handle);

        return $versions = $matches[1];
    }
}
