<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');

$con=mysqli_connect("172.31.20.191","root","vistart3","DMP");
	$sql_services = "SELECT id,service_master FROM tbl_service_master";
	$result_services = mysqli_query($con,$sql_services);
?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/common.js"></script>

<div class="content-wrapper">

<section class="content-header">
	<h1>Import data </h1>
</section>

        <!-- Main content -->
        <section class="content">
		
			<div class="row">
			<div class="col-xs-8">
				<div class="box box-warning" style=" height: 650px;">
					<div class="box-header">  <?php echo validation_errors(); ?>          </div>				
					<div class="box-body">
					<form class="cmxform form-horizontal adminex-form" method="post" action="<?php echo base_url() ?>index.php/welcome/importcsv" enctype="multipart/form-data">
						<div class="form-group">
							<div class="col-sm-4">
								<label>Select category</label>
								</div>
									<div class="col-sm-6">
								<select name="service_id" class="form-control"style="margin-top:10px; margin-left: 0;">
								<?php while($row_services = mysqli_fetch_array($result_services))
										{ ?>
									<option value="<?php echo $row_services["id"]; ?>"><?php echo $row_services["service_master"]; ?></option>
										<?php  }  ?>	
							</select>
							</div>
						</div><br/><br/>
						<div class="form-group" style="width:200px; margin-left:100px;">
							<input type="file" name="userfile" required style="margin-left:1px;"><br><br>
							<input style="margin-left: 0;" type="submit" name="submit" value="UPLOAD" class="btn btn-primary">
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