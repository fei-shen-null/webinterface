<?php
   /**
    * WPИ-XM Server Stack - Webinterface
    * Jens-André Koch © 2010 - onwards
    * http://wpn-xm.org/
    *
    *        _\|/_
    *        (o o)
    +-----oOO-{_}-OOo------------------------------------------------------------------+
    |                                                                                  |
    |    LICENSE                                                                       |
    |                                                                                  |
    |    WPИ-XM Server Stack is free software; you can redistribute it and/or modify   |
    |    it under the terms of the GNU General Public License as published by          |
    |    the Free Software Foundation; either version 2 of the License, or             |
    |    (at your option) any later version.                                           |
    |                                                                                  |
    |    WPИ-XM Server Stack is distributed in the hope that it will be useful,        |
    |    but WITHOUT ANY WARRANTY; without even the implied warranty of                |
    |    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                 |
    |    GNU General Public License for more details.                                  |
    |                                                                                  |
    |    You should have received a copy of the GNU General Public License             |
    |    along with this program; if not, write to the Free Software                   |
    |    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA    |
    |                                                                                  |
    +----------------------------------------------------------------------------------+
    */

function index()
{
    $tpl_data = array(
        'no_layout' => true, // it's a modal dialog
        'domains' => \Webinterface\Helper\Domains::listDomains()
    );

    render('page-action', $tpl_data);
}

function insert()
{
    $newDomainName = isset($_GET['newdomain']) ? $_GET['newdomain'] : null;

    $domainFileToCreate = NGINX_DOMAINS_DIR . $newDomainName . '.conf';

    clearstatcache();

    /**
     * Create folder "domains" in "/bin/nginx/conf", if not existant yet.
     *
     * Note: the folder is normally created during installation.
     * This is just a fallback, in case the user might have removed it.
     */
    if (!is_dir(NGINX_DOMAINS_DIR)) {
        mkdir(NGINX_DOMAINS_DIR, 0777);
    }

    // read domain template file
    $tplContent = file_get_contents(WPNXM_DATA_DIR . '/config-templates/nginx-domain-conf.tpl');

    // replace the host name in the domain template
    $content = str_replace('%%domain%%', $newDomainName, $tplContent);

    // write new domain file using the domain template as content
    file_put_contents($domainFileToCreate, $content);

    // Add include-line for new domain file in "\bin\nginx\conf\domains.conf"

    clearstatcache();

    $domainsMainConfigFile = WPNXM_DIR . '\bin\nginx\conf\domains.conf';

    if (!is_writable($domainsMainConfigFile) && !chmod($domainsMainConfigFile, 0777)) {
        exit('The "domains.conf" file is not writeable. Please modify permissions.');
    } else {
        file_put_contents($domainsMainConfigFile, "\n # automatically added domain configuration file \n include domains/$newDomainName.conf;", FILE_APPEND);
    }

    // check for "COM" (php_com_dotnet.dll)
    if (!class_exists('COM') and !extension_loaded("com_dotnet")) {
        $msg = 'COM class not found. Enable the extension by adding "extension=php_com_dotnet.dll" to your php.ini.';
        throw new Exception($msg);
    }

    $WshShell = new COM("WScript.Shell");

    // reload nginx configuration
    $cmdRestartNginx = 'cmd /c "' . WPNXM_DIR . '\bin\nginx\nginx.exe -p ' . WPNXM_DIR . ' -c ' . WPNXM_DIR . '\bin\nginx\conf\nginx.conf -s reload"';
    $oExec = $WshShell->run($cmdRestartNginx, 0, false);

    // add the new virtual host to the windows .hosts file using the "hosts" tool
    $cmdAddHosts = 'cmd /c "' . WPNXM_DIR . '\bin\tools\hosts' . ' add ' . $_SERVER['SERVER_ADDR'] . ' ' . $newDomainName . ' # added by WPN-XM"';
    passthru($cmdAddHosts);

    // flush ipcache
    $cmdIpflush = 'ipconfig /flushdns';
    $oExec = $WshShell->run($cmdIpflush, 0, false);

    // wait a second for dns flush
    sleep(1);

    // forward to new host
    header("Location: http://$newDomainName/");
}
