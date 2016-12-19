<?php
include_once('config/config.php'); 
$mode=$_REQUEST['mode'];
switch ($mode) {
 
	case "search_product_html": 
 		$limit_from = "0" ; $limit_to = "12" ;
		if(@$_POST['page_limit_from']){
			$limit_from=$_POST['page_limit_from'];
		}
		if(@$_POST['max_show']){
			$limit_to=$_POST['max_show'];
		}
		$html=$html.'<div class="col-md-9 col-sm-9"><h2> </h2>	<div class="blog-inner " data-animation="fadeInUp" data-animation-delay="300"> ';
		
		$html=$html.'<div class="container pet-r" ><div class="row">';
		$sql_product = "SELECT s.* ,c.catogories_name  FROM `tbl_service_plans` as s  left join tbl_product_category as c on c.id = s.category_id where s.service_id = '2' ";
		if(count($_POST['cat_ids'])){
			 $where=$where." AND s.category_id IN (".implode(',',$_POST['cat_ids']).")";
		}
		if(count($_POST['brand_ids'])){
			 $where=$where." AND s.brand_id IN (".implode(',',$_POST['brand_ids']).")";
		}
		if(count($_POST['weight'])){
			 $where=$where." AND s.weight_id IN (".implode(',',$_POST['weight']).")";
		}
		if(count($_POST['search_text'])){
			 $where=$where." AND s.plan_name like '%".$_POST['search_text']."%'";
		}
		if(count($_POST['pet_ids'])){
			 $where=$where." AND ( ";
			 for($k=0;$k<count($_POST['pet_ids']);$k++){
			 	if($k>0){
			 		$where=$where." OR ( ";
				}else{
					$where=$where."  ( ";
				}
			 	$where=$where." (s.pet_type_id  like '".$_POST['pet_ids'][$k]."')OR(s.pet_type_id  like '".$_POST['pet_ids'][$k]."@%')OR(s.pet_type_id  like '%@".$_POST['pet_ids'][$k]."')OR(s.pet_type_id  like '%@".$_POST['pet_ids'][$k]."@%') ";
				 $where=$where." ) ";
			 }
			 $where=$where." ) ";
		}		
		if(count($_POST['offer'])){
			$where=$where." AND ( ";
			 for($o=0;$o<count($_POST['offer']);$o++){
			 	$offer_arr=explode('-',$_POST['offer'][$o]);
				if($o>0){
			 		$where=$where." OR ( ";
				}else{
					$where=$where."  ( ";
				}
			 	$where=$where." s. offer BETWEEN  ".$offer_arr[0]." AND  ".$offer_arr[1]." ";
				 $where=$where." ) ";
			 }
			 $where=$where." ) ";
		}
		$cont_sql=$sql_product;
		$sql_product=$sql_product.$where." LIMIT ".$limit_from." , ".$limit_to;
 		$result__product = mysql_query($sql_product);
		$r=0;
		while($row_product = mysql_fetch_array($result__product)){
		$new_price=$row_product["rate"]*$row_product["offer"]/100;
		$html=$html.'<div class="col-md-4 col-sm-4"><h2>'.$row_product["catogories_name"].'</h2><a href="product-details.php?product_id='.$row_product["id"].'" class="thumbnail"><img src="'.$row_product["image"].'" alt="Pulpit Rock" style="width:150px;height:150px"><div class="border-bot size">'.$row_product["plan_name"].'</div><div class="amount">'.$row_product["rate_title"].'</div><div class="pu-discount fk-font-11"><span class="pu-old">'.$row_product["rate_title"].'</span><span class="pu-off-per else"> Rs '.($row_product["rate"]-$new_price).' ('.$row_product["offer"].'%)</span></div></a></div>';
		$r++;
		}
		if($r==0){
			$html=$html.'<h1 style="text-align:center;">Record Not Found ... </h1>';
		}
		$html=$html.'</div> </div>';
 		$html=$html.'</div></div>';
		$cont_sql="SELECT COUNT(s.id) as total   FROM `tbl_service_plans` as s  left join tbl_product_category as c on c.id = s.category_id where s.service_id = '2' ".$where;
 		$result__product_cnts = mysql_query($cont_sql);
		$result__product_cnt = mysql_fetch_array($result__product_cnts);
		$html=$html.'<div class="pagination"><ul>';
			$increment=12;$style=""; $cnt=1;
			for($p=1;$p<=($result__product_cnt['total']);$p=$p+12){
				$current=1;
				$class='pagination_call_ajax ';
				if($_POST['page_limit_from']){
					$current=$_POST['page_limit_from']+1;
				}
				if($p==$current){
					$class1=" active ";
				}else{
					$class1="  ";
				}
 			  $html=$html.'<li  class="'.$class1.'"  id="li'.$p.'" ><a  data_p="'.$p.'" class="'.$class.'  " data-from="'.($p-1).'" data-form ="college_list" data-to="'.$increment.'" >'.$cnt.'</a></li>';
			  $cnt++;
			  }
			 $html=$html.'</ul></div>';
			 
		echo $html;
		die();
 	break;
	
	
	case "search_product_cat_html":
	
		$sql1 = "SELECT id,catogories_name FROM tbl_product_category WHERE service_id = '2'  AND id IN (".implode(',',$_POST['cat_ids']).")";
		$result1 = mysql_query($sql1);
		$row1 = mysql_fetch_array($result1);
								
 		$limit_from = "0" ; $limit_to = "12" ;
 
 		if(@$_POST['page_limit_from']){
			$limit_from=$_POST['page_limit_from'];
		}
		if(@$_POST['max_show']){
			$limit_to=$_POST['max_show'];
		}
		$html=$html.'<div class="col-md-9 col-sm-9">	<div class="blog-inner " data-animation="fadeInUp" data-animation-delay="300"> ';
		
		$html=$html.'<div class="container pet-r" ><h2>'.$row1["catogories_name"].'</h2><div class="row">';
		$sql_product = "SELECT s.* ,c.catogories_name  FROM `tbl_service_plans` as s  left join tbl_product_category as c on c.id = s.category_id where s.service_id = '2' ";
		if(count($_POST['cat_ids'])){
			 $where=$where." AND s.category_id IN (".implode(',',$_POST['cat_ids']).")";
		}
		if(count($_POST['brand_ids'])){
			 $where=$where." AND s.brand_id IN (".implode(',',$_POST['brand_ids']).")";
		}
		if(count($_POST['search_text'])){
			 $where=$where." AND s.plan_name like '%".$_POST['search_text']."%'";
		}
		if(count($_POST['pet_ids'])){
			 $where=$where." AND ( ";
			 for($k=0;$k<count($_POST['pet_ids']);$k++){
			 	if($k>0){
			 		$where=$where." OR ( ";
				}else{
					$where=$where."  ( ";
				}
			 	$where=$where." (s.pet_type_id  like '".$_POST['pet_ids'][$k]."')OR(s.pet_type_id  like '".$_POST['pet_ids'][$k]."@%')OR(s.pet_type_id  like '%@".$_POST['pet_ids'][$k]."')OR(s.pet_type_id  like '%@".$_POST['pet_ids'][$k]."@%') ";
				 $where=$where." ) ";
			 }
			 $where=$where." ) ";
		}
		
		if(count($_POST['offer'])){
			$where=$where." AND ( ";
			 for($o=0;$o<count($_POST['offer']);$o++){
			 	$offer_arr=explode('-',$_POST['offer'][$o]);
				if($o>0){
			 		$where=$where." OR ( ";
				}else{
					$where=$where."  ( ";
				}
			 	$where=$where." s. offer BETWEEN  ".$offer_arr[0]." AND  ".$offer_arr[1]." ";
				 $where=$where." ) ";
			 }
			 $where=$where." ) ";
		}
		$cont_sql=$sql_product;
	 	$sql_product=$sql_product.$where." LIMIT ".$limit_from." , ".$limit_to;
 		$result__product = mysql_query($sql_product);
		$r=0;
		while($row_product = mysql_fetch_array($result__product)){
		$new_price=$row_product["rate"]*$row_product["offer"]/100;
		$html=$html.'<div class="col-md-4 col-sm-4"><a href="product-details.php?product_id='.$row_product["id"].'" class="thumbnail"><img src="'.$row_product["image"].'" alt="Pulpit Rock" style="width:150px;height:150px"><div class="border-bot size">'.$row_product["plan_name"].'</div><div class="amount">'.$row_product["rate_title"].'</div><div class="pu-discount fk-font-11"><span class="pu-old">'.$row_product["rate_title"].'</span><span class="pu-off-per else"> Rs '.($row_product["rate"]-$new_price).' ('.$row_product["offer"].'%)</span></div></a></div>';
		$r++;
		}
		if($r==0){
			$html=$html.'<h1 style="text-align:center;">Record Not Found ... </h1>';
		}
		$html=$html.'</div> </div>';
 		$html=$html.'</div></div>';
		$cont_sql="SELECT COUNT(s.id) as total   FROM `tbl_service_plans` as s  left join tbl_product_category as c on c.id = s.category_id where s.service_id = '2' ".$where;
 		$result__product_cnts = mysql_query($cont_sql);
		$result__product_cnt = mysql_fetch_array($result__product_cnts);
		$html=$html.'<div class="pagination"><ul>';
			$increment=12;$style="";
			for($p=1;$p<=($result__product_cnt['total']);$p=$p+12){
				$current=1;
				$class='pagination_call_cat_ajax ';
				if($_POST['page_limit_from']){
					$current=$_POST['page_limit_from']+1;
				}
				if($p==$current){
					$class1=" active ";
				}else{
					$class1="  ";
				}
 			  $html=$html.'<li  class="'.$class1.'"  id="li'.$p.'" ><a  data_p="'.$p.'" class="'.$class.'  " data-from="'.($p-1).'" data-form ="college_list" data-to="'.$increment.'" >'.$p.'</a></li>';
			  }
			 $html=$html.'</ul></div>';
			 
		echo $html;
		die();
 	break;
	
}


?>