<h2 class="heading">Updater</h2>

<div class="left-box">
    <div class="cs-message">
        <div class="cs-message-content cs-message-content-config">
<?php
echo '<table class="table table-condensed table-hover">
<thead>
    <tr>
        <th>Component</th><th>Your Version</th><th>Latest Version</th>
    </tr>
    <tr>
        <td>Windows</td>
        <td><span style="font-size:14px">'.$windows_version.'('.$bitsize.')</span></td>
        <td><span style="font-size:14px">Windows 8.1</span></td>
    </tr>
</thead>
';

foreach ($components as $idx => $componentName)
{
    if ($componentName === 'PEAR') {
        continue;
    }
   
    $class     = '\WPNXM\Webinterface\Software\\'.$componentName;
    $component = new $class;

    $versionString = $component->getVersion();
    $version       = strlen($versionString) > 10 ? '0.0.0' : $versionString;

    $html = '<tr>
        <td>'.$component->name.'</td>
        <td><span style="font-size:14px">'.$versionString.'</span></td>
        <td>'.printUpdatedSign($component->getRegistryName(), $version, $registry[$component->registryName]['latest']['version']).'</td>
    </tr>';

    $html = str_replace('float:right', 'float:left', $html);
    echo $html;

    unset($component);
}
echo '</table></div></div></div>';

/**
 * The function prints an update symbol if old_version is lower than new_version.
 *
 * @param string Old version.
 * @param string New version.
 */
function printUpdatedSign($component, $old_version, $new_version)
{
    $url = sprintf(
        WPNXM_WEBINTERFACE_ROOT.'index.php?page=update&action=download&component=%s&version=%s',
        $component,
        $new_version
    );

    if (version_compare($old_version, $new_version) === -1) {
        $html = '<a href="'.$url.'"';
        $html .= ' class="download btn btn-success btn-xs" style="font-size: 14px">';
        $html .= '<i class="download icon"></i>';
        $html .= '&nbsp; '.$new_version.'</a>';

        return $html;
    }

    return '<span style="font-size:14px">'.$old_version.'</span>';
}
?>

<script>
function updateProgress(json)
{
    var progressBar = $('progress');
    progressBar.attr('value', json.progress.loaded);
    progressBar.attr('max', json.progress.total);
}

function download(link)
{
    var xhr = new XMLHttpRequest();
    xhr.open('GET', link);
    xhr.send(null);

    // 1 second interval for continous xhr response handling
    var timer;
    timer = window.setInterval(function () {
        // finished?
        if (xhr.readyState === XMLHttpRequest.DONE) {
            window.clearTimeout(timer);
            $('progress').replaceWith('<b>Done!</b>');
        }
        // append callback data to the body for evaluation (updates the progress bar)
        $('body').append(' ' + xhr.responseText + ' ');
    }, 1000);
};

// intercept clicks on the "Download Component" links
$("a.download" ).on('click', function (e) {
    e.preventDefault();
    // add download progress bar
    $(this).after('<progress id="progress" value="0" max="0">0%</progress>');
    // trigger AJAX download with curl callback to update the progessbar
    download(this.href);
    return false;
});
</script>
