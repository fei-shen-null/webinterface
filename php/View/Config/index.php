<h2 class="heading">Configuration</h2>

<div class="col-md-10 content-centered">

    <!-- Configuration Panel -->
    <div class="panel panel-default text-left" id="configuration-panel">
        <div class="panel-heading panel-heading-gray">
          <h4>Configuration</h4>
        </div>
        <div class="panel-body panel-body-gray" id="tab-content" style="overflow: hidden;">

            <!-- tabs left -->
            <div class="tabs-left">
                <ul class="nav nav-tabs" id="configuration-tabs" data-tabs="tabs">
                  <li class="active"><a name="help" href="/webinterface/index.php?page=config#help">Help</a></li>
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
            </div>

            <!-- The tab content is fetched via Ajax and inserted into the tab-pane. -->
            <div class="tab-content">
              <div class="tab-pane active" id="the-tab-pane">bla</div>
            </div>
        </div>
    </div>

</div> <!-- ./col-md-10 -->

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

function loadTabContent(tabObject)
{
  if (!tabObject || !tabObject.length) {
    return;
  }

  // get the requested tab from the attribute "name" of the link
  var tab = tabObject.attr('name');

  // target action for loading the tab content via AJAX is "showtab"
  var href = 'index.php?page=config&action=showtab&tab=' + tab;

  // target element for the incoming content
  var containerId = 'div#the-tab-pane';  // selector for the target container

  // load content via ajax, load additional js for certain pages and "activate" it
  $(containerId).load(href, function () {
    if (tab === 'php') {
      setupTreeTable();
      setupjEditable();
    }
    $(containerId).fadeIn('slow');

    // Set URL to remember TAB on page refresh.
    // The original AJAX content URL is "index.php?page=config&action=showtab&tab=PAGE",
    // but we need to get the full content (config page) and request the TAB content (ajax).
    // That URL is "index.php?page=config#tab"
    window.history.pushState("", "", 'index.php?page=config#' + tab);
  });
}

function setupTabs()
{
  var configTabs = '#configuration-tabs';
  var activeTab  = $(configTabs + ' li.active a');

  // load the first tab on page load (current active tab)
  /*if (activeTab.length > 0) {
    loadTabContent(activeTab);
  }*/

  // intercept clicks on the tab items
  $(configTabs + ' li a').click(function () {

      var tab = $(this);
      var parent_li = tab.parent('li');

      // do not reload content of currently active tab
      if (parent_li.hasClass('active')) {
        return false;
      }

      // set the new tab "active"
      $(configTabs + ' li.active').removeClass('active');
      parent_li.addClass('active');

      // show ajax loading indicator
      $('div#the-tab-pane').html('<p style="text-align: center;"><img src="<?php echo WPNXM_IMAGES_DIR; ?>ajax-spinner.gif" width="64" height="64" /></p>');

      loadTabContent(tab);

      return false;
  });
}

function handleRedirectToTab()
{
  var anchor = window.location.href.split('#')[1];
  if (anchor !== '') {
    var tabToSelect = $('#configuration-tabs').find('a[name="'+anchor+'"]');
    $(tabToSelect).trigger('click');
  }
}

$(function () {
  setupTabs();
  handleRedirectToTab();
});
</script>
