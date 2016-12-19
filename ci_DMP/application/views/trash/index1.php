<!DOCTYPE html>
<html>
<body>

<?php

$this->load->view('include_files');
?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php
$this->load->view('header');
$this->load->view('left_side');
?>

<div class="content-wrapper">
</div>
</div>
<?php 
$this->load->view('footer');
?>
<div class="control-sidebar-bg"></div>
</div>
<?php
$this->load->view('footer_js');
?>
</body>
</html>