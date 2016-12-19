<?php
session_start();
include_once('config/config.php'); 

$condition=$_REQUEST['q'];
//build query

$query_cate = "select id,catogories_name from tbl_product_category where condition_id = '".$condition."'";
$result_cate = mysql_query($query_cate);
while($row_cate = mysql_fetch_array($result_cate))
{			
	?> <div id="delete_response" class="container pet-r" >
	   <h2><?php echo $row_cate["catogories_name"]; ?></h2>
	    <div class="row">
		<?php 
		$query = "select * from tbl_service_plans where  category_id= '".$row_cate['id']."'";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
		{    ?>
			<div class="col-md-3 col-sm-3 productdiv" id="product<?php echo $row["id"]; ?>" >
				<a href="product-details.php?product_id=<?php echo $row["id"]; ?>" class="thumbnail">
					<?php if($row["offer"]!=0) {   ?>
					<img src="images/offer1.png" style="margin-left: 65px;"><span class="offer_pro">Save <?php echo $row["offer"];?>%</span>
					<?php } else   {?>											
						<p></p>		
					<?php } ?>			
					<img src="<?php echo $row["image"]; ?>" alt="Pulpit Rock" style="width:150px;height:150px"/>
									
					<div class="border-bot size">
						<?php echo $row["plan_name"]; ?>
					</div>
					<div class="pu-discount fk-font-11">
						<!--<img src="images/star.png">-->
					</div>										
					<div class="amount">
					 <?php if($row["offer"]!=0) {   ?>
					<span class="pu-old"> Rs. <?php echo $row["rate"];?></span>
							<?php echo  'Rs '.($row["rate"]-$new_price); ?>
					</div>			
					<?php } else   {?>	
					
					<?php echo  'Rs '.($row["rate"]); ?>
					</div>			

					<?php } ?>										
					<div class="productpanel" id="panel" style="display:none;">
					njkfjkdgdfjgfdjgdjfgjfdkhgjfgjkhgjfhgjdfhgjfhgjk
					
					</div>
				</a>
			</div>
		<?php  }   ?>
		
		
			
		</div>
		</div>
<?php }    ?>