<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - 2014 Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

namespace Webinterface\Components;

/**
 * WPN-XM Webinterface - Class for PostgreSQL
 */
class PostgreSQL extends AbstractComponent
{
    public $name = 'PostgreSQL';

    public $registryName = 'postgresql';

    /**
     * Init:    initdb.exe <datafolderpath>
     * Start:   pg_ctl.exe -D "<datafolderpath>" -l logfile start
     */

    public $installationFolder = '\bin\postgresql';

    public $files = array(
        // Note: the folder was renamed from "pgsql" (name in the original zip) to "postgresql"
        '\bin\postgresql\bin\initdb.exe',
        '\bin\postgresql\bin\postgresql.conf',
        '\bin\postgresql\bin\pg_ctl.exe' // http://www.postgresql.org/docs/9.3/static/app-pg-ctl.html
    );

    public $configFile = '\bin\postgresql\bin\postgresql.conf';

    /**
     * Returns Version.
     *
     * @return string Version
     */
    public function getVersion()
    {
        if($this->isInstalled(true) === false) {
            return 'not installed';
        }

        $command = 'start \bin\postgresql\bin\pgsql.exe -V';
        exec($command, $output);

        $output = str_replace('pgsql (PostgreSQL)', '', $output);

        return $output;
    }
}
