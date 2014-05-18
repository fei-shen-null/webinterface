<h2 class="heading">Updater</h2>

<?php
// display info box, if registry was updated
if($registry_updated === true) {
    echo '<div class="info">The WPN-XM Software Registry was updated.</div>';
}
?>

<div class="left-box"> 
    <div class="cs-message">
        <div class="cs-message-content cs-message-content-config">
<?php
echo '<table class="table table-condensed table-hover">
<thead>
    <tr>
        <th>Component</th><th>Your Version</th><th>Latest Version</th>
    </tr>
    <tr>
        <td>Windows</td>
        <td><span style="font-size:14px">' . $windows_version . '(' . $bitsize . ')</span></td>
        <td><span style="font-size:14px">Windows 8.1</span></td>
    </tr>
</thead>
';

foreach ($components as $index => $componentName) {
    
    if($componentName === 'PEAR') {
        continue;
    }
    
    $class = '\Webinterface\Components\\'.$componentName;
    $component = new $class;
    
    $versionString = $component->getVersion();
    $version = strlen($versionString) > 10 ? '0.0.0' : $versionString;
    
    $html = '<tr>
        <td>' . $component->name . '</td>
        <td><span style="font-size:14px">' . $versionString . '</span></td>       
        <td>' . printUpdatedSign($version, $registry[$component->registryName]['latest']['version']) . '</td>
    </tr>';
    
    $html = str_replace('float:right', 'float:left', $html);
    echo $html;
    
    unset($component);
}
echo '</table></div></div></div>';

/**
 * The function prints an update symbol if old_version is lower than new_version.
 *
 * @param string Old version.
 * @param string New version.
 */
function printUpdatedSign($old_version, $new_version)
{
    if (version_compare($old_version, $new_version) === -1) {       
        $html = '<a href="#"';
        $html .= ' class="btn btn-success btn-xs" style="font-size: 14px">';
        $html .= '<span class="glyphicon glyphicon-arrow-up"></span>';
        $html .= '&nbsp; '.$new_version.'</a>';
            
        return $html;
    }

    return '<span style="font-size:14px">'. $new_version . '</span>';
}
?>