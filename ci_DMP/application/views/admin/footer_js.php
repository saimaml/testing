<script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
	<!--poonam-->	
<script src="<?php echo base_url(); ?>bootstrap/js/jquery-ui.js"></script>
<script>
function showImage(src,target) {
  var fr=new FileReader();
  // when image is loaded, set the src of the image where you want to display it
  fr.onload = function(e) { target.src = this.result; };
  src.addEventListener("change",function() {
    // fill fr with image data    
    fr.readAsDataURL(src.files[0]);
  });
}

var src = document.getElementById("src");
var target = document.getElementById("target");
showImage(src,target);
</script>

<script type="text/javascript">
$(document).ready(function() {
	var $tabs = $('#tabs').tabs({ selected: 0 }); 
	$("#addstudent").click(function(){ 
		$("#tabs").tabs({disabled: 'fragment-1'});
		$("#tabs").tabs({active: 1 });
	}); 
	$("#confirm").click(function(){
		$("#tabs").tabs({disabled: 'fragment-2'});
		$("#tabs").tabs({active: 0 });
	}); 
 
});
</script> 



 <!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>plugins/fastclick/fastclick.min.js"></script>
    <!-- Sparkline -->
<script src="<?php echo base_url(); ?>plugins/sparkline/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>



<script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- jvectormap -->
<script src="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo base_url(); ?>plugins/chartjs/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/function.js"></script>
<script src="<?php echo base_url(); ?>plugins/iCheck/icheck.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/select2/select2.full.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>dist/js/autocomplete/countries.js"></script>
<script src="<?php echo base_url(); ?>dist/js/autocomplete/jquery.autocomplete.js"></script>
<!-- <script src="dist/js/tabcontent.js" type="text/javascript"></script>
-->
<script src="<?php echo base_url(); ?>plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url(); ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url(); ?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
     <!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
	    <!-- Ion Slider -->
<script src="<?php echo base_url(); ?>plugins/ionslider/ion.rangeSlider.min.js"></script>
    <!-- Bootstrap slider -->
<script src="<?php echo base_url(); ?>plugins/bootstrap-slider/bootstrap-slider.js"></script>

<script>
	$(document).ready(function() {
    $('#example').DataTable( {
        "pagingType": "full_numbers"
    });
});
</script>


<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>

	<?php if(!$_SERVER['QUERY_STRING']){?>
<script src="<?php echo base_url(); ?>dist/js/pages/dashboard2.js"></script>
	<?php } ?>
	
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
	<script>
      $(function () { 
	  	$("#range_1").ionRangeSlider({ 
          min: 0,
          max: 5000,
          from: 1000,
          to: 4000,
          type: 'double',
          step: 1,
          prefix: "$",
          prettify: false,
          hasGrid: true
        });
	  	 $(".select2").select2();
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
		$("#example1").DataTable();
        $('#example2').DataTable();
		$('#with_out_pagination').DataTable({bPaginate:false,paging:false,"bInfo":false});
		$(".datemask").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
		$('.singledate').daterangepicker({singleDatePicker:true});
		
		$('#autocomplete-custom-append').autocomplete({
                    serviceUrl:"ajax.php?mode=controller&task=autocompltete&type=username",
                    appendTo: '#autocomplete-container',
					 dataType: 'json',
					 mustMatch: true,
					  onSelect: function(suggestion) {
					  	if(suggestion.data!='0'){
							$('#parent_id').val(suggestion.parent_id);
							$('#parent_name').html(suggestion.name);
						}else{
							$('#autocomplete-custom-append').val('');	
							$('#parent_id').val('');
							$('#parent_name').html('');
						}
					},
					onSearchStart:function() {
						$('#parent_id').val('');
							$('#parent_name').html('');
						}
          });
		 
      });
    </script>
