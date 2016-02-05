<h2 class="heading">Projects and Tools</h2>

<div class="col-md-10 content-centered">

    <div class="col-md-6" id="left-box">

        <!-- Projects Panel -->
        <div class="panel panel-default">
          <div class="panel-heading panel-heading-gray">
            <div class="pull-left">
                <h4>Projects <small>(<?php echo $numberOfProjects; ?>)</small></h4>
            </div>
            <div class="pull-right">
                <?php if (FEATURE_1 == true) { // @todo feature-flag create new project dialog ?>
                    <a class="btn btn-default btn-sm new-project-btn-position floatright"
                       data-toggle="modal" data-target="#myModal"
                       href="index.php?page=projects&action=create" >
                       New Project
                    </a>
                <?php } ?>
                <?php if (FEATURE_4 == true) { // @todo feature-flag list-domains dialog ?>
                    <a class="btn btn-default btn-sm new-project-btn-position floatright"
                       data-toggle="modal" data-target="#myModal"
                       href="index.php?page=domains">
                       List Domains
                    </a>
                <?php } ?>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="panel-body panel-body-gray">
            <!-- list-group for projects -->
            <?php echo $listProjects; ?>
          </div>
        </div>
    </div>

    <div class="col-md-6" id="right-box">

        <!-- Tools Panel -->
        <div class="panel panel-default">
          <div class="panel-heading panel-heading-gray">
            <div class="pull-left">
                <h4>Tools <small>(<?php echo $numberOfTools; ?>)</small></h4>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="panel-body panel-body-gray">
            <?php echo $listTools; ?>
          </div>
        </div>

    </div>

    <div class="clearfix"></div> <!-- cleafix for left and right box -->

</div> <!-- ./col-md-10 >