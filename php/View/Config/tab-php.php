<h2>PHP Version</h2>

This shows the currently active PHP version. If multiple PHP versions are installed, you might switch between them.

<?php echo $php_version_switcher_form; ?>

<h2>PHP INI Editor</h2>
The editor allows modifications of existing values in your php.ini.
Click on a bold section to expand all directives for that section.
You might then click on the value to edit it.
Pressing the enter key will saves the new value to your php.ini. Take care!
Do not forget to restart the PHP daemon in order to let the new settings become alive!

<div class="info">
    You are editing <?php echo $ini['ini_file']; ?>
    <br>You are only able to modify existing values.
</div>

<table id="treeTable">
<thead>
<tr>
  <th width="35%">Section - Directive</th>
  <th>Value</th>
</tr>
</thead>

<?php
$i = 0;
$nodeName = '';
foreach ($ini['ini_array'] as $key => $value) {
    $i = $i + 1;
    $nodeName = 'node-' . $i;
    $html = '';

    if ($value['type'] === 'section') {
        echo '<tr id="'.$nodeName.'"><td>'.$value['section'].'</td></tr>';
        $sectionNodeName = $nodeName;
    }

    if ($value['type'] === 'comment') {
        // ain't show nothing, yet
    }

    if ($value['type'] === 'entry') {
        echo '<tr id="'.$nodeName.'" class="child-of-'.$sectionNodeName.'">';
        echo '<td>'.$value['key'].'</td>';
        // class editable for jquery.jEditable
        echo '<td><div class="editable">' . $value['value'] . '</div></td>';
        echo '</tr>';
    }
}
?>

</table>
