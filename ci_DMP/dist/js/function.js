$(document).on("click", "#admin_login", function(event) {

	var counter=0;

	var username=$("#username").val();

	var password=$('#password').val();

	if(($.trim(username) == '')&&(username.length==0)){

		$("#username").css("border", "1px solid red");

		counter++;

	}else{

		$("#username").css("border", "#d2d6de")

		}

	if(($.trim(password) == '')&&(password.length==0)){

		$("#password").css("border", "1px solid red");

		counter++;

	}else{

		$("#password").css("border", "#d2d6de")

		}

	if(counter==0){

			$.getJSON("ajax.php?mode=controller", {task:'login', username:username,password:password}, function (response) {

					if(response['sucess']){

						location.reload();

					}else{

						$('.error').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>  <h4><i class="icon fa fa-ban"></i> ERROR!</h4>Invalide Username Or Password...</div>');

					}																																								 				});	

		}else{

			return false;		

			}	



	

});

$(document).on("click", ".btn_validator", function(event) {

		var buttonElement = $(this);

		var counter=0;

		$('.required').each(function() {

			var currentElement = $(this);

			var value = $.trim(currentElement.val());

			if(value==""||value.length==0){

				$(this).css("border", "1px solid red");

				counter++;

			}else{

				$(this).css("border", "1px solid #d2d6de");

				}

		});

		if(counter==0){

			$('#'+buttonElement.attr('data-frm')).submit();

			}

});


$('#check_all').on('ifChecked', function(event) { // Sangita

		$(".check_all").iCheck('check');

		$('.icheckbox_square-blue').removeClass('active');

	})

$('#check_all').on('ifUnchecked', function(event) { // Sangita

		$(".check_all").iCheck('uncheck');

		$('.icheckbox_square-blue').removeClass('active');

	})


$(document).on("change", ".photo_validate", function(event) {

	var file = this.files[0];

			var imagefile = file.type;

			var match= ["image/jpeg","image/png","image/jpg"];	

			if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))

			{

				$(this).val('');

				alert('jpeg , png , jpg files allowed');

				return false;

			}

            else

			{

               

            }		

});

$(document).on("change", ".required", function(event) {

	var currentElement = $(this);

	var value = $.trim(currentElement.val());

	if(value==""||value.length==0){

		$(this).css("border", "1px solid red");

			}else{

				$(this).css("border", "1px solid #d2d6de");

			}

});



$(".cust_msg").delay(5000).fadeOut();

$(".check_unquie").change(function() {

	var table=$(this).attr('data-table');

	var field=$(this).attr('id');

	var value=$(this).val();

	var data_task=$(this).attr('data-task');

	var record_id=$(this).attr('data-id');

	var placeholder=$(this).attr('data-msg')

	var path='ajax.php?mode=controller'; 

	$.getJSON("ajax.php?mode=controller", {"task":data_task,"table":table,"field":field,"value":value,"record_id":record_id}, function (response) {

		if(response['sucess']){

		 }else{

			alert( placeholder + ' alerady Exists')

			$('#'+field).val('');

		}		

	});

	

});


$(document).on('keypress',".no_space",function(event){

    var regex = new RegExp("^[ ]+$");

    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);

    if (regex.test(key)) {

    	event.preventDefault();

    	return false;

    }

});



$(document).on('keypress',".no_number",function(event){

    var regex = new RegExp("^[0-9]+$");

    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);

    if (regex.test(key)) {

    	event.preventDefault();

    	return false;

    }

});

$(document).on('keypress',".no_chara",function(event){

    var regex = new RegExp("^[a-zA-Z]+$");

    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);

    if (regex.test(key)) {

    	event.preventDefault();

    	return false;

    }

});



$(document).on('keypress',".percentage_val",function(event){

	var val=parseFloat($(this).val());

	if(val>100){

		alert('Percentage not greater than 100');

		$(this).val('');

		return false;	

	}

	

});



$(document).on('change',".check_tomax",function(event){

	var minqty=parseFloat($('#'+$(this).attr('data-from')).val());

	var maxqty=parseFloat($('#'+$(this).attr('data-to')).val());

	if((minqty>maxqty)){

		alert($(this).attr('data-msg'));

		$(this).val('');

		return false;	

	}

	

});



$(document).on('keypress',".no_special",function(event){

    var regex = new RegExp("^[a-zA-Z 0-9\b\t]+$");

    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode); 

	if((event.keyCode==9)||(event.keyCode==13)){

		return true;

		}

	if($( this ).hasClass( "allow_dot" )){

		if(key=='.'){

			return true;	

		}	

	}else{

    if (!regex.test(key)) {

    	event.preventDefault();

    	return false;

    }

	}

});

$(document).on('click',".confirm_delete",function(event){

		if(confirm("Do You Want To Delete This Record ?")){

			return true;

		}else{

			return false;	

		}

		

});

$(document).on('change',".email_valide",function(event){

  var email=$('#email').val(); 

		if(email.length){

			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

			 if(regex.test(email)){

			 }else{

				 $(this).val('');

				 alert('Invalid Email Address')

				 }

		}

});



$(document).on('change',".match_val",function(event){

	var val=$(this).val();

	var val1=$('#'+$(this).attr('data-parent')).val();

	if(val==val1){

	}else{

		$(this).val('');

		alert($(this).attr('data-msg'))	;

		return false;

	}

});

$(document).on('click',".max_show",function(event){

	var val=$(this).attr('data-limit');

	$('#max_show').val(val);

	$('#'+$(this).attr('data-form')).submit();

});

$(document).on('click',".pagination_call",function(event){

	var val=$(this).attr('data-from');

	$('#page_limit_from').val(val);

	$('#max_show').val($(this).attr('data-to'));

	$('#'+$(this).attr('data-form')).submit();

});

$(document).on('click','.detail_view',function(event){

	$('#detail_body').html('')

	$.getJSON("ajax.php?mode=controller", {task:'detail_view', type:'flight',id:$(this).attr('data-rc')}, function (response) {

	if(response['sucess']){

		$('#detail_body').html(response['html'])

		$('#detailModal').modal('show');

	}else{

		$('#detailModal').modal('hide');

	}	

	});

});





$(document).on('click','.assign_action',function(event){

	var action =$(this).attr('data-action');

	var from_id=$(this).attr('data-to-form');

	$('#'+from_id).attr('action',action);

});



$(document).on('click','.export_class',function(event){

	var action =$(this).attr('data-go');

	var from_id=$(this).attr('data-frm');

	$('#'+from_id).attr('action',action);  

	$('#'+from_id).submit();

});



/*	  25 Feb 2016

	  created by Poonam 

	  */

$(document).on('click','.detail_view_hotel',function(event){

	$.getJSON("ajax.php?mode=controller", {task:'detail_view', type:'hotel',id:$(this).attr('data-rc')}, function (response) {

	if(response['sucess']){

		$('#detail_body').html(response['html'])

		$('#detailModal').modal('show');

	}else{

		$('#detailModal').modal('hide');

	}	

	});

});



/*	  26 Feb 2016

	  created by Sangita

	  */



$('.select2').on("select2:select", function(e) { 

 	if($(this).hasClass('set_comm_runtime')){

	var val=$(this).val();

		if(val){

			$('#hotel_commission').val($('#org_name').children('option:selected').attr('data-hotel'));

			$('#flight_commission').val($('#org_name').children('option:selected').attr('data-flight'));

			$('#package_commission').val($('#org_name').children('option:selected').attr('data-package'));

			$('#comm_id').val($('#org_name').children('option:selected').attr('data-comm-id'));

			$('#save_comm').removeAttr('disabled');

		 }else{

			 $('#hotel_commission').val('');

			 $('#flight_commission').val('');

			 $('#package_commission').val('');

			 $('#comm_id').val(''); 

			 $('#save_comm').prop('disabled',true);

			 }

	}

});



$('.check_all').change(function () {	
  $('#example tr td input[type="checkbox"]').prop('checked', $(this).prop('checked'));
}); 

  
  /*  $('.check_all').change(function(){
	  alert("Hi");
    var cells = $('#example').cells().nodes();
    $( cells ).find(':checkbox').prop('checked', $(this).is(':checked'));
}); */




$(document).on('click','#save_comm',function(event){

	$.getJSON("ajax.php?mode=controller", {task:'save_customer_commission', comm_id:$('#comm_id').val() , type:$('#type').val() ,hotel_commission:$('#hotel_commission').val(),flight_commission:$('#flight_commission').val(),package_commission:$('#package_commission').val() }, function (response) {

		if(response['sucess']){

			alert(response['msg']);

			location.reload();

		}

	});

});

