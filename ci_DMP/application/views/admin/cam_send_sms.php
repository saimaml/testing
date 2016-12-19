<?php
$this->load->view('admin/header.php');
$this->load->view('admin/left_side.php');
?>
<div class="content-wrapper">

<title>Send Email User List</title>
<div style="width:100%;">
 <!-- Content Header (Page header) -->
      
        <!-- Main content -->
        <section class="content">
				<?php echo form_open("Welcome/select_usersms_master/"); ?>		
         <div class="row">
		 <div class="col-xs-12"> 
				<div class="alert alert-danger alert-dismissable cust_msg" <?php if(@$this->session->flashdata('derror')=='2'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> ERROR!</h4>Record Not Added Email Already Exist </div>
				<div class="alert alert-danger alert-dismissable cust_msg" <?php if(@$this->session->flashdata('error')=='0'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> ERROR!</h4>Please Select User </div>
				<div class="alert alert-danger alert-dismissable cust_msg" <?php if(@$this->session->flashdata('error')=='1'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> ERROR!</h4>Record Not Added Mobile Already Exist </div>
			
				<div class="alert alert-success alert-dismissable cust_msg" <?php if(@$this->session->flashdata('success')=='1'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> SUCCESS!</h4>File Uploaded </div>
				<div class="alert alert-success save alert-dismissable cust_msg" <?php if(@$this->session->flashdata('success')=='2'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?>><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> SUCCESS!</h4>Send Message </div>
				</div>
         <div class="col-xs-12">
          <div class="col-xs-8">  
            <h3>Send Email User List</h3>
          </div>
		  <div class="col-xs-5">  
             <div class="box-header">
              <div class="form-group">
				<div class="col-sm-5">
					<label style="margin-top: 10px;">Select Email Template</label>
					</div>
						<div class="col-sm-7">
					<select name="sms_template" class="form-control" style="margin-top:0px; margin-left: -15%;">
					<?php
					$query = $this->db->get_where('tbl_sms_master', array('is_approved' => '1'));
						

						foreach ($query->result() as $row)
						{  ?>
									<option value="<?php echo $row->description; ?>"><?php echo $row->short_heading; ?></option>
				<?php 	} 		?>
					
							
				</select>
				</div>

			</div>
             
         </div>
        </div>
          <div class="col-xs-2">  
         <div class="col-xs-10" style=" text-align:right;  margin-left: 70px; margin-top: 14px;"><input type="checkbox" class="check_all" data-related-class="facility_check" title="Check All Facilities" name="select_all" id="select_all"> &nbsp;&nbsp;Select All</div>
         </div>
          <div class="col-xs-2">  
             <div class="box-header">
             <div class="col-xs-3" style=" text-align:right; margin-left: 39px;">  <button class="btn btn-success  " style="color:#FFFFFF" type="submit" value="Add">Send Email</button></div>
         </div>
        </div>
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
                        <th>Action</th>       
                        
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
                            <td><input type="checkbox" name="ids[]" class="facility_check" value="<?php echo $row->id; ?>" ></td>
                        </tr>
                     <?php $i++; }
                  ?>
                </tbody>
                </table>	  
                </div><!-- /.box-body -->
              </div>	
			</div>
			
		</div></div>
		<?php echo form_close(); ?>
        </section><!-- /.content -->
	<!---->
	</div>
 </div>
<?php 
$this->load->view('admin/footer');
?>