<?php 
/*
 * This gets displayed inside a Bootstrap3 modal window.
 * The content is inserted into "modal-dialog > modal-content".
 * So, the only div elements needed are header, body and footer.
 */
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Edit Project "<?php echo $project; ?>"</h4>
</div>
<div class="modal-body">
    Yo, dawg!
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Save changes</button>
</div>