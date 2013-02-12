Update

<?php var_dump($components);

 echo (new \Webinterface\Components\Adminer)->getVersion();
 echo (new \Webinterface\Components\MariaDB)->getVersion();

var_dump((new \Webinterface\Components\MariaDB)->isInstalled());
?>

List all Installaed Components | Perform a request to the server asking for new versions