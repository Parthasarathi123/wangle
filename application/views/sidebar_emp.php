 <div class="page-content">
    	<div class="row">		  
            <div class="col-md-2">
		  	<div class="sidebar content-box" style="display: block;">
                <ul class="nav">
                    <!-- Main menu -->
                    <li class="current"><a href="<?php echo site_url('employee/dashboard');?>"><i class="glyphicon glyphicon-home"></i> Dashboard</a></li>
                    <li class="submenu">
                         <a href="#">
                            <i class="fa fa-clock-o"></i> Timesheet
                            <span class="caret pull-right"></span>
                         </a>
                         <!-- Sub menu -->
                         <ul>
                             <li><a href="<?php echo site_url('employee/timesh');?>">Enter Todays Timesheet</a></li>
                            <li><a href="<?php echo site_url('employee/showts');?>">edit previous time sheet</a></li>
                        </ul>
                    </li>
                   
                    
                    <li class="submenu">
                         <a href="#">
                            <i class="fa fa-umbrella"></i> Apply for Leave
                            <span class="caret pull-right"></span>
                         </a>
                         <!-- Sub menu -->
                         <ul>
                             <li><a href="<?php echo site_url('employee/apply_leave');?>">Apply</a></li>
                            <li><a href="<?php echo site_url('employee/leave');?>">View Leave List</a></li>
                        </ul>
                    </li>
                </ul>
                     </div>
		  </div>