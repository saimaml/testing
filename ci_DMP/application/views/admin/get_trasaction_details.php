<?php
foreach ($posts as $row)
{ 
	$id = $row->cart_master_id;
	
} 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
		<title>Discovermypet</title> 
		<link rel="shortcut icon" href="images/favicon.png">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
				
		<style>
			table
			{
				border:1px solid black;
			}
			th
			{
				border:1px solid black;
				padding:20px;
				background-color:#ccc;
			}
			td
			{
				border:1px solid black;
				padding:20px;
				
			}
		</style>
    </head>
	<body>
	<?php
	$aVar=mysqli_connect("172.31.20.191","root","vistart3","DMP");
	$sql_order = "SELECT id,date_purchase,billing_name,billing_email,billing_tel,billing_address,billing_country,delivery_name,delivery_address,delivery_country FROM tbl_cart_master WHERE id = '$id'";
						$result_order = mysqli_query($aVar,$sql_order); 
						$row_order = mysqli_fetch_array($result_order);
						$all_total =0;
	?><table style="border:1px solid #000;width:580px">
				<tbody><tr>
					<th colspan="2" style="background-color:#ccc">Order Details</th>
				</tr>
				<tr>				
					<td style="border:1px solid #ccc">
						<b>Order ID :</b> <span><?php echo $row_order["id"]; ?></span><br>
						<b>Date added : </b><span><?php echo $row_order["date_purchase"]; ?></span><br>						 
						<b>Payment Method :</b><span>Cash On Delivery</span><br>
						<b>Shipping Method : </b><span>Flat</span>
					</td>
					<td style="border:1px solid #ccc">
						<b>Email : </b><span><a target="_blank" href="mailto:poonams@indiawebinfotech.com"><?php echo $row_order["billing_email"]; ?></a></span><br>
						<b>Telephone : </b> <span><?php echo $row_order["billing_tel"]; ?></span><br>
						<!--<b>IP Address : </b><span><?php echo $ip;  ?></span><br>						 -->
					</td>				
				</tr>
			</tbody></table>
			<table style="border:1px solid #000;width:580px">
				<tbody><tr>
					<th style="background-color:#ccc">Payment Address</th>
					<th style="background-color:#ccc">Shipping Address</th>
				</tr>
				<tr>
				
					<td style="border:1px solid #ccc">
						<?php echo $row_order["billing_name"]; ?><br>
						<?php echo $row_order["billing_address"]; ?><br>
						<?php echo $row_order["billing_country"]; ?><br>					
					</td>
					<td style="border:1px solid #ccc">
					
						<?php echo $row_order["delivery_name"]; ?><br>
						<?php echo $row_order["delivery_address"]; ?><br>
						<?php echo $row_order["delivery_country"]; ?><br>					
					</td>				
				</tr>
			</tbody></table>
						
		<table>
			<tr>
				<th>Sr No.</th>
				<th>Product Name</th>
				
				<th>Price</th>
				<th>Attribute</th>
			
				<th>Quantity</th>
				<th>Order Total</th>
			</tr>
			<?php $i=1; $amt=0;
				
				 $sql = "SELECT quantity,rate,product_id,attribute_id FROM tbl_cart WHERE cart_master_id = '$id'";
					$result = mysqli_query($aVar,$sql);			
					while($row = mysqli_fetch_array($result))
					{
						$sql_product = "SELECT plan_name,rate FROM tbl_service_plans WHERE id ='".$row["product_id"]."'";
						$result_product =mysqli_query($aVar,$sql_product);
						$row_product = mysqli_fetch_array($result_product);
						
						
						
					 ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row_product["plan_name"]; ?> </td>
				
				<td><?php echo $row["rate"]; ?></td>
				<td>
				<?php
					
						$sql_attr = "SELECT weight_id,size_name,price,img FROM tbl_product_attribute WHERE id ='".$row['attribute_id']."'";
						$result_attr = mysqli_query($aVar,$sql_attr);
						$row_attr = mysqli_fetch_array($result_attr);						
							echo $row_attr["size_name"].",";
				?></td>
				<td><?php echo $row["quantity"]; ?></td>
				<td> Rs.<?php $amt =$row["rate"] *$row["quantity"]; echo $amt ?>/- </td>
			</tr>
			
			<?php $all_total= $all_total+$row["rate"] *$row["quantity"]; }  ?>
		
			
			<tr>
				<td colspan="5">Total</td>
				<td>Rs.<?php echo $all_total;?>/-</td>
			</tr>
		</table>
		
		<FORM>
			<INPUT TYPE="button" value="Print" onClick="window.print()"/>
		</FORM>
	</body>
</html>