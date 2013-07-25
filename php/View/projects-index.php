<h2 class="heading">Projects and Tools</h2>

    <div class="left-box">
        <div class="cs-message">
            <div class="cs-message-content-projects">
                <?php if (FEATURE_1 == true) { // @todo feature-flag create new project dialog ?>
                    <a class="aButton new-project-btn-position floatright"
                       rel="modal:open" href="index.php?page=projects#newproject" >
                       New Project
                    </a>
                <?php } ?>
                 <?php if (FEATURE_4 == true) { // @todo feature-flag create new project dialog ?>
                    <a class="aButton new-project-btn-position floatright"
                        rel="modal:open" href="index.php?page=domains#listDomains">
                        List Domains
                    </a>
                <?php } ?>
                <h2>Projects <small>(<?php echo $numberOfProjects; ?>)</small></h2>
                <?php echo $listProjects; ?>
            </div>
        </div>
    </div>

    <div class="right-box">
        <div class="cs-message">
            <div class="cs-message-content-projects">
                <h2>Tools <small>(<?php echo $numberOfTools; ?>)</small></h2>
                <?php echo $listTools; ?>
            </div>
        </div>
    </div>
