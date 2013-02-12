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
    * @copyright  Jens-André Koch (2010 - onwards)
    * @link       http://wpn-xm.org/
    */

namespace Webinterface\Helper;

class PHPInfo
{
    /**
     * Returns the (full) content of phpinfo().
     *
     * @return string Content of phpinfo()
     */
    public static function getPHPInfoContent()
    {
        # fetch the output of phpinfo into a buffer and assign it to a variable
        ob_start();
        phpinfo();
        $buffered_phpinfo = ob_get_contents();
        ob_end_clean();

        return $buffered_phpinfo;
    }

    /**
     * Returns only the body content of phpinfo().
     *
     * When settings $strip_tags true, the phpinfo body content is
     * further reduced for better and faster processing with preg_match().
     *
     * @param boolean Strips tags from content when true.
     * @return string phpinfo
     */
    public static function getPHPInfo($strip_tags = false)
    {
        $matches = '';
        $buffered_phpinfo = self::getPHPInfoContent();

        # only the body content
        preg_match_all("=<body[^>]*>(.*)</body>=siU", $buffered_phpinfo, $matches);
        $phpinfo = $matches[1][0];

        # enhance the readability of semicolon separated items
        $phpinfo = str_replace(";", "; ", $phpinfo);
        $phpinfo = str_replace('&quot;', '"', $phpinfo);

        if ($strip_tags === true) {
            $phpinfo = strip_tags($phpinfo);
            $phpinfo = str_replace('&nbsp;', ' ', $phpinfo);
            $phpinfo = str_replace('  ', ' ', $phpinfo);
        }

        # colorize keywords green/red
        $phpinfo = preg_replace('#>(yes|on|enabled|active)#i', '><span style="color:#090; font-weight: bold;">$1</span>', $phpinfo);
        $phpinfo = preg_replace('#>(no|off|disabled)#i', '><span style="color:#f00; font-weight: bold;">$1</span>', $phpinfo);

        # grab all php extensions for display in an additional table
        preg_match_all("^(?:module_)(.*)\"^", $buffered_phpinfo, $match_modules, PREG_SET_ORDER);

        // create 4 lists from the whole extensions result set
        $modlists = array();
        $i = 0;
        foreach ($match_modules as $mod) {
            $modlists[($i % 4)][] = $mod;
            $i++;
        }

        // create html table listing the extensions
        $html = '';
        $html .= '<div class="center"><h1>PHP Extensions</h1>';
        $html .= '<table style="width: 600px";>';

        foreach ($modlists as $modlist) {
            $html .= '<td valign="top"><ul>';
            foreach ($modlist as $mod) {
                $html .= '<li><a href="#module_' . $mod[1] . '">' . $mod[1] . '</a></li>';
            }
            $html .= '</ul></td>';
        }
        $html .= '</tr></table></div><br>';

        return $html . $phpinfo;
    }
}
