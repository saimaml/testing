<?php
	include_once('header_prod.php');
	$sql_services = "SELECT id,service_master,service_desc,website_img FROM tbl_service_master WHERE id!='0' order by set_order ";
	$result_services =  mysqli_query($con,$sql_services);
	?>
	<!-- HEADER End -->
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
	<!-- Blog Begins -->
	<section id="welcome"> 
	<!-- Welcome Section Begins -->
		<div class="container welcome-inner">  
			<div class="row">	
				<div class="col-md-12">		
					<ul class="breadcrumb">		
						<li><a href="home">
						<i class="glyphicon glyphicon-home"></i></a></li>	
						<li class="active">Services</li>	
					</ul>		
				</div>
			<!-- Blog Left Part --> 
			</div>
		</div>
	</section>
	<section id="screenshots" style="margin-bottom:8% !important;">
	<div class="screenshots">
	<div class="container features-inner">   
	<div class="row">
	<div class="col-md-12 text-center">		
	<!-- Title --> 			
	<div class="title">		
	<h2> Pet <span>Services</span></h2>	
	</div>		
	<!-- Description --> 
	<p class="desc">Explore &amp; experience unique features and ways to care for your pet through your own “Discover My Pet App &trade;”.</p>		
	</div>	
	<div class="col-md-12 ">	
	<div class="input-group animated services_dr" data-animation="fadeInUp" data-animation-delay="300">
	<form method="POST" action="servicedetails.php">	
	<div class="col-md-4">	
	<div class="form-group">	
	<select name="city" class="form-control" id="select_city"> 	
	<option value="-1">--Select City--</option>	
	<option value="pune">Pune</option>			
	<option value="mumbai">Mumbai</option>		
	<option value="delhi">Delhi</option>	
	<option value="ahmedabad">Ahmedabad</option>	
	<option value="bangalore">Bangalore</option>
	<option value="chennai">Chennai</option>		
	<option value="nagpur">Nagpur</option>		
	<option value="goa">Goa</option>		
	<option value="kolkata">Kolkata</option>
	<option value="hyderabad">Hyderabad</option>		
	</select>	
	</div>			
	</div>		
	<div class="col-md-8">		
	<div id="custom-search-input"> 
	<div class="input-group col-md-12"> 
	<input type="text" class="search-query form-control skills" name="name" placeholder="Search" />
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
	</div>		
	<div class="row">       
	<!-- FEATURES LEFT -->   
	<div class="col-md-12 col-sm-6">   
	<?php while($row_services = mysqli_fetch_array($result_services))		
		{	?>		
	<div class="col-md-4 features-list features-list-left">		
	<li class="features-list-item animated fadeInLeft visible" data-animation="fadeInLeft" data-animation-delay="500">	
	<a href="">		
	<!-- Icon -->   
	<i><img style="border-radius:50%;" src="<?php echo $row_services["website_img"]?>"/></i>
	</a>
	<div class="features-content">
	<?php $service_master = clean(strtolower($row_services["service_master"]));  ?>
	<h4><a href="#" onclick="select_service('<?php echo $row_services["id"]?>','<?php echo $service_master; ?>');"><?php echo $row_services["service_master"]?></a></h4>
	<p class="italic"><?php echo $row_services["service_desc"]?></p>   
	</div>   
	</li> 
	</div>		
	<?php  }	?>
	</div>
	</div>	
	</div>   
	</div>   
	</section>  
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
	function select_service(cat_id,cat_nm){
		var city = document.getElementById("select_city").value;
		//var url = "<?php echo WEb_URL; ?>/servicedetails.php?id=" + cat_id + "&city=" + city;
		//var url = "<?php echo WEb_URL; ?>/servicedetails/" + city + "/" + cat_id;			
		var url = "<?php echo WEb_URL; ?>" + cat_nm + "/" + city + "/" +cat_id + "/servicedetails" ;		
		window.location.href = url;
		} 
		</script>
		<!-- FOOTER -->	
		<?php include_once('footer.php'); ?> <!-- FOOTER END -->		