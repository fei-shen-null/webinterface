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

class Composer extends AbstractComponent
{
    public $name = 'Composer';

    public $registryName = 'composer';

    public $downloadURL = 'http://wpn-xm.org/get.php?s=composer';

    public $targetFolder = '/bin/php';

    /**
     * Returns Version.
     *
     * @return string Version
     */
    public function getVersion()
    {
        return '1.0.0';
    }
}
