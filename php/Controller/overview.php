<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - 2014 Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

use Webinterface\Helper\Serverstack;
use Webinterface\Components\XDebug;

function index()
{
    $tpl_data = array(
      // load jq, because the database password reset uses jq modal window
      'load_jquery_additionals' => true,
      // version
      'nginx_version'       => Serverstack::getVersion('nginx'),
      'php_version'         => Serverstack::getVersion('php'),
      'mariadb_version'     => Serverstack::getVersion('mariadb'),
      'memcached_version'   => Serverstack::getVersion('memcached'),
      'xdebug_version'      => Serverstack::getVersion('xdebug'),
      'mongodb_version'     => Serverstack::getVersion('mongodb'),
      'postgresql_version'  => Serverstack::getVersion('postgresql'),
      // status
      'nginx_status'        => Serverstack::getStatus('nginx'),
      'php_status'          => Serverstack::getStatus('php'),
      'mariadb_status'      => Serverstack::getStatus('mariadb'),
      'xdebug_status'       => Serverstack::getStatus('xdebug'),
      'mongodb_status'      => Serverstack::getStatus('mongodb'),
      'phpext_mongo_status' => Serverstack::getStatus('phpext_mongo'),
      'memcached_status'    => Serverstack::getStatus('memcached'),
      'phpext_memcached_status' => Serverstack::getStatus('phpext_memcache'),
      'postgresql_status'   => Serverstack::getStatus('postgresql'),
      // your ip
      'my_ip'               => Serverstack::getMyIP(),
      // passwords
      'mariadb_password'    => Serverstack::getPassword('mariadb'),
      'mongodb_password'    => Serverstack::getPassword('mongodb'),
      // which additional components are installed
      'memcached_installed' => Serverstack::isInstalled('memcached'),
      'xdebug_installed'    => Serverstack::isInstalled('xdebug'),
      'mongodb_installed'   => Serverstack::isInstalled('mongodb'),
      'postgresql_installed' => Serverstack::isInstalled('postgresql'),
      'phpext_memcached_installed' => Serverstack::isExtensionInstalled('memcached'),
      'phpext_xdebug_installed' => Serverstack::isExtensionInstalled('xdebug'),
      'xdebug_extension_type' => XDebug::getXDebugExtensionType(),
      'xdebug_profiler_active' => XDebug::isProfilerActive()
    );

    render('page-action', $tpl_data);
}

function stop()
{
    Webinterface\Helper\Daemon::stopDaemon($_GET['daemon']);
    redirect(WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview');
}

function start()
{
    Webinterface\Helper\Daemon::startDaemon($_GET['daemon']);
    redirect(WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview');
}
