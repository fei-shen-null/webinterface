 <div class="modal-header">               
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">Change Database Password for <?php echo $component; ?></h4>
</div>
<div class="modal-body">    
    <form id="reset-password-form"
          action="/webinterface/index.php?page=resetpw&action=update" method="POST">
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
    <button type="submit" class="btn btn-primary">Ok</button>
</div>

<script type="text/javascript" charset="utf-8">
$(document).ready(function() {
   // $("#myModal .modal-title").html('TEST');
   
   // rename submit button
   $('#myModal button[type="submit"]').html('Change Password');
   
   // bind submit action
   $('#myModal button[type="submit"]').bind('click', function(event) {     
       var form = $("#myModal .modal-body form");
       
       $.ajax({
         type: form.attr('method'),
         url: form.attr('action'),
         data: form.serializeArray(),
         
         cache: false,
         success: function(response, status) {
           $('#myModal .modal-body').html(response);
         }
       });
       
       event.preventDefault();
  });
});
</script>
