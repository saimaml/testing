            <!-- Main Content -->
            <div class="container-fluid">
                <div class="side-body">
                    <div class="page-title">
                        <span class="title">Delete Form </span>
                     </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card">
                               
                                <div class="card-body">
								<?php echo form_open_multipart("welcome/delete_product1"); ?>
                                    <form class="form-horizontal"id="contact-form" method="post" action="">
                                        <div class="form-group">
                                            <label for="service_id" class="col-sm-2 control-label">Service ID</label>
                                            <div class="col-sm-10">
                                                <input type="textbox" class="form-control" id="service_id" name="service_id" placeholder="Service ID" value="<?php if (isset($_POST['save'])){ echo $_POST['service_id'];} else { echo $posts['service_id'];}?>" required/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="plan_name" class="col-sm-2 control-label">Plan Name</label>
                                            <div class="col-sm-10">
                                                <input type="textbox" class="form-control" id="plan_name" name="plan_name" placeholder="Plan name" value="<?php if (isset($_POST['save'])){ echo $_POST['plan_name'];} else { echo $posts['plan_name'];}?>" required/>
                                            </div>
                                        </div>
										<div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="hidden" name="id" value="<?php echo $posts['id']; ?>" />
                                            </div>
                                        </div>
										<div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-default">Delete</button>
                                            </div>
                                        </div>
										
                                    </form>
									 <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
              <!-- Javascript Libs -->
            <script type="text/javascript" src="<?php echo base_url();?>/js/MS_14.js"></script>
            <script type="text/javascript" src="<?php echo base_url();?>/js/MS_11.js"></script>
            <script type="text/javascript" src="<?php echo base_url();?>/js/MS_12.js"></script>
            <script type="text/javascript" src="<?php echo base_url();?>/js/MS_10.js"></script>
            <script type="text/javascript" src="<?php echo base_url();?>/js/MS_7.js"></script>
            <script type="text/javascript" src="<?php echo base_url();?>/js/MS_13.js"></script>
            <script type="text/javascript" src="<?php echo base_url();?>/js/MS_5.js"></script>
            <script type="text/javascript" src="<?php echo base_url();?>/js/MS_4.js"></script>
            <script type="text/javascript" src="<?php echo base_url();?>/js/MS_3.js"></script>
            <script type="text/javascript" src="<?php echo base_url();?>/js/MS_2.js"></script>
            <script type="text/javascript" src="<?php echo base_url();?>/js/MS_19.js"></script>
            <!-- Javascript -->
            <script type="text/javascript" src="<?php echo base_url();?>/js/MS_1.js"></script>
            <script type="text/javascript" src="<?php echo base_url();?>/js/MS_0.js"></script>
</body>

</html>
