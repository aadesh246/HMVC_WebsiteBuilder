<!DOCTYPE html>
<html>
<head>
      <meta name="author" content="<?php echo $this->settings->get_setting("site_author")?>">

	<title><?php echo $this->settings->get_setting('site_title');?></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</head>
<body>
 

<nav class="navbar navbar-dark bg-dark navbar-expand-md mb-5">
  <div class="container">
    <a class="navbar-brand" href="<?php echo base_url();?>">My MVC Framework</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <?php if(!$this->ion_auth->logged_in()):?>
      	<li class="nav-item active">
        <a class="nav-link btn px-3 btn-primary" href="<?php echo base_url();?>auth/login">Sign In <span class="sr-only"></span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url();?>auth/create_user">Register <span class="sr-only"></span></a>
      </li><?php else: ?>
      <?php if($this->ion_auth->is_admin()):?>
      	<li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url();?>admin">Admin Panel</a>
      </li><?php endif;?>
      <li class="nav-item active mr-sm-1">
        <a class="nav-link btn btn-primary" href="<?php echo base_url();?>auth/logout">Sign Out</a>
      </li><?php endif;?>
      
  </div></ul></div></div></nav>
  