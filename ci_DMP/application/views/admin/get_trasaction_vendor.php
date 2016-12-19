<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');

	$aVar=mysqli_connect("172.31.20.191","root","vistart3","DMP");
	$sql_vendor_id = "SELECT user_id,vendor_id,cart_master_id FROM tbl_cart WHERE vendor_id !='0'";
	$result_vendor_id = mysqli_query($aVar,$sql_vendor_id); 

?>
<div class="content-wrapper">

<title>Transaction Details</title>

<div style="width:100%;">
<!-- Main content -->

        <section class="content">
         <div class="row">
        <div class="col-xs-12">

        <div class="box box-primary">

          <div class="box-header">

            <h3 style="float:left;">Product List</h3>

                <div class="box-body">

                 	 <table id="example" class="display table table-bordered table-striped">
						<thead>
							<tr>
								<th>ID </th>			
									<th>User Name</th>
									<th>Vendor Name</th>
									<th>Purchase Date</th>
									<th>Status</th>
									<th>View</th>
							</tr>
						</thead>

				<tbody id="update_cont">
							
	<?php $i=1; while($row_vendor_id = mysqli_fetch_array($result_vendor_id))
	{	

		$sql_master_id = "SELECT * FROM tbl_cart_master WHERE id = '".$row_vendor_id['cart_master_id']."'";
		$result_master_id = mysqli_query($aVar,$sql_master_id); 
		$row_master_id = mysqli_fetch_array($result_master_id);			?>
								<tr class="gradeX" id="list_data_tr<?php echo $row_master_id["id"];?>">
									<td><?php echo $i;?></td>	
									
									<td>									
									<?php 
									
						
						$sql_user = "SELECT name FROM app_users WHERE id = '".$row_vendor_id['user_id']."'";
						$result_user = mysqli_query($aVar,$sql_user); 
						$row_user = mysqli_fetch_array($result_user);
									
									echo $row_user["name"];
									
									
									?></td>	
									
									<td>								
									<?php 									
						
						$sql_vendor = "SELECT name FROM tbl_vendor WHERE id = '".$row_vendor_id['vendor_id']."'";
						$result_vendor = mysqli_query($aVar,$sql_vendor); 
						$row_vendor = mysqli_fetch_array($result_vendor);
									
									echo $row_vendor["name"];									
									
									?></td>	
									<td><?php echo $row_master_id["date_purchase"];?></td>	

									<td>
										<?php if($row_master_id["is_paid"] ==0)
											echo "Pending";
										else if($row_master_id["is_paid"] ==1)
											echo "Successfully";
										else if($row_master_id["is_paid"]==2)
											echo "Failed"; ?> </td>	
										<td><?php $attributes = array('target' => '_blank'); echo form_open("welcome/view_transaction",$attributes); ?>
									<input type="hidden" value="<?php echo $row_master_id["id"];?>" name="id"/>
									<button class="btn btn-primary " type="submit" value="Submit">View Details</button>
								<?php echo form_close(); ?>
								
							</td>	
																		
								</tr>
								<?php $i++; }  ?>  
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
