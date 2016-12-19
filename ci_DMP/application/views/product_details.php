<div class="container-fluid">
	<div class="side-body">
		<div class="page-title">
			<span class="title">Add Product Details</span>
		 </div>
		<div class="row">
			<div class="col-xs-12">
				<div class="card">
					<div class="card-body">
					<?php echo form_open_multipart("welcome/add_product_details"); ?>
						<form class="form-horizontal"id="contact-form" method="post" action="">
							<div class="form-group">
								<label for="service_id" class="col-sm-2 control-label">Product ID</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="product_id" name="product_id" placeholder="Enter Product id" required/>
								</div>
							</div>
							<div class="form-group">
								<label for="brand_id" class="col-sm-2 control-label">Product Details</label>
								<div class="col-sm-10">
									<textarea name="details" class="form-control" placeholder="Message goes here"></textarea>
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