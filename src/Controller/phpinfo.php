<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - 2016, Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

function index()
{
    $tpl_data = [
        'php_info' => \WPNXM\Webinterface\Helper\PHPInfo::getPHPInfo(),
    ];

    render('page-action', $tpl_data);
}
