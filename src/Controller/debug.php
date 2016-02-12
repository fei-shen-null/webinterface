<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - onwards, Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

/**
 * Debug Index
 */
function index()
{
    $tpl_data = [
        'constants' => showConstants('raw'), // showConstants() is defined in bootstrap.php
    ];

    render('page-action', $tpl_data);
}
