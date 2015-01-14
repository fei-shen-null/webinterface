<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - onwards, Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
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
        preg_match_all("#<body[^>]*>(.*)</body>#siU", $buffered_phpinfo, $matches);
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
        $match_modules = array();
        preg_match_all("^(?:module_)(.*)\"^", $buffered_phpinfo, $match_modules, PREG_SET_ORDER);

        // create 4 lists from the whole extensions result set
        $modlists = array();
        $i = 0;
        foreach ($match_modules as $mod) {
            $modlists[($i % 4)][] = $mod;
            $i++;
        }

        // render "list of extensions" with jump to section
        $html = '';

        foreach ($modlists as $modlist) {
            $html .= '<div class="col-md-3"><ul class="list-group">';
            foreach ($modlist as $mod) {
                $html .= '<li class="list-group-item margin-2">';
                $html .= '<a href="#module_' . $mod[1] . '">' . $mod[1] . '</a></li>';
            }
            $html .= '</ul></div>';
        }

        return $html . $phpinfo;
    }
}
