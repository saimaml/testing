<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');
?>
<div class="content-wrapper"><title>Social Timeline</title><div style="width:100%;">
<!-- Main content -->	<section class="content">		<div class="row">
        <div class="col-xs-12">        <div class="box box-primary">

          <div class="box-header">

            <h3 style="float:left;">Social Timeline</h3>

                <div class="box-body">

                 	 <table id="example" class="display table table-bordered table-striped">
						<thead>
							<tr>
								<th>ID </th>			
									<th>User name</th>									
									<th>Timeline Image</th>								
									<th>Timeline Video</th>
									<th>Timeline Text</th>
									<th>Posted Date</th>
									<th>Action</th>
							</tr>
						</thead>

   						<tbody id="update_cont">
								<?php foreach($posts as $results){?>
								<tr class="gradeX" id="list_data_tr<?php echo $results->id;?>">
									<td><?php echo $results->id;?></td>	
									<td><?php echo $results->name;?></td>	
									
									<td><img src="<?php echo $results->post_img;?>" alt="Timeline Image" height="200" width="200" /></td>	
									<td><?php echo $results->post_video;?></td>	
									<td><?php echo $results->post_text;?></td>	
									<td><?php echo $results->posted_date;?></td>	
									
									<td>
										<a><?php echo form_open("welcome/edit_social"); ?><input type="hidden" name="id" value="<?php echo $results->id;?>"><button class="btn btn-info" type="submit" value="Update"><i class="fa fa-pencil"></i></button><?php echo form_close();?></a>
										
										<a onclick="delete_social(<?php echo $results->id;?>);" href="javascript:void(0);" ><button class="btn btn-danger" type="submit" value="Update"><i class="fa fa-trash-o"></i></button><?php echo form_close(); ?></a>
										
										<a><?php echo form_open("welcome/view_social"); ?><input type="hidden" name="id" value="<?php echo $results->id;?>"><button class="btn btn-primary" type="submit" value="View"><i class="fa fa-eye" aria-hidden="true"></i>
										</button><?php echo form_close(); ?></a>
									</td>
								</tr>
								<?php }  ?>  
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

    function delete_social(id){

       var r=confirm("Do you want to delete this?")

        if (r==true)

          window.location = url+"index.php/welcome/delete_social/"+id;

        else

          return false;

        } 

</script>
