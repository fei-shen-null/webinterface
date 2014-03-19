<?php
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
