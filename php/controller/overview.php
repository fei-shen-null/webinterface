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

include WPNXM_HELPER_DIR . 'serverstack.php';

function index()
{
    $tpl_data = array(
      // load jq, because the database password reset uses jq modal window
      'load_jquery'         => true,
      // version
      'nginx_version'       => Serverstack::getNGINXVersion(),
      'php_version'         => Serverstack::getPHPVersion(),
      'mariadb_version'     => Serverstack::getMariaDBVersion(),
      'memcached_version'   => Serverstack::getMemcachedVersion(),
      'xdebug_version'      => Serverstack::getXdebugVersion(),
      // status
      'nginx_status'        => Serverstack::getStatus('nginx'),
      'php_status'          => Serverstack::getStatus('php'),
      'mariadb_status'      => Serverstack::getStatus('mariadb'),
      'memcached_status'    => Serverstack::getStatus('memcached'), // daemon && extension
      'xdebug_status'       => Serverstack::getStatus('xdebug'),
      // ...
      'my_ip'               => Serverstack::getMyIP(),
      'mariadb_password'    => Serverstack::getMariaDBPassword(),
      'memcached_installed' => Serverstack::assertExtensionInstalled('memcached'),
      'xdebug_installed'    => Serverstack::assertExtensionInstalled('xdebug'),
      // extension "com_dotnet" is needed to open logfile with editor, else we disable the log buttons
      'canOpenLogfileWithEditor' => function() {
                                      if(!class_exists('COM') and !extension_loaded("com_dotnet")) {
                                      return false;
                                    }}
    );

    render('page-action', $tpl_data);
}
