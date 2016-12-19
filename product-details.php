<?php
	include_once('header_prod.php');	
	include_once('config/config.php');
	$product_id = $_GET["product_id"];
	$sql = "SELECT id,plan_name,category_id,description,brand_id,rate_title,rate,offer,image,related_product_id, service_id FROM tbl_service_plans WHERE id = '$product_id'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	$new_price=$row["rate"]*$row["offer"]/100;
		
 ?>
<style>
	 .btn
	{
		font-size: 18px;
	}
	.form-control
	{
		width:50px;
		float:left;
	} 
	.btn-default
	{
		float:left;
	}
	ul
	{
		text-align: left !important;
		list-style-type: square !important;
	}
	li
	{
		color:#717b82 !important;
	}
	.blog-outer .blog-status li {
    color: #000;
    display: ;
    font-size: 18px;
    padding: 0 1px;
}
</style> 
<!-- HEADER END --> 
<section id="blog-outer" class="blog-outer">
	<div class="container">
		<div class="row"> 
		<!-- Blog Left Part --> 
			<div class="col-md-9"> 
			<!-- Blog 1 Image Post-->                        	 
				<div class="container blog-status">
					
					<!-- Product main -->  
						<div class="row"> 
								<div class="col-md-4">
								
								<img id="zoom_01" src="<?php echo $row["image"]; ?>" data-zoom-image="product/large/p-1.jpeg">
								<!--	Category Begins -->
					 
								</div>
								
								<div class="col-md-8 food">
									<div class="row">
										<div class="col-md-12">
											<h1 style="line-height:30px !important;"><?php echo $row["plan_name"]; ?></h1>
										</div>
									</div>										
												
									<div class="row brand">
										<div class="col-md-12">
											Brand: <a href="#">Solid Gold Pet Products</a>
										</div>													
										<div class="col-md-12">
													Availability: <span> In Stock </span>
												</div>
										</div>												
										<div class="row">
											<div class="col-md-12 product-price">
												<span>Rs.<span id="rate"><?php echo $row["rate"]; ?></span><span id="rate1" style="display:none;"></span></span>
											</div>
										</div>
										 <?php $sql_pack = "SELECT id,pack,rate as pack_rate FROM tbl_product_pack WHERE product_id = '".$product_id."'";
										  $result_pack = mysql_query($sql_pack);
										 $i = 0;
										$cnt = mysql_num_rows($result_pack);
										if($cnt > 0)
										{
											
									
										while($row_pack = mysql_fetch_array($result_pack))
										{
										if($i == 0)
										{	
											
											$id = $row_pack["id"];
											$pack_name = $row_pack["pack"];
											$pack_rate = $row_pack["pack_rate"];
										}
									 ?>						
										<div class="col-md-4" >
											<a class="thumbnail" <?php if($i==0) echo 'active1';?> onclick="Data('<?php echo $row_pack["id"]?>', '<?php echo $row_pack["pack_rate"]?>', '<?php echo $row_pack["pack"]?>', this)" style=" margin-left: -19px;" >
											<div class="border-bot supply"><?php echo $row_pack["pack"];?>

											<input type="hidden" name="pack" id="pack<?php echo $i;?>" value="<?php echo $row_pack["pack"]?>">

											</div>
											<p>Rs.<?php echo $row_pack["pack_rate"];?></p>
											<p>Free Shipping</p>
											</a>
										</div>
											<?php $i++; }   ?>
											<input type="hidden" name="selected_pack" id="selected_pack" value="<?php echo $row["plan_name"]; ?>">
									 <input type="hidden" name="selected_pack_rate" id="selected_pack_rate" value="<?php echo $pack_rate ?>">
									 <input type="hidden" name="selected_pack_name" id="selected_pack_name" value="<?php echo $pack_name ?>">
									 <?php
											
											
												} else {  ?>
													
													<input type="hidden" name="selected_pack" id="selected_pack" value="<?php echo $row["id"]; ?>">
									 <input type="hidden" name="selected_pack_rate" id="selected_pack_rate" value="<?php echo $row["rate"]; ?>">
									 <input type="hidden" name="selected_pack_name" id="selected_pack_name" value="<?php echo $row["plan_name"]; ?>">
										<?php		}?>
											
																
											<div style="clear:both;">
												<div class="row">
													<div class="col-md-4"> 
														<div class="form-group">
															  <label for="sel1">Quantity</label>
															  <div style="clear:both;">
															   												  
																  <input type="text" id="qty<?php echo $row["id"]?>" name="quant[1]" class="form-control input-number" value="1" min="1" max="50">
															  
															
														</div>
														</div>
													</div>
														
													<div class="col-md-8 but-top">
														
														<button type="button" class="btn btn-success" onclick="addToCart('<?php echo $row["plan_name"]; ?>', <?php echo $row["id"]?>, $('#qty<?php echo $row["id"]?>').val(), $('#selected_pack_rate').val(), $('#selected_pack').val(), $('#selected_pack_name').val(),  '<?php echo $row["service_id"]; ?>'); return false;"><i class="fa fa-shopping-cart" aria-hidden="true"></i>Add to Cart</button>
													</div>
												</div>
												</div>
												<div class="row">
												<div class="col-md-10">
												<p style="font-weight:bold;color:#000;">Description</p>
												<?php echo $row["description"];?>
												</div>
												</div>
										<div class="row">
		<?php $sql_details = "SELECT details,used_for,Color,Finish,rounded_rim,body_material,suitable_for,model_number,rubber_ring,Capacity,Weight,Height,Width,Depth,Pattern,size FROM tbl_product_details WHERE product_id = '$product_id'";
		$result_detials = mysql_query($sql_details);
		$row_details = mysql_fetch_array($result_detials);
						
		?>
		<div class="col-md-12" style="margin-top:50px;">
					<?php echo $row_details["details"];?>
		</div>
		</div>
								</div>	       
									</div> 
								</div>         <!-- Blog Left Part Ends -->  
					</div>         <!-- Blog Left Part Ends -->  
			
				<!-- Blog Right Part Begins -->  
			<div class="col-md-3">  
				<div class="sidebar side food">  
					<!-- Search Box Begins -->	
						<h1>Related Products</h1>
						<?php $related =  (explode(",",$row["related_product_id"]));
						for($i=0;$i<2;$i++) 
						{
							$sql_related = "SELECT id,image FROM tbl_service_plans WHERE id = '".$related[$i]."'";
							$result_related = mysql_query($sql_related);
							$row_related = mysql_fetch_array($result_related);
						?> 
							  
						
						<!-- Related Product Sidebar -->    
						<div data-animation-delay="300" data-animation="fadeInUp" class="twitter-feed animated fadeInUp visible"> 
							<div class="tweet"> 
								<img src="<?php echo $row_related["image"];?>"> 
								<a href="product-details.php?product_id=<?php echo$row_related["id"];?>"><button type="button" class="btn btn-success">Details</button></a>
							</div> 
						</div> 
						<?php } ?>						
							<!-- Related Product Sidebar Ends -->
							
					
						<!-- Archive Begins -->
						<div data-animation-delay="300" data-animation="fadeInUp" class="archives animated">
						
						<p><a href="#">Free Shipping <i class="flaticon-arrow209"></i></a></p>
						<p><a href="#">Hand-picked exclusive <i class="flaticon-arrow209"></i></a></p>
						<p><a href="#">Mentored<i class="flaticon-arrow209"></i></a></p>
						<p><a href="#">Auto-ship<i class="flaticon-arrow209"></i></a></p>
						</div>                            
						<!-- Archive Ends -->
				</div> 
			</div>  <!-- Blog Right Part Ends -->	
			
		</div>
		
		
	</div>
</section>
<?php  $sql = "SELECT id, service_id, plan_name,rate_title,rate FROM tbl_service_plans where id = '$id' ";
	$result =mysql_query($sql);
	$row = mysql_fetch_array($result)?>
    <div class="" id="add_to_cart" style="display:none">
		<div class="row border t-heading">
			<header class="h-text-align-center ">
					<h1 style="text-align: center;">
						<i class="fa fa-check"></i>	
					</h1>				
					<h2 style="text-align: center;" id="ajaxDiv">Item added to your cart</h2>
			</header>
     	</div>			
		<div class="row package border">
			<div class="col-sm-2 img_left">
				<img class="img-responsive" alt="" src="images/cart.jpg">
			</div>				
			<div class="col-sm-5">
				<h4 id="added_item"></h4>
			</div>
			<div class="col-sm-2">
				<p><h3 class="price" id="rate_title"></h3></p>
			</div>	
			<div class="col-sm-2">
				<p><h3 class="price" id="quality"></h3></p>
			</div>			
		</div>
		<div class="row border">
			<div class="col-sm-4 col-md-offset-2">
				<p><h3 class="price" id="pack_name"></h3></p>
			</div>				
			<div class="col-sm-2">
				<p><h3 class="price" id="pack_rate"></h3></p>
			</div>
		</div>
		<div class="row support border">		
			<div class="inner package">
				<label style="float:right; margin-right:100px;">
					<strong>Total :</strong>					
					<span class="item-upgrade__savings" id="total"></span>
				</label>
			</div>
		</div>
		<div class="row" style=" padding:20px; ">
					<a href="product.php"><button type="submit" id="close" name="Keep_Browsing" class="btn btn-primary-0" >Keep Browsing</button></a>  					
					<?php if(isset($_session["user_id"]))		{?>
					<a href="shopping-cart.php?user_id =<?php echo $_session["user_id"];?>"><button type="submit" name="Keep_Browsing" class="btn btn-primary-0" style="float:right;">Go to checkout</button></a>
					<?php }
					else
					{
						?><a href="shopping-cart.php?session_id=<?php echo $session_id;?>"><button type="submit" name="Keep_Browsing" class="btn btn-primary-0" style="float:right;">Go to checkout</button></a>
					<?php }?>
						
			</div>
			
   </div>
<!-- FOOTER -->  
<style>
	.active1
	{		
		background-color: #fff;
		border: 1px solid red;
		border-radius: 4px;
		display: block;
		line-height: 1.42857;
		margin-bottom: 20px;
		max-width: 99%;		
		transition: border 0.2s ease-in-out 0s;
	}	
</style>
<script language="javascript" type="text/javascript">
 function Data(id, rate, pack, el)
{               
	
	$('.thumbnail').removeClass('active1') ;
	$(el).addClass('active1') ;	
	$('#selected_pack').val(id);
	$('#selected_pack_rate').val(rate);
	$('#selected_pack_name').val(pack);	
	var content = document.getElementById("selected_pack_rate").value;
	$('#rate1').text(content);
   	$("#rate").hide();
	$("#rate1").show();
} 

function addToCart(package_name ,package_id, quantity,rate,pack_id, pack, service_id){
	/* if(pack_id == "")
	{
		alert("Please select the pack.");
		return false;
	} */
	
   var ajaxRequest;  // The variable that makes Ajax possible!
   try{
      ajaxRequest = new XMLHttpRequest();       // Opera 8.0+, Firefox, Safari
   }catch (e){
      
     try{
         ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");  // Internet Explorer Browsers
      }catch (e) {
         
         try{
            ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
         }catch (e){
         
            // Something went wrong
            alert("Your browser broke!");
            return false;
         }
      } 
   }    
   ajaxRequest.onreadystatechange = function(){
   
      if(ajaxRequest.readyState == 4){
         //var ajaxDisplay = document.getElementById('ajaxDiv' + package_id);
         var current_quantity = ajaxRequest.responseText;
		 	
		$('#total_quantity').text(current_quantity);
		$('#added_item').text(package_name);
		$('#rate_title').text(rate);
		$('#quality').text(quantity);
		$('#total').text(rate*quantity);
		$('#pack_name').text(pack);		
		
		$("#add_to_cart").dialog({ 
			width: "45%",
			maxWidth: "600px"
		});		
	}
   }
   
   // Now get the value from user and pass it to
   // server script.
  
   var queryString = "?package_id=" + package_id + "&quantity=" + quantity + "&rate=" + rate+ "&pack_id=" + pack_id + "&service_id=" + service_id;
   
   ajaxRequest.open("GET", "addtocart.php" + queryString, true);
   ajaxRequest.send(null); 
}
//-->


$('.btn-number').click(function(e){ 
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
</script>

<script src='zoom/jquery.elevatezoom.js'></script>
								
<script>
$('#zoom_01').elevateZoom({
zoomType: "inner",
cursor: "crosshair",
zoomWindowFadeIn: 500,
zoomWindowFadeOut: 750
}); 
</script>
	<?php include_once('footer.php'); ?>
 
<!-- FOOTER END -->		