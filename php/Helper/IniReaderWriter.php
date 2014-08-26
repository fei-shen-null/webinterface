<?php
/**
 * WPИ-XM Server Stack
 * Copyright © 2010 - 2014 Jens-André Koch <jakoch@web.de>
 * http://wpn-xm.org/
 *
 * This source file is subject to the terms of the MIT license.
 * For full copyright and license information, view the bundled LICENSE file.
 */

namespace Webinterface\Helper;

/**
 * WPN-XM Server Stack - INI Reader and Writer.
 */
class IniReaderWriter
{
    /* @var array File content, line by line. */
    protected $lines;

    /* @var string The INI filename. */
    protected $file;

    public function __construct($file = '')
    {
        if ($file !== '' and is_file($file) === false) {
            throw new \Exception(sprintf('File not found: "%s".', $file));
        }

        $this->file = $file;
        $this->read();
    }

    public function read()
    {
        $this->lines = array();

        $section = '';

        $content = file($this->file);

        foreach ($content as $line) {
            // comment or whitespace
            if (preg_match('/^\s*(;.*)?$/', $line)) {
                $this->lines[] = array('type' => 'comment', 'data' => $line);
            // section
            } elseif (preg_match('/\[(.*)\]/', $line, $match)) {
                $section = $match[1];
                $this->lines[] = array('type' => 'section', 'data' => $line, 'section' => $section);
            // entry
            } elseif (preg_match('/^\s*(.*?)\s*=\s*(.*?)\s*$/', $line, $match)) {
                $this->lines[] = array('type' => 'entry', 'data' => $line, 'section' => $section, 'key' => $match[1], 'value' => $match[2]);
            }
        }

        return $this;
    }

    /**
     * @param string $section
     * @param string $key
     */
    public function get($section, $key)
    {
        foreach ($this->lines as $line) {
            if($line['type'] != 'entry') continue;
            //if($line['section'] != $section) continue;
            if($line['key'] != $key) continue;

            return $line['value'];
        }

        //throw new Exception('Missing Section or Key');
    }

    /**
     * @param string $section
     */
    public function set($section, $key, $value)
    {
        foreach ($this->lines as &$line) {
            if($line['type'] != 'entry') continue;
            //if($line['section'] != $section) continue;
            if($line['key'] != $key) continue;
            $line['value'] = $value;
            $line['data'] = $key . " = " . $value . "\r\n";

            return;
        }

        throw new Exception('Missing Section or Key');
    }

    public function write($file = '')
    {
        if ($file == '') {
            $file = $this->file;
        }

        $fp = fopen($file, 'w');

        foreach ($this->lines as $line) {
            fwrite($fp, $line['data']);
        }

        fclose($fp);
    }

    public function returnArray()
    {
        return $this->lines;
    }
}
