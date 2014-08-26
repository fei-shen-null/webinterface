<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - 2014 Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

function restart()
{
     Webinterface\Helper\Daemon::restartDaemon($_GET['daemon']);
}

function start()
{
     Webinterface\Helper\Daemon::startDaemon($_GET['daemon']);
}

function stop()
{
     Webinterface\Helper\Daemon::stopDaemon($_GET['daemon']);
}
