<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');
?>
<div class="content-wrapper">

<title>List Product Details</title>

<div style="width:100%;">
<!-- Main content -->

        <section class="content">
         <div class="row">
        <div class="col-xs-12">

        <div class="box box-primary">

          <div class="box-header">

            <h3 style="float:left;">List Product Details</h3>

                <div class="box-body">

                 	 <table id="example" class="display table table-bordered table-striped">
						<thead>
							<tr>
								<th>ID</th>	
								<th>Details</th>
								<th>Action</th>
							</tr>
						</thead>

                    <tbody id="update_cont">

		 <?php foreach($posts as $results){?>        

		 <tr class="gradeX" id="list_data_tr<?php echo $results->id;?>">

		 <td><?php echo $results->product_id;?></td>	

		 <td><?php echo $results->details;?></td>	
		 	 	  

		  <td><a class="btn btn-info btn-xs" href="<?php echo base_url();?>index.php/welcome/edit/<?php echo $id = $results->id;?>" title="Edit Record"><i class="fa fa-pencil"></i></a>

		  <a class="btn btn-danger btn-xs " href="<?php echo base_url();?>index.php/welcome/delet/<?php echo $id = $results->id;?>" title="Delete Record"><i class="fa fa-trash-o"></i></a>

			</td>	  

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
