<?php 
$user_id = $this->session->userdata('user_id');	
if ($user_id == '1')
{  ?><aside class="main-sidebar">
<?php $username = $this->session->userdata('username'); ?>
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo base_url(); ?>application/views/upload_files/poonam.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p> <?php echo $username; ?></p>
              <!-- Status -->
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <!-- search form (Optional) -->
          
          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">MENUS</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active" ><a href="<?php echo site_url('welcome/profile/'); ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
			
			<li><a href="<?php echo site_url('welcome/app_user/'); ?>"><i class="fa fa-home text-aqua"></i> <span>App User</span></a></li>	
			 <li><a href="<?php echo site_url('welcome/social/'); ?>"><i class="fa fa-users text-aqua"></i> <span>Social</span></a></li>
			  <li><a href="<?php echo site_url('welcome/add_city/'); ?>"><i class="fa fa-home text-aqua"></i> <span>City</span></a></li>
			  <li><a href="<?php echo site_url('welcome/import/'); ?>"><i class="fa fa-home text-aqua"></i> <span>Import services</span></a></li>			 
			
			  
			<li class="treeview" ><a herf="#"><i class="fa fa-shopping-cart text-aqua"></i> <span> Product</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">   	
          <li><a href="<?php echo site_url('welcome/add_product/'); ?>">Add  Product</a></li>
          <li><a href="<?php echo site_url('welcome/list_product/'); ?>">List Of Product</a></li>
          <li><a href="<?php echo site_url('welcome/top_selling_product/'); ?>">Top Selling Product</a></li>
          <li><a href="<?php echo site_url('welcome/import_product/'); ?>">Import Of Product</a></li>	        
        </ul>
      </li>	   
	
	  <li class="treeview" ><a herf="#"><i class="fa fa-shopping-cart text-aqua"></i> <span> SMS Master</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">    
	
          <li><a href="<?php echo site_url('welcome/sms_master/'); ?>">Add  SMS Master</a></li>
          <li><a href="<?php echo site_url('welcome/list_sms_master/'); ?>">List Of SMS Master</a></li>         
        </ul>
      </li>
	  <li class="treeview" ><a herf="#"><i class="fa fa-shopping-cart text-aqua"></i> <span> Email Master</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">    
	
          <li><a href="<?php echo site_url('welcome/email_master/'); ?>">Add  Email Master</a></li>
          <li><a href="<?php echo site_url('welcome/list_email_master/'); ?>">List Of Email Master</a></li>         
        </ul>
      </li>
	  <li class="treeview" ><a herf="#"><i class="fa fa-shopping-cart text-aqua"></i> <span> Transaction</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">    
	
          <li><a href="<?php echo site_url('welcome/get_transaction_details/'); ?>">All Transaction</a></li>
          <li><a href="<?php echo site_url('welcome/get_transaction_vendor/'); ?>">Transaction of Vendor</a></li>
         
        </ul>
      </li>
	  <li class="treeview" ><a herf="#"><i class="fa fa-shopping-cart text-aqua"></i> <span>Campaign</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">    
	
          <li><a href="<?php echo site_url('welcome/cam_send_sms/'); ?>">Send SMS </a></li>
          <li><a href="<?php echo site_url('welcome/cam_send_email/'); ?>">Send Email</a></li>
		    <li><a href="<?php echo site_url('welcome/cam_send_grp_email/'); ?>">Send Group Email</a></li>
          <li><a href="<?php echo site_url('welcome/cam_send_grp_sms/'); ?>">Send Group SMS</a></li>
         
        </ul>
      </li>
	  <li class="treeview" ><a herf="#"><i class="fa fa-users text-aqua"></i> <span> Partner</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">    
	
          <li><a href="<?php echo site_url('welcome/add_vendor/'); ?>">Add Partner</a></li>
          <li><a href="<?php echo site_url('welcome/list_vendor/'); ?>">List Partner</a></li>
         
        </ul>
      </li>
	  <li class="treeview" ><a herf="#"><i class="fa fa-comment text-aqua"></i> <span> Blog</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">    
	
          <li><a href="<?php echo site_url('welcome/add_blog/'); ?>">Add Blog</a></li>
          <li><a href="<?php echo site_url('welcome/list_blog/'); ?>">List Blog</a></li>
         
        </ul>
      </li>
	  

	  
	 
      <!--- End Setting  Menu -->
		</ul><!-- /.sidebar-menu -->
	</section>
  <!-- /.sidebar -->
</aside>
<?php  } elseif($this->session->userdata('is_distributer') =="1") {  ?>
	<aside class="main-sidebar">
<?php $username = $this->session->userdata('username'); ?>
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo base_url(); ?>application/views/upload_files/poonam.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p> <?php echo $username; ?></p>
              <!-- Status -->
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>                  
          <!-- Sidebar Menu -->
		<ul class="sidebar-menu">
            <li class="header">MENUS</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active" ><a href="<?php echo site_url('welcome/profile/'); ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
			
			  <li class="active" ><a href="<?php echo site_url('welcome/importsms_user/'); ?>"><i class="fa fa-home text-aqua"></i> <span>Import File</span></a></li>
			  <li><a href="<?php echo site_url('welcome/list_sendsms/'); ?>"><i class="fa fa-home text-aqua"></i> <span>Send SMS User List</span></a></li>
		</ul>
		</li>
	
      <!--- End Setting  Menu -->
		</ul><!-- /.sidebar-menu -->
	</section>
  <!-- /.sidebar -->
</aside>
<?php }  elseif($this->session->userdata('is_distributer') =="2") {  ?>
	<aside class="main-sidebar">
<?php $username = $this->session->userdata('username'); ?>
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo base_url(); ?>application/views/upload_files/poonam.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p> <?php echo $username; ?></p>
              <!-- Status -->
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>                  
          <!-- Sidebar Menu -->
		<ul class="sidebar-menu">
            <li class="header">MENUS</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active" ><a href="<?php echo site_url('welcome/profile/'); ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
			 <li class="active" ><a href="<?php echo site_url('welcome/setting/'); ?>"><i class="fa fa-home text-aqua"></i> <span>Setting</span></a></li>
	
			  <li><a href="<?php echo site_url('welcome/importsms_user/'); ?>"><i class="fa fa-home text-aqua"></i> <span>Import User File</span></a></li> 
			  <li><a href="<?php echo site_url('welcome/list_sendsms/'); ?>"><i class="fa fa-home text-aqua"></i> <span>Send SMS User List</span></a></li>
			  	 
			
			<li  class="treeview" ><a herf="#"><i class="fa fa-shopping-cart text-aqua"></i> <span> Product</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">    
	
          <li><a href="<?php echo site_url('welcome/add_product/'); ?>">Add  Product</a></li>
          <li><a href="<?php echo site_url('welcome/list_product_vendor/'); ?>">List Of Product</a></li> <li><a href="<?php echo site_url('welcome/import_product_vendor/'); ?>">Import Of Product</a></li>
		
		</ul>
		
	
      <!--- End Setting  Menu -->
		</ul><!-- /.sidebar-menu -->
	</section>
  <!-- /.sidebar -->
</aside>
<?php }  else {   ?>
<aside class="main-sidebar">
<?php $username = $this->session->userdata('username'); ?>
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar user panel (optional) -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo base_url(); ?>application/views/upload_files/poonam.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p> <?php echo $username; ?></p>
              <!-- Status -->
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>

          <!-- search form (Optional) -->
          
          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <li class="header">MENUS</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active" ><a href="<?php echo site_url('welcome/profile/'); ?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
			
			  <li class="active" ><a href="<?php echo site_url('welcome/setting/'); ?>"><i class="fa fa-home text-aqua"></i> <span>Setting</span></a></li>
	
			
			<li  class="treeview" ><a herf="#"><i class="fa fa-shopping-cart text-aqua"></i> <span> Product</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">    
	
          <li><a href="<?php echo site_url('welcome/add_product/'); ?>">Add  Product</a></li>
          <li><a href="<?php echo site_url('welcome/list_product_vendor/'); ?>">List Of Product</a></li> <li><a href="<?php echo site_url('welcome/import_product_vendor/'); ?>">Import Of Product</a></li>
		
         
        </ul>
      </li>
	
      <!--- End Setting  Menu -->
		</ul><!-- /.sidebar-menu -->
	</section>
  <!-- /.sidebar -->
</aside>
<?php } ?>