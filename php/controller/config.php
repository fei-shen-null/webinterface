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

function index()
{
    $tpl_data = array(
        'load_jquery' => true
    );

    render('page-action', $tpl_data);
}

function update_phpini_setting()
{
    $section = ''; // @todo section? needed to save the directive? string (directive=>value) is unique!?
    $directive = filter_input(INPUT_POST, 'directive');
    $value = filter_input(INPUT_POST, 'value');

    Webinterface\Helper\PHPINI::setDirective($section, $directive, $value);

    echo 'Entry saved.';
}

function update_phpextensions()
{
    $extensions = $_POST['extensions'];

    $ext = new Webinterface\Helper\PHPExtensionManager();

    foreach ($extensions as $extension) {
        $ext->enable($extension);
    }

    echo 'Entries saved.';
}

function showtab()
{
    /**
     * Tab Controller - handles GET requests for tab pages.
     * Calls to tab pages look like this: "index.php?page=config&action=showtab&tab=xy".
     * Each tab returns content for inline display in the tabs-content container.
     */
    $tab = filter_input(INPUT_GET, 'tab');
    $tab = strtr($tab, '-', '_'); // minus to underscore conversion
    $tabAction = 'showtab_' . $tab;
    if (!is_callable($tabAction)) { throw new \Exception('The controller method "'.$tabAction.'" for the Tab "'.$tab.'" was not found!'); }
    $tabAction();
}

function showtab_nginx()
{
    render('config-showtab-nginx', array('no_layout' => true));
}

function showtab_mariadb()
{
    render('config-showtab-mariadb', array('no_layout' => true));
}

function showtab_mongodb()
{
    render('config-showtab-mongodb', array('no_layout' => true));
}

function showtab_nginx_domains()
{
    $tpl_data = array(
        'no_layout' => true,
        'project_folders' => (new Webinterface\Helper\Projects())->fetchProjectDirectories(true),
        'domains' => (new Webinterface\Helper\Domains())->listDomains()
    );

    render('config-showtab-nginx-domains', $tpl_data);
}

function showtab_php_ext()
{
    $phpext = new Webinterface\Helper\PHPExtensionManager();

    $tpl_data = array(
        'no_layout' => true,
        'available_extensions' => $phpext->getExtensionDirFileList(),
        'enabled_extensions' =>  $phpext->getEnabledExtensions()
    );

    render('config-showtab-phpext', $tpl_data);
}

function showtab_help()
{
    render('config-showtab-help', array('no_layout' => true));
}

function showtab_php()
{
    $tpl_data = array(
        'no_layout' => true,
        'ini' => Webinterface\Helper\PHPINI::read(), // $ini array structure = 'ini_file', 'ini_array'
    );

    render('config-showtab-php', $tpl_data);
}

function showtab_xdebug()
{
    $tpl_data = array(
        'no_layout' => true,
        'ini_settings' => ini_get_all('xdebug'),
    );

    render('config-showtab-xdebug', $tpl_data);
}
