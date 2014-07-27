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
    $projects = new Webinterface\Helper\Projects();

    $tpl_data = array(
        'load_jquery_additionals' => true,
        'numberOfProjects'        => $projects->getNumberOfProjects(),
        'listProjects'            => $projects->listProjects(),
        'numberOfTools'           => $projects->getNumberOfTools(),
        'listTools'               => $projects->listTools()
    );

    render('page-action', $tpl_data);
}

function create()
{
    $tpl_data = array(
        'no_layout' => true
    );

    render('page-action', $tpl_data);
}

function edit()
{
    $project = filter_input(INPUT_GET, 'project');

    $tpl_data = array(
        'no_layout' => true,
        'project' => $project
    );

    render('page-action', $tpl_data);
}

function createproject()
{   
    $project = filter_input(INPUT_POST, 'projectname');
    
    $template = filter_input(INPUT_POST, 'projecttemplate');
    switch ($template) {
        case '"Hello World" Project':
            $template = new Webinterface\Helper\ProjectTemplate();
            $template->generate();
            break;
        case  '"Composer" Project':

            break;
        case 'Project Folder only':
        default:
            break;
    }

    $bool = mkdir(WPNXM_WWW_DIR . DS . $project, 0777);
    
    if($bool === true) {
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
