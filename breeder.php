<?php
	include_once('header_prod.php');
	$sql = "SELECT breed_name,breed_img,LEFT(breed_desc, 80) as breed_desc  FROM tbl_breed WHERE Type='Dog'LIMIT 20";
	$result = mysqli_query($con,$sql);
	
?>
<style>
.list_name li
{
	display:inline-block;
	margin:6px;
    padding: 5px 7px;
    transition: all 0.4s ease 0s;
	border:1px solid;
}
a
{
	color:#fff;
}
</style>
<section id="team">
	<div class="team">
		<div class="bg-overlay pattern"></div>
		<div class="container team-inner">
			<!-- Title & Desc Row Begins -->
			<div class="row">
				<div class="col-md-12 text-center">
					<!-- Title --> 
					<div class="title">
						<h2> All Dog <span>Breed Profiles</span></h2>
					</div>
					<!-- Description --> 
					<!--<p class="desc white">We ensure quality &amp; support. People love us &amp; we love them. Here goes some simple dummy text.</p>-->
				</div>
			</div>
			<div class="row">
			<div data-animation-delay="300" data-animation="fadeInUp" class="tags animated fadeInUp visible">     
				<ul class="list_name">         
					<li><a class="default-color" href="#">A</a></li>           
					<li><a class="default-color" href="#">B</a></li>                                    
					<li><a class="default-color" href="#">C</a></li>                                    
					<li><a class="default-color" href="#">D</a></li>                                    
					<li><a class="default-color" href="#">E</a></li>                                    
					<li><a class="default-color" href="#">F</a></li>                                    
					<li><a class="default-color" href="#">G</a></li>                                    
					<li><a class="default-color" href="#">H</a></li>                               
					<li><a class="default-color" href="#">I</a></li>                               
					<li><a class="default-color" href="#">J</a></li>                               
					<li><a class="default-color" href="#">K</a></li>                               
					<li><a class="default-color" href="#">L</a></li>                               
					<li><a class="default-color" href="#">M</a></li>                               
					<li><a class="default-color" href="#">N</a></li>                               
					<li><a class="default-color" href="#">O</a></li>                               
					<li><a class="default-color" href="#">P</a></li>                               
					<li><a class="default-color" href="#">Q</a></li>                               
					<li><a class="default-color" href="#">R</a></li>                               
					<li><a class="default-color" href="#">S</a></li>                               
					<li><a class="default-color" href="#">T</a></li>                               
					<li><a class="default-color" href="#">U</a></li>                               
					<li><a class="default-color" href="#">V</a></li>                               
					<li><a class="default-color" href="#">W</a></li>                               
					<li><a class="default-color" href="#">X</a></li>                               
					<li><a class="default-color" href="#">Y</a></li>                               
					<li><a class="default-color" href="#">Z</a></li>                               
				</ul>
			</div>
			</div>
			<!-- Title & Desc Row Ends -->
			<div class="row">
			<div data-animation-delay="300" data-animation="fadeInUp" class="tags animated fadeInUp visible">
				<div class="center">
					<h2>A</h2>
				</div>
			</div>
			</div>
			<!-- Team Row Begins -->
			<div class="row">
			<?php while($row = mysqli_fetch_array($result))
			{  ?>
				<!-- Team 1 Begins -->
				<div data-animation-delay="400" data-animation="fadeInLeft" class="col-md-3 col-sm-6 animated fadeInLeft visible">
					<div class="team-box">
						<!-- Team Box Inner Begins --> 
						<div class="team-box-inner">
							<!-- Thumbnail -->
							<div class="team-thumbnail">
								<img class="img-responsive" alt="team" src="<?php echo $row['breed_img']; ?>">
							</div>
							<div class="about-member">
								<div class="member-details">
									<!-- Title -->
									<h3 class="team-title normal"><?php echo $row["breed_name"]; ?></h3>
									<!--<h4 class="role1">UI/UX Expert</h4>-->
									<!-- Description -->
									<p><?php echo $row['breed_desc']; ?></p>
								</div>
							</div>
						</div>
						<!-- Team Box Inner Ends -->
					</div>
				</div>
				<!-- Team 1 Ends -->
			<?php   }   ?>				
			</div>
			<!-- Team Row Ends -->
		</div>
	</div>
</section>
	
<?php
	include_once('footer.php');
?>