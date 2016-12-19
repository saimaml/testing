<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');
?><!-- Main Content -->
<div class="container-fluid">
	<div class="side-body">
		<div class="page-title">
			<span class="title">My Setting </span>
		 </div>
		<div class="row">
			<div class="col-xs-12">
				<div class="card">
				   
					<div class="card-body">
					 <div class="col-xs-12">
				<div class="alert alert-danger alert-dismissable cust_msg" <?php if(@$this->session->flashdata('derror')=='2'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> ERROR!</h4>Password Not Match</div>
				
				<div class="alert alert-danger alert-dismissable cust_msg" <?php if(@$this->session->flashdata('derror')=='1'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> ERROR!</h4>Invalid Password</div>
				
				<div class="alert alert-success alert-dismissable cust_msg" <?php if(@$this->session->flashdata('dsucess')=='1'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> SUCCESS!</h4>Record Deleted </div>
				<div class="alert alert-success save alert-dismissable cust_msg" <?php if(@$this->session->flashdata('success')=='1'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?>><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> SUCCESS!</h4>Record Saved </div>
				</div>	
					<?php echo form_open_multipart("welcome/edit_password"); ?>
						<form class="form-horizontal"id="contact-form" method="post" action="">
							<?php echo validation_errors(); ?>
						<div class="form-group">
								<label for="old_pwd" class="col-sm-2 control-label">Old Password</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="old_pwd" name="old_pwd" placeholder="Enter Old Password" value="<?php echo set_value('old_pwd'); ?> "required />
								</div>
						</div>
							<div class="form-group">
								<label for="new_pwd" class="col-sm-2 control-label">New Password</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="new_pwd" name="new_pwd" placeholder="Enter New Password" value="<?php echo set_value('new_pwd'); ?>" required/>
								</div>
							</div>		
							<div class="form-group">
								<label for="confirm_pwd" class="col-sm-2 control-label">Confirm Password</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="confirm_pwd" name="confirm_pwd" placeholder="Enter Confirm Password" value="<?php echo set_value('confirm_pwd'); ?>" required />
								</div>
							</div>	
						
						<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<button type="submit" class="btn btn-default">Submit</button>
								</div>
							</div>
						</form>
						 <?php echo form_close(); ?>
						 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>    

<?php 

$this->load->view('admin/footer');

?>