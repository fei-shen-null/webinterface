<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - 2016, Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

/**
 * daemon restart
 */
function restart()
{
	global $request;
    $daemon = $request->get('daemon', null);
    
    Webinterface\Helper\Daemon::restartDaemon($daemon);
}

/**
 * daemon start
 */
function start()
{
	global $request;
    $daemon = $request->get('daemon', null);

    Webinterface\Helper\Daemon::startDaemon($daemon);
}

/**
 * daemon stop
 */
function stop()
{
	global $request;
    $daemon = $request->get('daemon', null);

    Webinterface\Helper\Daemon::stopDaemon($daemon);
}
