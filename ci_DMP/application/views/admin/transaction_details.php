<?php
$this->load->view('admin/header.php');
$this->load->view('admin/left_side.php');
?>
<div class="content-wrapper">

<title>Transaction List</title>
<div style="width:100%;">
 <!-- Content Header (Page header) -->
      
        <!-- Main content -->
        <section class="content">
						
         <div class="row">
		 	<div class="col-xs-6">
			
				<div class="box box-primary">
          <div class="box-header">
            <?php echo form_open("Admin/search_user"); ?>
            <div class="col-xs-12">
              <h3>Search Box....</h3>
            </div><br><br><br>
          	  <div class="col-xs-12">
                  <div class="form-group">
                    <label class="control-label">User Name</label>
                     <input type="text" name="name" class="form-control" placeholder="User Name!">
                    <ul class="txtbname dropdown-menu" style="margin-left:15px;margin-right:0px;cursor:pointer" role="menu" aria-labelledby="dropdownMenu"  id="Dropdownbname">
                  </div>
              </div>
              <div class="col-xs-12">
                  <div class="form-group">
                    <button  class="btn btn-info" type="submit" >Search</button>
                  </div>
              </div>
            <?php echo form_close(); ?>
          </div><!-- /.box-header -->
          </div>
          </div>

        <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-header">
            <h3 style="float:left;">User List</h3>
                <div class="box-body">
                 	 <table id="with_out_pagination" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Sr No</th>                                              
                        <th>User Name</th>                        
                        <th>Purchase Date</th>                        
                        <th>Status</th>
                        <th>View</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php $i=1;
                      foreach ($transactions as $row)
                      { 
                            ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $row->billing_name;?></td>
                            <td><?php echo $row->date_purchase;?></td>
							<?php if($row->is_paid == 1)  {   ?>  
							<td>Successfully</td>
							<?php  } elseif($row->is_paid == 2)   {  ?>
								
								<td>Failed</td>
								
							<?php   } else   {		?>
                          
                           <td>Pending</td>
						   	<?php   }	?>
							<td><?php echo form_open("Admin/transaction_details"); ?>
									<input type="hidden" value="<?php echo $row->id;?>" name="id"/>
									<button class="btn btn-primary " type="submit" value="Submit">View Details</button>
								<?php echo form_close(); ?>
							</td>
                        </tr>
                     <?php $i++; }
                  ?>
                </tbody>
                </table>	  
                </div><!-- /.box-body -->
              </div>	
			</div>
			
		</div>
		</form>
        </section><!-- /.content -->
	<!---->
	</div>
 </div>
<?php 
$this->load->view('admin/footer');
?>