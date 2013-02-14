/* Browser Update Notifier - async (http://browser-update.org/update.js) */

var $bu = {};
$bu.ol = window.onload;
window.onload = function() {
    try {
        if ($bu.ol) $bu.ol();
    }catch (e) {}
    var e = document.createElement("script");
    e.setAttribute("type", "text/javascript");
    e.setAttribute("src", "http://localhost/webinterface/assets/js/browser-update.js");
    document.body.appendChild(e);

    setCurrentPageActiveInMainMenu();
    enableTooltips();
}

/* override native alert() function with a call to jquery.modal */
window.alert = function () {
  var msg = arguments[0];
  jQuery('<div class="modal"></div>')
  .html('<p class="error">' + msg.replace(/\n/g, "<br />") + '</p>')
  .appendTo('body')
    .modal({
      escapeClose: true,
      clickClose: false,
      showClose: true
    });
};

/* highlight current page in headline main menu */

function setCurrentPageActiveInMainMenu() {
    var aObj = document.getElementsByClassName('main_menu')[0].getElementsByTagName('a');
    for(var i = 0; i < aObj.length; i++) {
        if(document.location.href.indexOf(aObj[i].href)>=0) {
            aObj[i].className='active';
        }
    }
}

/* Enable Twitter Bootstrap Tooltips */
/* Usage: <a href="#" rel="tooltip" title="tooltip text!">*/

function enableTooltips() {
    $('[rel=tooltip]').tooltip();
}
