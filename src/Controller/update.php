<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - onwards, Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

function index()
{
    $tpl_data = [
        'load_jquery_additionals' => true,
        'components'              => \Webinterface\Helper\Serverstack::getInstalledComponents(),
        'windows_version'         => \Webinterface\Helper\Serverstack::getWindowsVersion(),
        'bitsize'                 => \Webinterface\Helper\Serverstack::getBitSizeString(),
        'registry_updated'        => \Webinterface\Helper\Updater::updateRegistry(),
        'registry'                => include WPNXM_DATA_DIR.'wpnxm-software-registry.php',
    ];

    render('page-action', $tpl_data);
}

function download()
{
    $component = ($component = filter_input(INPUT_GET, 'component')) ? $component : 'none';
    $version   = ($version = filter_input(INPUT_GET, 'version')) ? $version : '0.0.0';

    if ($component === 'none' or $version === '0.0.0') {
        throw new \InvalidArgumentException('Please specify "component" and "version".');
    }

    $url = \Webinterface\Helper\Registry::getUrl($component, $version);
    \Webinterface\Helper\Downloader::download($url);
}

function curl_progress_callback($download_size, $downloaded, $upload_size, $uploaded)
{
    $data = [ 'progress' => [
        'loaded' => $downloaded,
        'total'  => $download_size,
    ]];

    $json = json_encode($data);
    echo '<script>updateProgress('.$json.');</script>'.PHP_EOL;
    ob_flush();
    flush();
}
