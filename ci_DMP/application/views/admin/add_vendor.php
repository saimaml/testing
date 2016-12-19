<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/common.js"></script>
<div class="content-wrapper">
<section class="content-header">
	<h1>Add Partner</h1>
</section>

        <!-- Main content -->
        <section class="content">
		<?php echo form_open_multipart("welcome/add_vendor1"); ?>
			<div class="row">
			 <div class="col-xs-12">
				<div class="alert alert-danger alert-dismissable cust_msg" <?php if(@$this->session->flashdata('derror')=='2'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> ERROR!</h4>Record Not Added Email Already Exist </div>
				<div class="alert alert-danger alert-dismissable cust_msg" <?php if(@$this->session->flashdata('error')=='1'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> ERROR!</h4>Record Not Added Mobile Already Exist </div>
			
				<div class="alert alert-success alert-dismissable cust_msg" <?php if(@$this->session->flashdata('dsucess')=='1'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> SUCCESS!</h4>Record Deleted </div>
				<div class="alert alert-success save alert-dismissable cust_msg" <?php if(@$this->session->flashdata('success')=='1'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?>><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> SUCCESS!</h4>Record Saved </div>
				</div>	
			<div class="col-xs-8">
				<div class="box box-warning" style=" height: 650px;">
					<div class="box-header">  <?php echo validation_errors(); ?>          </div>			<div class="box-body">
						<div class="form-group">
							<label for="service_id" class="col-sm-4 control-label">Name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required/>
							</div>
						</div><br/><br/>
						<div class="form-group">
								<label for="orgnisation_name" class="col-sm-4 control-label">Organisation Name</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="orgnisation_name" name="orgnisation_name" placeholder="Enter Organisation Name" required/>
								</div>
							</div>	<br/><br/>	
							<div class="form-group">
								<label for="email" class="col-sm-4 control-label">Email</label>
								<div class="col-sm-8">
									<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required/>
								</div>
							</div>	<br/><br/>	
							<div class="form-group">
								<label for="website" class="col-sm-4 control-label">Website</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="website" name="website" placeholder="Enter website"/>
								</div>
							</div>	<br/><br/>		
							<div class="form-group">
								<label for="address" class="col-sm-4 control-label">Address</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="address" name="address" placeholder="Enter address" required/>
								</div>
							</div>	<br/><br/>		
							<div class="form-group">
								<label for="city" class="col-sm-4 control-label">City</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="city" name="city" placeholder="Enter City" required/>
								</div>
							</div>	<br/><br/>							
							<div class="form-group">
								<label for="mobile" class="col-sm-4 control-label">Mobile</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile" required/>
								</div>
							</div>	<br/><br/>	
							<div class="form-group">
								<label for="land_line1" class="col-sm-4 control-label">Office Landline No.1</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="land_line1" name="land_line1" placeholder="Enter Landline No.1" />
								</div>
							</div>	<br/><br/>
							<div class="form-group">
								<label for="land_line2" class="col-sm-4 control-label">Office Landline No.2</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="land_line2" name="land_line2" placeholder="Enter Landline No.2" />
								</div>
							</div>	<br/><br/>
							<div class="form-group">
								<label for="password" class="col-sm-4 control-label">Password</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="password" name="password" placeholder="Enter Password" required/>
								</div>
							</div>	<br/><br/>	
							<div class="form-group">
								<label for="password" class="col-sm-4 control-label">Select User</label>
								<div class="col-sm-8">
									<input type="radio" value="0" id="is_distributer" name="is_distributer" /> Vendor
									<input type="radio" value="1" id="is_distributer" name="is_distributer" /> Distributer																		<input type="radio" value="2" id="is_distributer" name="is_distributer" /> Both
								</div>
							</div>	<br/><br/>	
														
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-default">Submit</button>
								</div>
							</div>						
					
			
				                   
					 </div>
				</div>
			</div>
			</div>
		<?php  echo form_close(); ?>
      </section><!-- /.content -->
	  
	   <!-- Modal -->
  
</div>     

<?php 
$this->load->view('admin/footer');
?>