<?php
	include_once('config/config.php'); 
    
    //get search term
    $searchTerm = $_GET['term'];     
	
	$sql = "SELECT plan_name,m.main_category FROM tbl_service_plans as d,tbl_product_main_cat as m WHERE d.plan_name LIKE '%".$searchTerm."%' OR m.main_category LIKE '%".$searchTerm."%' and d.main_category_id  = m.id GROUP by plan_name ORDER BY d.plan_name ASC ";
	  
	$result = mysqli_query($con,$sql);
	while($row =mysqli_fetch_assoc($result))
	{
	 $data[] = $row['plan_name'];
	}    
	//return json data
    echo json_encode($data);
?>