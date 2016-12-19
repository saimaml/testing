<?php include_once('header_prod.php'); 

session_start();
if ($_SESSION['login'] == "1") {  
 
//echo "you are logged in";
}
else if ($_SESSION['login'] == "") 
{
	header('location:login.php');
} 
 
 $id = $_SESSION["id"];
$sql_select = "SELECT * FROM app_users WHERE id = '".$id."' ";
$result_select = mysqli_query($con,$sql_select);

	   if(isset($_POST["submit"]))
	   {
		   $name = $_POST["name"];
		   $address1 = $_POST["address1"];
		   $address2 = $_POST["address2"];
		   $pincode = $_POST["pincode"];
		   $city = $_POST["city"];		  	   
		   
			$sql="UPDATE app_users SET name = '".$name."',address1 = '".$address1."',address2 = '".$address2."',pincode = '".$pincode."',city = '".$city."' WHERE id = '".$id."' ";
		   $result =mysqli_query($con,$sql);
		   if(mysqli_affected_rows() != 0)
			{?>
			<div class="alert alert-success alert-dismissable"> 
			<button type="button" data-dismiss="alert" aria-hidden="true" class="close"><i class="fa fa-times"></i></button> <strong>Successfully updated.</strong></div>
			<?php }
			else
			{?>
			<div class="alert alert-danger alert-dismissable">    
			<button type="button" data-dismiss="alert" aria-hidden="true" class="close"><i class="fa fa-times"></i></button> <strong>Error not updated details.</strong></div>
			<?php }
		}
	   
 ?>
<style>
.form-control
{
	width:90%;
	margin-left: 5%;
}
.btn-primary
{
	margin-left:5%;
}
</style>
<!-- HEADER END -->

    <!-- Pricing Table Begins -->
     <section id="unique-home" class="price-table">
            <div class="container pricing-inner">
                <!-- Title & Desc Row Begins -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <!-- Title -->
                        <div class="title">
                            <h2>My <span>Profile</span></h2>
                        </div>
						<nav class="breadcrumbs ">
							<a href="index.php">Home</a>						
						</nav>
                        <!-- Description -->
                        <p class="desc white">We ensure quality & support. People love us & we love them. Here goes some simple dummy text.</p>
                    </div>
                </div>
				<div class="row">
				<!-- Blog Left Part Begins -->
				<div class="col-md-4">
					<div class="sidebar"> 		
						<!-- Facebook Sidebar --> 
						<div class="sidebar-facebook animated" data-animation="fadeInUp" data-animation-delay="300">
							<img src="<?php echo URL ?>images/features/my_info_painting_400.png" alt=""/>
						</div>			
					</div>
				</div>                   <!-- Blog Left Part Ends -->
				<div class="col-md-8 sidebar-facebook">	 
				<?php $row = mysql_fetch_array($result_select);	?>								
					<form action="" method="POST" role="form">
						<div class="form-group">
							<input type="name" class="form-control" id="name" name="name" placeholder="Name" value ="<?php echo $row['name']; ?>" required>
						</div>
						<div class="form-group">
								<input type="email" class="form-control" id="email" name="email" placeholder="Email address" required  value = "<?php echo $row['email']; ?>">
							</div>
						<div class="form-group">
							<input type="mobile" class="form-control" id="mobile"  name="mobile" placeholder="Mobile Number" required  value = "<?php echo $row['mobile']; ?>" >
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="address1" name="address1" placeholder="Flat/House/Office No" required  value = "<?php echo $row['address1']; ?>" >
						</div>
						
						<div class="form-group">
							<input type="text" class="form-control" id="address2" name="address2" placeholder="Street/Society/Office Name" required  value = "<?php echo $row['address2']; ?>" >
						</div>
						
						<div class="form-group">
							<input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" required  value = "<?php echo $row['pincode']; ?>" >
						</div>
						
						<div class="form-group">
							<input type="text" class="form-control" id="city" name="city" placeholder="City" required  value = "<?php echo $row['city']; ?>" >
						</div>
						
						<div class="form-group">
							<button type="submit" name="submit" class="btn btn-primary">Submit	</button>  
						</div>
					</form> 	
				</div>
				</div>
          
        </section>
        <!-- Price Table Ends -->
							 
<!-- FOOTER -->

	<?php include_once('footer.php'); ?>
 
<!-- FOOTER END -->		