<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');
?>

<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/common.js"></script>

<div class="content-wrapper">

<section class="content-header">
	<h1>Import Send SMS data </h1>
</section>

        <!-- Main content -->
        <section class="content">
		
			<div class="row">
			<div class="col-xs-8">
				<div class="box box-warning" style=" height: 650px;">
					<div class="box-header">  <?php echo validation_errors(); ?> </div>				
					<div class="box-body">
					<form class="cmxform form-horizontal adminex-form" method="post" action="<?php echo base_url() ?>index.php/welcome/import_sms_csv" enctype="multipart/form-data">
					 <div class="form-group">

		                  <label class="col-sm-4 control-label" style="margin-left:-15%;">Select CSV File<label style="color:#FF0000">*</label></label>

		                  <div class="col-sm-8">

		                   <input type="file" name="userfile" required style="margin-left:1px;" required>


		                  </div>

		                </div></br></br>
				
						<div class="row">
						<div class="col-sm-2"></div>		
							<a href="/ci_DMP/application/download/Sample_file.csv">Download Sample File</a>						
						</div>
						</div></br></br>									
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