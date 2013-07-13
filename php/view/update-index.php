Update Installed Components
<?php
//var_dump($components);
// echo (new \Webinterface\Components\Adminer)->getVersion();

foreach($components as $index => $component)
{
    // not supported PHP syntax
    // echo (new '\Webinterface\Components\\'.$component)->getVersion();

    $class = '\Webinterface\Components\\'.$component;

    $version = (new $class)->getVersion();
    //$installed = (new $class)->isInstalled();

    $components[$index] = array(
        'name' => $component,
        'url' => $version,
        //$installed' => $installed
    );
}

echo '<table class="table table-condensed table-hover">
<thead>
    <tr>
        <th>Component</th><th>Version</th>
    </tr>
</thead>
';

foreach($components as $index => $component) {
    echo '<tr>
        <td>'.$component['name'].'</td>
        <td>'.$component['url'].'</td>
    </tr>';
}
echo '</table>';
?>