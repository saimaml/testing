<?php
	include_once('header_prod.php');	
	
	
	$query = "UPDATE tbl_visit SET visit_count = visit_count + 1 WHERE page_name = 'Blog Details'";
	$result_visit = mysqli_query($con,$query);
	
	$id = $_REQUEST["id"];
	$sql = "SELECT title , description,created_date,image FROM tbl_news WHERE id = '".$id."' ";
	$result = mysqli_query($con,$sql);
	$row = mysqli_fetch_array($result);
	$time = strtotime($row["created_date"]);		
?>
<style>
.blog-outer .blog-status ul {
    background: #f9f9f9 none repeat scroll 0 0;
    border-bottom: 1px solid #f0f0f0;
    border-top: 1px solid #f0f0f0;
    list-style: outside none none;
    margin-left: -15px;
    margin-right: -15px;
    padding: 10px 0;
   
}
.blog-outer .blog-status li {
	display: list-item;
    padding: 0 20px;
	color:#717b82;
	list-style:disc;
	text-align:left;
	margin-left:30px;
	font-size: 15px;
}
.blog-outer .blog-status ul {
    font-size: 13px;
    list-style: outside none none;
  
}
.blog-outer .blog-status i {
    margin: 5px 8px;
}
.comments {
    padding: 20px 0;
}
.bold.span-inner {
    color: #fff;
}
 </style>
<!-- HEADER END -->
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">

	<section class="blog-outer blog-single" id="blog-outer"> 
		<div class="container">    
			<!-- Title & Desc Row Begins --> 
			<div class="row"> 
				<div class="col-md-12 header text-center"> 
				<!-- Title -->           
				<div class="title">     
				<h2>Pet <span>Story</span></h2>      
				</div>                        <!-- Description -->   
			<!--	<p class="desc">We ensure quality &amp; support. People love us &amp; we love them. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>   -->  
				</div>                
				</div>   

 
		<div class="row">
			<div class="col-md-12">
				<ul class="breadcrumb" style="margin-bottom:0px;">
					<li><a href="home"><i class="glyphicon glyphicon-home"></i></a></li>
					<li><a href="blog">Pet Story</i></a></li>
					<li class="active">Story Details</li>
				</ul>
			</div><!-- Blog Left Part -->    			
		</div>
					
				<!-- Title & Desc Row Ends -->        
				<div class="row">     
				<!-- Blog Left Part -->         
				<div class="col-md-10">         
				<!-- Blog 1 Image Post-->            
				<div data-animation-delay="300" data-animation="fadeInUp" class="blog-inner animated fadeInUp visible">                           
				<div class="container blog-status">   
				<!-- Blog Date and Title -->                    
				<div class="row blog-date">         
				<div class="col-md-1 text-center">     
				<span class="bold span-inner"><?php echo date('d', $time); ?></span><br>      
				<span class="bold span-inner"><?php echo date('M', $time); ?></span>   
				</div>                   
				<div class="col-md-11 blog-title">      
				<h1 style="color:#fff;font-size:24px;"><?php echo $row["title"]; ?></h1>	
				
				</div>                              
				</div>              
				<!-- Blog Status -->   
				                   
				<!-- Blog Description  -->    
				<p></p>
				<!-- Image -->                            
				<img class="img-responsive" alt="" src="<?php echo $row["image"]; ?>">  
				<p><?php echo $row["description"]; ?></p>			
								
				       
                </div>                   
				</div>                  
				<!-- Blockquote Begins -->       
				               
			
				<!-- Blockquote Ends -->           
				<!-- Comment Section Begins -->              
				<section class="comments">       
				<!-- Title -->                 
				<div data-animated="fadeInUp" class="title-accent animated undefined visible fadeInUp">
			
				</div>               
				<!-- Comment 1 -->         
				  
				
				<!-- Leave a Comment -->                        
				<div data-animation-delay="300" data-animation="fadeInUp" class="form-section animated fadeInUp visible">                                <h3>Leave A Comment</h3>                                <hr>                                <p style="display: none;" class="form-message"></p>                                <!-- Form Begins -->                               
				<form action="process.php" method="post" id="contactform" class="form-horizontal bv-form" name="contactform" role="form" novalidate="novalidate">                                    <!-- Field 1 -->		                                    <div class="input-text form-group has-feedback">                                        <input type="text" placeholder="Full Name" class="input-name form-control" name="contact_name" data-bv-field="contact_name"><i style="display: none; top: 0px;" class="form-control-feedback" data-bv-icon-for="contact_name"></i>                                    <small style="display: none;" data-bv-validator="notEmpty" data-bv-validator-for="contact_name" class="help-block"></small></div>                                    <!-- Field 2 -->                                    <div class="input-email form-group has-feedback">                                        <input type="email" placeholder="Email" class="input-email form-control" name="contact_email" data-bv-field="contact_email"><i style="display: none; top: 0px;" class="form-control-feedback" data-bv-icon-for="contact_email"></i>                                    <small style="display: none;" data-bv-validator="notEmpty" data-bv-validator-for="contact_email" class="help-block"></small><small style="display: none;" data-bv-validator="emailAddress" data-bv-validator-for="contact_email" class="help-block"></small></div>                                    <!-- Field 3 -->                                    <div class="textarea-message form-group has-feedback">                                        <textarea rows="4" placeholder="Message" class="textarea-message form-control" name="contact_message" data-bv-field="contact_message"></textarea><i style="display: none; top: 0px;" class="form-control-feedback" data-bv-icon-for="contact_message"></i>                                    <small style="display: none;" data-bv-validator="notEmpty" data-bv-validator-for="contact_message" class="help-block"></small></div>                                    <!-- Button -->                                    <button type="submit" class="btn btn-default">Send Now <i class="flaticon-arrow209"></i></button>				                                <input type="hidden" value=""></form>
				<!-- Form Ends -->	                            </div>
				</section>                 
				<!-- Comment Section Ends -->												       

				</div>         
				<!-- Blog Left Part Ends -->                    <!-- Blog Right Part Begins -->                
				<div class="col-md-4">                      
				<div class="sidebar">                            <!-- Search Box Begins -->
			                  
				
				<!-- Facebook Sidebar -->                   
				                          <!-- Twitter Sidebar -->           
			               <!-- Twitter Sidebar Ends -->                            <!-- Category Begins -->     

			              </div>                    </div>                    <!-- Blog Right Part Ends -->			                </div>                <!-- Blog Row Ends -->            </div>            <!-- Blog Container Ends -->        </section>




<!-- FOOTER -->

	<?php include_once('footer.php'); ?>
 
<!-- FOOTER END -->		
	