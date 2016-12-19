<?php
	include_once('header_prod.php');
	
	$query = "UPDATE tbl_visit SET visit_count = visit_count + 1 WHERE page_name = 'Blog'";
	$result_visit = mysqli_query($con,$query);
	
	$sql = "SELECT id,title,description,created_date,image FROM tbl_news order by created_date desc ";
	$result = mysqli_query($con,$sql);
	
	
?>
 <style>
 .blog-outer .blog-status .blog-date {
    background-color: #fff;
    margin-top: 0px;
    padding: 10px 0;
 }
 .btn-primary {
    background-color: #e74c3c !important;
    border-color: #e74c3c;
    color: #fff;
	margin-left:10px;
     width: 94%;
}
 </style>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
<!-- HEADER END -->
<section class="blog-outer" id="blog-outer">
	<!-- Blog Grid Begins -->  
	<div class="blog-grid">
		<div class="container">
		<!-- Title & Desc Row Begins -->
		<div class="row">
			<div class="col-md-12 header text-center">
				<!-- Title -->
				<div class="title">
					<h2>Pet Story</h2>
				</div>
				<!-- Description -->
				<p class="desc">Take an informative ride with Discover My Pet Companion Blog Segment</p>
			</div>   
		</div> 
	
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb">
					<li><a href="home"><i class="glyphicon glyphicon-home"></i></a></li>					
					<li class="active">Pet Story</li>
				</ul>
			</div><!-- Blog Left Part -->                    
		
		</div>
	
		<!-- Title & Desc Row Ends -->  
	<!-- Blog Grid Inner Begins --> 
		<div class="row">
			<!-- Blog Grid Inner Begins -->	
		<?php while($row = mysqli_fetch_array($result))
		{			$title = clean(strtolower($row["title"])); 			
			$time = strtotime($row["created_date"]);
			?>
			
		
			<div class="grid-col-3"> 
			<div class="col-md-4">
			<!-- Blog 1 Image Post--> 
				<!--<div class="grid-posts" style="position: absolute; left: 0px; top: 0px;">-->
					<div data-animation-delay="300" data-animation="fadeInUp" class="blog-inner animated fadeInUp visible"> 
						<div class="container blog-status">   
							<!-- Image -->           
							<img class="img-responsive" alt="" src="<?php echo $row["image"]; ?>"/>
							<!-- Blog Date and Title -->       
							<div class="row blog-date">       
								<div class="col-md-2 text-center">    
									<span class="bold span-inner"><?php echo date('d', $time); ?></span><br>  
									<span class="bold span-inner"><?php echo date('M', $time); ?></span>     
								</div>                            
								<div class="col-md-10 blog-title">    
									<h3 style="font-size:20px;"><?php echo $row["title"]; ?></h3> 
								</div>                  
							</div>                  
							<p><?php
							$ans= substr($row["description"],0,150);
							echo $ans;

							 $title = clean(strtolower($row["title"]));
							?></p>    
							<!-- Bottom Content -->     
							<div class="row">
								<!-- Title --> 	
								<a href="<?php echo WEb_URL ?><?php echo $title; ?>/<?php echo $row['id']; ?>/blog_details"><button class="btn btn-primary" type="button">Read More</button></a>
							</div>
							
						<!-- Bottom Content Ends -->			                                   
						</div>
					</div>       
				</div>     	
		
			<?php } ?>
			<!-- Blog Grid Inner Begins -->	
			
		
			</div>  		  
					  
		</div>
	<!-- Blog Grid Inner Ends -->
	</div>
	</div>            
	<!-- Blog Grid Ends -->      
</section>
<!-- FOOTER -->

	<?php include_once('footer.php'); ?>
 
<!-- FOOTER END -->		