<!-- This css style will come alive only, when javascript is disabled.
     Its for displaying a message for all the security nerds with disabled javascript.
     We need this reminder, because the WPN-XM configuration pages depend on AJAX. -->
<noscript><style type="text/css">
  #page{ display:none; }
  #javascript-off-errorbox { display:block; font-size:20px; color:red; }
</style></noscript>

<script>
function setupTreeTable()
{
  // Apply some configuration settings
  $("table#treeTable").treeTable({
    clickableNodeNames: true
  });

  // Make visible that a row is clicked
  $("table#treeTable tbody tr").mousedown(function () {
    $("tr.selected").removeClass("selected"); // Deselect currently selected rows
    $(this).addClass("selected");
  });

  // Make row selected, when span is clicked
  $("table#treeTable tbody tr span").mousedown(function () {
    $($(this).parents("tr")[0]).trigger("mousedown");
  });
}

function setupjEditable()
{
  $('.editable').editable(submitEdit, {
         indicator : 'Saving...',
         tooltip   : 'Click to edit...'
     });
  $('.edit_area').editable(submitEdit, {
         type      : 'textarea',
         cancel    : 'Cancel',
         submit    : 'OK',
         indicator : '<img src="<?php echo WPNXM_IMAGES_DIR; ?>ajax-spinner.gif">',
         tooltip   : 'Click to edit..' //<img src="img/pencil.png">
     });
}

function submitEdit(value, settings)
{
  var edits = new Object();
  var origvalue = this.revert;
  var textbox = this;
  var result = value;

  // ok, we have the value, but not the "name of the directive".
  // therefore let's fetch the html value of the first td tag from the row,
  // which we are currently editing the value of (in the second td).
  var directive = $('td:first', $(this).parents('tr')).html();

  //console.log(edits);
  //alert("You changed the setting "+ directive +" to the value "+ value +".");

  // build array for sending data as json
  edits['directive'] = directive;
  edits['value'] = value;

  var returned = $.ajax({
      url: 'index.php?page=config&action=update-phpini-setting',
      type: "POST",
      data : edits,
      dataType : "json",
      complete: function (xhr, textStatus) {
          var response = xhr.responseText;
      }
  });

  return(result);
};

function loadTab(tabObj)
{
  if (!tabObj || !tabObj.length) {
    return;
  }

  // get the page from the href
  var href = tabObj.attr('href');   // href="index.php?page=config#php"
  var page = href.split('#')[1].toLowerCase(); // [index.php?page=config, php], return 1st element from array

  var href = 'index.php?page=config&action=showtab&tab=' + page;

  // target content for the incoming content
  var containerId = 'div#tab-content';  // selector for the target container

  // load content via ajax, load additional js for certain pages and "activate" it
  $(containerId).load(href, function () {
    if (page === 'php') {
      setupTreeTable();
      setupjEditable();
    }
    $(containerId).fadeIn('fast');
  });
}

function setupTabs()
{
  // define selectors
  var tabsNavigation = 'div#organic-tabs > ul.nav';
  var activeTab = tabsNavigation + ' li a.current';

  // load the first tab on page load (current active tab)
  if ($(activeTab).length > 0) {
    loadTab($(activeTab));
  }

  // intercept clicks on the tab items
  $(tabsNavigation + ' li a').click(function () {

      // do not reload content of current tab
      if ($(this).hasClass('current')) {
        return false;
      }
      // switch current to the new tab
      $(tabsNavigation + ' li a.current').removeClass('current');
      $(this).addClass('current');

      // show ajax loading indicator
      $('div#tab-content').html('<p style="text-align: center;"><img src="<?php echo WPNXM_IMAGES_DIR; ?>ajax-spinner.gif" width="64" height="64" /></p>');

      // load content
      loadTab($(this));

      return false;
  });
}

function handleRedirectToTab()
{
  var anchor = window.location.href.split('#')[1];
  if (anchor != '') {
        var tabToSelect = $('#organic-tabs').find('a[name="'+anchor+'"]');
        $(tabToSelect).trigger('click');
  }
}

$(function () {
  setupTabs();
  handleRedirectToTab();
});
</script>

<h2 class="heading">Configuration</h2>

<div class="left-box">
    <div class="cs-message">
        <div class="cs-message-content cs-message-content-config">

            <div id="organic-tabs">

                <ul class="nav headings-level-1">
                  <li><a name="help" href="/webinterface/index.php?page=config#help" class="current">Help</a></li>
                  <li><a name="php" href="/webinterface/index.php?page=config#php">PHP</a></li>
                  <li><a name="php-ext" href="/webinterface/index.php?page=config#php-ext">PHP Extensions</a></li>
                  <?php if (FEATURE_3 == true) { ?>
                  <li><a name="nginx" href="/webinterface/index.php?page=config#nginx">Nginx</a></li>
                  <li><a name="nginx-domains" href="/webinterface/index.php?page=config#nginx-domains">Nginx Domains</a></li>
                  <li><a name="mariadb" href="/webinterface/index.php?page=config#mariadb">MariaDB</a></li>
                  <?php } ?>
                  <?php if(FEATURE_3 == true && $mongodb_installed === true) { ?>
                      <li><a name="mongodb" href="/webinterface/index.php?page=config#mongodb">MongoDB</a></li>
                  <?php } ?>
                  <?php if($xdebug_installed === true) { ?>
                      <li><a name="xdebug" href="/webinterface/index.php?page=config#xdebug">XDebug</a></li>
                  <?php } ?>
                </ul>

                <div id="tab-content" style="overflow: hidden;"></div>

            </div>

          </div>
    </div>
</div>

</div>
