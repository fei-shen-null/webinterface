<?php
class SeleniumBootstrapTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        $this->isSeleniumAvailable();

        $this->setBrowser('chrome');
        $this->setBrowserUrl('http://www.google.com/');
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
        $this->url('http://www.google.com/');
        $this->assertEquals('Google', $this->title());
    }
 
}
