<form id="reset-password-form" style="width:400px;" action="/webinterface/index.php?page=resetpw&action=update" method="POST">
    <fieldset>
        <legend>Change Database Password</legend>
        <h4>Please enter the new database password (user root):</h4>
        <input type="text" name="newPassword">
        <br><br>
        <a class="btn btn-default btn-sm" rel="modal:close">Cancel</a>
        <a class="btn btn-default btn-sm" id="btn-change-password" rel="ajax:modal">Change Password</a>
        <div id="reset-pw-result"></div>
    </fieldset>
</form>

<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
         $('a[rel="ajax:modal"]').click(function (event) {
            //xy.showSpinner();
          $.ajax({
            url: $(this).closest('form').attr('action'),
            method: $(this).closest('form').attr('method'),
            data: "newPassword=" + $(this).closest('form').find('input[name="newPassword"]').val(),
            dataType: 'html',
            success: function (newHTML, textStatus, jqXHR) {
              //xy.hideSpinner();
              $(newHTML).appendTo('div#reset-pw-result'); //.modal();
            }
            // ajax error
          });

          return false;
        });
    });
</script>
