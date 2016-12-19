<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');
?>

<div class="content-wrapper">
<title>Customer List</title>
<div style="width:100%;">
 <!-- Content Header (Page header) -->   
 <!-- Main content -->
	<section class="content">	
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable cust_msg" <?php if(@$this->session->flashdata('derror')=='2'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> ERROR!</h4>Record Not Added Product Already Exist </div>
		<div class="alert alert-danger alert-dismissable cust_msg" <?php if(@$this->session->flashdata('derror')=='1'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> ERROR!</h4>Record Not Saved </div>
		<div class="alert alert-success alert-dismissable cust_msg" <?php if(@$this->session->flashdata('dsucess')=='1'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?> ><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> SUCCESS!</h4>Record Deleted </div>
		<div class="alert alert-success save alert-dismissable cust_msg" <?php if(@$this->session->flashdata('success')=='1'){?> style="display:block" <?php }else{?> style="display:none" <?php } ?>><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4 style="width: 133px; float: left;"><i class="icon fa fa-ban"></i> SUCCESS!</h4>Record Saved </div>
	</div>				
        <div class="row">
        <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-header">
            <h3 style="float:left;">Customer List</h3>
                <div class="box-body">
                 	<table id="with_out_pagination" class="table table-bordered table-striped">
                    <thead>
					<tr>
						<th>Sr No</th>
                        <th>Customer Name</th>
                        <th>Customer Area</th> 
                        <th>Customer City</th> 
                        <th>Customer Contact</th> 
                        <th>Customer Concern Name</th> 
                        <th>Customer Email</th> 
                        <th>Customer Website</th> 
                        <th>Customer Company Name</th> 
                        <th>Modify</th>
                        <th>Delete</th>
					</tr>
                    </thead>
                    <tbody>

                     <?php $i=1; foreach ($customer as $row)   {  ?>

                        <tr>

                            <td><?php echo $i;?></td>

                            <td><?php echo $row->name;?></td>
                            <td><?php echo $row->area;?></td>
                            <td><?php echo $row->city;?></td>
                            <td><?php echo $row->contact;?></td>
                            <td><?php echo $row->concern_name;?></td>
                            <td><?php echo $row->email;?></td>
                            <td><?php echo $row->website;?></td>
                            <td><?php echo $row->company_name;?></td>

                           
                            <td><?php echo form_open("admin/edit_category"); ?><input type="hidden" name="id" value="<?php echo $row->id;?>"><button class="btn btn-primary " type="submit" value="Update">Update</button><?php echo form_close(); ?></td>



                            <td><?php echo form_open("admin/delete_category"); ?><input type="hidden" name="id" value="<?php echo $row->id;?>"><button class="btn btn-primary " type="submit" value="Delete">Delete</button><?php echo form_close(); ?></td>

                        </tr>

                     <?php $i++; }

                  ?>

                </tbody>

                </table>	  

                </div><!-- /.box-body -->

              </div>	

			</div>		

		</div>

		</form>

	</section><!-- /.content -->

	<!---->

	</div>

 </div>

<?php 

$this->load->view('admin/footer');

?>