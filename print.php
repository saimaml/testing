<?php $id = $_POST["cart_master_id"];
		include_once('config/config.php');  $all_total=0;?>
<!DOCTYPE html>
<html lang="en">
    <head>
		<title>Discover My Pet</title> 
		<link rel="shortcut icon" href="<?php echo URL ?>images/favicon.png">
		<link href="<?php echo URL ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo URL ?>css/style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL ?>css/responsive.css" rel="stylesheet" type="text/css" />
		
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
	<?php  $sql_order = "SELECT id,date_purchase FROM tbl_cart_master WHERE id = '$id'";
						$result_order = mysqli_query($con,$sql_order); 
						$row_order = mysqli_fetch_array($result_order);
	?>
						<span class="bold">Order no : </span><span><?php echo $row_order["id"]; ?></span>
						<span class="bold">Date Purchased : </span><span><?php echo $row_order["date_purchase"]; ?></span>
		<table>
			<tr>
				<th>Sr No.</th>
				<th>Product Name</th>
				<th>Pack</th>
				<th>Price</th>
				<th>Quantity</th>
				<th>Order Total</th>
			</tr>
			<?php $i=1; $amt=0;
				
					$sql = "SELECT package_id,quantity,rate,pack_id FROM tbl_cart WHERE cart_master_id = '$id'";
					$result = mysqli_query($con,$sql);			
					while($row = mysqli_fetch_array($result))
					{
						$sql_product = "SELECT plan_name,rate FROM tbl_service_plans WHERE id ='".$row["package_id"]."'";
						$result_product =mysqli_query($con,$sql_product);
						$row_product = mysqli_fetch_array($result_product);
						
						$sql_pack = "SELECT pack FROM tbl_product_pack WHERE product_id='".$row["package_id"]."'";
						$result_pack = mysqli_query($con,$sql_pack);
						$row_pack = mysqli_fetch_array($result_pack);
						
					 ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row_product["plan_name"]; ?> </td>
				<td><?php echo $row_pack["pack"]; ?> </td>
				<td><?php echo $row["rate"]; ?></td>
				<td><?php echo $row["quantity"]; ?></td>
				<td> Rs.<?php $amt =$row["rate"] *$row["quantity"]; echo $amt ?>/- </td>
			</tr>
			
			<?php $all_total=$$all_total+$row["rate"] *$row["quantity"]; }  ?>
		
			<tr>
			<?php 
					$sql_shipping = "SELECT shipping,range1 FROM tbl_charges WHERE range1 < $all_total LIMIT 1";
					$result_shipping =mysqli_query($con,$sql_shipping);
					$row_shipping = mysqli_fetch_array($result_shipping);
					$shipping = $row_shipping['shipping']; ?>
				<td colspan="5">Shipping Charges</td>
				<td><?php echo $shipping; ?></td>
			</tr>
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