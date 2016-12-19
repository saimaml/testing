<?php


echo "hello";
error_reporting(0);
$myhtml = <<<EOF
<br><br><table cellspacing="4" cellpadding="4"><tbody><tr><td>order_id</td><td>350</td></tr><tr><td>tracking_id</td><td>105080575705</td></tr><tr><td>bank_ref_no</td><td>105229</td></tr><tr><td>order_status</td><td>Success</td></tr><tr><td>failure_message</td><td></td></tr><tr><td>payment_mode</td><td>Credit Card</td></tr><tr><td>card_name</td><td>MasterCard</td></tr><tr><td>status_code</td><td>0</td></tr><tr><td>status_message</td><td>Transaction Successful</td></tr><tr><td>currency</td><td>INR</td></tr><tr><td>amount</td><td>1.0</td></tr><tr><td>billing_name</td><td>Vikas</td></tr><tr><td>billing_address</td><td>Ambegoav</td></tr><tr><td>billing_city</td><td>Pune</td></tr><tr><td>billing_state</td><td>Maharashtra</td></tr><tr><td>billing_zip</td><td>411038</td></tr><tr><td>billing_country</td><td>India</td></tr><tr><td>billing_tel</td><td>9630828026</td></tr><tr><td>billing_email</td><td>Sharmavikas2491@gmail.com</td></tr><tr><td>delivery_name</td><td>Vikas</td></tr><tr><td>delivery_address</td><td>Ambegoav</td></tr><tr><td>delivery_city</td><td>Pune</td></tr><tr><td>delivery_state</td><td>Maharashtra</td></tr><tr><td>delivery_zip</td><td>411038</td></tr><tr><td>delivery_country</td><td>India</td></tr><tr><td>delivery_tel</td><td>9630828026</td></tr><tr><td>merchant_param1</td><td></td></tr><tr><td>merchant_param2</td><td></td></tr><tr><td>merchant_param3</td><td></td></tr><tr><td>merchant_param4</td><td></td></tr><tr><td>merchant_param5</td><td></td></tr><tr><td>vault</td><td>N</td></tr><tr><td>offer_type</td><td>null</td></tr><tr><td>offer_code</td><td>null</td></tr><tr><td>discount_value</td><td>0.0</td></tr><tr><td>mer_amount</td><td>1.0</td></tr><tr><td>eci_value</td><td>02</td></tr><tr><td>retry</td><td>N</td></tr><tr><td>response_code</td><td>0</td></tr></tbody></table><br></center></body></head>
EOF;
$doc = new DOMDocument();
$doc->loadHTML($myhtml);

$tags = $doc->getElementsByTagName('td');

$i=1;
$arr=array();$main_arr=array();
foreach ($tags as $tag) {
	if($i==1){
		$arr['lable']=$tag->nodeValue;
		$i++;
	}else{
		$arr['value']=$tag->nodeValue;
		$main_arr[]=$arr;
		$i=1;
	}
   
}
var_dump($main_arr);
?>