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
$index = 0;
$node_name = '';
foreach ($ini['ini_array'] as $key => $value) {
    $index = $index + 1;
    $node_name = 'node-' . $index;
    $html = '';

    if ($value['type'] == 'section') {
        echo '<tr id="'.$node_name.'"><td>'.$value['section'].'</td></tr>'; $section_node_name = $node_name;
    }

    if ($value['type'] == 'comment') { }

    if ($value['type'] == 'entry') {
        echo '<tr id="'.$node_name.'" class="child-of-'.$section_node_name.'"><td>'.$value['key'].'</td>';
        echo '<td><div class="editable">'; // span tag for jquery.jEditable
        echo $value['value'] . '</div></td></tr>';
    }
}
?>

</table>
