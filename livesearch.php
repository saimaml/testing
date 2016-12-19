<?php
include_once('config/config.php');

$name=$_REQUEST['q'];
 $sql = "SELECT * FROM tbl_service_details WHERE city LIKE '%$name%'"; 

 $result =mysqli_query($con,$sql);

if(mysqli_num_rows($result)>0)
{
 while($row = mysqli_fetch_array($result))
  {
   ?>
   <div class="row blog-inner blog-inner-bottom">
   <div class="col-md-4">
		<!-- Image --> 
		<img src="<?php echo $row["image"]; ?>" alt="" class="img-responsive" />
	</div>
	<div class="col-md-8">
		<h4><?php echo $row["name"]; ?></h4>
		<div class="con">
			<p><i class="fa fa-phone"></i>+<?php echo $row["phone_no"];?><p>
			<p><i class="fa fa-map-marker"></i><?php echo $row["address1"]; ?><span> <?php echo $row["address2"]; ?></span></p>
			<p><?php echo $row["city"]; ?></p>
		</div>
	</div>
	<div class="col-md-12 shops">
		<h4><i class="fa fa-star-o"></i> Click here to view your friends rating.</h4> 
	</div>
	</div>

   

   <?php
    }
}
else
{
	echo "No records found";
}
?>

