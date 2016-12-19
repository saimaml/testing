<!DOCTYPE html> 
<html lang="en-US">
  <head>
    <title>Discover My Pet</title>
    <meta charset="utf-8">
  <link href="<?php //echo base_url(); ?>css/admin/bootstrap.min.css" rel="stylesheet" type="text/css">
  
  </head>
  <body class="login-page">
<?php include( 'admin/include_files.php' ); ?>

<header id="myCarousel" class="carousel carousel-fade" style="top: 0px; z-index: -999; position: fixed; width: 100%;">
<div class="carousel-inner">

<div class="item active">
<div class="fill" style="background-image:url('<?php echo base_url(); ?>images/Dubai.jpg');"></div>
</div>

</div>
</header>


  <div class="login-box">
<div class="login-logo">
<div class="login-box-body">
<p class="error"></p>
<p class="login-box-msg">Login</p><div class="col-xs-12">	<div class="alert alert-danger alert-dismissable cust_msg" <?php if(@$this->session->flashdata('error')=='2'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 113px; float: left;"><i class="icon fa fa-ban"></i> ERROR!</h4>Password must be 5 character </div></div>

<?php 
$this->load->helper('form');
$attributes = array('class' => 'form-signin');
 ?>

 <?php echo form_open('welcome/login');   ?>
<div class="form-group has-feedback">
   
<?php $email = array(
              'name'        => 'email',
              'id'          => 'inputEmail3',
              'class'       => 'form-control',
              'placeholder'   => 'Username',
             
            );

 echo form_input($email);?>
 <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
 </div>
 <div class="form-group has-feedback">
 
	  <?php $pass = array(
              'name'        => 'pass',
              'id'          => 'inputPassword3',
              'class'       => 'form-control',
              'placeholder'   => 'password',
             
            );

	  echo form_password($pass); 
	        if(isset($message_error) && $message_error){
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Oh snap!</strong> Change a few things up and try submitting again.';
          echo '</div>';             
      }	  ?>
	 <span class="glyphicon glyphicon-lock form-control-feedback"></span>
	  </div>
	  
 <div class="form-group">
 <?php   echo "<br />";
      echo anchor('admin/validate_credentials', 'Signup!');
      echo "<br />";?>
  </div>
 <div class="row">
<div class="col-xs-8"> </div>
<div class="col-xs-4">
	 <?php  echo "<br />";
	 
      echo form_submit('submit', 'Login', 'class="btn btn-primary btn-block btn-flat"');
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
    