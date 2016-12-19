<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');
$user_id = $this->session->userdata('user_id');	
?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/common.js"></script>

<div class="content-wrapper">

<section class="content-header">
	<h1>Import Product data </h1>
</section>

        <!-- Main content -->
        <section class="content">
		
			<div class="row">
			<div class="col-xs-8">
				<div class="box box-warning" style=" height: 650px;">
					<div class="box-header">  <?php echo validation_errors(); ?>          </div>				
					<div class="box-body">
					<form class="cmxform form-horizontal adminex-form" method="post" action="<?php echo base_url() ?>index.php/welcome/import_product_csv_vendor" enctype="multipart/form-data">
						<input type = "hidden" name="vendor" value="<?php echo $user_id; ?>	"/>
						<div class="form-group" style="width:200px; margin-left:100px;">
							<input type="file" name="userfile" required style="margin-left:1px;"><br><br>
							
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
</div>     

<?php 
$this->load->view('admin/footer');
?>