<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');

	$con=mysqli_connect("172.31.20.191","root","vistart3","DMP");
	$sql_sub_cat = "SELECT id,catogories_name FROM tbl_product_category";
	$result_sub_cat = mysqli_query($con,$sql_sub_cat);
?>
<style>
button, input, select, textarea {
  
    width: 120px;
}
.color
{
	list-style:none;
	
	width:20px;
	height:20px;	
}

</style>
<div class="content-wrapper">
<title>Product List</title><div style="width:100%;">
<!-- Main content -->

        <section class="content">
         <div class="row">
        <div class="col-xs-12">

        <div class="box box-primary">

          <div class="box-header">   
		  	<?php echo form_open("welcome/add_top_selling"); ?>
			<button type="submit" class="btn btn-default">Submit</button>

                <div class="box-body">
                 	 <table id="example" class="display table table-bordered table-striped">
						<thead>
							<tr>
								<th>ID</th>		 		
								<th>Vendor Name</th>	
								<th>Main Category </th>
								<th>Sub Category </th>							
								<th>Product / Brand Name</th>
								<th>Description</th>
								<th>Price <span> <i class="fa fa-inr" aria-hidden="true"></i></span></th>
								<th>Offer %</th>								
								<th>Company </th>
								<th>Show Product</th>
							</tr>
						</thead>

                    <tbody>
				

                  <?php $i=1;
				
					foreach($posts as $results){        ?>
                        <tr>

                            <td><?php echo $results->id;?></td>
							<td>
	<?php
	$sql_vendor_nm = "SELECT name FROM tbl_vendor WHERE id = '$results->vendor_id'";
	$result_vendor_nm = mysqli_query($con,$sql_vendor_nm);
	$row_vendor_nm = mysqli_fetch_array($result_vendor_nm);	
	echo $row_vendor_nm["name"] ;
	?>
</td>
<td>
	<?php
	$sql_main_cat = "SELECT main_category FROM tbl_product_main_cat WHERE id = '$results->main_category_id'";
	$result_main_cat = mysqli_query($con,$sql_main_cat);
	$row_main_cat = mysqli_fetch_array($result_main_cat);	
	echo $row_main_cat["main_category"] ;
	?>
</td>
<td>
	<?php
	$sql_sub_cat = "SELECT catogories_name FROM tbl_product_category WHERE id = '$results->category_id'";
	$result_sub_cat = mysqli_query($con,$sql_sub_cat);
	$row_sub_cat = mysqli_fetch_array($result_sub_cat);	
	echo $row_sub_cat["catogories_name"] ;
	?>
</td>
		     
<td><?php echo $results->plan_name;?></td>		     
<td style="width:100px;"><?php echo substr($results->description,0,25)." more...";?></td>		     
<td>Rs.<?php echo $results->rate;?></td>		     
<td><?php echo $results->offer;?></td>		     
	     
<td>
	<?php
	$sql_brand = "SELECT brand_name FROM tbl_product_brand WHERE id = '$results->brand_id'";
	$result_brand = mysqli_query($con,$sql_brand);
	$row_brand = mysqli_fetch_array($result_brand);	
	echo $row_brand["brand_name"] ;
	?>

</td>		     
	  
<td>
<?php if($results->top_selling_act =='1')
{  ?>
	<input type="checkbox" name="product[]" checked value="<?php echo $results->id;?>">
<?php  }  else  {   ?>
	<input type="checkbox" name="product[]" value="<?php echo $results->id;?>">
	
<?php } ?>
	
</td>

</tr>  
      
<?php $i++; }     ?> 
	<?php  echo form_close(); ?>
                </tbody>
				 

                </table>	  

                </div><!-- /.box-body -->

              </div>	

			</div>	

		</div>	

        </section><!-- /.content -->

	<!---->

	</div>

 </div>
 <?php 
$this->load->view('admin/footer');
?>
<script>
function select_attribute(x) {
    //var x = document.getElementsByClassName("attr_id").value;
	//alert(x);
	if(x ==1)
	{
		 $(".color123").show();
		 $(".price").show();
		 $(".size").hide();
	}
	else
	{
		$(".price").show();
		$(".size").show();
		$(".color123").hide();
		
	}
	
}
function edit_attribute(x) {
    //var x = document.getElementsByClassName("attr_id").value;
	//alert(x);
	if(x ==1)
	{
		 $(".color_edit").show();
		// $(".price_edit").show();
		 $(".size_edit").hide();
	}
	else
	{
	//	$(".price_edit").show();
		$(".size_edit").show();
		$(".color_edit").hide();		
	}	
}

</script>
<script>
function search_sub_cat() { 
    var x = document.getElementById("sub_category_search").value;
	
	$.ajax({
            url : "<?php echo base_url(); ?>index.php/welcome/search_sub_cat", // my controller :<?php echo base_url(); ?>admin/order/new_order
            method: "POST",
            data: "id="+x,
            success: function(response) {
                $("#div11").html(response);
            }
      })  
}


</script>