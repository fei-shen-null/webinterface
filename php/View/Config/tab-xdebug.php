<h2>XDebug - PHP Debugger &amp; Profiler</h2>

<?php if($xdebug_installed === true) { ?>

<table id="treeTable" class="treeTable" style="width:500px; float:left;">
<thead>
<tr>
  <th>Directive</th>
  <th>Value</th>
</tr>
</thead>
<?php
foreach ($ini_settings as $setting => $values) {
    echo '<tr><td>' . $setting . '</td><td>' . $values['global_value'] . '</td></tr>';
}
?>
</table>

<?php } else { ?>

PHP Extension "XDebug" is not installed.

<?php } ?>
