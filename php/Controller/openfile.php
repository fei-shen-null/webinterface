<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - 2014 Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

function index()
{
    /**
     * You need to append the parameter "file" to the URL, e.g. "openfile.php?file=nginx-access-log".
      * Other values include: "nginx-error-log", "php-error-log". See the switch for more.
     */
    $file = isset($_GET['file']) ? $_GET['file'] : null;

    switch ($file) {
        case 'nginx-access-log':
            Webinterface\Helper\OpenFile::openFile(WPNXM_DIR . '\logs\access.log');
            break;
        case 'nginx-error-log':
            Webinterface\Helper\OpenFile::openFile(WPNXM_DIR . '\logs\error.log');
            break;
        case 'php-error-log':
            Webinterface\Helper\OpenFile::openFile(WPNXM_DIR . '\logs\php_error.log');
            break;
        case 'mariadb-error-log':
            Webinterface\Helper\OpenFile::openFile(WPNXM_DIR . '\logs\mariadb_error.log');
            break;
        case 'mariadb-log':
            Webinterface\Helper\OpenFile::openFile(WPNXM_DIR . '\logs\mariadb.log');
            break;
        case 'mongodb-log':
            Webinterface\Helper\OpenFile::openFile(WPNXM_DIR . '\logs\mongodb.log');
            break;
        case 'postgresql-log':
            Webinterface\Helper\OpenFile::openFile(WPNXM_DIR . '\logs\pgsql.log');
        default:
            throw new InvalidArgumentException(
                sprintf('The method %s() has no case statement for "%s".', __METHOD__ , $file)
            );
            break;
    }

    header('Location: ' . WPNXM_WEBINTERFACE_ROOT . 'index.php?page=overview');
}
