<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class model extends CI_Model 
{ 
	public function __construct()
	{
		$this->load->database();// loading the databse
		$this->load->library("pagination");
		$this->load->helper("url");
		parent::__construct();
	}	
	function login($email,$password)
	{
		$this->db->where("email",$email);
		$this->db->where("password",$password);
		$query=$this->db->get("app_users");
		if($query->num_rows()>0)		{
			foreach($query->result() as $rows)
			{
				//add all data to session 'password'    => $rows->password,
				$newdata = array(
				'user_id'  => $rows->id,		
				'user_name'    => $rows->name,		
				'email'    => $rows->email,			
				'type'    => 'admin',							'logged_in'  => TRUE
				);
			}
			$this->session->set_userdata($newdata);
			return true;
		}
			return false;
	}
	public function set_password($email,$data)	{
		$this->db->where('email',$email);
		$this->db->update('tbl_vendor',$data);
	}
	
	public function set_password_mobile($mobile,$data)
	{
		$this->db->where('mobile',$mobile);
		$this->db->update('tbl_vendor',$data);
	}
	function login_vendor($email,$password)
	{
		$this->db->where("email",$email);
		$this->db->where("password",$password);
		$query=$this->db->get("tbl_vendor");
		if($query->num_rows()>0)
		{
			foreach($query->result() as $rows)
			{
			//add all data to session 'password'    => $rows->password,
			$newdata = array(
			'user_id'  => $rows->id,	
			'username'    => $rows->name,				
			'email'    => $rows->email,	
			'type'    => 'vendor',									
			'logged_in'  => TRUE
			);
			}
			$this->session->set_userdata($newdata);
			return true;
		}
			return false;
	}
	public function chck_distributer($user_id)
	{
		$this->db->select('is_app_distributer');
		$this->db->where("id",$user_id);
		$query = $this->db->get("tbl_vendor");
		 
		if ($query->num_rows() > 0) 
		{
			$ret = $query->row();
			return $ret->is_app_distributer;
		}
		
		
		return false;
	}
	public function chck_pwd($old_pwd)
	{
		$this->db->where('password',$old_pwd);
		$query = $this->db->get("tbl_vendor");
		 
		if ($query->num_rows() > 0) 
		{
			return true;
		}
		return false;	
	}	
	public function add_product($data)
	{ 
		$this->db->insert('tbl_service_plans',$data);
		return $this->db->insert_id();		
	}
	public function select_product($product_id)
	{	
		$this->db->order_by("id", "desc");
		$this->db->where('id',$product_id);
		$query = $this->db->get("tbl_service_plans");				
		return $query->result();	
	}	
	public function add_city($data)
	{ 
		$this->db->insert('tbl_city',$data);
		return $this->db->insert_id();		
	}	
	public function add_service($data)
	{ 
		$this->db->insert('service_master',$data);
		return $this->db->insert_id();		
	}
	public function add_product_detai($data)
	{
		$this->db->insert('tbl_product_details',$data);
		//return $this->db->insert_id();
	}
	public function add_blog_detai($data)
	{
		$this->db->insert('tbl_news',$data);
		return $this->db->insert_id();
	}
	public function insert_sms_master($data)
	{
		$this->db->insert('tbl_sms_master',$data);
		return $this->db->insert_id();
	}
	public function insert_group_master($data)
	{
		$this->db->insert('tbl_camp_grp',$data);
		return $this->db->insert_id();
	}
	public function insert_email_master($data)
	{
		$this->db->insert('tbl_email',$data);
		return $this->db->insert_id();
	}
	
	public function list_sms_master()
	{	
		$query = $this->db->get("tbl_sms_master");				
		return $query->result();
	}
	public function list_email_master()
	{	
		$query = $this->db->get("tbl_email");				
		return $query->result();
	}
	public function get_active_user()
	{
		$this->db->where('is_active','1');
		$query = $this->db->get("app_users");				
		return $query->result();		
	}
	public function select_subject($email_template)
	{
		$this->db->where('file_path',$email_template);
		$query = $this->db->get("tbl_email");				
		$ret = $query->row();
		return $ret->subject;		
	}
	function search_active_user($array)
	{
		$this->db->where($array);
		$query = $this->db->get("app_users");				
		return $query->result();		
	}
	public function update_notification($insert_blog)
	{
		$this->db->insert('tbl_notification',$insert_blog);
		return $this->db->insert_id(); 
	}
	
	public function get_blog()
	{
		$this->db->order_by("id", "desc");
		$query = $this->db->get("tbl_news");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;		
	}
	public function sort_asc_id()
	{
		$this->db->order_by("id", "asc");
		$query = $this->db->get("tbl_cart");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;		
	}
	public function sort_des_id()
	{
		$this->db->order_by("id", "desc");
		$query = $this->db->get("tbl_cart");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;		
	}
	public function save_blog($newid, $field, $ext)
	{		
		$data=array(
			$field => "http://www.discovermypet.in/ci_DMP/uploads/".$newid.$ext
		);
		$this->db->where('id',$newid);
		$this->db->update('tbl_news',$data);

	}
	public function edit_blog($id)
	{
		$this->db->where('id',$id);		
		$query = $this->db->get("tbl_news");		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;		
	}
	function edit_blog_detai($data,$id)
	{		
		$this->db->where('id',$id);
		$this->db->update('tbl_news',$data);
	}
	function delete_blog($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('tbl_news');  
	}	
	function delete_social($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('tbl_timeline');  
	}	
	public function get_product_detail()
	{
		$this->db->order_by("id", "desc");
		$query = $this->db->get("tbl_product_details");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;		
	}	
	public function get_product_detail_vendor($id)
	{
		
		$this->db->order_by("id", "desc");
		$this->db->where('vendor_id',$id);
		$query = $this->db->get("tbl_product_details");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;		
	}	
	public function save_imgurl($newid, $field, $ext)
	{		
		$data=array(
			$field => "http://www.discovermypet.in/ci_DMP/uploads/".$newid.$ext
		);
		$this->db->where('id',$newid);
		$this->db->update('tbl_service_plans',$data);

	}
	function save_image($newid,$fileName)
	{
		$img = explode(",",$fileName);
		
		for($i=0;$i<count($img);$i++)
		{
			$img1[$i] = "http://www.discovermypet.in/ci_DMP/uploads/".$img[$i];
		}
		   $fileName = implode(',',$img1);
			$data=array(
			"image" => $fileName
		);
		
		$this->db->where('id',$newid);
		$this->db->update('tbl_service_plans',$data);
	}
	function save_image_attribute($newid,$fileName)
	{
		$img = explode(",",$fileName);
		
		for($i=0;$i<count($img);$i++)
		{
			$img1[$i] = "http://www.discovermypet.in/ci_DMP/uploads/".$img[$i];
		}
		   $fileName = implode(',',$img1);
			$data=array(
			"img" => $fileName
		);
		
		$this->db->where('id',$newid);
		$this->db->update('tbl_product_attribute',$data);
	}
	public function save_service_master($newid, $field, $ext)
	{		
		$data=array(
			$field => "http://www.discovermypet.in/product/".$newid.$ext
		);
		$this->db->where('id',$newid);
		$this->db->update('service_master',$data);

	}
	public function save_pwd($new_pwd, $user_id)
	{	
		$data=array('password'=>$new_pwd);	
		
		$this->db->where('id',$user_id);
		$this->db->update('tbl_vendor',$data);

	}
	
	public function save_imgurl_service($newid, $field, $ext)
	{		
		$data=array(
			$field => $newid.$ext
		);
		$this->db->where('id',$newid);
		$this->db->update('tbl_service_details',$data);

	}
	public function edit_product($product_id, $data)
	{		
		$this->db->where('id',$product_id);
		$this->db->update('tbl_service_plans',$data);
	}
	public function delete_attr_color($product_id)
	{
		$this->db->where('product_id',$product_id);
		$this->db->delete('tbl_product_color'); 
	}
	public function edit_attr_color($product_id,$data)
	{
		$this->db->where('product_id',$product_id);
		$this->db->update('tbl_product_color',$data);		
	}
	public function add_data($data)
	{ 
		$this->db->insert('tbl_product_category',$data);
		//return $this->db->insert_id();
		
	}	
	public function add_attribute($data)
	{ 
		$this->db->insert('tbl_product_attribute',$data);
		return $this->db->insert_id();		
	}	
	public function add_color_attribute($data)
	{
		$this->db->insert('tbl_product_color',$data);
		return $this->db->insert_id();		
	}
	 public function chng_top_selling_prod_zero()
	{
		$data=array(
			'top_selling_act'=>0);			
		$this->db->update('tbl_service_plans',$data);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
	} 
	public function chng_top_selling_prod_one($product)
	{
		
		$data=array(
			'top_selling_act'=>1);				
		$this->db->where_in('id ',$product);
		$this->db->update('tbl_service_plans',$data);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
		
	}
	public function delete_attribute($product_id,$attr_id)
	{
		$this->db->where('product_id',$product_id);
		$this->db->where('atr_id',$attr_id);
		$this->db->delete('tbl_product_attribute');  
	}
	
		
	public function add_data_main_cat($data)
	{ 
		$this->db->insert('tbl_product_main_cat',$data);
		//return $this->db->insert_id();
		
	}	
	public function add_brand($data)
	{ 
		$this->db->insert('tbl_product_brand',$data);
		//return $this->db->insert_id();
		
	}	
	public function get_all()
	{	
		$this->db->order_by("id", "desc");
		$query = $this->db->get("tbl_product_category");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;
	}
	public function get_all_main_cat()
	{	
		$this->db->order_by("id", "desc");
		$query = $this->db->get("tbl_product_main_cat");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;
	}
	public function get_all_city()
	{	
		$this->db->order_by("id", "desc");
		$query = $this->db->get("tbl_city");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;
	}
	
	public function get_all_service()
	{	
		$this->db->order_by("id", "desc");
		$query = $this->db->get("tbl_service_details");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;
	}
	public function get_service()
	{	
		$this->db->order_by("id", "asc");
		$query = $this->db->get("service_master");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;
	}
	public function get_all_brand()
	{	
		$this->db->order_by("id", "desc");
		$query = $this->db->get("`tbl_product_brand");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;
	}
	public function get_product()
	{	
		$this->db->order_by("id", "desc");
		$query = $this->db->get("tbl_service_plans");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;
	}
	public function get_product_vendor($id)
	{	
		$this->db->order_by("id", "desc");
		$this->db->where('vendor_id',$id);
		$query = $this->db->get("tbl_service_plans");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;
	}
	public function get_trasaction()
	{	
		$this->db->order_by("id", "desc");
		$query = $this->db->get("tbl_cart_master");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;
	}
	public function get_trasaction_vendor($id)
	{	
		$this->db->order_by("id", "desc");
		$this->db->where("id",$id);
		$query = $this->db->get("tbl_cart_master");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;
	}
	public function get_main_cat1($id)
	{	
		$this->db->order_by("id", "desc");
		$this->db->where("id",$id);
		$query = $this->db->get("tbl_product_main_cat");
		return $query->row_array();// returing array of data		
	}
	public function get_trasaction_vendor_id($id)
	{	
		$this->db->select('cart_master_id,id,user_id');
		$this->db->where("vendor_id",$id);
		$query = $this->db->get("tbl_cart");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;
	}
	public function vendor_transaction()
	{
		$this->db->select('cart_master_id');
		$this->db->where("vendor_id !=",'0');
		$query = $this->db->get("tbl_cart");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;
	}
	public function get_trasaction_detail($id)
	{	
		$this->db->order_by("id", "desc");
		$this->db->where("cart_master_id",$id);
		$query = $this->db->get("tbl_cart");
		 
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row) {
			$data[] = $row;
		}
		return $data;
		}
		return false;
	}
	public function get1($id) 
	{		
		$query = $this->db->get_where('tbl_product_category', array('id' => $id)); // getting user with conditions
		return $query->row_array();// returing array of data		
	}
	public function get_delete($id) 
	{		
		$query = $this->db->get_where('tbl_service_plans', array('id' => $id)); // getting user with conditions
		return $query->row_array();// returing array of data		
	}
	public function update_category($data,$id)
	{
		$this->db->where('id',$id);
		$this->db->update('tbl_product_category',$data);   
	}
	public function delete_user($data,$id)
	{	
			$this->db->where('id',$id);
			$this->db->delete('tbl_product_category');   
	}
	public function delete_product($id)
	{	
			$this->db->where('id',$id);
			$this->db->delete('tbl_service_plans');   
	}
	public function delete_main_cat($id)
	{	
			$this->db->where('id',$id);
			$this->db->delete('tbl_product_main_cat');   
	}
	function insert_csv($data) 
	{	
		$this->db->insert('tbl_service_details', $data);
		return true;
	}
	function insert_csv_cam_grp($data) 
	{	
		$this->db->insert('tbl_sms_user', $data);
		return true;
	}
	function insert_product_csv($insert_data)
	{	
		$this->db->insert('tbl_service_plans', $insert_data);
		return $this->db->insert_id();
	}
	function insert_att_csv($insert_data)
	{	
		$this->db->insert('tbl_product_attribute', $insert_data);
		return $this->db->insert_id();
	}
	function update_product_csv($insert_data,$res_pro_ven)	{	
		$this->db->where('id',$res_pro_ven);
		$this->db->update('tbl_service_plans',$insert_data);  
		return true;
	}
	function update_att_csv($update_data,$res_att)
	{	
		$this->db->where('id',$res_att);
		$this->db->update('tbl_product_attribute',$update_data);  
		return true;
	}
	function select_vendor_id($vendor_name)
	{	
		$result = $this->db->query("SELECT id FROM tbl_vendor WHERE name = '$vendor_name' ")->row_array();	
		return $result['id'];
	}
	function select_main_cat_id($main_cat)
	{
		$result = $this->db->query("SELECT id FROM tbl_product_main_cat WHERE main_category = '$main_cat' ")->row_array();
		return $result['id'];		
	}
	function select_weight_id($weight_id)
	{
		$result = $this->db->query("SELECT id FROM tbl_pet_weight WHERE weight_name = '$weight_id' ")->row_array();
		return $result['id'];		
	}
	function select_sub_cat_id($sub_cat)
	{
		$result = $this->db->query("SELECT id FROM tbl_product_category WHERE catogories_name = '$sub_cat' ")->row_array();
		return $result['id'];		
	}
	function select_pet_type_id($pet_type)
	{
		$result = $this->db->query("SELECT id FROM tbl_product_type WHERE pet_type = '$pet_type' ")->row_array();
		return $result['id'];		
	}
	function select_brand_id($brand)
	{
		$result = $this->db->query("SELECT id FROM tbl_product_brand WHERE brand_name = '$brand' ")->row_array();
		return $result['id'];		
	}
	function chck_pro_ven($vendor_id,$product_name)
	{
		$this->db->select('id');
		$this->db->where("vendor_id",$vendor_id);
		$this->db->where("plan_name",$product_name);
		$query = $this->db->get("tbl_service_plans");
		if ($query->num_rows() > 0) 
		{	
			$result = $this->db->query("SELECT id FROM tbl_service_plans WHERE plan_name = '$product_name' and vendor_id = '$vendor_id'")->row_array();
			return $result['id'];
		}
		else
		{
			return false;
		}
	}
	function chck_prod($vendor_id,$main_cat,$sub_cat,$breed,$pet_type,$product_name)
	{
		$this->db->select('id');
		$this->db->where("vendor_id",$vendor_id);
		$this->db->where("plan_name",$product_name);
		$this->db->where("main_category_id",$main_cat);
		$this->db->where("category_id",$sub_cat);
		$this->db->where("pet_type_id",$pet_type);
		$query = $this->db->get("tbl_service_plans");
		if ($query->num_rows() > 0) 
		{	
			$result = $this->db->query("SELECT id FROM tbl_service_plans WHERE plan_name = '$product_name' and vendor_id = '$vendor_id'")->row_array();
			return $result['id'];
		}
		else
		{
			return false;
		}
	}
	function chck_pro($product_name)
	{
		$this->db->select('id');	
		$this->db->where("plan_name",$product_name);		
		$query = $this->db->get("tbl_service_plans");
		if ($query->num_rows() > 0) 
		{	
			$result = $this->db->query("SELECT id FROM tbl_service_plans WHERE plan_name = '$product_name' ")->row_array();
			return $result['id'];
		}
		else
		{
			return false;
		}
	}
	function chck_att($res_pro,$weight_id,$size)
	{
		$this->db->select('id');
		$this->db->where("product_id",$res_pro);
		$this->db->where("weight_id",$weight_id);
		$this->db->where("size_name",$size);	
		$query = $this->db->get("tbl_product_attribute");
		if ($query->num_rows() > 0) 
		{	
			$result = $this->db->query("SELECT id FROM tbl_product_attribute WHERE product_id = '$res_pro' and weight_id = '$weight_id' and size_name = '$size'")->row_array();
			return $result['id'];
		}
		else
		{
			return false;
		}
	}
	function search($from_date,$to_date)
	{
		$this->db->select('*');
		$this->db->from('tbl_cart');
		$this->db->where('created_date >=',$from_date);
		$this->db->where('created_date <=',$to_date);
		$query=$this->db->get();
		return $query->result();
	}
	function timeline()
	{
		$this->db->select('t.*,a.name');
		$this->db->from('tbl_timeline t');
		$this->db->join('app_users a', 'a.id = t.user_id', 'left');
		$query = $this->db->get();
		return $query->result();
	}
	function view_timeline($id)
	{
		$this->db->select('t.*,a.name');
		$this->db->from('tbl_timeline t');
		$this->db->join('app_users a', 'a.id = t.user_id', 'left');	
		$this->db->where('t.id',$id);		
		$query = $this->db->get();
		return $query->result();
	}
	function count_like($id)
	{
		$query = $this->db->query("SELECT COUNT(id) FROM tbl_notification WHERE timeline_id ='".$id."' AND type = 'like' GROUP BY id");
		return $query->num_rows();
	}
	function count_comment($id)
	{
		$query = $this->db->query("SELECT COUNT(id) as count FROM tbl_notification WHERE timeline_id ='".$id."' AND type = 'comment' GROUP BY id");
		return $query->num_rows();

	}
	function view_timeline_notification($id)
	{
		$this->db->select('');
		$this->db->from('tbl_notification');
		$this->db->join('app_users a', 'a.id = t.user_id', 'left');	
		$this->db->where('t.id',$id);		
		$query = $this->db->get();
		return $query->result();
	}
	function get_timeline($id)
	{
		$this->db->select('t.*,a.name');
		$this->db->from('tbl_timeline t');
		$this->db->join('app_users a', 'a.id = t.user_id', 'left');	
		$this->db->where('t.id',$id);		
		$query = $this->db->get();
		return $query->result();
	}
	function get_tip($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_tips_news');
		$this->db->where('id',$id);	
		$query = $this->db->get();
		return $query->result();
	}
	function get_tips()
	{
		$this->db->select('*');
		$this->db->from('tbl_tips_news');
		$query = $this->db->get();
		return $query->result();
	}
	/*** Vendor ***/
	public function add_vendor($data)
	{ 
		$this->db->insert('tbl_vendor',$data);
		return $this->db->insert_id();		
	}	
	public function chck_vendor_email($email)
	{
		$this->db->where('email',$email);
		$query = $this->db->get("tbl_vendor");
		 
		if ($query->num_rows() > 0) 
		{
			return true;
		}
		return false;	
	}
	public function chck_vendor_mobile($mobile)
	{
		$this->db->where('mobile',$mobile);
		$query = $this->db->get("tbl_vendor");
		 
		if ($query->num_rows() > 0) 
		{
			return true;
		}
		return false;	
	}
	public function edit_vendor($user_id,$data)
	{ 
		$this->db->where('id',$user_id);
		$this->db->update('tbl_vendor',$data);
		
	}	
	function get_vendor()
	{
		$this->db->select('*');
		$this->db->from('tbl_vendor');
		$query = $this->db->get();
		return $query->result();
	}
	function get_profile($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_vendor');
		$this->db->where('id',$id);	
		$query = $this->db->get();
		return $query->result();
	}
	function delete_vendor($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('tbl_vendor');  
	}	
	function get_sub_cat($id)
	{
		$this->db->select('id,catogories_name');
		$this->db->from('tbl_product_category');
		$this->db->where('main_id',$id);	
		$query = $this->db->get();
		return $query->result();
	}
	function search_sub_cat($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_service_plans');
		$this->db->where('category_id',$id);	
		$query = $this->db->get();
		return $query->result();
	}
	function get_email_grp_user()
	{
		$this->db->select('*');
		$this->db->from('tbl_sms_user');		
		$query = $this->db->get();
		return $query->result();
	}
	function search_group($id)
	{
		$this->db->select('*');
		$this->db->from('tbl_sms_user');
		$this->db->where('group_id',$id);	
		$query = $this->db->get();
		return $query->result();
	}
	/* Send SMS */
	function insert_sms_csv($data)
	{
		$this->db->insert('tbl_sms_user',$data);
		return $this->db->insert_id();
	}
	public function chck_user_mob($user_id,$mobile_no)
	{
		$this->db->where('phn_no',$mobile_no);
		$this->db->where('vendor_id',$user_id);
		$query = $this->db->get("tbl_sms_user");
		 
		if ($query->num_rows() > 0) 
		{
			return true;
		}
		return false;	
	}	

	function get_data($id){
		$this->db->select("name,phn_no");
		$this->db->from('tbl_sms_user');
		$this->db->where("id",$id);
		$query = $this->db->get();		
		return $query->result();
	}
	function get_data_app_user($id)
	{
		$this->db->select("name,mobile,email");
		$this->db->from('app_users');
		$this->db->where("id",$id);
		$query = $this->db->get();		
		return $query->result();
	}
	function get_data_user($id)
	{
		$this->db->select("name,phn_no,email");
		$this->db->from('tbl_sms_user');
		$this->db->where("id",$id);
		$query = $this->db->get();		
		return $query->result();
	}
	
	function update_count($id)
	{		
		$this->db->where('id', $id);
		$this->db->set('send_count', 'send_count+ 1', FALSE);
		$this->db->update('tbl_sms_user');		
	}
	function update_count_app_users($id)
	{		
		$this->db->where('id', $id);
		$this->db->set('send_sms_count', 'send_sms_count+ 1', FALSE);
		$this->db->update('app_users');		
	}
	function update_count_app_users_email($id)
	{		
		$this->db->where('id', $id);
		$this->db->set('send_email_count', 'send_email_count+ 1', FALSE);
		$this->db->update('app_users');		
	}
	public function update_sms_csv($name,$insert_data)
	{
		$this->db->where('name',$name);
		$this->db->update('tbl_sms_user',$insert_data);
	}
	function list_sendsms($user_id)
	{
		$this->db->select("*");
		$this->db->where('vendor_id', $user_id);
		$this->db->from('tbl_sms_user');
		$this->db->order_by("id","desc");
		$query = $this->db->get();		
		return $query->result();
	}	
}