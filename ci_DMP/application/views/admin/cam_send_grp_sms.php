<?php
$this->load->view('admin/header.php');
$this->load->view('admin/left_side.php');
?>
<div class="content-wrapper">

<title>Send SMS User List</title>
<div style="width:100%;">
 <!-- Content Header (Page header) -->
      
        <!-- Main content -->
        <section class="content">
				<?php echo form_open("Welcome/select_usersms_master_grp_sms/"); ?>		
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
		  	  <div class="col-xs-10">  
		  <div class="form-group">
				<div class="col-sm-2">
					<label style="margin-top: 10px;">Select Group</label>
					</div>
					<div class="col-sm-5">
					<select name="group_id" id="group_id" class="form-control" onchange="search_group();">				
					<?php
					$query = $this->db->get('tbl_camp_grp');						

						foreach ($query->result() as $row)
						{  ?>
							<option value="<?php echo $row->id; ?>"><?php echo $row->grp_name; ?></option>
						<?php 	} 		?>	
					</select>
				</div>
			</div> 
			</div> 
			 <div class="col-xs-2"> 
			   <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#myModal">Add Group</button>
				
			 </div>
		  
		  <div class="col-xs-5">  
             <div class="box-header">
			<div class="form-group">
				<div class="col-sm-5">
					<label style="margin-top: 10px;">Select SMS Template</label>
					</div>
					<div class="col-sm-7">
				<select name="sms_template" class="form-control" style="margin-top:0px; margin-left: -15%;">
					<?php
					$query = $this->db->get('tbl_sms_master');						

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
         <div class="col-xs-10" style=" text-align:right;  margin-left: 70px; margin-top: 14px;"><input type="checkbox" onClick="toggle(this)" data-related-class="facility_check" title="Check All Facilities" name="select_all" id="select_all"> &nbsp;&nbsp;Select All</div>
         </div>
          <div class="col-xs-2">  
             <div class="box-header">
             <div class="col-xs-3" style=" text-align:right; margin-left: 39px;">  <button class="btn btn-success  " style="color:#FFFFFF" type="submit" value="Add">Send SMS</button></div> 
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
                        <th>Email</th>                       
                        <th>Action</th>       
                        
                      </tr>
                    </thead>
                    <tbody id="">
                  <?php $i=1;
                      foreach ($users as $row)
                      { ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $row->name;?></td>
                            <td><?php echo $row->phn_no;?></td>                          
                            <td><?php echo $row->email;?></td>
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
	
	 
	   <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Group</h4>
        </div>
        <div class="modal-body">
			<?php echo form_open_multipart('welcome/add_group/');?>
				<div class="form-group">
					<label for="Group Name" class="col-sm-4 control-label">Group Name</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="group_name" name="group_name" placeholder="Enter Group Name" required />
					</div>
				</div>  <br/><br/>	
				<div class="form-group">
					<label for="Group Name" class="col-sm-4 control-label">Import Group</label>
					<div class="col-sm-8">
						<input type="file" name="userfile" required style="margin-left:1px;"><br><br>
					</div>
				</div>  <br/><br/>	
				
        </div>
			
        <div class="modal-footer">
		<button type="submit" class="btn btn-default">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      <?php  echo form_close(); ?>
    </div>
  </div>
	
	
	</div>
 </div>
<?php 
$this->load->view('admin/footer');
?>
<script>
function search_group() { 
    var x = document.getElementById("group_id").value;
	$.ajax({
            url : "<?php echo base_url(); ?>index.php/welcome/search_group_sms", // my controller :<?php echo base_url(); ?>admin/order/new_order
            method: "POST",
            data: "id="+x,
            success: function(response) {
                 $("#div11").html(response);
            }
      })  
}

function toggle(source) {
  checkboxes = document.getElementsByName('ids[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

</script>