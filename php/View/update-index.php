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
        <td>' . $windows_version . '(' . $bitsize . ')</td>
        <td>Windows 8.1</td>
    </tr>
</thead>
';

foreach ($components as $index => $componentName) {
    
    $class = '\Webinterface\Components\\'.$componentName;
    $component = new $class;
    
    $versionString = $component->getVersion();
    $version = strlen($versionString) > 10 ? '0.0.0' : $versionString;
    
    $html = '<tr>
        <td>' . $component->name . '</td>
        <td>' . $versionString . '</td>
        <td>' . printUpdatedSign($version, $registry[$component->registryName]['latest']['version']) . '</td>
    </tr>';
    
    $html = str_replace('float:right', 'float:left', $html);
    echo $html;
    
    unset($component);
}
echo '</table></div></div>';

/**
 * The function prints an update symbol if old_version is lower than new_version.
 *
 * @param string Old version.
 * @param string New version.
 */
function printUpdatedSign($old_version, $new_version)
{
    if (version_compare($old_version, $new_version, '<') === true) {
        $html = '<span class="label label-success">';
        $html .= $new_version;
        $html .= '</span><span style="color:green; font-size: 16px">&nbsp;&#x25B2;</span>';

        return $html;
    }

    return $new_version;
}
?>