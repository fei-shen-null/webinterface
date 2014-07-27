<?php
namespace Webinterface\Components;
class XHProf extends AbstractComponent
{
    public $name = 'XHProf';

    public $registryName = 'xhprof';

    public $installationFolder = '\www\tools\xhprof';

    public $files = array(
        '\www\tools\xhprof\package.xml',
        '\www\tools\xhprof\xhprof_html\index.php'
    );

    /**
     * Returns Version.
     *
     * @return string Version
     */
    public function getVersion()
    {
        if(!is_file(WPNXM_DIR . $this->files[0])) {
            return 'not installed';
        }

        $xml = simplexml_load_file(WPNXM_DIR . $this->files[0]);

        return $xml->version->release;
    }
}
