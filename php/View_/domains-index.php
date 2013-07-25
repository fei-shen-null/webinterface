<h2 class="heading">Local Nginx Domains</h2>

<div class="cs-message">
    <table class="cs-message-content" style="width: 100%;">
        <tr>
            <td class="resourceheader1 bold">Enable/Disable</td>
            <td class="resourceheader1 bold">Domain Name</td>
            <td class="resourceheader1 bold">FCQN</td>
            <td class="resourceheader1 bold">Webfolder</td>
        </tr>
        <?php
        var_dump($domains);
        $html = '';
        foreach ($domains as $domain) {
            $html .= '<tr>';
            #$html .= '<td>' . $domain['fcqn'] . '</td>';
            #$html .= '<td>' . $domain['x'] . '</td>';
            #$html .= '<td>' . $domain['x'] . '</td>';
            #$html .= '<td>' . $domain['x'] . '</td>';
            $html .= '</tr>';
        }
        echo $html;
        ?>
    </table>
</div>
