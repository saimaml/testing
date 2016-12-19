<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');
?>

<div class="content-wrapper">

<title>Home List</title>
<div style="width:100%;">
 <!-- Content Header (Page header) -->
      
        <!-- Main content -->
        <section class="content">
						
         <div class="row">
		 	<div class="col-xs-6">
			
				<div class="box box-primary">
          <div class="box-header">
            <?php echo form_open("admin_home/search_home"); ?>
            <div class="col-xs-12">
              <h3>Search Box....</h3>
            </div><br><br><br>
          	  <div class="col-xs-12">
                  <div class="form-group">
                    <label class="control-label">Home Name</label>
                     <input type="text" name="home_name" class="form-control" placeholder="Project Name">
                    <ul class="txtbname dropdown-menu" style="margin-left:15px;margin-right:0px;cursor:pointer" role="menu" aria-labelledby="dropdownMenu"  id="Dropdownbname">
                  </div>
              </div>
              <div class="col-xs-12">
                  <div class="form-group">
                    <button  class="btn btn-info" type="submit" >Search</button>
                  </div>
              </div>
            <?php echo form_close(); ?>
          </div><!-- /.box-header -->
          </div>
          </div>

        <div class="col-xs-12">
        <div class="box box-primary">
          <div class="box-header">
            <h3 style="float:left;">Home List</h3>
                <div class="box-body">
                 	 <table id="with_out_pagination" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Home Id</th>
                        <th>Home Name</th>
                        <th>Address</th>
                        <th>Pincode</th>
                        <th>City</th>
                        <th>Builder Name</th>
                        <th>Status</th>
                        <th>Amenities</th>
                        <th>Add Flats</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php 
                      foreach ($homes as $row)
                      {
                          $arrayName =unserialize($row->amenities);
                            ?>
                        <tr>
                            <td><?php echo $row->h_id;?></td>
                            <td><?php echo $row->project_name;?></td>
                            <td><?php echo $row->address;?></td>
                            <td><?php echo $row->pincode;?></td>
                            <td><?php echo $row->city;?></td>
                            <td><?php echo $row->builder_name;?></td>
                            <td><?php echo $row->home_project_type;?></td>
                            <td><?php 
                                for ($i=0; $i <sizeof($arrayName) ; $i++) { 
                                    foreach ($amenities as $rowame)
                                    {
                                        if($arrayName[$i]==$rowame->amenities_id)
                                        {
                                          echo $rowame->amenities_name."<br>";
                                        }
                                    }
                            } ?> </td>
                            <td><?php echo form_open("admin_home/create_flat"); ?><input type="hidden" name="h_id" value="<?php echo $row->h_id;?>"><button class="btn btn-primary " type="submit" value="Add Flat">Add Flat</button><?php echo form_close(); ?></td>
                        </tr>
                     <?php }
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