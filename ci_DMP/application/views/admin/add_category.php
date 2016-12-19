<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');
?>

<div class="content-wrapper">

<section class="content-header">
	<h1>Create Category</h1>
</section>

        <!-- Main content -->
        <section class="content">
	<?php echo form_open_multipart('admin/add_category1/');?>
	
			<div class="row">
			<div class="col-xs-8">
				<div class="box box-warning" style=" height: 650px;">
					<div class="box-header">
                </div>				
					 <div class="box-body">
					 	<div class="form-group">
                  <label class="col-sm-4 control-label">Category Name<label style="color:#FF0000">*</label></label>
                  <div class="col-sm-8">
                    <input type="text" name="catogories_name" class="form-control" placeholder="Category Name">
                  </div>
                </div></br></br>
				<div class="form-group">
                  <label class="col-sm-4 control-label">Category Name<label style="color:#FF0000">*</label></label>
                  <div class="col-sm-8">
                  <input type="file" name="userfile" id="src" onchange="showImage(this)"/>
				  <img id="target" height="200" width="200"/> 
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

