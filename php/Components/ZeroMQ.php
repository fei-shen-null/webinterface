<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - 2014 Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

namespace Webinterface\Components;

class ZeroMQ extends AbstractComponent
{
    public $name = 'ZeroMQ';

    public $type = 'PHP Extension';

    public $registryName = 'phpext_zmq';

    public function getVersion()
    {
        if (extension_loaded('zmq') === false) {
            return \Webinterface\Helper\Serverstack::printExclamationMark(
                'Not implemented yet!'
            );
        }
    }
}
