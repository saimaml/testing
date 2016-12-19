<?php
	include_once('config/config.php'); 
    
    //get search term
    $searchTerm = $_GET['term'];
     
	$sql = "SELECT d.name as name,m.service_master FROM tbl_service_details as d,tbl_service_master as m WHERE d.name LIKE '%".$searchTerm."%' OR m.service_master LIKE '%".$searchTerm."%' and d.service_cat_id  = m.id GROUP by d.name ORDER BY d.name ASC ";
	  
	$result = mysqli_query($con,$sql);
	while($row =mysqli_fetch_assoc($result))
	{
	 $data[] = $row['name'];
	}    
	//return json data
    echo json_encode($data);
?>