<?php
namespace Webinterface\Components;
class ZeroMQ
{
    public function getVersion()
    {
        if (extension_loaded('apc') === false) {
            return \Webinterface\Helper\Serverstack::printExclamationMark(
                'Not implemented yet!'
            );
        }
    }
}
