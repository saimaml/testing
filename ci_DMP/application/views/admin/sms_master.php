<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/common.js"></script>

<div class="content-wrapper">

<section class="content-header">
	<h1>Add SMS Template</h1>
</section>

        <!-- Main content -->
        <section class="content">
		<?php echo form_open_multipart("welcome/add_sms_master"); ?>
			<div class="row">
			<div class="col-xs-8">
				<div class="box box-warning" style=" height: 650px;">
					<div class="box-header">  <?php echo validation_errors(); ?>          </div>				
					<div class="box-body">
						<div class="form-group">
								<label for="title" class="col-sm-2 control-label">SMS Title</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required/>
								</div>
							</div><br/><br/>	
							
							<div class="form-group">
								<label for="brand_id" class="col-sm-2 control-label">SMS Template</label>
								<div class="col-sm-10">
									<textarea name="details" class="form-control" placeholder="Message goes here"></textarea>
								</div>
							</div>		<br/><br/>	
																				
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
</div>     

<?php 
$this->load->view('admin/footer');
?>