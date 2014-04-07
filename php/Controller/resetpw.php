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
    $component = filter_input(INPUT_GET, 'component', FILTER_SANITIZE_STRING);

    $tpl_data = array(
        'no_layout' => true,
        'component' => ucfirst($component)
    );
    
    render('page-action', $tpl_data);
}

function update()
{
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (empty($password) === true) {
        echo '<div class="alert alert-danger">No Password given!</div>';
        return;
    } 
    
    $component = filter_input(INPUT_POST, 'component', FILTER_SANITIZE_STRING);
    
    if(empty($component) === true) {
        echo '<div class="alert alert-danger">No Component given!</div>';
        return;
    }
    
    switch ($component) { 
        case 'mariadb':
            $c = new Webinterface\Components\MariaDb();
            echo $c->setPassword($password);
        case 'mongodb':
            $c = new Webinterface\Components\MongoDb();
            echo $c->setPassword($password);
        default:
            echo '<div class="alert alert-danger">Component not found.</div>';
    }
}
