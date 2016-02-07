<h2>
    PHP Extensions
    <small>(<?php echo $number_enabled_php_extensions; ?> of <?php echo $number_available_php_extensions; ?> loaded)</small>
    <div id="phpext-ajax-status" class="btn btn-small btn-success floatright hide">Updating PHP Extensions.</div>
</h2>

To enable an extension, check it's checkbox. To disable an extension, uncheck it's checkbox. <small>Surprise, surprise!</small>
<form id="phpExtensionsForm" class="phpextensions form-horizontal" method="post"
      action="<?php echo WPNXM_WEBINTERFACE_ROOT; ?>index.php?page=config&amp;action=update_php_extensions">

    <fieldset id="phpExtensionsFormContent">
    <?php echo $php_extensions_form; ?>
    </fieldset>

    <div class="right">
        <button type="reset" class="btn btn-danger"><i class="icon-remove"></i> Reset</button>
        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Submit</button>
    </div>
</form>

<h2>
    Zend Extensions
    <small>(<?php echo $number_enabled_zend_extensions; ?> of <?php echo $number_available_zend_extensions; ?> loaded)</small>
    <div id="zendext-ajax-status" class="btn btn-small btn-success floatright hide">Updating Zend Extensions.</div>
</h2>
<form id="zendExtensionsForm" class="phpextensions form-horizontal" method="post"
      action="<?php echo WPNXM_WEBINTERFACE_ROOT; ?>index.php?page=config&amp;action=update_zend_extensions">

    <fieldset id="zendExtensionsFormContent">
    <?php echo $zend_extensions_form; ?>
    </fieldset>

    <div class="right">
        <button type="reset" class="btn btn-danger"><i class="icon-remove"></i> Reset</button>
        <button type="submit" class="btn btn-success"><i class="icon-ok"></i> Submit</button>
    </div>
</form>

<!-- JS for the "PHP Extension" tab (tab-phpext.php) -->
<script type="text/javascript">
jQuery.fn.extend({
    // extend jQuery with a "pulsate" function
    // Usage: http://jsfiddle.net/nick_craver/HHWBv/
    pulsate: function() {
        var obj = $(this);
        // pulsate 3 times
        for(var i=0; i<2; i++) {
          obj.animate({opacity: 0.2}, 1000, 'linear')
             .animate({opacity: 1}, 1000, 'linear');
        }
        // pulsate 1 more, then hide
        obj.animate({opacity: 0.2}, 1000, 'linear')
           .animate({opacity: 1}, 1000, 'linear', function() {
            obj.hide();
        });
    return obj;
    }
});

$(function() {

  $('#zendExtensionsForm').submit(function(e) {
    event.preventDefault(); // Prevent the form from submitting via the browser
    var form = $(this);
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize()
      }).done(function(data) {
          signalRestartAndUpdateExtensions(data, 'zend');
      });
  });

  $('#phpExtensionsForm').submit(function(e) {
    console.log('test');
    event.preventDefault(); // Prevent the form from submitting via the browser
    var form = $(this);
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize()
      }).done(function(data) {
          signalRestartAndUpdateExtensions(data, 'php');
      });
  });

});

function signalRestartAndUpdateExtensions(responseText, extensionType)
{
    if(extensionType === 'zend') {
      var ajaxStatusId = '#zendext-ajax-status';
      var targetId = '#zendExtensionsFormContent';
      var url = 'index.php?page=config&action=renderZendExtensionsFormContent';
    }

    if(extensionType === 'php') {
      var ajaxStatusId = '#phpext-ajax-status';
      var targetId = '#phpExtensionsFormContent';
      var url = 'index.php?page=config&action=renderPHPExtensionsFormContent';
    }

    // indicating the change to php.ini and the PHP restart
    $(ajaxStatusId).html(responseText.responseText).removeClass('hide').show().pulsate();

    // restart PHP
    $.get("index.php?page=daemon&action=restart&daemon=graceful-php");

    // update the extension display
    var updateExtensionsForm = function() {
        $.ajax({url: url}).done(function(html) {
          $(targetId).html(html);
          $(ajaxStatusId).hide().addClass('hide');
        });
    }

    // use a delayed call, because PHP needs to startup again
    setTimeout(updateExtensionsForm, 2200);
}
</script>