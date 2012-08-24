<h2>PHP Extensions <small>(<?=count($enabled_extensions)?> of <?=count($available_extensions)?> loaded)</small></h2>

<form class="form-horizontal" action="index.php?page=config&amp;action=update_phpextensions" method="post">
<div class="control-group" style="float: left; width: 125px; margin: 10px;">
<?php
// use list of available_extensions to draw checkboxes
$html_checkboxes = '';
$i = 0;

foreach ($available_extensions as $name => $file) {
    // in case the extension is enabled, check the checkbox
    $checked = false;
    if (isset($enabled_extensions[$file])) {
        $checked = true;
    }

    /**
     * Deactivate the checkbox for the XDebug Extension.
     * XDebug is not loaded as normal PHP extension ([PHP]extension=).
     * It is loaded as a Zend Engine extension ([ZEND]zend_extension=).
     */
    $disabled = '';
    if (strpos($name, 'xdebug') !== false) {
        $disabled = 'disabled';
    }

    // the input tag is wrapped by the label tag
    $html_checkboxes .= '<label class="checkbox';
    $html_checkboxes .= ($checked === true) ? ' active-element" ' : ' not-active-element" ';
    $html_checkboxes .= 'style="vertical-align: 30%;">';
    $html_checkboxes .= '<input type="checkbox" name="extensions[]" value="'.$file.'" ';
    $html_checkboxes .= ($checked === true) ? 'checked="checked" ' : '';
    $html_checkboxes .=  $disabled.'>';
    $html_checkboxes .= substr($name, 4);
    $html_checkboxes .= '</label>';

    $i++; if ($i == 12) { $html_checkboxes .= '</div><div style="float: left; width: 125px; margin: 10px;">'; $i = 0; }
}

echo $html_checkboxes;
?>
</div>
<div style="clear:both; float:right;">
    <input type="submit" class="aButton" value=" Submit ">
    <input type="reset" class="aButton" value=" Reset ">
</div>
</form>
