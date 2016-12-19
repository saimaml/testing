<!DOCTYPE html> 
<html lang="en-US">
  <head>
    <title>CodeIgniter Admin Sample Project</title>
    <meta charset="utf-8">
  <link href="<?php //echo base_url(); ?>css/admin/bootstrap.min.css" rel="stylesheet" type="text/css">
  
  </head>
  <body class="login-page">
<?php include( 'include_files.php' ); ?>

<header id="myCarousel" class="carousel carousel-fade" style="top: 0px; z-index: -999; position: fixed; width: 100%;">
<div class="carousel-inner">
<div class="item">
<div class="fill" style="background-image:url('<?php echo base_url(); ?>images/paris-france.jpg');"></div>
</div>
<div class="item active">
<div class="fill" style="background-image:url('<?php echo base_url(); ?>images/Dubai.jpg');"></div>
</div>
<div class="item">
<div class="fill" style="background-image:url('<?php echo base_url(); ?>images/maldives.jpg');"></div>
</div>
<div class="item">
<div class="fill" style="background-image:url('<?php echo base_url(); ?>images/london.jpg');"></div>
</div>
</div>
</header>


  <div class="login-box">
<div class="login-logo">
<div class="login-box-body">
<p class="error"></p>
<p class="login-box-msg">Sign up for New Account</p>

<?php 
$this->load->helper('form');
$attributes = array('class' => 'form-signin');
 ?>

 <?php echo form_open('user/create_member', $attributes);   ?>


 <div class="form-group has-feedback">
  
<?php $Name = array(
              'name'        => 'name',
              'id'          => 'inputName3',
              'class'       => 'form-control',
              'placeholder'   => 'Name',
             
            );

 echo form_input($Name);?>
 <span class="glyphicon glyphicon-nameplate form-control-feedback"></span>
 </div>

 <div class="form-group has-feedback">
  
<?php $Email = array(
              'name'        => 'email',
              'id'          => 'inputEmail3',
              'class'       => 'form-control',
              'placeholder'   => 'Email Id',
             
            );

 echo form_input($Email);?>
 <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
 </div>
 

<div class="form-group has-feedback">
 
	  <?php $password = array(
              'name'        => 'password',
              'id'          => 'inputPassword3',
              'class'       => 'form-control',
              'placeholder'   => 'Password',
             
            );

	  echo form_password($password); 
	        if(isset($message_error) && $message_error){
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Oh snap!</strong> Change a few things up and try submitting again.';
          echo '</div>';             
      }	  ?>
	 <span class="glyphicon glyphicon-lock form-control-feedback"></span>
	  </div>
	  
	  
	  <div class="form-group has-feedback">
 
	  <?php $re_password = array(
              'name'        => 're_password',
              'id'          => 'inputPassword3',
              'class'       => 'form-control',
              'placeholder'   => 'Retype Password',
             
            );

	  echo form_password($re_password); 
	        if(isset($message_error) && $message_error){
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Oh snap!</strong> Change a few things up and try submitting again.';
          echo '</div>';             
      }	  ?>
	 <span class="glyphicon glyphicon-lock form-control-feedback"></span>
	  </div>

  
<div class="form-group has-feedback">
  
<?php $contact = array(
              'name'        => 'contact',
              'id'          => 'inputContact3',
              'class'       => 'form-control',
              'placeholder'   => 'Contact',
             
            );

 echo form_input($contact);?>
 <span class="glyphicon glyphicon-earphone form-control-feedback"></span>
 </div>


 
 <div class="form-group">
 <?php   echo "<br />";
      echo anchor('user', 'Login!');
      echo "<br />";?>
  </div>
 <div class="row">
<div class="col-xs-8"> </div>
<div class="col-xs-4">
	 <?php  echo "<br />";
	 
      echo form_submit('submit', 'Sign Up', 'class="btn btn-primary btn-block btn-flat"');
      echo form_close();
      ?>  
</div>
</div> 

 </div>
</div>
</div><!--container-->
    <script src="<?php echo base_url(); ?>js/jquery-1.7.1.min.js"></script>
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
  </body>
</html>    
    