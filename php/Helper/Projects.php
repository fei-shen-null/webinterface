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
        'memadmin' => '',
        'phpmemcachedadmin' => '',
        'phpmyadmin' => '',
        'rockmongo' => '',
        'webgrind' => '',
        'webinterface' => '',
        'wincache' => '',
        'xcache' => '',
        'xhprof' => 'xhprof/xhprof_html'
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
            $html .= '<ul class="list-group">';

            foreach ($this->dirs as $dir) {
                // always display the folder
                $html .= '<li class="list-group-item">';
                $html .= '<a class="folder" href="' . WPNXM_ROOT . $dir . '">' . $dir . '</a>';

                if (FEATURE_4 == true) {
                    $html .= $this->renderDomainLink($dir);
                }

                $html .= $this->getRepositoryLinks($dir);

                $html .= '</li>';
            }
        }

        return $html . '</ul>';
    }

    public function listTools()
    {
        $html = '<ul class="list-group">';

        foreach ($this->toolDirectories as $dir => $href) {
            if ($href === '') {
                $html .= '<li class="list-group-item"><a class="folder" href="' . WPNXM_ROOT . $dir . '">' . $dir . '</a></li>';
            } else {
                $html .='<li class="list-group-item"><a class="folder" href="' . WPNXM_ROOT . $href . '">' . $dir . '</a></li>';
            }
        }

        return $html . '</ul>';
    }

    /**
     * Returns links with icons to Github, Travis-CI and Packagist.
     **/
    public function getRepositoryLinks($dir)
    {
        $html = '';

        // display a link to Travis CI
        if (true === $this->hasTravisConfig($dir)) {

            $composer = array();

            /* if (extension_loaded('openssl')) {
              $possible_repos = file_get_contents('https://api.travis-ci.org/repositories.json?search='. $dir);
              var_dump($possible_repos);
              set the one found or ask user to select one of multiple
             * } */

            /**
             * some people set the composer name to "something/somwhere".
             * that breaks the 1:1 relation between repository name and packagist name,
             * e.g. github.com/bzick/fenom - fenom/fenom
             *
             * given that there is a 1:1 relation of travis-ci repo name and github repo name,
             * the only way to get the travis repo url is by fetching the git origin url from the config.
             * 1. read file: '.get/config'
             * 2. fetch "[remote "origin"] url
             * 3. extract repo name from URL = $package
             */

            // get github link
            if (true === $this->hasComposerConfig($dir)) {
                $composer = json_decode(file_get_contents(WPNXM_WWW_DIR . $dir . '/composer.json'), true);
                // add the github link by showing a github icon
                $html .= '<a class="btn btn-default btn-xs" style="margin-left: 5px;"';
                $html .= ' href="http://github.com/' . $composer['name'] . '"><img src="' . WPNXM_IMAGES_DIR . 'github_icon.png"/></a>';
            }

            $package = $this->getPackagistPackageDescription($composer['name']);

            if(empty($package) === false) {

                if(isset($package['status']) && $package['status'] === 'error') {
                    \Webinterface\Helper\Serverstack::printExclamationMark(
                        'The request to packagist.org failed. This might be a service problem.' .
                        ' Please ensure that HTTPS streamwrapper support is enabled in php.ini (extension=php_openssl.dll).'
                    );
                }

                $packageName = strtolower($package['package']['name']);

                // add the travis link by showing build status badge
                $html .= '<a style="margin-left: 5px;" href="http://travis-ci.org/' . $packageName . '">';
                $html .= '<img src="https://travis-ci.org/' . $packageName . '.png">';
                $html .= '</a>';

                // add packagist link and download badge
                /*
                $html .= '<ul><li><a style="margin-left: 5px;" href="https://packagist.org/packages/' . $composer['name'] . '">';
                $html .= '<img src="https://poser.pugx.org/' .  $composer['name']  . '/downloads.png">';
                $html .= '</a></li></ul>';*/
            }
        }

        return $html;
    }

    public function getPackagistPackageDescription($package = '')
    {
        $url = sprintf('https://packagist.org/packages/%s.json', $package);

        $context = stream_context_create(array(
            'http' => array(
                'ignore_errors' => true
             )
        ));
        // silenced, because this throws a warning, if offline
        $json = @file_get_contents($url, FALSE, $context);

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

    public function renderDomainLink($dir)
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

    public function hasTravisConfig($dir)
    {
        return is_file(WPNXM_WWW_DIR . $dir . '/.travis.yml');
    }

    public function hasComposerConfig($dir)
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
