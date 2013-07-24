<?php
class Selenium2FirefoxTest extends PHPUnit_Extensions_Selenium2TestCase
{
    public static $browsers = array(
        array(
            'browserName' => 'firefox',
        )
    );

    protected function setUp()
    {
        parent::setUp();

        $this->isSeleniumAvailable();

        $this->setHost('127.0.0.1');
        $this->setPort(4444);
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://127.0.0.1:80/');

        $this->setupSpecificBrowser(array(
            'host' => '127.0.0.1',
            'port' => '4444',
            'browserName' => 'Mozilla Firefox',
            'browser' => 'firefox',            
            /*'desiredCapabilities' => array(
                array('chromeOptions' => array(
                    'args' => array('no-sandbox')
                ))
            ),*/
            'seleniumServerRequestsTimeout' => '50',
        ));
    }

    public function isSeleniumAvailable()
    {
        $selenium_running = false;

        $fp = @fsockopen('localhost', 4444);
        if ($fp !== false) {
            $selenium_running = true;
            fclose($fp);
        }

        if($selenium_running === false) {
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
