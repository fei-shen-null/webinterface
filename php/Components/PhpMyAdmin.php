<?php 

namespace Webinterface\Components;

use \Webinterface\Components\AbstractComponent;

class PhpMyAdmin extends AbstractComponent
{
    public function getVersion()
    {
        echo __CLASS__ . '->' . __METHOD__ . ' : not implemented, yet!';
    }

    public static function getLink()
    {
       // is phpmyadmin installed?
       if (is_dir(WPNXM_WWW_DIR . 'phpmyadmin') === true) {
           $password = \Webinterface\Helper\Serverstack::getPassword('mariadb');
           $href = WPNXM_ROOT . 'tools/phpmyadmin/index.php?lang=en&server=1&pma_username=root&pma_password='.$password;

           return '<a href="'.$href.'">phpMyAdmin</a>';
       }
    } 
}