<?php

namespace WPNXMTest;

class BootstrapTest extends \PHPUnit_Framework_TestCase
{
    public function testSetup()
    {
        /**
         * ensure include path is set
         */
        $includePath = get_include_path();
        $this->assertContains(realpath(__DIR__ . '/../..'), $includePath);
        $this->assertContains(realpath(__DIR__ . '/../../tests'), $includePath);
    }
}