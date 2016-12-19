<?php
	include_once('header_prod.php');		$sql_services = "SELECT id,service_master,service_desc,service_img FROM tbl_service_master";
	$result_services =  mysqli_query($con,$sql_services);
	if(!empty($_REQUEST["id"]) AND isset($_REQUEST["city"]))
	{
		if($_REQUEST["city"] =='-1')
		{
			$id = $_REQUEST["id"];
			
			$sql = "SELECT name,address1,address2,city,state,phone_no,year_of_experience FROM 	tbl_service_details WHERE service_cat_id = '".$id."' ";
		}
		else
		{
			$id = $_REQUEST["id"];
			$city = $_REQUEST["city"];
			$sql = "SELECT name,address1,address2,city,state,phone_no,year_of_experience FROM 	tbl_service_details WHERE service_cat_id = '".$id."'and city = '".$city."' ";
			 
		}
		
		$result = mysqli_query($con,$sql);		
	}
	elseif(!empty($_REQUEST["id"]))
	{
		$id = $_REQUEST["id"];
		$sql = "SELECT name,address1,address2,city,state,phone_no,year_of_experience FROM tbl_service_details WHERE service_cat_id = '".$id."'";
		$result = mysqli_query($con,$sql);		
	} 
	elseif($_POST["name"] !="")
	{
		$name = $_POST["name"];
		$sql = "SELECT name,address1,address2,city,state,phone_no,year_of_experience FROM tbl_service_details WHERE name LIKE '%$name'";		
		$result = mysqli_query($con,$sql);	
	}
	elseif($_POST["city"] !='-1')
	{		
		$city = $_POST["city"];		
		$sql = "SELECT name,address1,address2,city,state,phone_no,year_of_experience FROM tbl_service_details WHERE city = '".$city."'";
		$result = mysqli_query($con,$sql);	
	}
	elseif($_POST["city"] !='-1' AND $_POST["name"] !="")
	{
		$name = $_POST["name"];
		$sql = "SELECT name,address1,address2,city,state,phone_no,year_of_experience FROM tbl_service_details WHERE city = '".$city."' and name LIKE '%$name'";		
		$result = mysqli_query($con,$sql);	
	}	
	else
	{		
		$sql = "SELECT name,address1,address2,city,state,phone_no,year_of_experience FROM tbl_service_details ";
		$result = mysqli_query($con,$sql);		}?> 
 <style>
.gold{
	color: #FFBF00;
}

/*********************************************
					PRODUCTS
*********************************************/

.product{
/*border: 1px solid #dddddd;*/
	/*height: 280px;*/
	-moz-box-shadow: 1px 2px 4px rgba(0, 0, 0,0.5);
    -webkit-box-shadow: 1px 2px 4px rgba(0, 0, 0, .5);
    box-shadow: 4px 5px 3px rgba(0, 0, 0, 0.5);
}

.product>img{
	max-width: 230px;
}

.product-rating{
	font-size: 17px;
    margin-bottom: 0;
}

.product-title{
	font-size: 20px;
	text-transform: uppercase;
}

.product-desc{
	font-size: 14px;
	line-height: 25px;
}

.product-price{
	font-size: 22px;
}

.product-stock{
	color: #74DF00;
	font-size: 20px;
	margin-top: 10px;
}

.product-info{
		margin-top: 50px;
}

/*********************************************
					VIEW
*********************************************/

.view-wrapper {
	float: right;
	max-width: 70%;
	margin-top: 25px;
}


/*********************************************
				ITEM 
*********************************************/

.service1-items {
	padding: 0px 0 0px 0;
	float: left;
	position: relative;
	overflow: hidden;
	max-width: 100%;
	height: 321px;
	width: 130px;
}
.service1-item {
	height: 107px;
	width: 120px;
	display: block;
	float: left;
	position: relative;
	padding-right: 20px;
	border-right: 1px solid #DDD;
	border-top: 1px solid #DDD;
	border-bottom: 1px solid #DDD;
}

.service1-item > img {
	max-height: 110px;
	max-width: 110px;
	opacity: 0.6;
	transition: all .2s ease-in;
	-o-transition: all .2s ease-in;
	-moz-transition: all .2s ease-in;
	-webkit-transition: all .2s ease-in;
}
.service1-item > img:hover {
	cursor: pointer;
	opacity: 1;
}
.service-image-right {
	padding-left: 50px;
}
.archives h4 {
    background-color: #f0f0f0;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 8px;
    margin-left: 0;
    margin-right: 0;
    margin-top: 0;
    padding-bottom: 10px;
    padding-left: 6px;
    padding-right: 0;
    padding-top: 8px;
    text-transform: uppercase;
}
.animated .rightbardelta{
   
    border: 1px solid #ddd !important;
    padding: 4% !important;
    
	}
.service-image-left > center > img,.service-image-right > center > img{
	
}
.title1 {
    color: #e74c3c;
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 15px;
    padding: 20px 0 7px;
    text-transform: uppercase;
	margin-left: 14px;
	display: inline-block;
    font-family: "Raleway",sans-serif;
}
.servicestitle {
    font-weight: bold;
}
 </style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
 <!-- HEADER End -->
 
  <!-- Blog Begins -->
<div class="container-fluid">   
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<!-- Title --> 
				<div class="title">
					<h2>Services<span> Details</span></h2>
				</div>
				<!-- Description --> 
				<!--<p class="desc">&nbsp;</p>-->
			</div>
			
	
			<div class="col-md-12">
				<ul class="breadcrumb" style="margin-bottom:0px;">
					<li><a href="home"><i class="glyphicon glyphicon-home"></i></a></li>
					<li><a href="<?php echo WEb_URL; ?>service-shop">Services</a></li>
					<?php
					if(!empty($_REQUEST["id"]))
					{ 
					$sql_service = "SELECT service_master FROM tbl_service_master WHERE id = '".$_REQUEST["id"]."'";
					$result_service = mysqli_query($con,$sql_service);	
					$row_service = mysqli_fetch_array($result_service);
					?>
						<li class="active"><?php echo $row_service["service_master"]; ?></li>
						
					<?php  }	?>					
				</ul>
			</div><!-- Blog Left Part -->    						
		

			<div class="col-md-12">
				<!-- Title --> 
				<div class="title1">
				<?php
					if(!empty($_REQUEST["id"]))
					{ 
					$sql_service = "SELECT service_master FROM tbl_service_master WHERE id = '".$_REQUEST["id"]."'";
					$result_service = mysqli_query($con,$sql_service);	
					$row_service = mysqli_fetch_array($result_service);
					?>
						<h3 class="servicestitle"><?php echo $row_service["service_master"]; ?></h3>
					<?php  }
					?>
					
				</div>
				<!-- Description --> 
				<!--<p class="desc">&nbsp;</p>-->
			</div>
			<div class="col-md-12">
				<div class="input-group animated services_dr" data-animation="fadeInUp" data-animation-delay="300">
				<form method="POST" action="servicedetails.php">
				<div class="col-md-4">
				<div class="form-group">
					<select name="city" class="form-control"> 
					<option value="<?php if(isset($_REQUEST["city"] )) echo $_REQUEST["city"]; else echo "--Select City--";?>"> <?php if(isset($_REQUEST["city"] )) echo $_REQUEST["city"]; else echo "--Select City--";?></option>
					<option value="Pune">Pune</option>
					<option value="Mumbai">Mumbai</option>
					<option value="Delhi">Delhi</option>
					<option value="Ahmedabad">Ahmedabad</option>
					<option value="Bangalore">Bangalore</option>
					<option value="Chennai">Chennai</option>
					<option value="Nagpur">Nagpur</option>
					<option value="Goa">Goa</option>
					<option value="Kolkata">Kolkata</option>
					<option value="Hyderabad">Hyderabad</option>
					</select>
				</div>
				</div>
				<div class="col-md-8">
				<div id="custom-search-input">
					<div class="input-group col-md-12">
						<input type="text" class="search-query form-control skills" name="name" placeholder="Search" value="<?php if(isset($_REQUEST["name"] )) echo $_REQUEST["name"]; ?>" />
						<span class="input-group-btn">
							<button class="btn btn-danger" type="submit">
								<span class="fa fa-1x fa-search"></span>
							</button>
						</span>
					</div>
				</div>			
				</div>
				</form>
				</div> 			
						
			</div>
			</div><br>
		<div class="item-container">		
			<div class="container">	
				<div class="col-md-9">
				<?php 
				$num = mysqli_num_rows($result);
				if($num > 0)
				{
					
				
				while($row = mysqli_fetch_array($result))
				{   ?>
					<div class="row">
				<div class="col-md-4">
					<div class="product service-image-left">                    
						<center>
							<img id="item-display" src="<?php echo URL ?>images/toys.png" alt=""></img>
						</center>
					</div>			
				</div>					
				<div class="col-md-8">
					<div class="product-desc"><b><i class="icon-user" aria-hidden="true"></i> Name: </b><?php echo $row["name"]; ?></div>
					<div class="product-desc"><b><i class="fa fa-map-marker" aria-hidden="true"></i> Address:</b> <?php echo $row["address1"]." ".$row["address2"]." ".$row["city"]; ?>.</div>
					<div class="product-desc"><b><i class="fa fa-phone" aria-hidden="true"></i> Contact:</b> <?php echo $row["phone_no"]; ?></div>
					<div class="product-desc"><b>Experiance / Establishment:</b> <?php echo $row["year_of_experience"]; ?> Year </div>
					<div class="product-desc"><b>Working:</b> Available </div>	
							
					<div class="product-rating"><i class="fa fa-star gold"></i> <i class="fa fa-star gold"></i> <i class="fa fa-star gold"></i> <i class="fa fa-star gold"></i> <i class="fa fa-star-o"></i> </div>					
									
					<div class="btn-group wishlist">					
						<button type="button" class="btn btn-danger">
							Call Us
						</button>
					</div>
				</div>
				</div>
				<hr>					
				<?php  }  }  else
				{  ?>
					<div class="row">
					<h4> <img src="http://tacticmusic.com/wp-content/uploads/2015/11/coming-soon.jpg" width="850" height="400"></h4>
					</div>
			<?php	}					?>
				</div>
				<div class="col-md-3"> 
				<div class="sidebar">
			
<div class="archives animated" data-animation="fadeInUp" data-animation-delay="300">   
	<div class="rightbardelta">
				<h4>Service Categories</h4>  
				<?php while($row_services = mysqli_fetch_array($result_services))
							{	?>				
				<p><a href="servicedetails.php?id=<?php echo $row_services["id"]?>"><?php echo $row_services["service_master"]?><i class="flaticon-arrow209"></i></a></p>  
				<?php  }	?>						
					
				</div> 
				</div><br>
				</div>                    </div>
				
			</div> 			
		</div>
	
	</div>
</div>
	
 <!-- FOOTER -->
<script>
$(function() {
    $( ".skills" ).autocomplete({
        source: 'select_service1.php' 
    });
});

$(function() {
    $( ".search_product" ).autocomplete({
        source: 'select_service1.php' 
    });
});

</script>
	<?php include_once('footer.php'); ?>
 
<!-- FOOTER END -->		