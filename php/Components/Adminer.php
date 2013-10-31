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

namespace Webinterface\Components;

/**
 * WPN-XM Webinterface - Class for Adminer
 */
class Adminer extends AbstractComponent
{
    public $installationFolder = /* WPNXM_ROOT . */ '\www\adminer'; // i wish PHP would support this! PHP6 ?!

    public $files = array(
        '\www\adminer\adminer.php'
    );

    /**
     * Returns PHP Version.
     *
     * @return string PHP Version
     */
    public function getVersion()
    {
        $file = WPNXM_DIR . $this->files[0];

        $matches = '';
        $maxLines = 8; // read only the first few lines of the file

        $file_handle = fopen($file, "r");

        for ($i = 0; $i < $maxLines && !feof($file_handle); $i++) {
            $line_of_text = fgetcsv($file_handle, 1024);
            // lets grab the version from the phpdoc tag
            preg_match('/\* \@version (\d+.\d+.\d+)/', $line_of_text[0], $matches);
        }
        fclose($file_handle);

        return $versions = $matches[1];
    }
}
