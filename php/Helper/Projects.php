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

namespace Webinterface\Helper;

class Projects
{
    private $dirs = array();

    /**
     * The "toolDirectories" array contains paths of the "/www" folder.
     * These paths are administration tools for WPN-XM, shipped with the distribution.
     *
     * In the webinterface, on the page "Projects and Tools", this array is used to
     * divide the "Tools" folders from your "Your Projects" folders.
     *
     * @see fetchProjectDirectories(false)
     * @var array
     */
    private $toolDirectories = array(
        'adminer' => 'adminer/adminer.php',
        'phpmyadmin' => '',
        'webgrind' => '',
        'webinterface' => '',
        'xhprof' => 'xhprof/xhprof_html',
        'memadmin' => '',
        'phpmemcachedadmin' => '',
        'rockmongo' => ''
    );

    public function __construct()
    {
        $this->dirs = $this->fetchProjectDirectories();
    }

    /**
     * Returns the list of directories in the "/www" folder.
     *
     * @param  bool  $all True, will return all dirs. False, will exclude tool directories.
     * @return array
     */
    public function fetchProjectDirectories($all = false)
    {
        $dirs = array();

        $handle = opendir(WPNXM_WWW_DIR); # __DIR__

        while ($dir = readdir($handle)) {
            if ($dir == "." or $dir == "..") {
                continue;
            }

            // exclude WPN-XM infrastructure and tool directories
            if (array_key_exists($dir, $this->toolDirectories) and ($all === false)) {
                continue;
            }

            if (is_dir(WPNXM_WWW_DIR . $dir) === true) {
                $dirs[] = $dir;
            }
        }

        closedir($handle);

        asort($dirs);

        return $dirs;
    }

    public function listProjects()
    {
        $html = '';

        if ($this->getNumberOfProjects() == 0) {
            $html = "No project dirs found.";
        } else {
            $html .= '<ul class="projects">';

            foreach ($this->dirs as $dir) {
                // always display the folder
                $html .= '<li>';
                $html .= '<a class="folder" href="' . WPNXM_ROOT . $dir . '">' . $dir . '</a>';

                if (FEATURE_4 == true) {
                    $html .= $this->getListDomainsButton($dir);
                }

                $html .= $this->getTravisCILink($dir);

                $html .= '</li>';
            }
        }

        return $html . '</ul>';
    }

    public function listTools()
    {
        $html = '<ul class="tools">';

        foreach ($this->toolDirectories as $dir => $href) {
            if ($href === '') {
                $html .= '<li><a class="folder" href="' . WPNXM_ROOT . $dir . '">' . $dir . '</a></li>';
            } else {
                $html .='<li><a class="folder" href="' . WPNXM_ROOT . $href . '">' . $dir . '</a></li>';
            }
        }

        return $html . '</ul>';
    }

    public function getTravisCILink($dir)
    {
        $html = '';

        // display a link to Travis CI
        if (true === $this->containsTravisConfig($dir)) {

            $composer = array();

            /* if (extension_loaded('openssl')) {
              $possible_repos = file_get_contents('https://api.travis-ci.org/repositories.json?search='. $dir);
              var_dump($possible_repos);
              set the one found or ask user to select one of multiple
             * } */

            if (true === $this->containsComposerConfig($dir)) {
                $composer = json_decode(file_get_contents(WPNXM_WWW_DIR . $dir . '/composer.json'), true);
                // add the github link by showing a github icon
                $html .= '<a class="btn btn-mini pull-right" style="padding-left: 6px; padding-bottom: 1px; margin-left: 3px; border-right-width: 1px;"';
                $html .= ' href="http://github.com/' . $composer['name'] . '"><img src="' . WPNXM_IMAGES_DIR . 'github_icon.png"/></a>';
            }

            $package = $this->getPackagistPackageDescription($composer['name']);
            $packageName = $this->getPackageName($package);

            if (isset($packageName) === true) {
                // add the travis link by showing build status icon
                $html .= '<a class="pull-right" href="http://travis-ci.org/' . $packageName . '">';
                $html .= '<img src="https://travis-ci.org/' . $packageName . '.png">';
                $html .= '</a>';
            }
        }

        return $html;
    }

    public function getPackagistPackageDescription($package = '')
    {
        $url = sprintf('https://packagist.org/packages/%s.json', $package);
        $json = @file_get_contents($url);
        $array = json_decode($json, true);

        return $array;
    }

    /**
     * Returns the correct Package name.
     *
     * Note: This is not just the return of $packageDescription['name'], because it's lowercased.
     * This returns the correct name for building a Travis-CI or Github URL.
     */
    public function getPackageName(array $packageDescription = array())
    {
        return str_replace('https://github.com/', '', $packageDescription['package']['repository']);
    }

    public function getListDomainsButton($dir)
    {
        $html = '';

        if (false === $this->isDomain($dir)) {
            // display link to add a new domain for this directory
            $html .= '<a class="btn-new-domain floatright" ';
            $html .= ' href="' . WPNXM_WEBINTERFACE_ROOT . 'index.php?page=domains&newdomain=' . $dir . '">';
            $html .= 'New Domain</a>';
        } else {
            // display link to the domain
            $html .= '<a class="floatright" href="http://' . $dir . '/">' . $dir . '</a>';
        }

        return $html;
    }

    /**
     * Check, if a seperate domain exists in \bin\nginx\conf\domains\
     */
    public function isDomain($dir)
    {
        return is_file(WPNXM_DIR . '/bin/nginx/conf/domains/' . $dir . '.conf');
    }

    public function containsTravisConfig($dir)
    {
        return is_file(WPNXM_WWW_DIR . $dir . '/.travis.yml');
    }

    public function containsComposerConfig($dir)
    {
        return is_file(WPNXM_WWW_DIR . $dir . '/composer.json');
    }

    /**
     * tools directories are hardcoded.
     * because we don't know which ones the user installed,
     * we check for existence.
     * if a tool dir is not there, remove it from the list.
     * this affects the counter.
     */
    public function checkWhichToolDirectoriesAreInstalled()
    {
        foreach ($this->toolDirectories as $dir => $href) {
            if (is_dir(WPNXM_WWW_DIR . $dir) === false) {
                unset($this->toolDirectories[$dir]);
            }
        }
    }

    public function getNumberOfProjects()
    {
        return count($this->dirs);
    }

    public function getNumberOfTools()
    {
        $this->checkWhichToolDirectoriesAreInstalled();

        return count($this->toolDirectories);
    }
}
