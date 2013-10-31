<?php
namespace Webinterface\Components;
class APC
{
    /**
     * Returns Version.
     *
     * @return string Version
     */
    public function getVersion()
    {
        if (extension_loaded('apc') === false) {
            return \Webinterface\Helper\Serverstack::printExclamationMark(
                'The APC Extension "memcache" is required.'
            );
        }

        return \Webinterface\Helper\Serverstack::printExclamationMark(
            'Not implemented yet.'
        );

        $info = \apc_sma_info();
        var_dump($info);

        return $info['version'];
    }
}
