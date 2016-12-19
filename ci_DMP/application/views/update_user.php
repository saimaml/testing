
<?php
$this->load->view('header');
$this->load->view('left_side');
?>

<div class="content-wrapper">
<section class="content-header">
          <h1>Update User </h1>          
</section>
        <!-- Main content -->
    <section class="content">
	<?php echo form_open_multipart('user/save_update/');?>
	 <div class="col-xs-10">
		</div><div class="col-xs-2"></div>
			<div class="row">
			<div class="col-xs-12">
				<div class="box box-warning">
					<div class="box-header">
					<h3 class="box-title">&nbsp;Update User</h3>
                </div>
				
					 <div class="box-body">
					 <div class="col-xs-6">
				<?php 
                      foreach ($posts as $row)
                      {
                            ?>	
                            <input type="hidden" name="c_id" class="form-control" value=" <?php echo $row->c_id; ?>" />
					 	<div class="form-group">
							<label class="col-sm-4 control-label"  for="Username">Name<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
								<input type="text" name="c_name" class="form-control" value=" <?php echo $row->c_name; ?>" />
							</div>
						</div></br></br>
						
						<div class="form-group">
							<label class="col-sm-4 control-label"  for="plan">Address<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
								<input type="text" name="address" class="form-control" value=" <?php echo $row->address; ?>" />
							</div>
						</div></br></br></br></br></br></br></br>
						<div class="form-group">
							<label class="col-sm-4 control-label"  for="Username">City<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
								<input type="text" name="city" class="form-control" value=" <?php echo $row->c_city; ?>" />
							</div>
						</div></br></br>
						<div class="form-group">
							<label class="col-sm-4 control-label"  for="Username">State<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
									<input type="text" name="state" class="form-control" value=" <?php echo $row->c_state; ?>" />
							</div>
						</div></br></br>
						<div class="form-group">
							<label class="col-sm-4 control-label"  for="Username">Phone No <label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
									<input type="text" name="phone_no" class="form-control" value=" <?php echo $row->c_phone; ?>" />
								</div>
						</div></br></br>
						<div class="form-group">
							<label class="col-sm-4 control-label"  for="Username">Mobile No<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
								<input type="text" name="mobile_no" class="form-control" value=" <?php echo $row->c_mobile; ?>" />
								</div>
						</div></br></br>
						<div class="form-group">
							<label class="col-sm-4 control-label"  for="Username">Email Id<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
								<input type="text" name="email" class="form-control" value=" <?php echo $row->c_email; ?>" />
								</div>
						</div></br></br>
						<div class="form-group">
							<label class="col-sm-4 control-label"  for="Username">DOB<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
								<input type="text" name="dob" class="form-control" value=" <?php echo $row->c_dob; ?>" />
							</div>
						</div></br></br>
						<div class="form-group">
							<label class="col-sm-4 control-label"  for="Username">Username<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
								<input type="text" name="username" class="form-control" value=" <?php echo $row->username; ?>" />
							</div>
						</div></br></br>
						<div class="form-group">
							<label class="col-sm-4 control-label"  for="Username">Password<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
								<input type="text" name="password" class="form-control" value=" <?php echo $row->password; ?>" />
							</div>
						</div></br></br>
			<?php } ?>
						<div class="form-group">
							<label class="col-sm-4 control-label"  for="Username"></label>
							<div class="col-sm-8">
								<input class="btn btn-block btn-info btn_validator" type="submit"  value="Save" style="width:200px;" >
							</div>
						</div>
				    </div>
					
					 </div>
				</div>
			</div>
			</div>
		<?php  echo form_close(); ?>
      </section><!-- /.content -->



</div>
<?php 
$this->load->view('footer');
?>

