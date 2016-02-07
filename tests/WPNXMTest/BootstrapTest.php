<?php

/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - 2016, Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

namespace WPNXMTest;

class BootstrapTest extends \PHPUnit_Framework_TestCase
{
    public function testSetup()
    {
        /**
         * ensure include path is set
         */
        $includePath = get_include_path();
        $this->assertContains(realpath(__DIR__.'/../..'), $includePath);
        $this->assertContains(realpath(__DIR__.'/../../tests'), $includePath);
    }
}
