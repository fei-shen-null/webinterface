<?php

namespace WPNXMTest;

class Selenium2ChromeTest extends \PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        $this->isSeleniumAvailable();

        $this->setupSpecificBrowser(array(
            'host' => '127.0.0.1',
            'port' => 5555,
            'browserName' => 'chrome',
            'desiredCapabilities' => array(
                array('chromeOptions' => array(
                    'args' => array('no-sandbox')
                ))
            ),
            'seleniumServerRequestsTimeout' => '50',
        ));

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
        $this->url('/');
        $this->assertEquals('WPИ-XM Serverstack for Windows', $this->title());
    }

}
