<h2>
    PHP Extensions
    <small>(<?=count($enabled_extensions)?> of <?=count($available_extensions)?> loaded)</small>
    <div id="ajax-status" class="floatright red hide">Extensions updated (0)</div>
</h2>

To enable an extension, check it's checkbox. To disable an extension uncheck it's checkbox. <small>Surprise, surprise!</small>
<form id="phpExtensionsForm" class="phpextensions form-horizontal"
      action="index.php?page=config&amp;action=update_phpextensions"
      method="post">

<?php
$html_checkboxes = '';
$i = 1; // start at first element
$itemsTotal = count($available_extensions); // elements total

// use list of available_extensions to draw checkboxes
foreach ($available_extensions as $name => $file) {
    // if extension is enabled, check the checkbox
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

    // render column opener (everytime on 1 of 12)
    if($i === 1) {
        $html_checkboxes .= '<div class="control-group" style="float: left; width: 125px; margin: 10px;">';
    }

    // the input tag is wrapped by the label tag
    $html_checkboxes .= '<label class="checkbox';
    $html_checkboxes .= ($checked === true) ? ' active-element">' : ' not-active-element">';
    $html_checkboxes .= '<input type="checkbox" name="extensions[]" value="'.$file.'" ';
    $html_checkboxes .= ($checked === true) ? 'checked="checked" ' : '';
    $html_checkboxes .=  $disabled.'>';
    $html_checkboxes .= substr($name, 4);
    $html_checkboxes .= '</label>';

    if ($i === 12 or $itemsTotal === 1) {
        $html_checkboxes .= '</div>';
        $i = 0; /* reset column counter */
    }

    $i++;
    $itemsTotal--;
}

echo $html_checkboxes;
?>

<div style="clear:both; float:right;">
    <input type="submit" class="aButton" value=" Submit ">
    <input type="reset" class="aButton" value=" Reset ">
</div>

</form>
