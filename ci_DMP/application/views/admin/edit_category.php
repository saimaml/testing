<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');
?>

<div class="content-wrapper">
<section class="content-header">
          <h1>Edit Category </h1>
</section>

<!-- Main content -->
<section class="content">
	<?php echo form_open_multipart('admin/edit_category1/');?>	
	<div class="row">
		<div class="col-xs-8">
			<div class="box box-warning" style=" height: 650px;">
				<?php foreach ($category as $row) 
				{ ?>
					<div class="box-body">
						
						<div class="form-group">
							<label class="col-sm-4 control-label" >Category Name<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
								<input type="text" name="catogories_name" class="form-control" value="<?php echo $row->catogories_name; ?>">
							</div>
						</div></br></br>  
						<div class="form-group">
							<label class="col-sm-4 control-label" >Category Image<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
							
								<input type="file" name="userfile" id="src" onchange="showImage(this)"/>
								<img id="target" src="<?php echo base_url(); ?>uploads/<?php echo $row->cat_img;?>" alt="img" height="200" width="200"/> 
							
								
							</div>
						</div></br></br>           
						<div class="form-group">
						  <div class="col-md-6">
							  <div style="padding-right:17px;padding-top: 25px;">
								<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
						  <button type="submit" class="btn btn-primary pull-right" name="savenext">Save</button>
						</div>
						  </div>
						</div></br></br>
               
                        
					</div>
       <?php    }         ?>  
			</div>
		</div>
	</div>
		<?php  echo form_close(); ?>
</section><!-- /.content -->
</div>
<?php 
$this->load->view('admin/footer');
?>