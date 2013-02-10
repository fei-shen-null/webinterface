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
    |    WPИ-XM Serverstack is free software; you can redistribute it and/or modify    |
    |    it under the terms of the GNU General Public License as published by          |
    |    the Free Software Foundation; either version 2 of the License, or             |
    |    (at your option) any later version.                                           |
    |                                                                                  |
    |    WPИ-XM Serverstack is distributed in the hope that it will be useful,         |
    |    but WITHOUT ANY WARRANTY; without even the implied warranty of                |
    |    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                 |
    |    GNU General Public License for more details.                                  |
    |                                                                                  |
    |    You should have received a copy of the GNU General Public License             |
    |    along with this program; if not, write to the Free Software                   |
    |    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA    |
    |                                                                                  |
    +----------------------------------------------------------------------------------+
    *
    * @license    GNU/GPL v2 or (at your option) any later version..
    * @author     Jens-André Koch <jakoch@web.de>
    * @copyright  Jens-André Koch (2010 - 2012)
    * @link       http://wpn-xm.org/
    */

function index()
{
    render('page-action', array('no_layout'=>true));
}



function insert()
{
    if(isset($_GET['newvhost']) && !empty($_GET)) {
        $newVhostName = $_GET['newvhost'];
    }

    $vhostFileToCreate = NGINX_VHOSTS_DIR . $newVhostName . '.conf';

    clearstatcache();

    /**
     * Create folder "vhosts" in "/bin/nginx/conf", if not existant yet.
     *
     * note: this folder is created during installation, but the user might have removed it.
     */
    if (!is_dir(NGINX_VHOSTS_DIR)) {
        mkdir(NGINX_VHOSTS_DIR, 0777);
    }

    // read vhost template file
    $tplContent = file_get_contents(WPNXM_DATA_DIR . '/config-templates/nginx-vhost-conf.tpl');

    // replace the host name in the vhost template
    $content = str_replace('%%vhost%%', $newVhostName, $tplContent);

    // write new vhost file using the vhost template as content
    file_put_contents($vhostFileToCreate, $content);

    // Add include-line for new vhost file in "\bin\nginx\conf\vhosts.conf"

    clearstatcache();

    $main_vhost_conf_file = NGINX_CONF_DIR . 'vhosts.conf';

    if (!is_writable($main_vhost_conf_file) && !chmod($main_vhost_conf_file, 0777)) {
        exit('The "vhosts.conf" file is not writeable. Please modify permissions.');
    } else {
        file_put_contents($main_vhost_conf_file, "\n # automatically added vhost configuration file \n include vhosts/$newVhostName.conf;", FILE_APPEND);
    }

    // check for "COM" (php_com_dotnet.dll)
    if (!class_exists('COM') and !extension_loaded("com_dotnet")) {
        $msg = 'COM class not found. Enable the extension by adding "extension=php_com_dotnet.dll" to your php.ini.';
        throw new Exception($msg);
    }

    $WshShell = new COM("WScript.Shell");

    // reload nginx configuration
    $cmd_restartNginx = 'cmd /c "'.  WPNXM_DIR . '\bin\nginx\nginx.exe -p ' . WPNXM_DIR . ' -c ' . WPNXM_DIR . '\bin\nginx\conf\nginx.conf -s reload"';
    $oExec = $WshShell->run($cmd_restartNginx , 0, false);

    // add the new virtual host to the windows .hosts file using the "hosts" tool
    $cmdAddHosts = 'cmd /c "' . WPNXM_DIR . '\bin\tools\hosts' . ' add ' . $_SERVER['SERVER_ADDR'] . ' ' . $newVhostName . ' # added by WPN-XM"' ;
    passthru($cmdAddHosts);

    // flush ipcache
    $cmdIpflush = 'ipconfig /flushdns';
    $oExec = $WshShell->run($cmdIpflush , 0, false);

    // wait a second for dns flush
    sleep(1);

    // forward to new host
    header("Location: http://$newVhostName/");
}
