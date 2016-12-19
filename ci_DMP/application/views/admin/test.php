<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');
?>
<title>Add Info | </title>
<body class="sticky-header" ng-app="schollapp">
<section>
  
    <div class="main-content" >      
        <div class="page-heading">		
			Import data 
		</div>      
        <div class="wrapper">
           <div class="row">
				<div class="x_content bs-example-popovers col-sm-10">			
					<form class="cmxform form-horizontal adminex-form" method="post" action="<?php echo base_url() ?>index.php/welcome/importcsv" enctype="multipart/form-data">
					<div class="col-lg-12">
					<section class="panel">
					<div class="panel-body">
						<div class="form-group" style="width:200px; margin-left:100px;">
							<label>Select category</label>
								<select name="service_id" class="form-control"style="margin-top:10px; margin-left: 0;">
								<option value="1">Veterinary Doctors</option>
								<option value="2">Home Services</option>
								<option value="3">Dog Grooming Services</option>
								<option value="4">Pet Hostel and Dog care Services</option>
								<option value="5">Pet Adoption Centers</option>
								<option value="6">Pet Shops</option>
								<option value="7">Pet Insurance</option>
								<option value="8">Dog Trainers</option>
								<option value="9">Pet Ambulance Services</option>
								
							</select>
						</div>
						<div class="form-group" style="width:200px; margin-left:100px;">
							<input type="file" name="userfile" required style="margin-left:1px;"><br><br>
							<input style="margin-left: 0;" type="submit" name="submit" value="UPLOAD" class="btn btn-primary">
						</div>
                    </form>
				</div>
				</section>
			</div>
        </div>
        </div></div>
							
	</div>
 </section>
 <?php 
 
$this->load->view('admin/footer');

?>