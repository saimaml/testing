<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');
?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/common.js"></script>

<div class="content-wrapper">

<section class="content-header">
	<h1>Delete Form </h1>
</section>

        <!-- Main content -->
        <section class="content">
	<?php echo form_open_multipart("welcome/delete_category"); ?>
			<div class="row">
			<div class="col-xs-8">
				<div class="box box-warning" style=" height: 650px;">
					<div class="box-header">  <?php echo validation_errors(); ?>          </div>				
					<div class="box-body">
						                         <div class="form-group">
                                            <label for="service_id" class="col-sm-2 control-label">Service ID</label>
                                            <div class="col-sm-10">
                                                <input type="textbox" class="form-control" id="service_id" name="service_id" placeholder="Service ID" value="<?php if (isset($_POST['save'])){ echo $_POST['service_id'];} else { echo $posts['service_id'];}?>" required/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="catogories_name" class="col-sm-2 control-label">Category Name</label>
                                            <div class="col-sm-10">
                                                <input type="textbox" class="form-control" id="catogories_name" name="catogories_name" placeholder="Category Name" value="<?php if (isset($_POST['save'])){ echo $_POST['catogories_name'];} else { echo $posts['catogories_name'];}?>" required/>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="hidden" name="id" value="<?php echo $posts['id']; ?>" />
                                            </div>
                                        </div>
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
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Brand</h4>
        </div>
        <div class="modal-body">
			<?php echo form_open('welcome/add_brand1/');?>
				<div class="form-group">
					<label for="Brand Name" class="col-sm-4 control-label">Brand Name</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="brand_name" name="brand_name" placeholder="Enter Brand Name" />
					</div>
				</div>  <br/><br/>	
				
        </div>
        <div class="modal-footer">
		<button type="submit" class="btn btn-default">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      <?php  echo form_close(); ?>
    </div>
  </div>
</div>
     

<?php 
$this->load->view('admin/footer');
?>


