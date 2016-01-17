<h2 class="heading">Server Environment</h2>

<div class="panel panel-info search">
    <div class="panel-heading left"><h4>Search in phpinfo()</h4></div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" id="search">

            <!-- Input-Button-Button -->
            <div class="form-group">
              <div class="col-md-10">
                <div class="input-group">
                  <input type="text" class="form-control col-md-5" id="textToHighlight" value="xdebug">
                  <div class="input-group-btn">
                    <button class="btn btn-info" type="button" id="highlightButton">
                        <span class="glyphicon glyphicon-search"></span> Search</button>
                    <button class="btn btn-default" type="button" id="resetButton">Reset</button>
                  </div>
                </div>
              </div>
            </div>

        </form>
        <!-- Search Results -->
        <div class="form-group" id="search-terms-navbar" style="visibility: hidden;">
            <div class="col-sm-10">
                <p>Search Term found! <span id="hits-counter"></span> Hits.</p>
                <button class="btn btn-default btn-md" type="button" id="nextButton"><i class="icon-arrow-down"></i> Next</button>
                <button class="btn btn-default btn-md" type="button" id="prevButton"><i class="icon-arrow-up"></i> Prev</button>
            </div>
        </div>
    </div>
</div>

<div id="phpinfo" class="phpinfo center">
    <div class="panel panel-info content-centered" style="width: 600px">
        <div class="panel-heading"><h4>PHP Extensions</h4></div>
        <div class="panel panel-body noshadow">
            <p style="font-size: 12px">Click on an extension, to jump to its phpinfo section.</p>
            <?php echo $php_info; ?>
        </div>
    </div>
</div>

<script type="text/javascript">
<!--
(function () {
    // initial scroll to position is the first element
    var currentScrollIndex = 0;
    var scrollToElement = function () {
        var elems = document.querySelectorAll('.highlight');
        // number of elements found (search hits)
        var n = elems.length;
        if (n > 0) {
            // additional feature: hit-counter for highlighted search terms
            document.getElementById('hits-counter').innerHTML = elems.length;
            document.getElementById('search-terms-navbar').style.visibility = "visible";
        } else {
            document.getElementById('search-terms-navbar').style.visibility = "hidden";
        }
        // scroll to element position
        var el = elems[currentScrollIndex];
        el.scrollIntoView(true);
    }
    var resetHighlight = function () {
        var elems = document.querySelectorAll('.highlight');
        var n = elems.length;
        while (n--) {
            var e = elems[n];
            e.parentNode.replaceChild(e.childNodes[0], e);
            }
        // reset scroll position to first element
        currentScrollIndex = 0;
        // hide the search terms navbar (prev/next button)
        document.getElementById('search-terms-navbar').style.visibility = "hidden";
    };
    // search button
    var e = document.querySelector('#highlightButton');
    if (!e) {return;}
    e.onclick = function () {
        resetHighlight();
        var e = document.querySelector('#textToHighlight');
        if (!e) {return;}
        var searchFor = new RegExp(e.value.replace(/\s+/g,'\\s+'), 'gi');
        doHighlight('phpinfo', 'highlight', searchFor);
        scrollToElement();
    };
    // next button
    var e = document.querySelector('#nextButton');
    if (!e) {return;}
    e.onclick = function () {
        currentScrollIndex++;
        scrollToElement();
    };
    // prev button
    var e = document.querySelector('#prevButton');
    if (!e) {return;}
    e.onclick = function () {
        currentScrollIndex--;
        scrollToElement();
    };
    // reset button
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
function doHighlight(A,c,z,s) {var G=document;if (typeof A==="string") {A=G.getElementById(A)}if (typeof z==="string") {z=new RegExp(z,"ig")}s=s||0;var j=[],u=[],B=0,o=A.childNodes.length,v,w=0,l=[],k,d,h;for (;;) {while (B<o) {k=A.childNodes[B++];if (k.nodeType===3) {j.push({i:w,n:k});v=k.nodeValue;u.push(v);w+=v.length} else {if (k.nodeType===1) {if(k.tagName.search(/^(script|style)$/i)>=0){continue}if(k.tagName.search(/^(a|b|basefont|bdo|big|em|font|i|s|small|span|strike|strong|su[bp]|tt|u)$/i)<0){u.push(" ");w++}d=k.childNodes.length;if (d) {l.push({n:A,l:o,i:B});A=k;o=d;B=0}}}}if (!l.length) {break}h=l.pop();A=h.n;o=h.l;B=h.i}if (!j.length) {return}u=u.join("");j.push({i:u.length});var p,r,E,y,D,g,F,f,b,m,e,a,t,q,C,n,x;for (;;) {r=z.exec(u);if (!r||r.length<=s||!r[s].length) {break}E=r.index;for (p=1;p<s;p++) {E+=r[p].length}y=E+r[s].length;g=0;F=j.length;while (g<F) {D=g+F>>1;if (E<j[D].i) {F=D} else {if (E>=j[D+1].i) {g=D+1} else {g=F=D}}}f=g;while (f<j.length) {b=j[f];A=b.n;v=A.nodeValue;m=A.parentNode;e=A.nextSibling;t=E-b.i;q=Math.min(y,j[f+1].i)-b.i;C=null;if (t>0) {C=v.substring(0,t)}n=v.substring(t,q);x=null;if (q<v.length) {x=v.substr(q)}if (C) {A.nodeValue=C} else {m.removeChild(A)}a=G.createElement("span");a.appendChild(G.createTextNode(n));a.className=c;a.id=c;m.insertBefore(a,e);if (x) {a=G.createTextNode(x);m.insertBefore(a,e);j[f]={n:a,i:y}}f++;if (y<=j[f].i) {break}}}}
// -->
</script>
