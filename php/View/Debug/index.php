<h2 class="heading">Debug</h2>

<div class="centered">

        <div class="cs-message">

            <table class="cs-message-content" style="width: 100%;">
                <tr>
                    <td colspan="2"><div class="resourceheader2 bold">Constants</div></td>
                </tr>
                <tr>
                    <td class="resourceheader1 bold">Name</td>
                    <td class="resourceheader1 bold">Values</td>
                </tr>
                <?php
                foreach ($constants as $name => $value) {
                    echo '<tr><td>' . $name . '</td>';
                    echo '<td>';
                    if ($value === false or $value === 0) {
                        echo 'false';
                    } elseif ($value === true or $value === 1) {
                        echo 'true';
                    } else {
                        echo $value;
                    }
                    echo '</td></tr>';
                }
                ?>
            </table>
