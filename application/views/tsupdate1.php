<?php

$this->load->view('header');
$this->load->view('sidebar_emp');

?>
<section name="page">
<div class="col-lg-7">
	  					<div class="col-lg-12">
			  				<div class="panel-heading">
					            <div class="panel-title"></div>
					          
					            <div class="panel-options">
					              <a data-rel="collapse" href="#"><i class="glyphicon glyphicon-refresh"></i></a>
					              <a data-rel="reload" href="#"><i class="glyphicon glyphicon-cog"></i></a>
					            </div>
					        </div>
			  				<div class="panel-body">
                                                            
                                                            <form role="form" method="post" action="update" class="form-horizontal">
                                                                    <div class="form-group">
											<label>Project Name:</label>
                                                                                        <input name="project_name" value="<?php echo $timesheet['project_name']; ?>" type="text" placeholder="Project Name" class="form-control">
										</div>
                                                                    <div class="form-group">
											<label>Task Description</label>
                                                                                        <textarea name="task_desc" rows="3" placeholder="Task Description"  value="<?php echo $timesheet['task_desc']; ?>"  class="form-control"></textarea>
										</div>
                                                                    <div class="form-group">
											<label>Start Time:</label>
                                                                                        <input type="text" name="start" placeholder="HH:MM AM/PM" class="form-control"  value="<?php echo $timesheet['start']; ?>" >
                                                                                        <label>End Time:</label>
                                                                                        <input type="text" name="end" placeholder="HH:MM AM/PM" class="form-control"  value="<?php echo $timesheet['end']; ?>" >
										</div>
                                                                    <div class="form-group">
											<label>Status of Task</label>
                                                                                        <input type="text" name="task_status" placeholder="Status of task" value="<?php echo $timesheet['task_status']; ?>"  class="form-control">
										</div>
                                                                    <div class="form-group">
											<label>Total time taken</label>
                                                                                        <input type="text" name="total_time" placeholder="Total time Taken" class="form-control"  value="<?php echo $timesheet['total_time']; ?>" >
										</div>
                                                                <input type="submit" class="btn btn-primary" name="timesheet" value="Submit">
                                                                    
                                                                    
								</form>
			  				</div>
			  			</div>
	  				</div>
</section>
<?php

     $this->load->view('footer');
?>