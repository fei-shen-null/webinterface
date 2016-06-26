<h2>Install PHP Extension<small style="font-size: 10px;">&nbsp; using Pickle v<?=$pickle_version?></small>
  <div id="php-extension-installation-ajax-status" class="btn btn-small btn-success floatright hide">Installing PHP Extension...</div>
</h2>
<?php if($pickle_installed) { ?>
<div id="bloodhound">
  <input type="text" class="typeahead" placeholder="PHP Extension"/>
  <!--<button class="btn btn-default ui item"><i class="large zoom icon"></i></span>Search</button>-->
  <button id="install-extension-button" type="submit" class="btn btn-success">Install</button>
</div>

<script type="text/javascript">
  var extensions = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    // URL points to a json file, that contains an array of PHP extension names
    prefetch: 'data/php-extensions-on-pecl.json'
  });
  // when passing in `null` for the `options` arguments, it will use default options
  $('#bloodhound .typeahead').typeahead(null, {
    name: 'extensions',
    limit: 5,
    source: extensions
  });
  $("#install-extension-button").click(function() {
    //alert( "Handler for .click() called." );
  });
</script>

<?php } else { ?>

<div class="alert alert-warning" role="alert">
  <strong>PHP Extension Installer not found!</strong>
  <hr>
  <p>The PHP Extension Installer (<a href="https://github.com/FriendsOfPHP/pickle">Pickle</a>) is used to install new PHP extensions.</p>
  <p>But Pickle wasn't found on your system.</p>
  <p><div class="btn btn-info btn-lg">Please install Pickle!</div></p>
  <!--<p><br/>Do you want to install Pickle now?</p>
  <br/>
  <button id="install-pickle-button" type="submit" class="btn btn-success">Install Pickle</button>
  -->
</div>

<script type="text/javascript">
// intercept clicks on the "Download Component" links
$("#install-pickle-button" ).on('click', function (e) {
    e.preventDefault();    
    alert( "Handler for .click() called. Launching Ajax Request to install Pickle." );    
    // add download progress bar
    $(this).after('<progress id="progress" value="0" max="0" style="margin-left: 15px">0%</progress>');
    // trigger AJAX download with curl callback to update the progessbar
    download('index.php?page=updater&action=install&software=pickle');
    return false;
});
function updateProgress(json)
{
    var progressBar = $('progress');
    progressBar.attr('value', json.progress.loaded);
    progressBar.attr('max', json.progress.total);
}

function download(link)
{
    var ajaxStatus = $('#php-extension-installation-ajax-status');
    ajaxStatus.html('<b>Downloading Pickle ...</b>').removeClass("hide");
    
    var xhr = new XMLHttpRequest();
    xhr.open('GET', link);
    xhr.send(null);

    // 1 second interval for continous xhr response handling
    var timer = window.setInterval(function () {
        // finished?
        if (xhr.readyState === XMLHttpRequest.DONE) {
            window.clearTimeout(timer);
            $('progress').replaceWith('<b>Done!</b>');
            ajaxStatus.html('<b>Done!</b>');
        }
        // append callback data to the body for evaluation (updates the progress bar)
        $('body').append(' ' + xhr.responseText + ' ');
        if((xhr.responseText).indexOf("Error")) {
            timer = null;
            return;
        }
    }, 2000);
};
</script>
<?php } ?>

<br><br>

<h2>
    PHP Extensions
    <small id="php-extensions-loaded">
      (<span id="number_enabled_php_extensions"><?php echo $number_enabled_php_extensions; ?></span>
      of <span id="number_available_php_extensions"><?php echo $number_available_php_extensions; ?></span> loaded)
    </small>    
    <div id="php-extension-activation-ajax-status" class="btn btn-small btn-success floatright hide">Updating PHP Extensions.</div>
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
    <small id="zend-extensions-loaded">
      (<span id="number_enabled_zend_extensions"><?php echo $number_enabled_zend_extensions; ?></span>
      of <span id="number_available_zend_extensions"><?php echo $number_available_zend_extensions; ?></span> loaded)
    </small>
    <div id="zend-extension-activation-ajax-status" class="btn btn-small btn-success floatright hide">Updating Zend Extensions.</div>
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
      var ajaxStatusId = $('#zend-extension-activation-ajax-status');
      var targetId = $('#zendExtensionsFormContent');
      var url = 'index.php?page=config&action=renderZendExtensionsFormContent';
    }

    if(extensionType === 'php') {
      var ajaxStatusId = $('#php-extension-activation-ajax-status');
      var targetId = $('#phpExtensionsFormContent');
      var url = 'index.php?page=config&action=renderPHPExtensionsFormContent';
    }

    // indicating the change to php.ini and the PHP restart
    ajaxStatusId.html(responseText.responseText).removeClass('hide').show().pulsate();

    // restart PHP
    $.get("index.php?page=daemon&action=restart&daemon=graceful-php");

    var updateExtensionsForm = function() {
        // update the extensions form display
        $.ajax({url: url}).done(function(html) {
          targetId.html(html);
          ajaxStatusId.hide().addClass('hide');
        });
        // update the number of loaded extensions
        $.getJSON('index.php?page=config&action=getNumberOfExtensionsLoaded', function(data) {
          $.each(data, function(key, val) {
            $('#'+key).html(val);
          });
        });
    }

    // use a delayed call, because PHP needs to startup again
    setTimeout(updateExtensionsForm, 2200);
}
</script>
