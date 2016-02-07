<h2>PHP Version</h2>

This shows the currently active PHP version. If multiple PHP versions are installed, you might switch between them.

<?php echo $php_version_switcher_form; ?>

<h2>PHP INI Editor</h2>
The editor allows modifications of existing values in your php.ini.
Click on a bold section to expand all directives for that section.
You might then click on the value to edit it.
Pressing the enter key will save the new value to your php.ini.
Do not forget to restart the PHP daemon in order to let the new settings become alive!

<div class="alert alert-info" role="alert">
    You are editing <b><?php echo $ini['ini_file']; ?></b>
</div>

<table id="treeTable">
<thead>
<tr>
  <th width="35%">Section - Directive</th>
  <th>Value</th>
</tr>
</thead>

<?php
// render the php.ini array into the TreeTable
// use class="editable" on values (jquery.jEditable)
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

<script>
var currentPHPversion = $("#php-version-switcher-form select[name='new-php-version'] option:selected").text();
console.log('The currently active PHP version is:' + currentPHPversion);

$("#php-version-switcher-form").submit(function(event) {
  event.preventDefault();
  var $form = $(this),
    url = $form.attr("action"),
    php_version = $form.find("select[name='new-php-version']").val();

  if(currentPHPversion === php_version) {
    console.log('Skipping version change, because old PHP version equals new PHP version.')
    return;
  }

  var posting = $.post(url, { new_php_version: php_version } );
});
</script>