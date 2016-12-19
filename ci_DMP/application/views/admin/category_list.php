<?php
$this->load->view('admin/header');
$this->load->view('admin/left_side');
?>
<div class="content-wrapper">
<title>Category List</title>
<div style="width:100%;">
 <!-- Content Header (Page header) -->     
        <!-- Main content -->
        <section class="content">					
         <div class="row">
		 	<div class="col-xs-6">
			
				<div class="box box-primary">
          <div class="box-header">
            <?php echo form_open("admin/search_flat"); ?>
            <div class="col-xs-12">
              <h3>Search Box....</h3>
            </div><br><br><br>
          	  <div class="col-xs-12">
                  <div class="form-group">
                    <label class="control-label">Category Name</label>
                     <input type="text" name="category_name" class="form-control" placeholder="Flat No!">
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
            <h3 style="float:left;">Category List</h3>
                <div class="box-body">
                 	 <table id="with_out_pagination" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Sr No</th>
                        <th>Category Name</th>
                        
                        <th>Photo</th>
                        <th>Modify</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                  <?php $i=1;
                      foreach ($category as $row)
                      { 
                            ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $row->catogories_name;?></td>
                            <td><img src="<?php echo base_url(); ?>uploads/<?php echo $row->cat_img;?>" alt="img" width=50px height=50px> </td>
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