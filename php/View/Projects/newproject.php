<form class="form-horizontal" method="post" action="index.php?page=projects&action=create">
<fieldset>

<!-- Form Name -->
<legend>Create New Project</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="projectname">Project Name</label>  
  <div class="col-md-4 controls">
    <input id="projectname" name="projectname" placeholder="projectname" class="form-control input-md" type="text">
    <!--<span class="help-block">Folder: xy\projectname</span> -->
  </div>
</div>

<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="buttonSave"></label>
  <div class="col-md-8">
    <button id="buttonSave" name="buttonSave" class="btn btn-success">Create Project</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

<!-- Select Basic 
<div class="control-group">
  <label class="control-label" for="selectbasic">Select Project Template</label>
  <div class="controls">
    <select id="selectbasic" name="selectbasic" class="input-xlarge">
      <option>Empty</option>
      <option>Hello World</option>
      <option>Composer Project</option> 
      <option>HTML5 Boilerplate</option> 
      <option>Twitter Bootstrap3</option> 
    </select>
  </div>
</div>
-->

</fieldset>
</form>