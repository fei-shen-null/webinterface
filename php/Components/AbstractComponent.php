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

/**
 * WPN-XM Webinterface - Abstract Base Class for Components.
 *
 * The class provides basic methods to gather pieces of information
 * about a component.
 */
abstract class AbstractComponent
{
    /* @var string Printable name of the component. */
    public $name;
    
    /* @var string Name of the component in the registry. */
    public $registryName;

    /* @var string Type (PHP Extensions, Daemon). */
    public $type;

    /**
     * @var array Array with all essential files of the component.
     * For making sure, that the component is installed.
     */
    public $files = array();

    /* @var string The configuration file of the component, if any. */
    public $configFile = '';

    /* @var string The target folder (or base folder) of the installation. */
    public $installationFolder = '';

    /**
     * Array with some essential file dependencies of the component.
     * For making sure, that the component's dependencies are also installed.
     */
    public $dependencyFiles = array();
    
    public $downloadURL = '';

    /**
     * Checks, if a component is installed.
     * A component is installed, if all its files exist.
     * The files are defined in the $files array.
     *
     * @param bool If true, checks only the first file (default). Otherwise, checks all files.
     * @return bool True, if installed, false otherwise.
     */
    public function isInstalled($fast = true)
    {
        $bool = false;
        foreach ($this->files as $file) {
            $bool = file_exists(WPNXM_DIR . $file);
            // stop at the first file found
            if ($bool === true && $fast === true) {
                break;
            }
        }

        return $bool;
    }

    public function checkDependencies()
    {
        $bool = false;
        foreach ($this->dependencyFiles as $file) {
            $bool = $bool && file_exists($file);
        }

        return $bool;
    }

    public function hasDependencies()
    {
        return (empty($dependencyFiles) === true) ? false : true;
    }

    public function getConfigFile()
    {
        return $this->configFile;
    }

    public function getInstallationFolder()
    {
        return $this->installationFolder;
    }

    public function download($url = '', $targetFolder = '')
    {
        $url = ($url === '') ? $this->downloadURL : $url;
        $targetFolder = ($targetFolder === '') ? $this->installationFolder: $targetFolder;
    }
    
    /**
     * Returns the pretty name of this component, e.g. "Xdebug".
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Returns the registry name of a component, e.g. "phpext_xdebug" for "Xdebug".
     * 
     * @return string
     */
    public function getRegistryName()
    {
        return $this->registryName;
    }
    
    /**
     * Find out, whether an extension is loaded
     * 
     * @param string $name
     * @return bool <b>TRUE</b> if the extension identified by <i>name</i>
     * is loaded, <b>FALSE</b> otherwise.
     */
    public function isExtensionLoaded($name = null)
    {
        $name = ($name === null) ? $name : $this->name;  
        
        return extension_loaded($name);
    }

    /**
     * Returns the Version
     * 
     * @return string
     */
    abstract public function getVersion();
}
