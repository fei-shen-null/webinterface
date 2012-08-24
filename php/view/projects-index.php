<h2 class="heading">Projects and Tools</h2>

    <div class="left-box">
        <div class="cs-message">
            <div class="cs-message-content-projects">
                <?php if (FEATURE_1 == true) { // @todo feature-flag create new project dialog ?>
                  <button class="aButton new-project-btn-position floatright" href="#newproject"><i class="icon-plus"></i> New Project</button>
                <?php } ?>
                <h2>Projects (<?=$numberOfProjects?>)</h2>
                <?=$listProjects?>
            </div>
        </div>
    </div>

    <div class="right-box">
        <div class="cs-message">
            <div class="cs-message-content-projects">
                <h2>Tools (<?=$numberOfTools;?>)</h2>
                <?=$listTools;?>
            </div>
        </div>
    </div>
