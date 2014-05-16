<?php

namespace WPNXMTest;

class SeleniumChromeTest extends \PHPUnit_Extensions_SeleniumTestCase
{
    public static $browsers = array(
        array(
            'browserName' => '*chrome',
        )
    );

    protected function setUp()
    {
        parent::setUp();

        $this->isSeleniumAvailable();

        $this->setHost('127.0.0.1');
        $this->setPort(4444);
        $this->setBrowser('chrome');
        $this->setBrowserUrl('http://127.0.0.1:80/');
    }

    public function isSeleniumAvailable()
    {
        $selenium_running = false;

        $fp = @fsockopen('localhost', 4444);
        if ($fp !== false) {
            $selenium_running = true;
            fclose($fp);
        }

        if ($selenium_running === false) {
             $this->markTestAsSkipped(
                'Selenium is not running on localhost:4444. Please start Selenium.'
             );
        }
    }

    public function testTitle()
    {
        $this->open('/');
        $this->assertTitle('WPИ-XM Server Stack for Windows - @APPVERSION@');
    }

}
