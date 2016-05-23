<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - 2016, Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

namespace WPNXM\Webinterface\Core;

class Request
{
    private $get  = [];
    private $post = [];

    private $filter_definition = [
        'token'     => FILTER_SANITIZE_STRING,
        'page'      => FILTER_SANITIZE_STRING,
        'action'    => FILTER_SANITIZE_STRING,
        'tab'       => FILTER_SANITIZE_STRING,
        'id'        => FILTER_SANITIZE_NUMBER_INT,
        'daemon'    => FILTER_SANITIZE_STRING,
        'file'      => FILTER_SANITIZE_STRING,
        'newdomain' => FILTER_SANITIZE_STRING,
    ];  

    public function __construct(array $filter_definition = []) 
    {
        $args = array_merge($this->filter_definition, $filter_definition);

        if($_SERVER['REQUEST_METHOD'] === 'GET') {                   
            $get = filter_input_array(INPUT_GET, $args, false);
            $this->get = isset($get) ? $get : [];
            unset($get, $_GET);           
        } 
        elseif($_SERVER['REQUEST_METHOD'] === 'POST') {      
            $post = filter_input_array(INPUT_POST, $args, false);
            $this->post = isset($post) ? $post : [];
            unset($post, $_POST);
        }        
    }

    public function get($key, $default = null)
    {
        return array_key_exists($key, $this->get) ? $this->get[$key] : $default;
    }

    public function post($key, $default = null)
    {
        return array_key_exists($key, $this->post) ? $this->post[$key] : $default;
    }    
}