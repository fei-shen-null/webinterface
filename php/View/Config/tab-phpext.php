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

<script type="text/javascript">
$(function() {

    handlePHPExtensionsForm();
    handleZendExtensionsForm();

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

});

// wait for the DOM to be loaded
function handleZendExtensionsForm() {
    var options = {
        delegation:    true,  // the form we are binding, does not exist, yet (load via ajax)
        target:        '#zendext-ajax-status',   // target element(s) to be updated with server response
        beforeSubmit:  showRequest,  // pre-submit callback
        success:       showResponse,  // post-submit callback

        // other available options:
        //url:       url         // override for form's 'action' attribute
        //type:      type        // 'get' or 'post', override for form's 'method' attribute
        dataType:    'json'      // 'xml', 'script', or 'json' (expected server response type)
        //clearForm: true        // clear all form fields after successful submit
        //resetForm: true        // reset the form after successful submit

        // $.ajax options can be used here too, for example:
        //timeout:   3000
    };

    // delegation binding of the form using 'ajaxForm'
    $('#zendExtensionsForm').ajaxForm(options);

    // pre-submit callback
    function showRequest(formData, jqForm, options) {
        // formData is an array; here we use $.param to convert it to a string to display it
        // but the form plugin does this for you automatically when it submits the data
        var queryString = $.param(formData);

        // jqForm is a jQuery object encapsulating the form element.  To access the
        // DOM element for the form do this:
        // var formElement = jqForm[0];

        /*alert('About to submit: \n\n' + queryString);*/

        // here we could return false to prevent the form from being submitted;
        // returning anything other than false will allow the form submit to continue
        // return false;

        return true;
    }

    // post-submit callback
    function showResponse(responseText, statusText, xhr, $form)  {
        // for normal html responses, the first argument to the success callback
        // is the XMLHttpRequest object's responseText property

        // if the ajaxForm method was passed an Options Object with the dataType
        // property set to 'xml' then the first argument to the success callback
        // is the XMLHttpRequest object's responseXML property

        // if the ajaxForm method was passed an Options Object with the dataType
        // property set to 'json' then the first argument to the success callback
        // is the json data object returned by the server

        // how to update page using json data
        // ==================================
        // * iterate over each property/value combination in the JSON object
        // * look for an element in the DOM that matches the property name
        //   o first, look for an element with a matching id attribute
        //   o if no element with a matching ID is found, look for input,
        //     select or textarea elements with a matching name attribute
        // * update the value, contents or selection of the matched element(s) based on the value in the JSON object

        var jsonData = responseText;
        var ajaxStatus = '#zendext-ajax-status';

        console.log(jsonData);

        // after a change to php ini, we are indicating the change and the PHP daemon restart
        // by showing the ajax status
        $(ajaxStatus).html(jsonData.responseText).removeClass('hide').show().pulsate();

        // restart PHP
        $.get("index.php?page=daemon&action=restart&daemon=graceful-php");

        // there might be a change in the on/off state of extensions.
        // fetch their state as HTML checkbox display
        var updateZendExtensionsForm = function() {
            $.ajax({
              url: "index.php?page=config&action=renderZendExtensionsFormContent"
            }).done(function(html) {
              $("#zendExtensionsFormContent").html(html);
              $(ajaxStatus).hide().addClass('hide');
            });
        }

        // delayed call, because PHP needs to startup again
        setTimeout(updateZendExtensionsForm, 2200);
    }
}; // ./ handlePHPExtensionsForm()

// wait for the DOM to be loaded
function handlePHPExtensionsForm() {
    var options = {
        delegation:    true,  // the form we are binding, does not exist, yet (load via ajax)
        target:        '#phpext-ajax-status',   // target element(s) to be updated with server response
        beforeSubmit:  showRequest,  // pre-submit callback
        success:       showResponse,  // post-submit callback

        // other available options:
        //url:       url         // override for form's 'action' attribute
        //type:      type        // 'get' or 'post', override for form's 'method' attribute
        dataType:    'json'      // 'xml', 'script', or 'json' (expected server response type)
        //clearForm: true        // clear all form fields after successful submit
        //resetForm: true        // reset the form after successful submit

        // $.ajax options can be used here too, for example:
        //timeout:   3000
    };

    // delegation binding of the form using 'ajaxForm'
    $('#phpExtensionsForm').ajaxForm(options);

    // pre-submit callback
    function showRequest(formData, jqForm, options) {
        // formData is an array; here we use $.param to convert it to a string to display it
        // but the form plugin does this for you automatically when it submits the data
        var queryString = $.param(formData);

        // jqForm is a jQuery object encapsulating the form element.  To access the
        // DOM element for the form do this:
        // var formElement = jqForm[0];

        /*alert('About to submit: \n\n' + queryString);*/

        // here we could return false to prevent the form from being submitted;
        // returning anything other than false will allow the form submit to continue
        // return false;

        return true;
    }

    // post-submit callback
    function showResponse(responseText, statusText, xhr, $form)  {
        // for normal html responses, the first argument to the success callback
        // is the XMLHttpRequest object's responseText property

        // if the ajaxForm method was passed an Options Object with the dataType
        // property set to 'xml' then the first argument to the success callback
        // is the XMLHttpRequest object's responseXML property

        // if the ajaxForm method was passed an Options Object with the dataType
        // property set to 'json' then the first argument to the success callback
        // is the json data object returned by the server

        // how to update page using json data
        // ==================================
        // * iterate over each property/value combination in the JSON object
        // * look for an element in the DOM that matches the property name
        //   o first, look for an element with a matching id attribute
        //   o if no element with a matching ID is found, look for input,
        //     select or textarea elements with a matching name attribute
        // * update the value, contents or selection of the matched element(s) based on the value in the JSON object

        var jsonData = responseText;
        var ajaxStatus = '#phpext-ajax-status';

        console.log(jsonData);

        // after a change to php ini, we are indicating the change and the PHP daemon restart
        // by showing the ajax status
        $(ajaxStatus).html(jsonData.responseText).removeClass('hide').show().pulsate();

        // restart PHP
        $.get("index.php?page=daemon&action=restart&daemon=graceful-php");

        // there might be a change in the on/off state of extensions.
        // fetch their state as HTML checkbox display
        var updatePHPExtensionsForm = function() {
            $.ajax({
                url: "index.php?page=config&action=renderPHPExtensionsFormContent"
            }).done(function(html) {
              $("#phpExtensionsFormContent").html(html);
              $(ajaxStatus).hide().addClass('hide')
            });
        }

        // delayed call, because PHP needs to startup again
        setTimeout(updatePHPExtensionsForm, 2200);
    }
}; // ./ handlePHPExtensionsForm()
</script>