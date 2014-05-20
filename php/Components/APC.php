<?php
namespace Webinterface\Components;
class APC extends AbstractComponent
{
    public $name = 'APC';
    
    public $type = 'PHP Extension';
    
    public $registryName = 'phpext_apc';
    
    /**
     * Returns Version.
     *
     * @return string Version
     */
    public function getVersion()
    {
        if (extension_loaded('apc') === false) {
            return \Webinterface\Helper\Serverstack::printExclamationMarkLeft(
                'The PHP Extension "APC" is required.'
            );
        }

        //$info = \apc_sma_info();
        //var_dump($info);

        return phpversion('apc');
    }
    
    public function getVersionRaw()
    {
        return phpversion('apc');
    }
}
