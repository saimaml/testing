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
	
	$sql_vendor = "SELECT id,name FROM tbl_vendor";
	$result_vendor = mysqli_query($con,$sql_vendor);	
	
	$sql_breed = "SELECT breed_id,breed_name from tbl_breed";
	$result_breed = mysqli_query($con,$sql_breed);
	
	$sql_weight = "SELECT id,weight_name FROM tbl_pet_weight";
	$result_weight = mysqli_query($con,$sql_weight);
	
	$sql_color = "SELECT id,color_nm FROM tbl_color";
	$result_color = mysqli_query($con,$sql_color);
	
?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/common.js"></script>

<div class="content-wrapper">

<section class="content-header">
	<h1>Add Product  </h1>
</section>

        <!-- Main content -->
        <section class="content">
		<?php echo form_open_multipart("welcome/add_product1"); ?>
			<div class="row">
			<div class="col-xs-10">
				<div class="box box-warning">
					<div class="box-header">  <?php echo validation_errors(); ?>          </div>				
					<div class="box-body">
						<div class="form-group">								
							<input type="hidden" class="form-control" id="service_id" name="service_id" placeholder="Enter service id" value="2" required/>
						</div>	
						<div class="form-group">
							<label for="category_id" class="col-sm-4 control-label">Main Category </label>
							<div class="col-sm-8">
							<select id="main_category_id" name="main_category_id" class="form-control" onchange="myFunction()">
							<option  value="-1">Select Main Category</option>
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
								
								<select name="category_id" class="form-control" id="div1" >
								<option  value="-1">Select Sub Category</option>
							</select>
							<span ></span>
							</div>
						</div>	<br/><br/>	
						<div class="form-group">
							<label for="category_id" class="col-sm-4 control-label">Breed</label>
							<div class="col-sm-8">									
							<select id="breed_id" name="breed_id" class="form-control">
							<option  value="0">Select Breed</option>
							<option  value="All">All</option>
								<?php while($row_breed = mysqli_fetch_array($result_breed))
										{ ?>
									<option value="<?php echo $row_breed["breed_id"]; ?>"><?php echo $row_breed["breed_name"]; ?></option>
										<?php  }  ?>	
							</select>
							<span ></span>
							</div>
						</div>	<br/><br/>	
						<div class="form-group">
							<label for="pet_type_id" class="col-sm-4 control-label">Pet Type </label>
							<div class="col-sm-8">
								<!--<input type="text" class="form-control" id="pet_type_id" name="pet_type_id" placeholder="Enter Pet ID" required/>-->
								
								 <select id="pet_type_id" name="pet_type_id" class="form-control">
								  <option value="1">Dog</option>
								  <option value="2">Cat</option>
								  <option value="1,2">Dog & Cat</option>
								 
								</select> 
								
							</div>
						</div>		<br/><br/>	
						<div class="form-group">
							<label for="vendor_id" class="col-sm-4 control-label">Vendor Name </label>
							<div class="col-sm-8">
							
								
								 <select id="vendor_id" name="vendor_id" class="form-control">
								  <?php while($row_vendor = mysqli_fetch_array($result_vendor))
										{ ?>
									<option value="<?php echo $row_vendor["id"]; ?>"><?php echo $row_vendor["name"]; ?></option>
										<?php  }  ?>
								 
								</select> 
								
							</div>
						</div>		<br/><br/>							
						<div class="form-group">
							<label for="plan_name" class="col-sm-4 control-label">Product /Brand Name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="plan_name" name="plan_name" placeholder="Enter Product Name" required/>
							</div>
						</div>	<br/><br/>	
						<div class="form-group">
							<label for="description" class="col-sm-4 control-label">Description</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" required/>
							</div>
						</div>	<br/><br/>
						<div class="form-group">
							<label for="rate" class="col-sm-4 control-label">Price (<span> <i class="fa fa-inr" aria-hidden="true"></i></span>)</label>
							<div class="col-sm-8">
								<input type="number" class="form-control" id="rate" name="rate" placeholder="Enter Rate" required/>
							</div>
						</div>	<br/><br/>
						<div class="form-group">
							<label for="offer" class="col-sm-4 control-label">Offer (%) </label>
							<div class="col-sm-8">
								<input type="number" class="form-control" id="offer" name="offer" placeholder="Enter Offer" />
							</div>
						</div>  <br/><br/>							
						<div class="form-group">
							<label for="image" class="col-sm-4 control-label">Product Image</label>
							<div class="col-sm-8">
								<input type="file" multiple="" class="form-control" id="userfile" name="userfile[]"/><!--<div id="imagePreview" ></div>-->
							</div>								
						</div>	<br/><br/>	
						<div class="form-group">
							<label for="brand_id" class="col-sm-4 control-label">Brand </label>
							<div class="col-sm-6">
								<!--<input type="text" class="form-control" id="brand_id" name="brand_id" placeholder="Enter Brand ID" required/>-->
								
								<select id="brand_id" name="brand_id" class="form-control">
								<?php while($row_brand = mysqli_fetch_array($result_brand))
								{ ?>
									<option value="<?php echo $row_brand["id"]; ?>"><?php echo $row_brand["brand_name"]; ?></option>
								<?php   }  ?>									 								 
								</select> 
								
							</div>
							<div class="col-sm-2">
								  <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal">Add Brand</button>
							</div>
						</div><br/><br/>	
						<div class="form-group">
							<label for="stock" class="col-sm-4 control-label">Stock </label>
							<div class="col-sm-8">
								<input type="number" class="form-control" id="stock" name="stock" placeholder="Enter Stock" required/>
							</div>
						</div>	<br/><br/>
						<div class="form-group">
							<label for="brand_id" class="col-sm-4 control-label">Product Details</label>
							<div class="col-sm-8">
								<textarea name="details" class="form-control" placeholder="Message goes here"></textarea>
							</div>
						</div>	<br/><br/>	
						<div class="form-group">
							<label for="brand_id" class="col-sm-4 control-label">Product Wight Attribute</label>
							<div class="col-sm-8">
								<input type="radio" onchange="select_attr('Weight');" name="weight_attribute" value="Weight"/>Yes 
								<input type="radio" onchange="select_attr('No');" name="weight_attribute" value="Size"/>No
							</div>
						</div>	<br/><br/>
						<div class="form-group" id="all_weight" style="display:none;">
							 <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
							<div class="col-sm-8">
							<?php while($row_weight = mysqli_fetch_array($result_weight))
							{
								?>
								<input type="checkbox" name="weight_id[]" id="weight_id<?php echo $row_weight['id'] ?>" value="<?php echo $row_weight['id'] ?>"><?php echo $row_weight['weight_name'] ?>
								
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
							<?php } ?>
							</div>
							<div id="place">
							</div>
						</div>	<br/><br/>	
						
						<div class="form-group">
							<label for="brand_id" class="col-sm-4 control-label">Product Size Attribute</label>
							<div class="col-sm-8">
								<input type="radio" onchange="select_attr_size('Size');" name="size_attribute" value="Size"/>Yes 
								<input type="radio" onchange="select_attr_size('No');" name="size_attribute" value="Size"/>No
							</div>
						</div>	<br/><br/>	
						<div class="form-group" id="all_size" style="display:none;">
							<label for="brand_id" class="col-sm-4 control-label">How many Size</label>
							<input type="text" id="size" name="size" placeholder="Enter textbox want" onkeyup="add_text();" />
							
							<div id="size_box">
							</div>
						</div>
						
						<div class="form-group">
						<label for="brand_id" class="col-sm-4 control-label">Product Color Attribute</label>
						<div class="col-sm-8">
							<input type="radio" onchange="select_attr_color('Color');" name="color_attribute" value="Color"/>Yes 
							<input type="radio" onchange="select_attr_color('No');" name="color_attribute" value="Size"/>No
						</div>
					</div>	<br/><br/>	
					<div class="form-group" id="all_color" style="display:none;">
						<?php while($row_color = mysqli_fetch_array($result_color))
						{
							?>
							<input type="checkbox"  name="color[]" value="<?php echo $row_color['id']; ?>" /><?php echo $row_color['color_nm']; ?>
						<?php } ?>
							
							<div id="size_box">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">Submit</button>
							</div>
						</div>	<br/><br/>			                   
					 </div>
				</div>
			</div>
			</div>
		<?php  echo form_close(); ?>
      </section><!-- /.content -->
	  
	   <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Brand</h4>
        </div>
        <div class="modal-body">
			<?php echo form_open('welcome/add_brand1/');?>
				<div class="form-group">
					<label for="Brand Name" class="col-sm-4 control-label">Brand Name</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="brand_name" name="brand_name" placeholder="Enter Brand Name" />
					</div>
				</div>  <br/><br/>	
				
        </div>
			
        <div class="modal-footer">
		<button type="submit" class="btn btn-default">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      <?php  echo form_close(); ?>
    </div>
  </div>
</div>
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


<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script> 
<?php 
$this->load->view('admin/footer');
?>

