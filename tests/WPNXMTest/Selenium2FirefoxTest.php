<?php

namespace WPNXMTest;

class Selenium2FirefoxTest extends \PHPUnit_Extensions_Selenium2TestCase
{
    public function setUp()
    {
        //$this->isSeleniumAvailable();

        $this->setHost('127.0.0.1');
        $this->setPort(4444);
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://127.0.0.1:80/');
        $this->prepareSession();
    }

    public function testTheSessionStartedInSetupAndCanBeUsedNow()
    {
        $this->assertStringEndsWith('about:blank', $this->url());
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
        $this->url('/');
        $this->assertEquals('WPИ-XM Server Stack for Windows - @APPVERSION@', $this->title());
    }

}
