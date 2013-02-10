<h2 class="heading">Projects and Tools</h2>

    <div class="left-box">
        <div class="cs-message">
            <div class="cs-message-content-projects">
                <?php if (FEATURE_1 == true) { // @todo feature-flag create new project dialog ?>
                    <button class="aButton new-project-btn-position floatright" href="#newproject">
                        New Project
                    </button>
                <?php } ?>
                 <?php if (FEATURE_4 == true) { // @todo feature-flag create new project dialog ?>
                    <button class="aButton new-project-btn-position floatright" href="#listDomains">
                        List Domains
                    </button>
                <?php } ?>
                <h2>Projects <small>(<?=$numberOfProjects?>)</small></h2>
                <?=$listProjects?>
            </div>
        </div>
    </div>

    <div class="right-box">
        <div class="cs-message">
            <div class="cs-message-content-projects">
                <h2>Tools <small>(<?=$numberOfTools?>)</small></h2>
                <?=$listTools?>
            </div>
        </div>
    </div>
