<?php
   /**
    * WPИ-XM Server Stack - Webinterface
    * Jens-André Koch © 2010 - onwards
    * http://wpn-xm.org/
    *
    *        _\|/_
    *        (o o)
    +-----oOO-{_}-OOo------------------------------------------------------------------+
    |                                                                                  |
    |    LICENSE                                                                       |
    |                                                                                  |
    |    WPИ-XM Serverstack is free software; you can redistribute it and/or modify    |
    |    it under the terms of the GNU General Public License as published by          |
    |    the Free Software Foundation; either version 2 of the License, or             |
    |    (at your option) any later version.                                           |
    |                                                                                  |
    |    WPИ-XM Serverstack is distributed in the hope that it will be useful,         |
    |    but WITHOUT ANY WARRANTY; without even the implied warranty of                |
    |    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                 |
    |    GNU General Public License for more details.                                  |
    |                                                                                  |
    |    You should have received a copy of the GNU General Public License             |
    |    along with this program; if not, write to the Free Software                   |
    |    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA    |
    |                                                                                  |
    +----------------------------------------------------------------------------------+
    *
    * @license    GNU/GPL v2 or (at your option) any later version..
    * @author     Jens-André Koch <jakoch@web.de>
    * @copyright  Jens-André Koch (2010 - 2012)
    * @link       http://wpn-xm.org/
    */
?>

<h2 class="heading">Server Environment</h2>

    <div class="cs-message-content search">
        <div id="search">
            <label><h4>Search in phpinfo()</h4></label>
            <input id="textToHighlight" type="text" value="xdebug">
            <button id="highlightButton">Search</button>
            <button id="resetButton">Reset</button>
        </div>
    </div>

    <div id="phpinfo">
        <br/>
        <?=$php_info;?>
    </div>

<script type="text/javascript">
<!--
(function(){
    var resetHighlight = function(){
    var elems = document.querySelectorAll('.highlight');
    var n = elems.length;
    while (n--) {
        var e = elems[n];
        e.parentNode.replaceChild(e.childNodes[0], e);
        }
    };
    var e = document.querySelector('#highlightButton');
    if (!e) {return;}
    e.onclick = function(){
    resetHighlight();
    var e = document.querySelector('#textToHighlight');
    if (!e) {return;}
    var searchFor = new RegExp(e.value.replace(/\s+/g,'\\s+'), 'gi');
    doHighlight('phpinfo', 'highlight', searchFor);
    document.getElementById('highlight').scrollIntoView(true);
    };
    e = document.querySelector('#resetButton');
    if (!e) {return;}
    e.onclick = resetHighlight;
})();

// Author: Raymond Hill
// Version: 2011-01-17
// Title: HTML text hilighter
// Permalink: http://www.raymondhill.net/blog/?p=272
// Purpose: Hilight portions of text inside a specified element, according to a search expression.
// Key feature: Can safely hilight text across HTML tags.
// Notes: Minified using YUI Compressor (http://refresh-sf.com/yui/),
function doHighlight(A,c,z,s){var G=document;if (typeof A==="string") {A=G.getElementById(A)}if (typeof z==="string") {z=new RegExp(z,"ig")}s=s||0;var j=[],u=[],B=0,o=A.childNodes.length,v,w=0,l=[],k,d,h;for (;;) {while (B<o) {k=A.childNodes[B++];if (k.nodeType===3) {j.push({i:w,n:k});v=k.nodeValue;u.push(v);w+=v.length} else {if (k.nodeType===1) {if(k.tagName.search(/^(script|style)$/i)>=0){continue}if(k.tagName.search(/^(a|b|basefont|bdo|big|em|font|i|s|small|span|strike|strong|su[bp]|tt|u)$/i)<0){u.push(" ");w++}d=k.childNodes.length;if (d) {l.push({n:A,l:o,i:B});A=k;o=d;B=0}}}}if (!l.length) {break}h=l.pop();A=h.n;o=h.l;B=h.i}if (!j.length) {return}u=u.join("");j.push({i:u.length});var p,r,E,y,D,g,F,f,b,m,e,a,t,q,C,n,x;for (;;) {r=z.exec(u);if (!r||r.length<=s||!r[s].length) {break}E=r.index;for (p=1;p<s;p++) {E+=r[p].length}y=E+r[s].length;g=0;F=j.length;while (g<F) {D=g+F>>1;if (E<j[D].i) {F=D} else {if (E>=j[D+1].i) {g=D+1} else {g=F=D}}}f=g;while (f<j.length) {b=j[f];A=b.n;v=A.nodeValue;m=A.parentNode;e=A.nextSibling;t=E-b.i;q=Math.min(y,j[f+1].i)-b.i;C=null;if (t>0) {C=v.substring(0,t)}n=v.substring(t,q);x=null;if (q<v.length) {x=v.substr(q)}if (C) {A.nodeValue=C} else {m.removeChild(A)}a=G.createElement("span");a.appendChild(G.createTextNode(n));a.className=c;a.id=c;m.insertBefore(a,e);if (x) {a=G.createTextNode(x);m.insertBefore(a,e);j[f]={n:a,i:y}}f++;if (y<=j[f].i) {break}}}}
// -->
</script>
