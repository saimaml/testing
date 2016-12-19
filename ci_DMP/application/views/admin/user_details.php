<?php
$this->load->view('admin/header.php');
$this->load->view('admin/left_side.php');
?>

<div class="content-wrapper">
<section class="content-header">
          <h1>Edit Users </h1>
</section>

<!-- Main content -->
<section class="content">
	
	<div class="row">
		<div class="col-xs-8">
			<div class="box box-warning" style=" height: 650px;">
				<?php foreach ($users as $row) 
				{ ?>
					<div class="box-body">
						
						<div class="form-group">
							<label class="col-sm-4 control-label" >Name<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
								<input type="text" name="name" class="form-control" value="<?php echo $row->name; ?>">
							</div>
						</div></br></br> 
						<div class="form-group">
							<label class="col-sm-4 control-label" >User ID / Email<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
								<input type="text" name="catogories_name" class="form-control" value="<?php echo $row->email; ?>">
							</div>
						</div></br></br>  
						<div class="form-group">
							<label class="col-sm-4 control-label" >Password<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
								<input type="text" name="catogories_name" class="form-control" value="<?php echo $row->password; ?>">
							</div>
						</div></br></br>  
						<div class="form-group">
							<label class="col-sm-4 control-label" >Mobile<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
								<input type="text" name="catogories_name" class="form-control" value="<?php echo $row->mobile; ?>">
							</div>
						</div></br></br>  
						<div class="form-group">
							<label class="col-sm-4 control-label" >Address<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
								<input type="text" name="catogories_name" class="form-control" value="<?php echo $row->address2; ?> ,   <?php echo $row->city; ?>">
							</div>
						</div></br></br>  
						          
						<div class="form-group">
						  <div class="col-md-6">
						 
							 
						<?php if($row->is_active == 1)  {   ?>
						 <?php echo form_open_multipart('Admin/edit_user_inactive/');?>	
							 <div style="padding-right:17px;padding-top: 25px;">
								<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
								<input type="hidden" name="name" value="<?php echo $row->name; ?>" />
								<input type="hidden" name="email" value="<?php echo $row->email; ?>" />
						  <button type="submit" class="btn btn-primary pull-right" name="savenext">Inactive</button>
						  </div>
						  <?php  echo form_close(); ?>
						   <?php } else {  ?>
						    <?php echo form_open_multipart('Admin/edit_user_active/');?>	
						   <div style="padding-right:17px;padding-top: 25px;">
								<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
								<input type="hidden" name="name" value="<?php echo $row->name; ?>" />
									<input type="hidden" name="email" value="<?php echo $row->email; ?>" />
						    <button type="submit" class="btn btn-primary pull-right" name="savenext">Active</button>
							</div>
							<?php  echo form_close(); ?>
						   <?php }  ?>
						
						  </div>
						</div></br></br>
               
                        
					</div>
       <?php    }         ?>  
			</div>
		</div>
	</div>
		
</section><!-- /.content -->
</div>
<?php 
$this->load->view('admin/footer');
?>