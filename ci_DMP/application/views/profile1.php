<?php
	$id = $rows;
	$this->load->view('admin/header');
	$this->load->view('admin/left_side');
?>

<div class="content-wrapper">
<section class="content-header">
    <h1>Vendor Profile </h1>
</section>
<!-- Main content -->
<section class="content">
	<?php echo form_open_multipart("welcome/edit_profile1"); ?>
	<div class="row">
		<div class="col-xs-8">
			<div class="box box-warning" style=" height: 650px;">
				<?php foreach($posts as $results){?>
					<div class="form-group">
						<label for="service_id" class="col-sm-4 control-label">Name</label>
								<div class="col-sm-8">

									<input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id;?>"/>
									<input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required value="<?php echo $results->name;?>"/>

								</div>

							</div>

							<br/><br/>

							<div class="form-group">

								<label for="orgnisation_name" class="col-sm-4 control-label">Organisation Name</label>

								<div class="col-sm-8">

									<input type="text" class="form-control" id="orgnisation_name" name="orgnisation_name" placeholder="Enter Organisation Name" required value="<?php echo $results->orgnisation_name;?>"/>

								</div>

							</div>	<br/><br/>

							<div class="form-group">

								<label for="email" class="col-sm-4 control-label">Email</label>

								<div class="col-sm-8">

									<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required value="<?php echo $results->email;?>"/>

								</div>

							</div>	<br/><br/>

							<div class="form-group">

								<label for="website" class="col-sm-4 control-label">Website</label>

								<div class="col-sm-8">

									<input type="text" class="form-control" id="website" name="website" placeholder="Enter website" required value="<?php echo $results->website;?>"/>

								</div>

							</div><br/><br/>			

							<div class="form-group">

								<label for="address" class="col-sm-4 control-label">Address</label>

								<div class="col-sm-8">

									<input type="text" class="form-control" id="address" name="address" placeholder="Enter address" required value="<?php echo $results->address;?>"/>

								</div>

							</div>	<br/><br/>							

							<div class="form-group">

								<label for="mobile" class="col-sm-4 control-label">Mobile</label>

								<div class="col-sm-8">

									<input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile" required value="<?php echo $results->mobile;?>"/>

								</div>

							</div>		<br/><br/>

							<div class="form-group">

								<label for="land_line1" class="col-sm-4 control-label">Office Landline No.1</label>

								<div class="col-sm-8">

									<input type="text" class="form-control" id="land_line1" name="land_line1" placeholder="Enter Landline No.1" required value="<?php echo $results->land_line1;?>"/>

								</div>

							</div>	<br/><br/>

							<div class="form-group">

								<label for="land_line2" class="col-sm-4 control-label">Office Landline No.2</label>

								<div class="col-sm-8">

									<input type="text" class="form-control" id="land_line2" name="land_line2" placeholder="Enter Landline No.2" value="<?php echo $results->land_line2;?>"/>

								</div>

							</div>	<br/><br/>

							<div class="form-group">

								<label for="password" class="col-sm-4 control-label">Password</label>

								<div class="col-sm-8">

									<input type="text" class="form-control" id="password" name="password" placeholder="Enter Password" required value="<?php echo $results->password;?>"/>

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



<?php 



$this->load->view('admin/footer');



?>