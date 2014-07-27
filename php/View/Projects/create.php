<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
     <h4 class="modal-title">Create New Project</h4>
</div>

<div class="modal-body">
    <form class="form-horizontal" method="post" action="index.php?page=projects&action=createproject">
    <fieldset>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="projectname">Project Name</label>  
      <div class="col-md-4 controls">
        <input id="projectname" name="projectname" placeholder="projectname" class="form-control input-md" type="text">
        <!--<span class="help-block">Folder: xy\projectname</span> -->
      </div>
    </div>

    <!--
    Work-In-Progess: Select Box "Choose a Project Template"
    Use this dialog box to generate a project stub for developing web applications.
    WPN-XM generates project stubs based on the following templates:

    The available options are:

        Empty:              choose this option to get just a project folder without any contents.
        Hello World:        choose this option to get a basic hello world project.
        Composer:           choose this option to have a project stub created using the Composer template.
        HTML5 Boilerplate:  choose this option to have a project structure set up with a HTML5 Boilerplate template.
        Twitter Bootstrap3: choose this option to have a project structure set up with a Twitter Bootstrap3 template. 
    -->

    <!-- Select Basic -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="projecttemplate">Select Project Template</label>
      <div class="col-md-4 controls">
        <select id="projecttemplate" name="projecttemplate" class="input-xlarge">
          <option>Project folder only</option>
          <option>"Hello World" Project</option>
          <option>"Composer" Project</option> 
          <!--
          <option>HTML5 Boilerplate</option> 
          <option>Twitter Bootstrap3</option>
          -->
        </select>
      </div>
    </div>

    </fieldset>
    </form>
</div>

<div class="modal-footer">
    <button type="submit" id="buttonSave" name="button" class="btn btn-success">Create Project</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>