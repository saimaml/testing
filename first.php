<?php
	include_once('config/config.php'); 
	
	$query = "UPDATE tbl_visit SET visit_count = visit_count + 1 WHERE page_name = 'First'";
	$result_visit = mysql_query($query);
	
	$sql = "SELECT breed_name FROM tbl_breed";
	$result = mysql_query($sql);
	
 ?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
<html lang="en">
    <head>
		<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <title>Discover My Pet</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Fullscreen Slit Slider with CSS3 and jQuery" />
        <meta name="keywords" content="slit slider, plugin, css3, transitions, jquery, fullscreen, autoplay" />
        <meta name="author" content="Codrops" />
        <link rel="stylesheet" type="text/css" href="css_1/demo.css" />
     
        <link rel="stylesheet" type="text/css" href="css_1/custom.css" />
		<script type="text/javascript" src="js_1/modernizr.custom.79639.js"></script>
		<link rel="stylesheet" href="css_1/normalize.css" />
		<link rel="stylesheet" href="css_1/font-awesome.css" />
		<link rel="stylesheet" href="css_1/ion.rangeSlider.css" />
		<link rel="stylesheet" href="css_1/ion.rangeSlider.skinModern.css" />
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		<link href='http://fonts.googleapis.com/css?family=Roboto:500' rel='stylesheet' type='text/css'>
		<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
		
		<script src="js_1/jquery-1.10.2.js"></script>
		
		<!-- font Awesome -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
		
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
	   <link rel="stylesheet" type="text/css" href="css_1/style.css" />
	   <link rel="stylesheet" href="css_1/jquery-ui.css">
	
		<style>
		.irs
		{
		width: 500px;
		}
		.de
		{
			margin-left: 41%;
		}
		</style>
		 
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
		<link rel="stylesheet" href="/resources/demos/style.css">
	
		<noscript>
			<link rel="stylesheet" type="text/css" href="css_1/styleNoJS.css" />
		</noscript>
		
		<script type="text/javascript">

		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-7243260-2']);
		  _gaq.push(['_trackPageview']);

		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https\\ssl\\MS_5.html' : 'http\\www\\MS_6.html') + '.google-analytics.com\\ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

		</script>
				<style>
		.deco img
		{
			margin-top:48px;
			margin-left:48px;
		}
		.btn-default:hover
		{
			background-color:#7C2021;
			color:#fff;
		}
		</style>
		
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></meta></head>
		<body>
	
			<div class="container demo-1 col-md-12">
				
				<!-- Codrops top bar -->
					<div class="codrops-top clearfix">
					   <div class="clr"></div>
					</div>
				<!--/ Codrops top bar -->

				<div id="slider" class="sl-slider-wrapper">
				<div class="sl-slider">
					<div class="sl-slide bg-1" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
						<div class="sl-slide-inner">
							<div><img class="de" src="images_1/logo-in-circle_260.png"></div>
							
							<div class="center-first">
								<button class="btn btn-white set_width" id="go_prev">No</button><span>
								<button id="go_next" class="btn btn-white set_width" >Yes</button></span>
							</div>								
							<h2>Do you have a dog?</h2>
							
							
							
						</div>
						<div><h2><button type="button" class="btn btn-danger firstbtn" style=""><a href="http://discovermypet.in/home.php" style="color:#fff;">Skip</a></button></h2></div>  
					</div>
					
					<div class="sl-slide bg-2" data-orientation="vertical" data-slice1-rotation="10" data-slice2-rotation="-15" data-slice1-scale="1.5" data-slice2-scale="1.5">
						<div class="sl-slide-inner">
							<!--<div class="deco" data-icon=""><img src="images_1/logo.png"></div>-->
							   <!--<div class="dog-name1">
							   <h3>Enter Dog Name</h3>
							   </div>-->
							<div class="color dog-enter">
							<!--<h3>What’s your dog’s name?</h3>-->
							<form method="POST" style="text-align:center;">							
							
							<label id="nm"  class="dogname">WHAT IS YOUR DOG’S NAME?</label>
							<div id="type_nm"><button type="button" class="btn btn-default" onclick="$('#txtname').focus(); $('#type_nm').hide();return false;">Type here</button></div>
								<input type="text" class="in-text" name="name" id="txtname" value="" onclick="$('#txtname').val(''); " onkeyup ="var text_input = $('#txtname');var size = parseInt($(text_input).css('font-size'));text_input.css('font-size', size-2+'px');" style="font-size:80px;text-align:center;font-weight:bold; background-color:transparent;color: #eee;border:none;">
						
							<!--
							<div class="btn_type" id="type_here"> 
								<button class="btn btn-white set_width" onclick="$('#name_view').show(); $('#type_here').hide();return false;">Type here</button>
							</div>
							
							<div id="name_view" style="display:none;">
								<input type="text" class="in-text" name="name" id="txtname" value="What’s your dog’s name?" onclick="$('#txtname').val(''); " onkeyup ="var text_input = $('#txtname');var size = parseInt($(text_input).css('font-size'));text_input.css('font-size', size-2+'px');" style="width:991px;height:115px;font-size:80px;text-align:center;font-weight:bold; background-color:transparent;color: #eee;border:none;">
							</div>  -->
							</form>
							<div><h2><button type="button" class="btn btn-danger skipbtn"><a href="http://discovermypet.in/home.php" style="color:#fff;">Skip</a></button></h2></div> 
							</div>			
							
						</div>
					</div>
					<div class="sl-slide bg-3" data-orientation="horizontal" data-slice1-rotation="3" data-slice2-rotation="3" data-slice1-scale="2" data-slice2-scale="1">
						<div class="sl-slide-inner">
							<!--<div class="deco" data-icon=""><img src="images_1/logo.png"></div>-->
							<div class="breed_center">
							<form method="POST">
							<h2>WHAT’S THE BREED OF YOUR DOG?<!--<span id="dogname1"></span>--></h2>
							<div class="breed">				
								<div class="form-group col-sm-10 pad">
								  <!--<label for="sel1">Select Breed:</label>-->
								  <div class="select">
								  <span class="arr"></span>
								  <select id="selBreed" class="form-control">
									<option value="" selected>Select Breed</option>
									<?php while($row = mysql_fetch_array($result)) {   ?>
										<option value="<?php echo $row["breed_name"];  ?>"><?php echo $row["breed_name"];  ?></option>
									<?php   }  ?>
																	
									 </select>
								</div>
								</div>
							</div>
							</form>
							<div><h2><button type="button" class="btn btn-danger skipbtn1"><a href="http://discovermypet.in/home.php" style="color:#fff;">Skip</a></button></h2></div> 
							</div>
						</div>						
					</div>
					
					<!--<div class="sl-slide bg-4" data-orientation="vertical" data-slice1-rotation="-5" data-slice2-rotation="25" data-slice1-scale="2" data-slice2-scale="1">
						<div class="sl-slide-inner">
							<div class="deco" data-icon=""><img src="images_1/logo.png"></div>
							<h2>Is <span class="dog_name" id="dogname2"></span> a boy or girl?</h2>
							<div class="center row">
								<div class="col-md-1 col-md-offset-5 col-xs-5 col-xs-offset-1 col-sm-2 col-sm-offset-4">
								<a id="dog_male" href="#"><img src="images_1/dog_male.jpg" class="img"/></a>
								</div>
								
								<div class="col-md-6 col-xs-6 col-sm-6">
								<a id="dog_female" href="#"><img src="images_1/dog_female.jpg" class="img"/></a>
								</div>								
							</div>							
						</div>
					</div>
					
					<div class="sl-slide bg-5" data-orientation="horizontal" data-slice1-rotation="-5" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="1">
						<div class="sl-slide-inner">
							<div class="deco" data-icon="t"></div>
							<h2>Where does  <span class="dog_name" id="dogname3"></span> live?</h2>
						</div>
					</div>-->
					
					<div class="sl-slide bg-5" data-orientation="horizontal" data-slice1-rotation="-6" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="1">
						<div class="sl-slide-inner">
							<!--<div class="deco" data-icon=""><img src="images_1/logo.png"></div>  -->
					
						<h2 class="onlyone">WHEN WAS YOUR PET BORN?<!--<span class="dog_name" id="dogname3"></span>--></h2>
							<div class="center-dog-name1">
								<div class="olds">
								<div class="margin-t set_width" style="width:550px; height:120px;">							
								<input type="text"  id="dog_age_text" value="" name="" />
									<div class="select1">
										<span class="arr"></span>
										<select id="selmonth" class="form-control">
											<option value="">Select Month</option>
											<option value="01">January</option>
											<option value="02">February</option>
											<option value="03">March</option>
											<option value="04">April</option>
											<option value="05">May</option>
											<option value="06">June</option>
											<option value="07">July</option>
											<option value="08">August</option>
											<option value="09">September</option>
											<option value="10">October</option>
											<option value="11">November</option>
											<option value="12">December</option>
										</select>
								</div>
								<div class="select2">
										<span class="arr"></span>
										<select id="seldate" class="form-control" id="sel1">
											<option value="">Day</option>                  
											<option value="01">1</option>
											<option value="02">2</option>
											<option value="03">3</option>
											<option value="04">4</option>
											<option value="05">5</option>
											<option value="06">6</option>
											<option value="07">7</option>
											<option value="08">8</option>	
											<option value="09">9</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
											<option value="13">13</option>
											<option value="14">14</option>
											<option value="15">15</option>
											<option value="16">16</option>
											<option value="17">17</option>
											<option value="18">18</option>
											<option value="19">19</option>
											<option value="20">20</option>
											<option value="21">21</option>		
											<option value="22">22</option>
											<option value="23">23</option>
											<option value="24">24</option>
											<option value="25">25</option>
											<option value="26">26</option>
											<option value="27">27</option>
											<option value="28">28</option>
											<option value="29">29</option>
											<option value="30">30</option>
											<option value="31">31</option>
										</select>
								
								</div>								
								</div>
								</div>
							
							</div>
							<div><h2><button type="button" class="btn btn-danger fourimage" style=""><a href="http://discovermypet.in/home.php" style="color:#fff;">Skip</a></button></h2></div> 
						</div>					
					</div>					
					
					<div class="sl-slide bg-6" data-orientation="horizontal" data-slice1-rotation="-6" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="1">
						<div class="sl-slide-inner">
							<!--<div class="deco" data-icon=""><img src="images_1/logo.png"></div>-->
							<h2>WHERE IS YOUR PET’S RESIDENCE?<!--<span class="dog_name" id="dogname4"></span>--></h2>
							
							<div class="center-map">
							<button onclick="initialize()" class="btn btn-success" id="get_user_location"><i class="fa fa-map-marker" aria-hidden="true"></i> Locate</button>
							<div id="type"><button type="button" class="btn btn-default lastbtn" onclick="$('#local').show(); $('#type').hide();return false;">Type</button></div>
							<div class="locate" id="local" style="display:none;">
								<input type="text" name="location" id="locate"/>
							</div>
							<h3 id="dog_location" style="color:#fff;"></h3>
							</div>
							
						</div>
						<div><h2><button type="button" class="btn btn-danger lastbtn" style=""><a href="http://discovermypet.in/home.php" style="color:#fff;">Skip</a></button></h2></div>
					</div>
					
					
					
					<div class="sl-slide bg-7" data-orientation="horizontal" data-slice1-rotation="-6" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="1">
						<div class="sl-slide-inner">
							<!--<div class="deco" data-icon=""><img src="images_1/logo.png"></div>-->
							<h2>SAVE YOUR PET’S PROFILE<!--<span class="dog_name" id="dogname5"></span>--></h2>							
							<div class="center-sign">
							<button type="button" class="btn btn-primary set_width1" data-toggle="modal" data-target="#myModal">Sign Up</button>
							<a href="http://discovermypet.in/fbconfig.php" target="_blank"><button type="submit" class="btn btn-fb set_width1" data-toggle="modal"><img src="images_1/fb.png" height="30" width="30" style="margin-top: -5px;">Continue</button></a> 
							</div>							 
						</div>
						<div><h2><button type="button" class="btn btn-danger" style="position: absolute; margin-top:11%; margin-left: -5%;"><a href="http://discovermypet.in/home.php" style="color:#fff;">Skip</a></button></h2></div>
					</div>
									
					<!--<div class="sl-slide bg-7" data-orientation="horizontal" data-slice1-rotation="-7" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="1">
						<div class="sl-slide-inner">
							<div class="deco" data-icon="t"></div>
							<h2>If <span class="dog_name" id="dogname5"></span> was a superhero, what would <span class="pronoun">her</span>tagline be?</h2>
						</div>
					</div>-->
				</div><!-- /sl-slider -->
				
				<nav class="nav-arrows">
					<span class="nav-arrow-prev">Previous</span> 
					<span class="nav-arrow-next">Next</span>
				</nav>

				<nav id="nav-dots" class="nav-dots">
					<span class="nav-dot-current"></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<!--<span></span>-->
				</nav>

			</div><!-- /slider-wrapper -->
		</div>
      	
		<script src="js_1/jquery-1.11.1.min.js"></script>
		<script src="js_1/ion.rangeSlider.js"></script>
		<script type="text/javascript" src="js_1/jquery.ba-cond.min.js"></script>
		<script type="text/javascript" src="js_1/jquery.slitslider.js"></script>
		<script type="text/javascript">	
			$(function() {
				
				$("#dog_age_text").ionRangeSlider({
            hide_min_max: true,
            keyboard: true,
            min: 1990,
            max: 2016,
            from: 50,
            
            type: 'single',
            step: 1,
            prefix: "",
            grid: true
        });

				$("#go_next").click(function(){
				$(".nav-arrow-next").click(); 
				return false;
			});
			
				$("#go_prev").click(function(){
					document.location = "home.php"; 
				});
		
			
			
			$("#selBreed").change(function(){
				$(".nav-arrow-next").click(); 				
				$("#dogbreed").val($('#selBreed').val());
				return false;
			});
			
			$("#selmonth").change(function(){
			$("#dogMonth").val($('#selmonth').val());
				return false;
			});
			
			$("#seldate").change(function(){
			$("#dogdate").val($('#seldate').val());
				return false;
			});
			
			
			
			$("#dog_age_text").change(function(){
				//$(".nav-arrow-next").click();
				age_value = $("#dog_age_text").val();				
				$("#dogbirth").val(age_value);
				//return false;
			});		
			
			$("#dog_male").click(function(){
				
				    $("#doggender").val("Male");
				$(".nav-arrow-next").click(); 
				return false;
			});
			
			$("#dog_female").click(function(){
				
				    $("#doggender").val("Female");
				$(".nav-arrow-next").click(); 
				return false;
			});
				
				var Page = (function() {

					var $navArrows = $( '.nav-arrows' ),
						$nav = $( '#nav-dots > span' ),
						slitslider = $( '#slider' ).slitslider( {
						
							onBeforeChange : function( slide, pos ) {
								
								if(pos == 5)
								{		
									$('.nav-arrow-next').hide();
								}
								
								if(pos == 2)
								{
									$("#dogname1").text($('#txtname').val());
									if($('.in-text').val()=="")
									{
										alert("please enter dog name");
										$(".nav-arrow-prev").click(); 
										return false;
										
									}
									
									}
								else if(pos == 3)
								{
									$("#dogname2").text($('#txtname').val());
								}
								else if(pos == 4)
									{
										$("#dogname3").text($('#txtname').val());
										$( "#dog_location" ).text($('#locate').val());
									}
									
									
								
								$("#dogname4").text($('#txtname').val());
								$("#dog_name").val($('#txtname').val());
								$("#dogname5").text($('#txtname').val());
								$nav.removeClass( 'nav-dot-current' );
								$nav.eq( pos ).addClass( 'nav-dot-current' );
								
							}
						} ),

						init = function() {

							initEvents();
							
						},
						initEvents = function() {

							// add navigation events 
							$navArrows.children( ':last' ).on( 'click', function() {
							
								slitslider.next();
								return false;

							} );

							$navArrows.children( ':first' ).on( 'click', function() {
								
								slitslider.previous();
								return false;

							} );

							$nav.each( function( i ) {
							
								$( this ).on( 'click', function( event ) {
									
									var $dot = $( this );
									
									if( !slitslider.isActive() ) {

										$nav.removeClass( 'nav-dot-current' );
										$dot.addClass( 'nav-dot-current' );
									
									}
									
									slitslider.jump( i + 1 );
									return false;
								
								} );
								
							} );

						};

						return { init : init };

				})();

				Page.init();

				/**
				 * Notes: 
				 * 
				 * example how to add items:
				 */

				/*
				
				var $items  = $('<div class="sl-slide sl-slide-color-2" data-orientation="horizontal" data-slice1-rotation="-5" data-slice2-rotation="10" data-slice1-scale="2" data-slice2-scale="1"><div class="sl-slide-inner bg-1"><div class="sl-deco" data-icon="t"></div><h2>some text</h2><blockquote><p>bla bla</p><cite>Margi Clarke</cite></blockquote></div></div>');
				
				// call the plugin's add method
				ss.add($items);

				*/
			
			});
		
	
</script>
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script> 
<script type="text/javascript"> 
 var geocoder;


// Get the latitude and the longitude;
function successFunction(position) {
  var lat = position.coords.latitude;
  var lng = position.coords.longitude;
  //alert(lat);
  //alert(lng);
  codeLatLng(lat, lng);
}

function errorFunction() {
  alert("Geocoder failed");
}

function initialize() {
  geocoder = new google.maps.Geocoder();
if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
}
}

function codeLatLng(lat, lng) {
  var latlng = new google.maps.LatLng(lat, lng);
  geocoder.geocode({latLng: latlng}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[1]) {
        var arrAddress = results;
        console.log(results);
        $.each(arrAddress, function(i, address_component) {
          if (address_component.types[0] == "locality") {
            console.log("City: " + address_component.address_components[0].long_name);
			$( "#dog_location" ).html(address_component.address_components[0].long_name);
			$( "#doglocation" ).val(address_component.address_components[0].long_name);
			
			
            itemLocality = address_component.address_components[0].long_name;
          }
        });
      } else {
        alert("No results found");
      }
    } else {
      alert("Geocoder failed due to: " + status);
    }
  });
}

jQuery(document).on('click','[data-toggle*=modal]',function(){
  jQuery('[role*=dialog]').each(function(){
    switch(jQuery(this).css('display')){
      case('block'):{jQuery('#'+jQuery(this).attr('id')).modal('hide'); break;}
    }
  });
});
</script> 
		<!-- All amey form variables here-->
		
		<form id="final_form" method="POST" action="post.php">
			<input type="hidden" name="dog_name" id="dog_name">
			<input type="hidden" name="doggender" id="doggender">
			<input type="hidden" name="dogbreed" id="dogbreed">
			<input type="hidden" name="dog_age" id="dogbirth">
			<input type="hidden" name="dogmonth" id="dogMonth">
			<input type="hidden" name="dogdate" id="dogdate">
			<input type="hidden" name="doglocation" id="doglocation">
					
							<div class="modal fade" id="myModal" role="dialog">
								<div class="modal-dialog">								
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal">&times;</button>
									  <h4 class="modal-title">Create Account</h4>
									</div>
									<div class="modal-body">
										Already have an account <button type="button" class="btn btn-primary" data-toggle="modal" data-dismiss="modal" data-target="#myModal1">Login</button>
										
										<div class="form-group">
											<label for="Name">Name:</label>
											<input type="text" name="name" class="form-control" id="name">
										</div>
										<div class="form-group">
											<label for="email">Email:</label>
											<input type="email" name="email" class="form-control" id="email">
										</div>
										<div class="form-group">
											<label for="mobile">Mobile:</label>
											<input type="mobile" name="mobile" class="form-control" id="mobile">
										</div>
										<div class="form-group">
											<label for="Password">Password:</label>
											<input type="password" name="password" class="form-control" id="password">
										</div>
										
										<div class="form-group">
											<input type="submit" value="submit" name="submit1" class="btn btn-primary" id="name"/>
										</div>
									</div>
									
								</div>
								  
								</div>
							</div>
							
							<div class="modal fade" id="myModal1" role="dialog">
								<div class="modal-dialog">								
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal">&times;</button>
									  <h4 class="modal-title">Log IN</h4>
									</div>
									<div class="modal-body">

										<div class="form-group">
											<label for="email">Email:</label>
											<input type="email" name="email1" class="form-control" id="email1">
										</div>
										<div class="form-group">
											<label for="Password">Password:</label>
											<input type="password" name="password1" class="form-control" id="password1">
										</div>
										
										<div class="form-group">										
										<input type="submit" name="submit1" value="submit" class="btn btn-primary" class="form-control" id="name">
										</div>																			
									</div>
									
								</div>
								  
								</div>
							</div>
		</form>
	</body>
</html>