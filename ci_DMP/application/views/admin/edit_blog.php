<?php
	$this->load->view('admin/header');
	$this->load->view('admin/left_side');
?>

<div class="content-wrapper">
<section class="content-header">
    <h1>Vendor Profile </h1>
</section>
<!-- Main content -->
<section class="content">
	<?php echo form_open_multipart("welcome/edit_blog1"); ?>
	<div class="row">
		<div class="col-xs-8">
			<div class="box box-warning" style=" height: 650px;">
				<?php foreach($posts as $results){?>
					<div class="form-group">
						<label for="service_id" class="col-sm-4 control-label">Name</label>
								<div class="col-sm-8">

									<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $results->id;?>"/>
									<input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required value="<?php echo $results->title;?>"/>

								</div>

							</div>

							<br/><br/>

							<div class="form-group">

								<label for="orgnisation_name" class="col-sm-4 control-label">Blog Details</label>

								<div class="col-sm-8">
									<textarea name="details" class="form-control" placeholder="Message goes here"><?php echo $results->description;?></textarea>
									

								</div>

							</div>	<br/><br/>

							<div class="form-group">

								<label for="Image" class="col-sm-4 control-label">Image</label>

								<div class="col-sm-8">
									<img src="<?php echo $results->image;?>" height="350" width="350" />
									<input type="file" multiple="true" class="form-control" id="userfile" name="userfile"/>

								</div>

							</div>	<br/><br/>													

							<div class="form-group">

								<div class="col-sm-offset-2 col-sm-10">

									<button type="submit" class="btn btn-default">Submit</button>

								</div>

							</div>

					<?php } echo form_close(); ?>



</section><!-- /.content -->



</div>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script> 

<?php 
	$this->load->view('admin/footer');
?>