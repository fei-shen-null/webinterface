<!-- Browser Update Notifier - async -->
var $buoop = {};
$buoop.ol = window.onload;
window.onload=function()
{
    try {if ($buoop.ol) $buoop.ol();}catch (e) {}
    var e = document.createElement("script");
    e.setAttribute("type", "text/javascript");
    <!--e.setAttribute("src", "http://browser-update.org/update.js");-->
    e.setAttribute("src", "http://localhost/webinterface/assets/js/browser-update.js");
    document.body.appendChild(e);

    setCurrentPageActiveInMainMenu();
}

 <!-- highlight current page in headline main menu -->
function setCurrentPageActiveInMainMenu() {
  aObj = document.getElementsByClassName('main_menu')[0].getElementsByTagName('a');
  for(i=0;i<aObj.length;i++) {
    if(document.location.href.indexOf(aObj[i].href)>=0) {
      aObj[i].className='active';
    }
  }
}
