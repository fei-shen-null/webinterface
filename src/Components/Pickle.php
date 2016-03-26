<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - onwards, Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

namespace Webinterface\Components;

/**
 * WPN-XM Webinterface - Class for Component Pickle
 */
class Pickle extends AbstractComponent
{
    public $name                = 'Pickle';
    public $registryName        = 'pickle';
    public $installationFolder  = '\bin\pickle';
    public $files               = '\bin\pickle\pickle.phar';
    
    public function getVersion()
    {
        return 'Not implemented, yet.';
    }
}
