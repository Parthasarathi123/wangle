 <!DOCTYPE html>
<html>
  <head>
    <title>Wangle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
     <link href="https://code.jquery.com/ui/1.10.3/themes/redmond/jquery-ui.css" rel="stylesheet" media="screen">
    <link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="<?php echo base_url(); ?>css/styles.css" rel="stylesheet">
    <link href="<?php echo base_url();?>vendors/fullcalendar/fullcalendar.css" rel="stylesheet" media="screen">
     <link href="<?php echo base_url();?>css/calendar.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body> 	<div class="header">
	     <div class="container">
	        <div class="row">
	           <div class="col-md-5">
	              <!-- Logo -->
	              <div class="logo">
                          <h1><a href="<?php echo site_url('').'/admin';?>">Wangle</a></h1>
	              </div>
	           </div>
	           <div class="col-md-5">
	              
	           </div>
	           <div class="col-md-2">
	              <div class="navbar navbar-inverse" role="banner">
	                  <nav class="collapse navbar-collapse bs-navbar-collapse navbar-right" role="navigation">
	                    <ul class="nav navbar-nav">
	                      <li class="dropdown">
	                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">administrator <b class="caret"></b></a>
	                        <ul class="dropdown-menu animated fadeInUp">
                                    <li class="submenu"><a href="#">Profile<span class="caret pull-right"></span></a>
                                    <ul>
                                        <li><a href="<?php echo site_url('auth/edit_user'); echo '/1';?>">Edit Profile</a></li>
                            <li><a href="<?php echo site_url('auth/change_password');?>">Change password</a></li>
                        </ul>
                                    </li>
	                          <li><a href="<?php echo site_url('auth/logout')?>">Logout</a></li>
	                        </ul>
	                      </li>
	                    </ul>
	                  </nav>
	              </div>
	           </div>
	        </div>
	     </div>
	</div>
