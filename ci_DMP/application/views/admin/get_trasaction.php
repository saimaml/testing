<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');
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

            <h3 style="float:left;">Transaction Details</h3>

                <div class="box-body">

                 	 <table id="example" class="display table table-bordered table-striped">
						<thead>
							<tr>
								<th>ID </th>			
								<th>User Name</th>
								<th>Purchase Date</th>
								<th>Status</th>
								<th>View</th>
							</tr>
						</thead>
						<tbody>
					
						<?php $i=1; foreach($posts as $results){  ?>
						<tr>
						<td><?php echo $i;?></td>
						<td>									
									<?php 
									
						$aVar=mysqli_connect("172.31.20.191","root","vistart3","DMP");
						$sql_user = "SELECT name FROM app_users WHERE id = '$results->user_id'";
						$result_user = mysqli_query($aVar,$sql_user); 
						$row_user = mysqli_fetch_array($result_user);
									
									echo $row_user["name"];
									
									
									?></td>	
										<td><?php echo $results->date_purchase;?></td>	
									<td>
										<?php if($results->is_paid ==0)
											echo "Pending";
										else if($results->is_paid ==1)
											echo "Successfully";
										else if($results->is_paid==2)
											echo "Failed"; ?> </td>	
									

							<td><?php $attributes = array('target' => '_blank'); echo form_open("welcome/view_transaction",$attributes); ?>
									<input type="hidden" value="<?php echo $results->id;?>" name="id"/>
									<button class="btn btn-primary " type="submit" value="Submit">View Details</button>
								<?php echo form_close(); ?>
								
							</td>				
					</tr>
					<?php $i++;	}  ?>
					
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
