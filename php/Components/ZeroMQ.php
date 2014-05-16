<?php
namespace Webinterface\Components;

class ZeroMQ
{
    public $name = 'ZeroMQ';
    
    public $type = 'PHP Extension';
    
    public $registryName = 'phpext_zmq';
    
    public function getVersion()
    {
        if (extension_loaded('zmq') === false) {            
            return \Webinterface\Helper\Serverstack::printExclamationMark(
                'Not implemented yet!'
            );
        }
    }
}
