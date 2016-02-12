 <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Change Database Password for <?php echo $component; ?></h4>
</div>
<div class="modal-body">
    <form id="reset-password-form"
          action="/tools/webinterface/index.php?page=resetpw&action=update" method="POST">
        <fieldset>
            <input type="hidden" name="component" value="<?php echo strtolower($component);?>">
            <!-- Text input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="password">New Password</label>
              <div class="col-md-6">
              <input id="password" name="password" placeholder="pw" class="form-control input-md" type="text">
              <span class="help-block">Set new password for user "root"</span>
              </div>
            </div>
        </fieldset>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Change Password</button>
</div>