<!-- start "footer.php" -->
    </div><!-- ./col-md-12.content-centered -->

    <div class="footer wpnxm-footer">
        <hr class="footer-line"/>
        <div class="footer-links">
            <p class="floatleft">
                <a target="_blank" href="http://wpn-xm.org/">Home</a> |
                <a target="_blank" href="https://github.com/WPN-XM/WPN-XM/">Github</a> |
                <a target="_blank" href="https://github.com/WPN-XM/WPN-XM/issues/new">Report Issue</a> |
                <a target="_blank" href="http://wpn-xm.org/#donate">Donate</a>
            </p>
            <p class="floatright"><a href="#">Back to top &#9650;</a></p>
        </div>

        <div class="clear">
             WPИ-XM Server Stack for Windows - Version <?php echo WPNXM_VERSION; ?>
            <p>&#169; 2010-<?php echo date("Y"); ?> by <a href="http://jakoch.de/">Jens-Andr&#x00E9; Koch</a> Softwaresystemtechnik.
                <br />
                Page generated in <?=round((microtime(true) - TIME_STARTED), 3);?>s.
            </p>
        </div>
    </div>

<!-- Modal -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
            Modal body
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Ok</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body>
</html>
