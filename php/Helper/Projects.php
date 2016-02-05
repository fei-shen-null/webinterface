<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - onwards, Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

namespace Webinterface\Helper;

class Projects
{
    private $projectFolders = array();

    /**
     * The "toolDirectories" array contains paths of the "/www/tools" folder.
     * These paths are administration tools for WPN-XM, shipped with the distribution.
     * Some of these tools do not provide an "index.php" at the top-level.
     * This array keeps the relation between a "tool folder" and it's "startup script"
     * or "startup folder with index.php".
     *
     * @var array
     */
    private $toolDirectories = array(
        'adminer' => 'adminer/adminer.php',
        'memadmin' => '',
        'phpmemcachedadmin' => '',
        'phpmyadmin' => '',
        'rockmongo' => '',
        'updater' => '', // wpn-xm registry updater
        'uprofiler' => 'uprofiler/uprofiler_html',
        'webgrind' => '',
        //'webinterface' => '', // wpn-xm webinterface
        'wincache' => '',
        'xcache' => '',
        'xhprof' => 'xhprof/xhprof_html'
    );

    public function __construct()
    {
        $this->projectFolders = $this->getProjects();
    }

    /**
     * Returns all project folders from "/www", excluding the "tools" folder.
     *
     * @return array
     */
    public function getProjects()
    {
        $dirs = array();
        $handle = opendir(WPNXM_WWW_DIR);

        while ($dir = readdir($handle)) {
            // exclude dot folders and tools folder
            if ($dir === '.' or $dir === '..' or $dir === 'tools') {
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
        if ($this->getNumberOfProjects() === 0) {
            return "No project dirs found.";
        }

        $html = '<ul class="list-group text-left">';

        foreach ($this->projectFolders as $dir) {
            // always display the folder
            $html .= '<li class="list-group-item">';
            $html .= '<a class="folder" href="' . WPNXM_ROOT . $dir . '">' . $dir . '</a>';

            if (FEATURE_4 === true) {
                $html .= $this->renderSettingsLink($dir);
            }

            $html .= $this->renderRepositoryLinks($dir);
            $html .= '</li>';
        }

        return $html . '</ul>';
    }

    public function listTools()
    {
        $this->checkWhichToolsAreInstalled();

        $html = '';

        foreach ($this->toolDirectories as $dir => $href) {
            $link = ($href === '') ? (WPNXM_ROOT . 'tools/' . $dir) : (WPNXM_ROOT . 'tools/' . $href);
            $html .= '<li class="list-group-item"><a class="folder" href="'.$link.'">' . $dir . '</a></li>';
        }

        // write the html list to file. this acts as a cache for the tools topmenu.
        // the file is rewritten each time "Tools & Projects" is opened,
        // because the user might have deleted or installed a new tool.
        file_put_contents(WPNXM_DATA_DIR . 'tools-topmenu.html', $html);

        return '<ul class="list-group text-left">' . $html . '</ul>';
    }

    /**
     * Returns links with icons to Github, Travis-CI and Packagist.
     */
    public function renderRepositoryLinks($dir)
    {
        $html = '';

        $hasComposerConfig = $this->hasComposerConfig($dir);

        // If the project folder contains a "composer.json" file and is found on "packagist.org",
        // display a "packgist.org" link.
        if (true === $hasComposerConfig) {
            $composer = json_decode(file_get_contents(WPNXM_WWW_DIR . $dir . '/composer.json'), true);

            // composer.json key "homepage"?
            if(isset($composer['homepage']) === true) {
                $html .= '<a class="btn btn-default btn-xs" style="margin-left: 5px; width: 28px; height: 20px;"';
                $html .= ' href="' . $composer['homepage'] . '"><span class="glyphicon glyphicon-home"></span></a>';
            }
        }

        // If the project folder contains a ".git/config" file with a github repo link, display a "github.com" link.
        if(true === $this->isGitRepoAndHostedOnGithub($dir)) {
            if(isset($composer['name']) === true) {
                $githubLink = 'https://github.com/' . $composer['name'];
            } else {
                $githubLink = 'https://github.com/' . $this->getProjectNameFromGitConfig($dir);
            }

            $html .= '<a class="btn btn-default btn-xs" style="margin-left: 5px;"';
            $html .= ' href="'.$githubLink.'"><img src="' . WPNXM_IMAGES_DIR . 'github_icon.png"/></a>';
        }

        /**
         * If the project folder contains a ".travis.yml" file, display a "travis-ci.org" link.
         */
        /*if (true === $this->hasTravisConfig($dir)) {

            /**
             * Unresolved Issues
             *
             * Some people set their composer name to "something/somwhere", while their github name is "x/y".
             * That breaks the 1:1 relation between github repository name and packagist name,
             * An example is: "github.com/bzick/fenom" - "packagist.org/fenom/fenom"
             *
             * given that there is a 1:1 relation of travis-ci repo name and github repo name,
             * the only way to get the travis repo url is by fetching the git origin url from the config.
             * 1. read file: '.get/config'
             * 2. fetch "[remote "origin"] url
             * 3. extract repo name from URL = $package
             *
             * Do a "like *" search and set the one found or ask user to select one of multiple.
             */
            /*
            if (extension_loaded('openssl') === true) {
                $possible_repos = file_get_contents('https://api.travis-ci.org/repositories.json?search=' . $dir);
                var_dump($possible_repos);
            }
            */
          /*
            // if the package is "composer-ified", it may also be on "packagist.org"
            $package = $this->getPackagistPackageDescription($composer['name']);

            //var_dump($package['package']);

            $packageName = strtolower($package['package']['name']);

            // add the travis link by showing build status badge
            $html .= '<a style="margin-left: 5px;" href="http://travis-ci.org/' . $packageName . '">';
            $html .= '<img src="https://travis-ci.org/' . $packageName . '.png">';
            $html .= '</a>';

            // add packagist link and download badge
            $html .= '<ul><li><a style="margin-left: 5px;" href="https://packagist.org/packages/' . $composer['name'] . '">';
            $html .= '<img src="https://poser.pugx.org/' .  $composer['name']  . '/downloads.png">';
            $html .= '</a></li></ul>';
        }*/

        return $html;
    }

    public function readProjectGitConfig($dir)
    {
        return file_get_contents(WPNXM_WWW_DIR . $dir . '/.git/config');
    }

    public function getProjectNameFromGitConfig($dir)
    {
        $gitConfig = $this->readProjectGitConfig($dir);
        preg_match('#github.com(?:\:|/)(.*).git#i', $gitConfig, $matches);
        return $matches[1];
    }

    public function isGitRepoAndHostedOnGithub($dir)
    {
        if($this->hasGitConfig($dir) === true) {
            $gitConfig = $this->readProjectGitConfig($dir);
            if (false !== strpos($gitConfig, 'github')) {
                return true;
            }
        }

        return false;
    }

    public function getPackagistPackageDescription($package = '')
    {
        $url = sprintf('https://packagist.org/packages/%s.json', $package);

        $context = stream_context_create(array(
            'http' => array(
                'ignore_errors' => true
             )
        ));

        // silenced: because this throws a warning, if offline
        $json = @file_get_contents($url, false, $context);

        $array = json_decode($json, true);

        if(isset($array['status']) && $array['status'] === 'error') {
            \Webinterface\Helper\Serverstack::printExclamationMark(
                'The request to packagist.org failed. This might be a service problem.' .
                ' Please ensure that HTTPS streamwrapper support is enabled in php.ini (extension=php_openssl.dll).'
            );
        }

        return $array;
    }

    /**
     * Returns the correct "package name" for building a Travis-CI or Github URL
     * This returns [package][repository] instead of [name], which is lowercased.
     */
    public function getPackageName(array $packageDescription = array())
    {
        return str_replace('https://github.com/', '', $packageDescription['package']['repository']);
    }

    public function renderSettingsLink($dir)
    {
        $html = '';

        // display "settings" cog wheel for this project. Modal shows a configuration screen "per project".
        $html .= '<a class="btn-new-domain floatright" data-toggle="modal" data-target="#myModal" ';
        $html .= ' href="' . WPNXM_WEBINTERFACE_ROOT . 'index.php?page=projects&action=edit&project=' . $dir . '">';
        $html .= '<span class="glyphicon glyphicon-cog"></span></a>';

        /*if (false === $this->isDomain($dir)) {
            // display link to add a new domain for this directory
            $html .= '<a class="btn-new-domain floatright" ';
            $html .= ' href="' . WPNXM_WEBINTERFACE_ROOT . 'index.php?page=domains&newdomain=' . $dir . '">';
            $html .= 'New Domain</a>';
        } else {
            // display link to the domain
            $html .= '<a class="floatright" href="http://' . $dir . '/">' . $dir . '</a>';
        }*/

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

    public function hasGitConfig($dir)
    {
        return is_file(WPNXM_WWW_DIR . $dir . '/.git/config');
    }

    /**
     * tools directories are hardcoded.
     * because we don't know which ones the user installed, we check for existence.
     * if a tool dir is not there, remove it from the list.
     */
    public function checkWhichToolsAreInstalled()
    {
        foreach ($this->toolDirectories as $dir => $href) {
            if (is_dir(WPNXM_WWW_DIR . 'tools\\' . $dir) === false) {
                unset($this->toolDirectories[$dir]);
            }
        }
    }

    public function getNumberOfProjects()
    {
        return count($this->projectFolders);
    }

    public function getNumberOfTools()
    {
        $this->checkWhichToolsAreInstalled();

        return count($this->toolDirectories);
    }
}
