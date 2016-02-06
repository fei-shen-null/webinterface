window.onload = function() {
    enableLoadingIndicatorPaceJs();
    setCurrentPageActiveInMainMenu();
    enableTooltips();
    onModalHideResetRemoteUrl();
    lazyBindModalSubmitActionToFormUrl();
}

/**
 * Allow Modal Content to be fetched from the new remote URL:
 * by destroying the old modal and removing its remote URL.
 */
function onModalHideResetRemoteUrl() {
    $('body').on('hidden.bs.modal', '.modal', function () {
      $(this).removeData('bs.modal');
    });
}

/**
 * Highlights the current page in the headline main menu
 */
function setCurrentPageActiveInMainMenu() {
    var location = window.location.href.toString().split(window.location.host)[1];
    $(".main_menu li a").removeClass("active");
    $(".main_menu li a[href='" + location  + "']").addClass("active");
    // special cases
    if(location.indexOf("update") >= 0) {
       $("a.dropdown-toggle:contains('Tools')").addClass("active");
    }
}

/**
 * Enable Twitter Bootstrap Tooltips
 * Usage:
 * <a href="#" rel="tooltip" title="tooltip text!">
 */
function enableTooltips() {
    $('[rel=tooltip]').tooltip();
}

function enableLoadingIndicatorPaceJs() {
    $(document).ajaxStart(function() { Pace.restart(); });
}

function ajaxGET(url, success) {
    $.ajax({
        url: url,
        method: "GET",
        success: success
    });
}

function lazyBindModalSubmitActionToFormUrl() {

  $('#myModal').on("click", 'input[type="submit"], button[type="submit"]', function (event) {

      var form = $("#myModal .modal-body form");

      $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serializeArray(),
        cache: false
      })
      .done(function(data, textStatus, jqXHR) {
        $('#myModal .modal-body').html(data);
      })
      .fail(function() {
        $('#myModal .modal-body').html("error");
      });

      // cancel the default action (submit)
      event.preventDefault();
  });
}
