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
        'load_jquery_additionals' => true,
        'components'              => \Webinterface\Helper\Serverstack::getInstalledComponents(),
        'windows_version'         => \Webinterface\Helper\Serverstack::getWindowsVersion(),
        'bitsize'                 => \Webinterface\Helper\Serverstack::getBitSizeString(),
        'registry_updated'        => \Webinterface\Helper\Updater::updateRegistry(),
        'registry'                => include WPNXM_DATA_DIR . 'wpnxm-software-registry.php'
    );

    render('page-action', $tpl_data);
}

function download()
{
    $component = ($component = filter_input(INPUT_GET, 'component')) ? $component : 'none';
    $version = ($version = filter_input(INPUT_GET, 'version')) ? $version : '0.0.0';

    if($component === 'none' or $version === '0.0.0') {
        throw new \InvalidArgumentException();
    }

    $registry = include WPNXM_DATA_DIR . 'wpnxm-software-registry.php';

    if(!isset($registry[$component][$version])) {
        throw new \InvalidArgumentException(sprintf('Component "%s" has no version "%s".', $component, $version));
    }

    downloadComponent($component, $version);
}

function downloadComponent($component, $version)
{
    // stream download the file
    $file = fopen(WPNXM_DATA_DIR . basename($registry[$component][$version]), 'r');

    set_time_limit(0); // unlimited max execution time

    $options = array(
        CURLOPT_URL     => $registry[$component][$version],
        CURLOPT_FILE    => $file,
        CURLOPT_TIMEOUT => 3600 * 2, // set 2h to not timeout on big files
        CURLOPT_HEADER  => 0,
        CURLOPT_NOPROGRESS => false,
        CURLOPT_PROGRESSFUNCTION => 'curl_progress_callback',
        //CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_BUFFERSIZE => 4096
    );

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    curl_exec($ch);
    curl_close($ch);

    fclose($file);
}

function curl_progress_callback($download_size, $downloaded, $upload_size, $uploaded)
{
    $data = array("progress" => array("loaded" => $downloaded, "total" => $download_size));
    $json = json_encode($data);
    echo '<script>updateProgress('.$json.');</script>' . PHP_EOL;
    ob_flush();
    flush();
}
