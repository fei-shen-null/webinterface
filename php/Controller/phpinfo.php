<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - 2014 Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

function index()
{
    $tpl_data = array(
        'php_info' => Webinterface\Helper\PHPInfo::getPHPInfo()
    );

    render('page-action', $tpl_data);
}
