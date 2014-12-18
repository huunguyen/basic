<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Form Name</legend>

<!-- Prepended text-->
<div class="control-group">
  <label class="control-label" for="prependedtext">Prepended Text</label>
  <div class="controls">
    <div class="input-prepend">
      <span class="add-on">rbac</span>
      <input id="prependedtext" name="prependedtext" class="input-xlarge" placeholder="Input role task operator" type="text" required="">
    </div>
    <p class="help-block">help</p>
  </div>
</div>

<!-- Multiple Radios (inline) -->
<div class="control-group">
  <label class="control-label" for="roles">choose one:</label>
  <div class="controls">
    <label class="radio inline" for="roles-0">
      <input type="radio" name="roles" id="roles-0" value="role" checked="checked">
      role
    </label>
    <label class="radio inline" for="roles-1">
      <input type="radio" name="roles" id="roles-1" value="task">
      task
    </label>
    <label class="radio inline" for="roles-2">
      <input type="radio" name="roles" id="roles-2" value="operator">
      operator
    </label>
  </div>
</div>

</fieldset>
</form>