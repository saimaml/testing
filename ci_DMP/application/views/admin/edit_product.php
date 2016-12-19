<?php

	$this->load->view('admin/header');
	$this->load->view('admin/left_side');

	$con=mysqli_connect("172.31.20.191","root","vistart3","DMP");
	$sql_main_cat = "SELECT id,main_category FROM tbl_product_main_cat";
	$result_main_cat = mysqli_query($con,$sql_main_cat);

	$sql_sub_cat = "SELECT id,catogories_name FROM tbl_product_category";
	$result_sub_cat = mysqli_query($con,$sql_sub_cat);
	
	$sql_brand = "SELECT id,brand_name FROM tbl_product_brand";
	$result_brand = mysqli_query($con,$sql_brand);	
	
	$sql_breed = "SELECT breed_id,breed_name from tbl_breed";
	$result_breed = mysqli_query($con,$sql_breed);
	
	$sql_weight = "SELECT id,weight_name FROM tbl_pet_weight";
	$result_weight = mysqli_query($con,$sql_weight);
	
	$sql_color = "SELECT id,color_nm FROM tbl_color";
	$result_color = mysqli_query($con,$sql_color);
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<div class="content-wrapper">

<section class="content-header">
	<h1>Edit Product </h1>
</section>
<!-- Main content -->
<section class="content">

	<?php foreach($posts as $results){   ?>
	<?php echo form_open_multipart("welcome/edit_product1"); ?>
	<div class="row">
	<div class="col-xs-8">
		<div class="box box-warning">
		<div class="box-header">  <?php echo validation_errors(); ?>          </div>
		<div class="box-body">
			<div class="form-group">
				<label for="category_id" class="col-sm-4 control-label">Main Category </label>
				<div class="col-sm-8">
				<select id="main_category_id" name="main_category_id" class="form-control">				
					<?php $sql_main_cat_select = "SELECT id,main_category FROM tbl_product_main_cat";
					$result_main_cat_select = mysqli_query($con,$sql_main_cat_select);
					$row_main_cat_select = mysqli_fetch_array($result_main_cat_select);	?>

					<option value="<?php echo $row_main_cat_select["id"]; ?>"><?php echo $row_main_cat_select["main_category"]; ?></option>
					<?php while($row_main_cat = mysqli_fetch_array($result_main_cat))
							{ ?>
						<option value="<?php echo $row_main_cat["id"]; ?>"><?php echo $row_main_cat["main_category"]; ?></option>
							<?php  }  ?>	
				</select>
				</div>
			</div>	<br/><br/>	
			<div class="form-group">
				<label for="category_id" class="col-sm-4 control-label">Sub Category</label>
				<div class="col-sm-8">							
					
					<?php $sql_sub_cat_select = "SELECT id,catogories_name FROM tbl_product_category WHERE id = '$results->category_id'";
						$result_sub_cat_select = mysqli_query($con,$sql_sub_cat_select);
						$row_sub_cat_select = mysqli_fetch_array($result_sub_cat_select);
					?>
					
					<select id="category_id" name="category_id" class="form-control">
					<option value="<?php  echo $row_sub_cat_select['id']; ?>"><?php echo $row_sub_cat_select['catogories_name']; ?></option>
					<?php while($row_sub_cat = mysqli_fetch_array($result_sub_cat))
					{ ?>
				<option value="<?php echo $row_sub_cat["id"]; ?>"><?php echo $row_sub_cat["catogories_name"]; ?></option>
					<?php   }  ?>									 								 
					</select> 
				</div>
			</div>	<br/><br/>	
			<div class="form-group">
				<label for="pet_type_id" class="col-sm-4 control-label">Pet Type </label>
				<div class="col-sm-8">											
					<select id="pet_type_id" name="pet_type_id" class="form-control">
					  <option value="1">Dog</option>
					  <option value="2">Cat</option>
					  <option value="1,2">Dog & Cat</option>					 
					</select> 					
				</div>
			</div>	<br/><br/>	
					<div class="form-group">
						<label for="plan_name" class="col-sm-4 control-label">Product Name</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="plan_name" name="plan_name" placeholder="Enter Product Name" value="<?php echo $results->plan_name;?>" required/>
						</div>
					</div><br/>				
					<div class="form-group">
						<label for="description" class="col-sm-4 control-label">Description</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="<?php echo $results->description;?>" required/>
						</div>
					</div><br/>								
					<div class="form-group">
						<label for="rate" class="col-sm-4 control-label">Rate</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="rate" name="rate" placeholder="Enter Rate" value="<?php echo $results->rate;?>" required/>
						</div>
					</div>	<br/>						
					<div class="form-group">
						<label for="offer" class="col-sm-4 control-label">Offer</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="offer" name="offer" placeholder="Enter Offer" value="<?php echo $results->offer;?>" required/>
						</div>
					</div>	<br/>
					<div class="form-group">
						<label for="brand_id" class="col-sm-4 control-label">Brand ID</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="brand_id" name="brand_id" placeholder="Enter Brand ID" value="<?php echo $results->brand_id;?>" required/>
							<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $results->id;?>"/>
						</div>
					</div>	<br/><br/>
					<div class="form-group">
						<label for="image" class="col-sm-4 control-label">Product Image</label>
						
						<div class="col-sm-8">
						<?php $img = explode(",",$results->image);
								for($i=0;$i<count($img);$i++)
								{   ?>
									<img style="width: 100%;" src="<?php echo $img[$i];?>"/>
							<?php	}
						?>
						
							<input type="file" multiple="true" class="form-control" id="userfile" name="userfile"/><!--<div id="imagePreview" ></div>-->
						</div>						
					</div>	<br/>
					<div class="form-group">
						<label for="brand_id" class="col-sm-4 control-label">Product Details</label>
						<div class="col-sm-8">
							<textarea name="details" class="form-control" placeholder="Message goes here"><?php echo $results->details;?></textarea>
						</div>
					</div>	<br/>							<br/>
				<div class="form-group">
						<label for="Stock" class="col-sm-4 control-label">Stock</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="stock" name="stock" placeholder="Enter Stock" value="<?php echo $results->stock;?>" required/>
						</div>
					</div>	<br/><br/>	
					<?php $sql_attribute = "SELECT weight_id,size_name,price,img FROM tbl_product_attribute WHERE product_id = '$results->id' and weight_id != '0'"; 
					$result_attributer = mysqli_query($con,$sql_attribute);
						if(mysqli_num_rows($result_attributer) > 0)
						{ ?>
							<div class="form-group">
							<label for="brand_id" class="col-sm-4 control-label">Product Weight Attribute</label>
							<div class="col-sm-8">
							<input type="radio" onchange="select_attr('Weight');" name="weight_attribute" value="Weight" checked />Yes 
							
								<input type="radio" onchange="select_attr('No');" name="weight_attribute" value="Size"/>No
								
								</div>
						</div>	<br/><br/> 
						<div class="form-group" id="all_weight" style="display:block;">
							<div class="col-sm-8">
							<?php while($row_weight = mysqli_fetch_array($result_weight))
							{
								$sql_atr_select = "SELECT weight_id,size_name,price,img FROM tbl_product_attribute WHERE weight_id = '".$row_weight['id']."' ";
								$result_atr_select = mysqli_query($con,$sql_atr_select);
								$row_select_atr = mysqli_fetch_array($result_atr_select);
								if(mysqli_num_rows($result_atr_select) > 0)									
								{
									?> <input type="checkbox"  checked name="weight_id[]" id="weight_id<?php echo $row_weight['id'] ?>" value="<?php echo $row_weight['id'] ?>"><?php echo $row_weight['weight_name'] ?>
								
								<input type="text" id="size<?php echo $row_weight['id'] ?>" name="size_w[]" placeholder="Enter size" value="<?php echo $row_select_atr["size_name"] ; ?>" />
								<input type="text" id="price<?php echo $row_weight['id'] ?>" placeholder="Enter price"  value="<?php echo $row_select_atr["price"] ; ?>" name="price_w[]"  />
								<input type="file" multiple="" id="userfile<?php echo $row_weight['id'] ?>" name="userfile_att[]" />
								 
							   <script type="text/javascript">
									$(function () {
										$("#weight_id<?php echo $row_weight['id'] ?>").click(function () {
											if ($(this).is(":checked")) {
												$("#size<?php echo $row_weight['id'] ?>").removeAttr("disabled");
												$("#price<?php echo $row_weight['id'] ?>").removeAttr("disabled");
												$("#userfile<?php echo $row_weight['id'] ?>").removeAttr("disabled");
												$("#size<?php echo $row_weight['id'] ?>").focus();
												$("#price<?php echo $row_weight['id'] ?>").focus();
												$("#userfile<?php echo $row_weight['id'] ?>").focus();
											} else {
												$("#size<?php echo $row_weight['id'] ?>").attr("disabled", "disabled");
												$("#price<?php echo $row_weight['id'] ?>").attr("disabled", "disabled");
												$("#userfile<?php echo $row_weight['id'] ?>").attr("disabled", "disabled");
											}
										});
										
									});
								</script>
								<br/>
								<br/>
									<?php  }
									else
									{
									?> <input type="checkbox"  name="weight_id[]" id="weight_id<?php echo $row_weight['id'] ?>" value="<?php echo $row_weight['id'] ?>"><?php echo $row_weight['weight_name'] ?>
								
								<input type="text" id="size<?php echo $row_weight['id'] ?>" name="size_w[]" placeholder="Enter size" disabled="disabled" />
								<input type="text" id="price<?php echo $row_weight['id'] ?>" placeholder="Enter price"  name="price_w[]"  disabled="disabled" />
								<input type="file" multiple="" disabled="disabled" id="userfile<?php echo $row_weight['id'] ?>" name="userfile_att[]" />
								 
								   <script type="text/javascript">
									$(function () {
										$("#weight_id<?php echo $row_weight['id'] ?>").click(function () {
											if ($(this).is(":checked")) {
												$("#size<?php echo $row_weight['id'] ?>").removeAttr("disabled");
												$("#price<?php echo $row_weight['id'] ?>").removeAttr("disabled");
												$("#userfile<?php echo $row_weight['id'] ?>").removeAttr("disabled");
												$("#size<?php echo $row_weight['id'] ?>").focus();
												$("#price<?php echo $row_weight['id'] ?>").focus();
												$("#userfile<?php echo $row_weight['id'] ?>").focus();
											} else {
												$("#size<?php echo $row_weight['id'] ?>").attr("disabled", "disabled");
												$("#price<?php echo $row_weight['id'] ?>").attr("disabled", "disabled");
												$("#userfile<?php echo $row_weight['id'] ?>").attr("disabled", "disabled");
											}
										});
										
									});
								</script>
								<br/>
								<br/>
									<?php
									}
								
								?>
									<?php } ?>
										</div>					
						</div>						
						
						<?php }  
						else
						{  ?>
							<div class="form-group">
							<label for="brand_id" class="col-sm-4 control-label">Product Wight Attribute</label>
							<div class="col-sm-8">
							<input type="radio" onchange="select_attr('Weight');" name="weight_attribute" value="Weight"  />Yes 
							
								<input type="radio" checked onchange="select_attr('No');" name="weight_attribute" value="Size"/>No
								
								</div>
						</div>	<br/><br/> 
						<?php  }   ?>
						
					<?php $sql_attribute_size = "SELECT weight_id,size_name,price,img FROM tbl_product_attribute WHERE product_id = '$results->id' and weight_id = '0'"; 
					$result_attribute_size = mysqli_query($con,$sql_attribute_size);  
					if(mysqli_num_rows($result_attribute_size) > 0)
						{ ?>
						<div class="form-group">
							<label for="brand_id" class="col-sm-4 control-label">Product Size Attribute</label>
							<div class="col-sm-8">
								<input type="radio" checked onchange="select_attr_size('Size');" name="size_attribute" value="Size"/>Yes 
								<input type="radio" onchange="select_attr_size('No');" name="size_attribute" value="Size"/>No
							</div>
						</div>	<br/><br/>	
						 <div class="form-group" id="all_size" style="display:block;">
							<label for="brand_id" class="col-sm-4 control-label">How many Size</label>
							<input type="text" id="size" name="size_count" value="<?php echo mysqli_num_rows($result_attribute_size); ?>" placeholder="Enter textbox want" onkeyup="add_text();" />
							
							<div id="size_box">
							<?php while($row_attribute_size = mysqli_fetch_array($result_attribute_size))
							{  ?>
								<input name="size[]" placeholder="Enter Size" type="text" value="<?php echo $row_attribute_size['size_name']; ?>">
								<input name="price_s[]" placeholder="Enter Price" type="text" value="<?php echo $row_attribute_size['price']; ?>">
						<?php 	}  ?>
							
							</div>
						</div>
						<?php  }   else  
						{   ?>
							<div class="form-group">
							<label for="brand_id" class="col-sm-4 control-label">Product Size Attribute</label>
							<div class="col-sm-8">
								<input type="radio" onchange="select_attr_size('Size');" name="size_attribute" value="Size"/>Yes 
								<input type="radio" checked onchange="select_attr_size('No');" name="size_attribute" value="Size"/>No
							</div>
						</div>	<br/><br/>	
						 <?php   }  ?>				 
						 
						 
						 <?php $sql_attr_color = "SELECT color_id FROM tbl_product_color WHERE product_id = '$results->id'";
						 $result_attr_color = mysqli_query($con,$sql_attr_color);
						 if(mysqli_num_rows($result_attr_color) > 0)
						 {  ?>
						 <div class="form-group">  
							<label for="brand_id" class="col-sm-4 control-label">Product Color Attribute</label>
							<div class="col-sm-8">
							 <input type="radio" checked onchange="select_attr_color('Color');" name="color_attribute" value="Color"/>Yes 
							<input type="radio" onchange="select_attr_color('No');" name="color_attribute" value="Size"/>No
								</div>
					</div>	<br/><br/>	
						<div class="form-group" id="all_color" style="display:block;">
						<?php 
						
						while($row_color = mysqli_fetch_array($result_color))
						{						
								 $sql_color_select = "SELECT id,color_id FROM tbl_product_color WHERE color_id LIKE '%".$row_color['id']."%'";
								$result_color_select = mysqli_query($con,$sql_color_select); 
								
								if(mysqli_num_rows($result_color_select) > 0)
								{
									?><input type="checkbox" checked name="color[]" value="<?php echo $row_color['id']; ?>" /><?php echo $row_color['color_nm']; 
								}
								else
								{ ?>
									<input type="checkbox"  name="color[]" value="<?php echo $row_color['id']; ?>" /><?php echo $row_color['color_nm']; ?>
									
								<?php  }							
							
						 } ?>
							
							
						</div>
							 
						 <?php  }  else
						 {  ?>
					 <div class="form-group">  
						<label for="brand_id" class="col-sm-4 control-label">Product Color Attribute</label>
						<div class="col-sm-8">
							 <input type="radio" onchange="select_attr_color('Color');" name="color_attribute" value="Color"/>Yes 
							<input type="radio" checked onchange="select_attr_color('No');" name="color_attribute" value="Size"/>No
								</div>
					</div>	<br/><br/>	
						 <?php     }		 ?>
						 
					
							
					
						
			
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Submit</button>
							</div>
						</div>	
					</div>
		</div>
	</div>
	</div>						
	<?php echo form_close();   }  ?>


</section><!-- /.content -->

</div>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script> 
<script>
function myFunction() {
    var x = document.getElementById("main_category_id").value;
	$.ajax({
            url : "<?php echo base_url(); ?>index.php/welcome/get_sub_cat", // my controller :<?php echo base_url(); ?>admin/order/new_order
            method: "POST",
            data: "id="+x,
            success: function(response) {
                 $("#div1").html(response);
            }
      })  
}
function select_attr(att)
{
	if(att =="Weight")
	{
		$('#all_weight').show();
	}
	else if(att =="No")
	{
		$('#all_weight').hide();
		
	}
}
function select_attr_size(att)
{
	if(att =="Size")
	{
		$('#all_size').show();
	}
	else if(att =="No")
	{
		$('#all_size').hide();
		
	}
}
function select_attr_color(att)
{
	if(att =="Color")
	{
		$('#all_color').show();
	}
	else if(att =="No")
	{
		$('#all_color').hide();
		
	}
}
 function add_text()
{
	 var val = document.getElementById("size").value;
	
	var s= "";
    for(var i = 1; i <= val; i++) {
		  
        s+= '<input type="text" name="size[]" placeholder="Enter Size">'; //Create one textbox as HTML
        s+= '<input type="text" name="price_s[]" placeholder="Enter Price">'; //Create one textbox as HTML
    }
    document.getElementById("size_box").innerHTML=s;
    

} 
</script>


<?php 
	$this->load->view('admin/footer');
?>