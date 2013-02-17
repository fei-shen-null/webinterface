<h2>
    PHP Extensions
    <small>(<?=count($enabled_extensions)?> of <?=count($available_extensions)?> loaded)</small>
    <div id="ajax-status" class="floatright hide btn btn-small btn-success">Updating Extensions.</div>
</h2>

To enable an extension, check it's checkbox. To disable an extension uncheck it's checkbox. <small>Surprise, surprise!</small>
<form id="phpExtensionsForm" class="phpextensions form-horizontal"
      action="index.php?page=config&amp;action=update_phpextensions"
      method="post">

<span id="phpExtensionsFormContent">
<?php
// extensions_loaded = daemon state
//var_dump($loaded_extensions);
echo $form;
?>
</span>

<div style="clear:both; float:right;">
    <input type="submit" class="aButton" value=" Submit ">
    <input type="reset" class="aButton" value=" Reset ">
</div>
</form>
