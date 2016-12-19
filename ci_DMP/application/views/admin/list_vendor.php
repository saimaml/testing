<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');
?>
<div class="content-wrapper">

<title>Vendor List</title>

<div style="width:100%;">
<!-- Main content -->

        <section class="content">
         <div class="row">
        <div class="col-xs-12">

        <div class="box box-primary">

          <div class="box-header" style="overflow:scroll;">

            <h3 style="float:left;">Vendor List</h3>

                <div class="box-body">

                 	 <table id="example" class="display table table-bordered table-striped">
						<thead>
							<tr>
								<th>ID</th>		 		
								<th>Name</th>
								<th>Type</th>
								<th>Orgnisation Name </th>
								<th>Email</th>
								<th>Website </th>
								<th>Address</th>
								<th>Mobile</th>
								<th>Office Landline No.1</th>
								<!--<th>Office Landline No.2</th>-->
								<th>Password</th>
								<th>Action</th>							
							</tr>
						</thead>
						<tbody id="update_cont">
						<?php foreach($posts as $results){?>
						<tr class="gradeX" id="list_data_tr<?php echo $results->id;?>">
							<td><?php echo $results->id;?></td>				
							<td><?php echo $results->name;?></td>			
							<td>
								<?php if($results->is_app_distributer =="0")
								{
									echo "Vendor";
								}
								else
								{
									echo "Distributer";
								}
									?></td>			
							<td><?php echo $results->orgnisation_name;?></td>	
							<td><?php echo $results->email;?></td>		     
							<td><?php echo $results->website;?></td>		     
							<td><?php echo $results->address;?></td>		     
							<td><?php echo $results->mobile;?></td>		     
							<td><?php echo $results->land_line1;?></td>		     
							<!--<td><?php echo $results->land_line2;?></td>-->		     
							<td><?php echo $results->password;?></td>		     
							<td><a class="btn btn-info btn-xs" href="<?php echo base_url();?>index.php/welcome/edit_vendor/<?php echo $id = $results->id;?>" title="Edit Record"><i class="fa fa-pencil"></i></a>

							<a onclick="delete_pro(<?php echo $results->id;?>);" class="btn btn-danger btn-xs " href="javascript:void(0);" title="Delete Record"><i class="fa fa-trash-o"></i></a></td>
						</tr>
						<?php }?>  
						</tbody>

                 
                </table>	  

                </div><!-- /.box-body -->

              </div>	

			</div>

			

		</div>

		

        </section><!-- /.content -->

	<!---->

	</div>

 </div>

<?php 

$this->load->view('admin/footer');

?>
 <script type="text/javascript">
    var url = "<?php echo base_url();?>";
    function delete_pro(id){
       var r=confirm("Do you want to delete this?")
        if (r==true)
          window.location = url+"index.php/welcome/delet_vendor/"+id;
        else
          return false;
        } 
</script>
