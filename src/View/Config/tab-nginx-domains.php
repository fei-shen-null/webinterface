<h2>Nginx Domains</h2>

<div class="floatleft">

    <fieldset style="width: 350px;">

    <legend><h3>Domains</h3></legend>

    <div class="info">
       You might select the domains to load.
       Enable or disable domains in "domain.conf", simply by toggling the checkbox.
       Remember to restart Nginx for changes to take effect
    </div>

    <form action="/webinterface/index.php?page=config&action=update_nginx_domains" method="post" class="well form-inline">
        <table>
            <?php
            if (!empty($domains)) {
                foreach ($domains as $domain) { /* array: fqpn, filename, loaded */

                    $checked = (isset($domain['enabled']) && $domain['enabled'] === true) ? 'checked="checked"' : '';

                    echo '<tr><td><input type="checkbox" '.$checked.'></td><td>'.$domain['filename'].'</td>
                          <td><a href="/webinterface/index.php?page=openfile&file='.$domain['filename'].'"Open in Editor</a></td></tr>';
                }
            } else {
                echo '<tr><td>No domains configuration files found.</td></tr>';
            } ?>
        </table>
        <div class="form-actions">
            <button type="submit" class="btn btn-default btn-sm"><i class="icon-ok"></i>&nbsp;&nbsp;&nbsp;Submit</button>
            <button type="reset" class="btn btn-default btn-sm"><i class="icon-remove"></i>&nbsp;&nbsp;&nbsp;Reset</button>
        </div>
    </form>

    </fieldset>

</div>

<div class="floatright">

    <fieldset style="width: 350px;">

    <legend><h3>Add or Edit Domain</h3></legend>

    <p class="info">
    Please select the location (realpath) for the domain, then add the Servername.
    You might also provide aliases for the servername. Do not forget to select the checkbox
    for adding the new domain domain to your "hosts" file for local name resolution.
    </p>

    <form class="well">

        <script>
        // servername suggestion based on path
        // transfer the 'selected realpath' to the input box 'servername'
        $('#folder').click(function () {
            var selectedText = $("#folder option:selected").text().toLowerCase();
            selectedText = 'www.' + selectedText + '.dev';
            $("input[id='servername']").val(selectedText);
        });

        // add alias input field
        $('#add-alias').click(function () {
            var addAliasRow = '<tr><td><input type="text" values="aliases[]"></td><td><a id="remove-alias"><i class="icon-minus"></i>Remove Alias</a></td></tr>';
            $("table[id='aliases']").append(addAliasRow);
            $("table[id='aliases'] tr:last-child input").focus();
        });

        // remove alias input field
        $("table[id='aliases']").on("click", "a", function (event) {
            $(this).closest("tr").remove();
        });
        </script>

        <ul id="form">
          <li>
            <label for="folder"><b>Location (Realpath)</b></label>
            <span class="block-help">Path of the project folder you want to create the domain for.</br>
                <small><?php echo WPNXM_WWW_ROOT; ?></small>
            </span>
            <select id="folder">
                <?php
                foreach ($project_folders as $folder) { ?>
                <option value="/<?php echo $folder; ?>"><?php echo $folder; ?></option>
                <?php } ?>
            </select>

            <label for="servername"><b>Servername</b></label>
            <span class="block-help">Enter the servername:</span>
            <input type="text" id="servername">

            <label for="addToHostsFile"><b>Add to "hosts"</b></label>
            <input id="addToHostsFile" type="checkbox">
            <span class=""block-help">Add domain to the hosts file for local name resolution?</span>

            <br><br>

            <!--<label>(Port)</label>-->

            <!--<label>(Dynamic DNS)</label>-->

            <label for="aliases"><b>Aliases</b><a id="add-alias"><i class="icon-plus"></i>Add Alias</a></label>
            <table id="aliases">
                <tr>
                    <td>Alias 1</td><td><a id="remove-alias"><i class="icon-minus"></i>Remove Alias</a></td>
                </tr>
            </table>

          </li>
        </ul>

        <div class="form-actions">
            <button type="submit" class="btn btn-default btn-sm"><i class="icon-ok"></i>&nbsp;&nbsp;&nbsp;Submit</button>
            <button type="reset" class="btn btn-default btn-sm"><i class="icon-remove"></i>&nbsp;&nbsp;&nbsp;Reset</button>
        </div>

    </form>

    </fieldset>

</div>
