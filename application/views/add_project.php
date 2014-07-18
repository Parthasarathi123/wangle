<?php
$this->load->view('header1');
$this->load->view('sidebar');
?>
<div class="col-md-10">
<h1>Add project</h1>
<p>Fill the details</p>


<?php echo form_open("admin/add_project");?>

      <label for="text">Project_name</label>
	<input type="input" name="project_name" /><br />

	<label for="text">Project_Description</label>
	<textarea name="project_description"></textarea><br />

      
           <select name="assigned_to">
              
              <?php  foreach($users as $key => $value) {?>
              <option><?php echo $value['username'];?></option>
              <?php }?>
</select> 
          
            
      </p>
            <p><input type="submit" name="submit" value="Create news item" /></p>
</div>
<?php echo form_close();
$this->load->view('footer');

?>
