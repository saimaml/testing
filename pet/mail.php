<?php 
function register_mail($name,$email,$password) // For Register mail			
{
	$to = $email;
	$subject = "Discover My Pet User";
	$message = "<html>
				<head><title>Registration details of Discovermypet</title></head>
				<body>	
					<table style='margin:0;padding:0;width:100%!important;line-height:100%!important' width='100%' cellspacing='0' cellpadding='0' border='0' height='100%'>
					<tbody><tr>	
					<td valign='top' bgcolor='ECECEC' background='bg_grey.gif' align='center'>	
					<table width='700' cellpadding='0' border='0'>
					<tbody><tr>
					<td valign='top' align='left'>
					<table width='100%' cellspacing='0' cellpadding='0' border='0'>
					<td width='155' valign='bottom' align='left' height='56'><img src='dmp_logoTNM.png' alt='Discovermypet' style='outline:none;display:block' class='CToWUd' width='169' border='0' height='70'></td>
					</tr></tbody>
				</table>
							";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <info@discovermypet.in>' . "\r\n";


mail($to,$subject,$message,$headers);
}
function mail_booking($order_id)
{	include_once('config/config.php'); 
	$sql ="SELECT id,date_purchase,billing_email,billing_name,billing_tel,billing_address,billing_city,billing_country,billing_state,billing_zip,delivery_name,delivery_state,delivery_address,delivery_city,delivery_zip,delivery_country FROM `tbl_cart_master` WHERE `id`='".$order_id."' ";
	$result =mysql_query($sql);
	$row=mysql_fetch_array($result);	
	$sql_get_product = "SELECT product_id,attribute_id,quantity,rate FROM tbl_cart WHERE cart_master_id = '".$row['id']."'";
	$result_get_product = mysql_query($sql_get_product);
	$email = $row["billing_email"];

$to = $email;

$subject = "Discover My Pet Admin";

$message = "
		<html>
		<head>
			<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
			<title>Discover My Pet</title>
			
		</head>
		<body>
			<div><img src='images/logo.png' alt='Discover My Pet'/></div>
			<p>Thank you for your interest in Discover My Pet products. Your order has been received and will be processed once payment has been confirmed.</p>
			<table style='border:1px solid #ccc;width:500px;'>
				<tr>
					<th style='background-color:#ccc;' colspan='2'>Order Details</th>
				</tr>
				<tr>
				
					<td style='border:1px solid #ccc;'>
						<b>Order ID :</b> <span>".$row['id']."</span><br/>
						<b>Date added : </b><span>".$row['date_purchase']."</span><br/>						 
						<b>Payment Method :</b><span>Cash On Delivery</span><br/>
						<b>Shipping Method : </b><span>Flat</span>
					</td>
					<td style='border:1px solid #ccc;'>
						<b>Email : </b><span>".$email."</span><br/>
						<b>Telephone : </b> <span>".$row['billing_tel']."</span><br/>
						<b>IP Address : </b><span>116.75.2.111</span><br/>						 
					</td>				
				</tr>
			</table>
			<div style='margin-top:20px;'></div>
			<table>
				<tr>
					<th style='background-color:#ccc;'>Payment Address</th>
					<th style='background-color:#ccc;'>Shipping Address</th>
				</tr>
				<tr>
				
					<td style='border:1px solid #ccc;'>
						".$row['billing_name']."<br/>
						Udyot Solution<br/>
						".$row['billing_address']."<br/>
						".$row['billing_city'].$row['billing_zip']."<br/>				
						".$row['billing_country']."<br/>						
					</td>
					<td style='border:1px solid #ccc;'>
					
						".$row['delivery_name']."<br/>
						".$row['delivery_address']."<br/>						
						".$row['delivery_city'].$row['delivery_zip']."<br/>	
						".$row['delivery_country']."<br/>						
					</td>				
				</tr>
			</table>
			<div style='margin-top:20px;'></div>
			<table>
				<tr>
					<th style='background-color:#ccc;'>Product</th>
					<th style='background-color:#ccc;'>Quantity</th>
					<th style='background-color:#ccc;'>Price</th>
					<th style='background-color:#ccc;'>Total</th>
				</tr>";
				while($row_get_product=mysql_fetch_array($result_get_product))
				{
					$sql_product="SELECT plan_name FROM tbl_service_plans WHERE id = '".$row_get_product['package_id']."'";
					$result_product = mysql_query($sql_product);
					$row_product = mysql_fetch_array($result_product);		
				
			$message .=	"<tr>				
					<td style='border:1px solid #ccc;'>".$row_product['plan_name']."</td>
					<td style='border:1px solid #ccc;'>".$row_get_product['quantity']."</td>	
					<td style='border:1px solid #ccc;'>".$row_get_product['rate']."</td>
					<td style='border:1px solid #ccc;'>".$row_get_product['quantity']*$row_get_product['rate']."</td>				
				</tr>";
				$all_total = $all_total + $row_get_product['quantity']*$row_get_product['rate'];
				}
				$message .=	"<tr>				
					<td style='border:1px solid #ccc;' colspan='3'>Sub-Total : </td>
					<td style='border:1px solid #ccc;'>Rs.".$all_total."</td>				
				</tr>";
				$sql_shipping = "SELECT shipping,range1 FROM tbl_charges WHERE range1 < $all_total LIMIT 1";
				$result_shipping =mysql_query($sql_shipping);
				$row_shipping = mysql_fetch_array($result_shipping);
				$shipping = $row_shipping['shipping'];		

			$message .="<tr>				
					<td style='border:1px solid #ccc;' colspan='3'>Per Item Shipping Rate : </td>
					<td style='border:1px solid #ccc;'>Rs.".$shipping."</td>				
				</tr>";
				$amt = $all_total + $shipping;
			$message .="<tr>				
					<td style='border:1px solid #ccc;' colspan='3'>Total : </td>
					<td style='border:1px solid #ccc;'>Rs.".$amt."</td>				
				</tr> 
			</table>
			<p>Please reply to this email if you have any questions.</p>
		</body>
</html>
			";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <info@discovermypet.in>' . "\r\n";


mail($to,$subject,$message,$headers);
}function mail_booking1($order_id){	include_once('config/config.php'); 	$sql ="SELECT id,date_purchase,billing_email,billing_name,billing_tel,billing_address,billing_city,billing_country,billing_state,billing_zip,delivery_name,delivery_state,delivery_address,delivery_city,delivery_zip,delivery_country FROM `tbl_cart_master` WHERE `id`='".$order_id."' ";	$result =mysql_query($sql);	$row=mysql_fetch_array($result);		$sql_get_product = "SELECT product_id,attribute_id,quantity,rate FROM tbl_cart WHERE cart_master_id = '".$row['id']."'";	$result_get_product = mysql_query($sql_get_product);	$email = $row["billing_email"];$to = "poonams@indiawebinfotech.com";$subject = "Discover My Pet Admin";$message = "		<html>		<head>			<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>			<title>Discover My Pet</title>					</head>		<body>			<div><img src='images/logo.png' alt='Discover My Pet'/></div>			<p>Thank you for your interest in Discover My Pet products. Your order has been received and will be processed once payment has been confirmed.</p>			<table style='border:1px solid #ccc;width:500px;'>				<tr>					<th style='background-color:#ccc;' colspan='2'>Order Details</th>				</tr>				<tr>									<td style='border:1px solid #ccc;'>						<b>Order ID :</b> <span>".$row['id']."</span><br/>						<b>Date added : </b><span>".$row['date_purchase']."</span><br/>						 						<b>Payment Method :</b><span>Cash On Delivery</span><br/>						<b>Shipping Method : </b><span>Flat</span>					</td>					<td style='border:1px solid #ccc;'>						<b>Email : </b><span>".$email."</span><br/>						<b>Telephone : </b> <span>".$row['billing_tel']."</span><br/>						<b>IP Address : </b><span>116.75.2.111</span><br/>						 					</td>								</tr>			</table>			<div style='margin-top:20px;'></div>			<table>				<tr>					<th style='background-color:#ccc;'>Payment Address</th>					<th style='background-color:#ccc;'>Shipping Address</th>				</tr>				<tr>									<td style='border:1px solid #ccc;'>						".$row['billing_name']."<br/>						Udyot Solution<br/>						".$row['billing_address']."<br/>						".$row['billing_city'].$row['billing_zip']."<br/>										".$row['billing_country']."<br/>											</td>					<td style='border:1px solid #ccc;'>											".$row['delivery_name']."<br/>						".$row['delivery_address']."<br/>												".$row['delivery_city'].$row['delivery_zip']."<br/>							".$row['delivery_country']."<br/>											</td>								</tr>			</table>			<div style='margin-top:20px;'></div>			<table>				<tr>					<th style='background-color:#ccc;'>Product</th>					<th style='background-color:#ccc;'>Quantity</th>					<th style='background-color:#ccc;'>Price</th>					<th style='background-color:#ccc;'>Total</th>				</tr>";				while($row_get_product=mysql_fetch_array($result_get_product))				{					$sql_product="SELECT plan_name FROM tbl_service_plans WHERE id = '".$row_get_product['package_id']."'";					$result_product = mysql_query($sql_product);					$row_product = mysql_fetch_array($result_product);									$message .=	"<tr>									<td style='border:1px solid #ccc;'>".$row_product['plan_name']."</td>					<td style='border:1px solid #ccc;'>".$row_get_product['quantity']."</td>						<td style='border:1px solid #ccc;'>".$row_get_product['rate']."</td>					<td style='border:1px solid #ccc;'>".$row_get_product['quantity']*$row_get_product['rate']."</td>								</tr>";				$all_total = $all_total + $row_get_product['quantity']*$row_get_product['rate'];				}				$message .=	"<tr>									<td style='border:1px solid #ccc;' colspan='3'>Sub-Total : </td>					<td style='border:1px solid #ccc;'>Rs.".$all_total."</td>								</tr>";				$sql_shipping = "SELECT shipping,range1 FROM tbl_charges WHERE range1 < $all_total LIMIT 1";				$result_shipping =mysql_query($sql_shipping);				$row_shipping = mysql_fetch_array($result_shipping);				$shipping = $row_shipping['shipping'];					$message .="<tr>									<td style='border:1px solid #ccc;' colspan='3'>Per Item Shipping Rate : </td>					<td style='border:1px solid #ccc;'>Rs.".$shipping."</td>								</tr>";				$amt = $all_total + $shipping;			$message .="<tr>									<td style='border:1px solid #ccc;' colspan='3'>Total : </td>					<td style='border:1px solid #ccc;'>Rs.".$amt."</td>								</tr> 			</table>			<p>Please reply to this email if you have any questions.</p>		</body></html>			";// Always set content-type when sending HTML email$headers = "MIME-Version: 1.0" . "\r\n";$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";// More headers$headers .= 'From: <info@discovermypet.in>' . "\r\n";mail($to,$subject,$message,$headers);}
function mail_vendor($order_id)
{	
	include_once('config/config.php'); 
	
	$sql ="SELECT id,date_purchase,billing_email,billing_name,billing_tel,billing_address,billing_city,billing_country,billing_state,billing_zip,delivery_name,delivery_state,delivery_address,delivery_city,delivery_zip,delivery_country FROM `tbl_cart_master` WHERE `id`='".$order_id."' ";
	$result =mysql_query($sql);
	$row=mysql_fetch_array($result);
	
	$sql_vendor_id = "SELECT vendor_id FROM tbl_cart WHERE session_id = '".$session_id."'";
	$result_vendor_id = mysql_query($sql_vendor_id);
	while($row_vendor_id = mysql_fetch_array($result_vendor_id))
	{
		$sql_vendor = "SELECT email FROM tbl_vendor WHERE id ='".$row_vendor_id['vendor_id']."'";
		$result_vendor = mysql_query($sql_vendor);
		$row_vendor = mysql_fetch_array($result_vendor);
		$email_vendor = $row_vendor["email"];
		
		$sql_get_product = "SELECT product_id,attribute_id,quantity,rate FROM tbl_cart WHERE vendor_id = '".$row_vendor_id['vendor_id']."'";
		$result_get_product = mysql_query($sql_get_product);
		
		
		$to = $email_vendor;

		$subject = "Discover My Pet Vendor";

		$message = "
				<html>
				<head>
					<meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
					<title>Discover My Pet</title>
					
				</head>
				<body>
					<div><img src='images/logo.png' alt='Discover My Pet'/></div>
					<p>Thank you for your interest in Discover My Pet products. Your order has been received and will be processed once payment has been confirmed.</p>
					<table style='border:1px solid #ccc;width:500px;'>
						<tr>
							<th style='background-color:#ccc;' colspan='2'>Order Details</th>
						</tr>
						<tr>
						
							<td style='border:1px solid #ccc;'>
								<b>Order ID :</b> <span>".$row['id']."</span><br/>
								<b>Date added : </b><span>".$row['date_purchase']."</span><br/>						 
								<b>Payment Method :</b><span>Cash On Delivery</span><br/>
								<b>Shipping Method : </b><span>Flat</span>
							</td>
							<td style='border:1px solid #ccc;'>
								<b>Email : </b><span>".$email."</span><br/>
								<b>Telephone : </b> <span>".$row['billing_tel']."</span><br/>
								<b>IP Address : </b><span>116.75.2.111</span><br/>						 
							</td>				
						</tr>
					</table>
					<div style='margin-top:20px;'></div>
					<table>
						<tr>
							<th style='background-color:#ccc;'>Payment Address</th>
							<th style='background-color:#ccc;'>Shipping Address</th>
						</tr>
						<tr>
						
							<td style='border:1px solid #ccc;'>
								".$row['billing_name']."<br/>
								Udyot Solution<br/>
								".$row['billing_address']."<br/>
								".$row['billing_city'].$row['billing_zip']."<br/>				
								".$row['billing_country']."<br/>						
							</td>
							<td style='border:1px solid #ccc;'>
							
								".$row['delivery_name']."<br/>
								".$row['delivery_address']."<br/>						
								".$row['delivery_city'].$row['delivery_zip']."<br/>	
								".$row['delivery_country']."<br/>						
							</td>				
						</tr>
					</table>
					<div style='margin-top:20px;'></div>
					<table>
						<tr>
							<th style='background-color:#ccc;'>Product</th>
							<th style='background-color:#ccc;'>Quantity</th>
							<th style='background-color:#ccc;'>Price</th>
							<th style='background-color:#ccc;'>Total</th>
						</tr>";
						while($row_get_product=mysql_fetch_array($result_get_product))
						{
							$sql_product="SELECT plan_name FROM tbl_service_plans WHERE id = '".$row_get_product['product_id']."'";
							$result_product = mysql_query($sql_product);
							$row_product = mysql_fetch_array($result_product);		
						
					$message .=	"<tr>				
							<td style='border:1px solid #ccc;'>".$row_product['plan_name']."</td>
							<td style='border:1px solid #ccc;'>".$row_get_product['quantity']."</td>	
							<td style='border:1px solid #ccc;'>".$row_get_product['rate']."</td>
							<td style='border:1px solid #ccc;'>".$row_get_product['quantity']*$row_get_product['rate']."</td>				
						</tr>";
						$all_total = $all_total + $row_get_product['quantity']*$row_get_product['rate'];
						}
						$message .=	"<tr>				
							<td style='border:1px solid #ccc;' colspan='3'>Sub-Total : </td>
							<td style='border:1px solid #ccc;'>Rs.".$all_total."</td>				
						</tr>";
						$sql_shipping = "SELECT shipping,range1 FROM tbl_charges WHERE range1 < $all_total LIMIT 1";
						$result_shipping =mysql_query($sql_shipping);
						$row_shipping = mysql_fetch_array($result_shipping);
						$shipping = $row_shipping['shipping'];		

					$message .="<tr>				
							<td style='border:1px solid #ccc;' colspan='3'>Per Item Shipping Rate : </td>
							<td style='border:1px solid #ccc;'>Rs.".$shipping."</td>				
						</tr>";
						$amt = $all_total + $shipping;
					$message .="<tr>				
							<td style='border:1px solid #ccc;' colspan='3'>Total : </td>
							<td style='border:1px solid #ccc;'>Rs.".$amt."</td>				
						</tr> 
					</table>
					<p>Please reply to this email if you have any questions.</p>
				</body>
		</html>
					";

		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$headers .= 'From: <info@discovermypet.in>' . "\r\n";

		mail($to,$subject,$message,$headers);
	}
}

?> 