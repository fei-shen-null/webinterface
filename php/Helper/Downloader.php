<?php
namespace Webinterface\Helper;

class Downloader
{
    /**
     * Download a file as stream.
     * 
     * @param string $url
     */
    public static function download($url)
    {
        $file = fopen(WPNXM_DATA_DIR . basename($url), 'r');

        set_time_limit(0); // unlimited max execution time

        $options = array(
            CURLOPT_URL     => $url,
            CURLOPT_FILE    => $file,
            CURLOPT_TIMEOUT => 3600 * 2, // set 2h to not timeout on big files
            CURLOPT_HEADER  => 0,
            CURLOPT_NOPROGRESS => false,
            CURLOPT_PROGRESSFUNCTION => 'curl_progress_callback',
            //CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_BUFFERSIZE => 4096
        );

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        curl_exec($ch);
        curl_close($ch);

        fclose($file);
    }
}
