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
    $projects = new \WPNXM\Webinterface\Helper\Projects();

    $tpl_data = [
        'load_jquery_additionals' => true,
        'numberOfProjects'        => $projects->getNumberOfProjects(),
        'listProjects'            => $projects->listProjects(),
        'numberOfTools'           => $projects->getNumberOfTools(),
        'listTools'               => $projects->listTools(),
    ];

    render('page-action', $tpl_data);
}

function create()
{
    $tpl_data = [
        'no_layout' => true,
    ];

    render('page-action', $tpl_data);
}

function edit()
{
    $project = filter_input(INPUT_GET, 'project');

    $tpl_data = [
        'no_layout' => true,
        'project'   => $project,
    ];

    render('page-action', $tpl_data);
}

function createproject()
{
    $project  = filter_input(INPUT_POST, 'projectname');
    $template = filter_input(INPUT_POST, 'projecttemplate');

    switch ($template) {
        case 0: // Hello world
            $template = new \WPNXM\Webinterface\Helper\ProjectTemplate();
            $template->generate();
            break;
        case 1: // PHP project with Composer
            break;
        case 2:
        default:
            break;
    }

    if (mkdir(WPNXM_WWW_DIR.DS.$project, 0777)) {
        header('Project created', true, '200');
    } else {
        header('Project not created.', true, '500');
    }

    exit;
}

function settings()
{
    $project = filter_input(INPUT_GET, 'project');

    echo $project;
}
