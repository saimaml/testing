
<?php
$this->load->view('header');
$this->load->view('left_side');
?>

<div class="content-wrapper">



<section class="content-header">
          <h1>Create Ads</h1>
          
        </section>

        <!-- Main content -->
        <section class="content">

         
		<!-- <form role="form" method="post" id="create_b2b_customer"  name="create_b2b_customer" action="ajax.php?mode=controller" class="form-horizontal" enctype="multipart/form-data">-->
	<?php echo form_open_multipart('user/do_upload/');?>
	 <div class="col-xs-10">
		</div><div class="col-xs-2"></div>
			<div class="row">
			<div class="col-xs-12">
				<div class="box box-warning">
					<div class="box-header">
                </div>
				
					 <div class="box-body">
					 <div class="col-xs-6">
					 								
					 	<div class="form-group">
							<label class="col-sm-4 control-label"  for="Username">URL<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
								<?php $url = array('name'        => 'url',
													'id'          => 'inputName3',
													'class'       => 'form-control',
													'placeholder'   => 'URL',
             
													);

									echo form_input($url);?>
								
							</div>
						</div></br></br>
						
						<div class="form-group">
							<label class="col-sm-4 control-label"  for="Username">Upload File<label style="color:#FF0000">*</label></label>
						<input type="file" name="userfile" />
						<div class="col-sm-8">
						</div>
						</div></br>
						
						<div class="form-group">
							<label class="col-sm-4 control-label"  for="contact">Contact<label style="color:#FF0000">*</label></label>
							<div class="col-sm-8">
								<?php $ads_date = array('name'        => 'ads_date',
													'id'          => 'created_from_date',
													'class'       => 'form-control pull-right singledate',
													'placeholder'   => 'Date',
													'data-provide' => 'datepicker'
													);

									echo form_input($ads_date);?>
									
									<!--	<input data-provide="datepicker">
								<script>
									$('.datepicker').datepicker({
										startDate: '-3d'
									});
									</script>-->
																	
							</div>
						</div></br></br>
						
						<div class="form-group">
						<label class="col-sm-4 control-label"  for="Username"></label>
							<div class="col-sm-8">
							<input class="btn btn-block btn-info btn_validator" type="submit"  value="Save" data-frm="create_b2b_customer" style="width:200px;" >
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

