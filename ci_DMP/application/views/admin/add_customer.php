<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');
?>

<div class="content-wrapper">

<section class="content-header">
	<h1>Create Customer</h1>
</section>

        <!-- Main content -->
        <section class="content">
		
		<?php echo form_open('admin/add_cust1/');?>
	
			<div class="row">
			<div class="col-xs-8">
				<div class="box box-warning" style=" height: 650px;">
					<div class="box-header">
					<?php echo validation_errors(); ?>
                </div>				
					 <div class="box-body">
					 	<div class="form-group">
                  <label class="col-sm-4 control-label">Customer Name<label style="color:#FF0000">*</label></label>
                  <div class="col-sm-8">
                    <input type="text" name="name" class="form-control" placeholder="Customer Name">
                  </div>
                </div></br></br>
				<div class="form-group">
                  <label class="col-sm-4 control-label">Customer Area<label style="color:#FF0000">*</label></label>
                  <div class="col-sm-8">
                    <input type="text" name="area" class="form-control" placeholder="Customer area">
                  </div>
                </div></br></br>
				<div class="form-group">
                  <label class="col-sm-4 control-label">Customer City<label style="color:#FF0000">*</label></label>
                  <div class="col-sm-8">
                    <input type="text" name="city" class="form-control" placeholder="Customer City">
                  </div>
                </div></br></br>
				
				<div class="form-group">
                  <label class="col-sm-4 control-label">Customer Contact<label style="color:#FF0000">*</label></label>
                  <div class="col-sm-8">
                    <input type="text" name="contact" class="form-control" placeholder="Customer Contact">
                  </div>
                </div></br></br>
				<div class="form-group">
                  <label class="col-sm-4 control-label">Customer Concern Name<label style="color:#FF0000">*</label></label>
                  <div class="col-sm-8">
                    <input type="text" name="concern_name" class="form-control" placeholder="Customer Concern Name">
                  </div>
                </div></br></br>
				<div class="form-group">
                  <label class="col-sm-4 control-label">Customer Email<label style="color:#FF0000">*</label></label>
                  <div class="col-sm-8">
                    <input type="text" name="email" class="form-control" placeholder="Customer Email">
                  </div>
                </div></br></br>
				<div class="form-group">
                  <label class="col-sm-4 control-label">Customer Website<label style="color:#FF0000">*</label></label>
                  <div class="col-sm-8">
                    <input type="text" name="website" class="form-control" placeholder="Customer Website">
                  </div>
                </div></br></br>
				<div class="form-group">
                  <label class="col-sm-4 control-label">Customer Company Name<label style="color:#FF0000">*</label></label>
                  <div class="col-sm-8">
                    <input type="text" name="company_name" class="form-control" placeholder="Customer Company Name">
                  </div>
                </div></br></br>
			
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-10">
						<button type="submit" class="btn btn-default">Submit</button>
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
$this->load->view('admin/footer');
?>

