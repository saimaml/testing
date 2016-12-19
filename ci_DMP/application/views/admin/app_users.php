<?php
$this->load->view('admin/header.php');
$this->load->view('admin/left_side.php');
?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( ".datepicker" ).datepicker();
  } );
  </script>
<div class="content-wrapper">

<title>User List</title>
<div style="width:100%;">
 <!-- Content Header (Page header) -->
      
        <!-- Main content -->
        <section class="content">
				
         <div class="row">
		 <div class="col-xs-12">
				<div class="alert alert-danger alert-dismissable cust_msg" <?php if(@$this->session->flashdata('derror')=='2'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> ERROR!</h4>Record Not Added Email Already Exist </div>
				<div class="alert alert-danger alert-dismissable cust_msg" <?php if(@$this->session->flashdata('error')=='0'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> ERROR!</h4>Please Select User </div>
				<div class="alert alert-danger alert-dismissable cust_msg" <?php if(@$this->session->flashdata('error')=='1'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> ERROR!</h4>Record Not Added Mobile Already Exist </div>
			
				<div class="alert alert-success alert-dismissable cust_msg" <?php if(@$this->session->flashdata('success')=='1'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> SUCCESS!</h4>File Uploaded </div>
				<div class="alert alert-success save alert-dismissable cust_msg" <?php if(@$this->session->flashdata('success')=='2'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?>><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> SUCCESS!</h4>Send Message </div>
				</div>
         <div class="col-xs-12">
          <div class="col-xs-12">  
            <h3>User List</h3>
          </div>
	<?php echo form_open("Welcome/search_user/"); ?>	
		  <div class="row">
			<div class="col-md-2">
			<select name="city">
				<option value="-1">--Select City--</option>
				<option value="Pune">Pune</option>
				<option value="Mumbai">Mumbai</option>
			</select>
			</div>
			<div class="col-md-4">
				<label>Select From Date</label>
				<input type="text" class="datepicker" name="from_date" />
			</div>
			<div class="col-md-3">
				<label>Select To Date</label>
				<input type="text" class="datepicker" name="to_date" />
			</div>
			<div class="col-md-2">
				  <div class="col-xs-3" style=" text-align:right; margin-left: 39px;">  <button class="btn btn-success  " style="color:#FFFFFF" type="submit" value="Add">Search</button></div>
			</div>
		  </div>
	<?php echo form_close(); ?>
     
        </div>        
        <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-header">
           
                <div class="box-body">
                 	 <table id="example" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Sr No</th>
                        <th>Name</th>                                            
                        <th>Mobile</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Register date</th>       
                        
                      </tr>
                    </thead>
                    <tbody>
                  <?php $i=1;
                      foreach ($users as $row)
                      { 
                            ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $row->name;?></td>
                            <td><?php echo $row->mobile;?></td>
                            <td><?php echo $row->address2;?></td>
                            <td><?php echo $row->city;?></td>
                            <td><?php echo $row->email;?></td>
                            <td><?php echo $row->password;?></td>
                            <td><?php echo $row->created_date;?></td>
                        </tr>
                     <?php $i++; }
                  ?>
                </tbody>
                </table>	  
                </div><!-- /.box-body -->
              </div>	
			</div>
			
		</div></div>
		
        </section><!-- /.content -->
	<!---->
	</div>
 </div>
 
<?php 
$this->load->view('admin/footer');
?>