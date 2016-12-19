<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('model');		
		$this->load->library('Csvimport');
	}	
	public function index()
	{
		$this->load->view('login');
	}	
	public function login() 
	{
		$data['title']= 'Login';
		$email=$this->input->post('email');
		$password=$this->input->post('pass');
		//set validations
		$this->form_validation->set_rules("email", "Email", "trim|required");
		$this->form_validation->set_rules("pass","Password","trim|required|min_length[5]|max_length[12]");
		if ($this->form_validation->run() == FALSE)
		{
			//validation fails	
			$this->session->set_flashdata('error', '2');
			$this->load->view('login');
		}
		else
		{
			/* $result=$this->model->login($email,$password);
			if($result) 
			{		
				$this->list_product();				
			}  
			else 
			{ */
				$result=$this->model->login_vendor($email,$password);
				if($result) 
				{		
					$user_id = $this->session->userdata('user_id');	
					$is_distributer=$this->model->chck_distributer($user_id);
					$newdata = array(									
						'is_distributer'  => $is_distributer );
			
				$this->session->set_userdata($newdata);
				$this->profile();
				}  
				else 
				{
					echo "Invalid username and password...";$this->index();
				} 
			//}
		}
	}
	public function main_index()
	{
		$this->load->view('header');
		$this->load->view('top_header');
		$this->load->view('sidebar');
		$this->load->view('index');
		$this->load->view('footer');		
	}
	public function add_sub_cat()
	{
		$this->load->view('header');
		$this->load->view('top_header');
		$this->load->view('sidebar');
		$this->load->view('add_form');
		$this->load->view('footer');			
	}
	function add_city()
	{
		$this->load->view('admin/add_city');		
	}
	function add_city1()
	{
		$data=array(
		'city_name'=>$this->input->post('city'),
		'status'=>1
			
		);	
		$this->form_validation->set_rules('city', 'city', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{	
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$this->add_city();	
		}
		else 
		{
			$this->model->add_city($data);	
			echo "successfully added";
			$this->list_city();			
		}
	}
	function list_city()
	{
		$data["posts"] = $this->model->get_all_city();		
		$this->load->view("list_city", $data);// View data according to array.		
		$this->load->view('footer');	
	}
	public function add_brand()
	{
		$this->load->view('header');
		$this->load->view('top_header');
		$this->load->view('sidebar');
		$this->load->view('add_brand');
		$this->load->view('footer');		
	}	
	public function list_brand()
	{
		$data["posts"] = $this->model->get_all_brand();		
		$this->load->view("list_form_brand", $data);// View data according to array.		
		$this->load->view('footer');		
	}
	
	public function add_sub_category()
	{
		$data=array(
		'service_id'=>$this->input->post('service_id'),
		'catogories_name'=>$this->input->post('catogories_name'),
		'created_date'=>date('Y-m-d')			
		);	
		$this->form_validation->set_rules('service_id', 'Service ID', 'required');
		$this->form_validation->set_rules('catogories_name', 'Category Name', 'required');
		if ($this->form_validation->run() == FALSE)
		{	
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$this->load->view('header');
			$this->load->view('top_header');
			$this->load->view('sidebar');
			$this->load->view('add_form');
			$this->load->view('footer');
		}
		else 
		{
			$this->model->add_data($data);	
			echo "successfully added";
			$this->list_sub_category();			
		}
	}
	public function add_main_category1()
	{
		$data=array(		
		'main_category'=>$this->input->post('catogories_name')			
		);	
		
		$this->form_validation->set_rules('catogories_name', 'Category Name', 'required');
		if ($this->form_validation->run() == FALSE)
		{	
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$this->load->view('header');
			$this->load->view('top_header');
			$this->load->view('sidebar');
			$this->load->view('add_main_cat');
			$this->load->view('footer');
		}
		else 
		{
			$this->model->add_data_main_cat($data);	
			echo "successfully added";
			$this->list_main_category();			
		}
	}
	public function edit_main_cat()
	{
		$this->load->view('header');
		$this->load->view('top_header');
		$this->load->view('sidebar');
		$id = $this->uri->segment(3, 0);
		$data['posts'] = $this->model->get_main_cat1($id); // calling Post model method getPosts()	
		$this->load->view('edit_main_cat', $data);
		$this->load->view('footer');		
	}
	public function edit_main_category()
	{
		$data=array(		
		'main_category'=>$this->input->post('catogories_name')			
		);	
		
		$this->form_validation->set_rules('catogories_name', 'Category Name', 'required');
		if ($this->form_validation->run() == FALSE)
		{	
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$this->load->view('header');
			$this->load->view('top_header');
			$this->load->view('sidebar');
			$this->load->view('add_main_cat');
			$this->load->view('footer');
		}
		else 
		{
			$this->model->add_data_main_cat($data);	
			echo "successfully added";
			$this->list_main_category();			
		}
	}
	
	public function delet_main_cat()
	{
		$this->load->view('header');
		$this->load->view('top_header');
		$this->load->view('sidebar');
		$id = $this->uri->segment(3);		
		$data['posts'] = $this->model->get_main_cat1($id); // calling Post model method getPosts()	
		$this->load->view('delete_main_cat', $data);
		$this->load->view('footer');		
	}
	public function delete_main_category()
	{
		$id = $this->input->post('id');
		$this->model->delete_main_cat($id);
		echo "succefully Delete..";
		$this->list_main_category();
	}
	
	public function add_main_category()
	{
		$this->load->view('header');
		$this->load->view('top_header');
		$this->load->view('sidebar');
		$this->load->view('add_main_cat');
		$this->load->view('footer');	
	}
	public function add_brand1()
	{
		$data=array(
		'brand_name'=>$this->input->post('brand_name'),
		'created_date'=>date('Y-m-d')			
		);	
		$this->form_validation->set_rules('brand_name', 'Brand Name', 'required');
		if ($this->form_validation->run() == FALSE)
		{	
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');			
			$this->load->view('admin/add_product');
		
		}
		else 
		{
			$this->model->add_brand($data);	
			$this->form_validation->set_message('brand_name', 'Succesfully Added.');
			$this->load->view('admin/add_product');			
		}
	}	
	public function edit() 
	{
		$this->load->view('header');
		$this->load->view('top_header');
		$this->load->view('sidebar');
		$id = $this->uri->segment(3, 0);
		$data['posts'] = $this->model->get1($id); // calling Post model method getPosts()	
		$this->load->view('edit_form', $data);
		$this->load->view('footer');		
	}
	public function delete()
	{
		$this->load->view('header');
		$this->load->view('top_header');
		$this->load->view('sidebar');
		$this->load->view('delete_form');
		$this->load->view('footer');		
	}
	public function list_main_category()
	{
		$data["posts"] = $this->model->get_all_main_cat();
		$this->load->view('header');
		$this->load->view('top_header');
		$this->load->view('sidebar');
		$this->load->view("list_main_cat", $data);// View data according to array.		
		$this->load->view('footer');		
	}
	public function list_sub_category()
	{
		$data["posts"] = $this->model->get_all();
		$this->load->view('header');
		$this->load->view('top_header');
		$this->load->view('sidebar');
		$this->load->view("list_form", $data);// View data according to array.		
		$this->load->view('footer');		
	}
	public function edit_category()
	{		
		$data=array(
		'service_id'=>$this->input->post('service_id'),
		'catogories_name'=>$this->input->post('catogories_name')		
		);	
		$this->form_validation->set_rules('service_id', 'Service ID', 'required');
		$this->form_validation->set_rules('catogories_name', 'Category Name', 'required');
		if ($this->form_validation->run() == FALSE)
		{	
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$this->edit();			
		}
		else 
		{
			$id = $this->input->post('id');			
			$this->model->update_category($data,$id);	
			//echo "successfully Updated";
			$this->list_category();			
		}			
	}
	
	public function delet()
	{
		$this->load->view('header');
		$this->load->view('top_header');
		$this->load->view('sidebar');
		$id = $this->uri->segment(3, 0);
		$data['posts'] = $this->model->get1($id); // calling Post model method getPosts()	
		$this->load->view('delete_form', $data);
		$this->load->view('footer');		
	}	
	public function delet_product()
	{
		$id = $this->uri->segment(3);		
		$data['posts'] = $this->model->delete_product($id); // calling Post model method getPosts()	
		//$this->load->view('delete_product', $data);
		$user_id = $this->session->userdata('user_id');	
		if($user_id =="1")
		{
			$this->list_product();
		}
		else
		{
			$this->list_product_vendor();
		}			
	}
	
	public function delete_category()
	{		
		$data=array(
		'service_id'=>$this->input->post('service_id'));			
		$id = $this->input->post('id');
		$this->model->delete_user($data,$id);
		echo "succefully Delete..";
		$this->list_category();		
	}	
	public function add_product()
	{		
		$this->load->view('admin/add_product');			
	}
	
	public function add_product1()
	{
		$user_id = $this->session->userdata('user_id');	
		$orignal_price = $this->input->post('rate');
		$offer = $this->input->post('offer');
		$disc = $orignal_price * $offer /100;
		$rate =$orignal_price - $disc;
		$data=array(
		'service_id'=>$this->input->post('service_id'),
		'category_id'=>$this->input->post('category_id'),
		'main_category_id'=>$this->input->post('main_category_id'),
		'pet_type_id'=>$this->input->post('pet_type_id'),
		'plan_name'=>$this->input->post('plan_name'),
		'breed_id'=>$this->input->post('breed_id'),
		'description'=>$this->input->post('description'),
		'orignal_price'=>$this->input->post('rate'),		
		'rate'=>$rate,
		//'rate_title'=>$this->input->post('rate_title'),
		'offer'=>$this->input->post('offer'),
		'brand_id'=>$this->input->post('brand_id'),
		'stock'=>$this->input->post('stock'),
		'details'=>$this->input->post('details'),
		'vendor_id'=>$this->input->post('vendor_id'),
		'image'=>1			
		);	
		$this->form_validation->set_rules('service_id', 'Service ID', 'required');
		$this->form_validation->set_rules('main_category_id', 'Main Category Name', 'required');
		$this->form_validation->set_rules('category_id', 'Category Name', 'required');
		$this->form_validation->set_rules('pet_type_id', 'Pet Type', 'required');
		$this->form_validation->set_rules('plan_name', 'Product Name', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
	
		$this->form_validation->set_rules('rate', 'rate', 'required');
		
		$this->form_validation->set_rules('brand_id', 'Brand Name', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{	
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			
			$this->load->view('admin/add_product');
			
		} 
		else 
		{
			$newid = $this->model->add_product($data);	
			$this->do_upload($newid);
			
			$user_id = $this->session->userdata('user_id');	
			
			$weight_attribute = $this->input->post('weight_attribute');
			$size_attribute = $this->input->post('size_attribute');
			$color_attribute = $this->input->post('color_attribute');
			
			if($weight_attribute == "Weight")
			{
				$weight_id=$this->input->post('weight_id'); 
				$size_w=$this->input->post('size_w'); 
				$price_w=$this->input->post('price_w'); 
				for($i=0;$i<count($weight_id);$i++)
				{
					$data=array(
					'product_id'=>$newid,
					'weight_id	'=>$weight_id[$i],				
					'size_name'=>$size_w[$i],
					'img'=>1,
					'price'=>$price_w[$i] );				
								
					$att_id = $this->model->add_attribute($data);
					$this->do_upload_att($att_id);					
				}				
			}
			if($size_attribute =="Size")
			{
				$size=$this->input->post('size'); 
				$price_s=$this->input->post('price_s'); 
				
				for($i=0;$i<count($size);$i++)
				{
					$data=array(
					'product_id'=>$newid,
					'weight_id	'=>0,				
					'size_name'=>$size[$i],
					'img'=>1,
					'price'=>$price_s[$i] );				
								
					$att_id = $this->model->add_attribute($data);
										
				}				
			}
			if($color_attribute == "Color")
			{
				$color=$this->input->post('color'); 
				
				$colors = implode(",",$color);
				
				$data=array(
					'product_id'=>$newid,
					'color_id	'=>$colors
						);		
					$att_id = $this->model->add_color_attribute($data);
				
			}
			
					
			if($user_id =="1")
			{
				$this->list_product();
			}
			else
			{
				$this->list_product_vendor();
			}
			
		}
	}
	public function edit_product1()	{		$user_id = $this->session->userdata('user_id');				
		$product_id = $this->input->post('id');	
		$color = $this->input->post('color');	
		if(!empty($color))   // Color attribute
		{
			$clr = implode(",",$color);
			$data_color = array('color_id'=>$clr);		
			$this->model->edit_attr_color($product_id,$data_color);
		}
		$weight_attribute = $this->input->post('weight_attribute');	
		if($weight_attribute =="Weight")		{
			$weight_id = $this->input->post('weight_id');				$size_w = $this->input->post('size_w');	
			$price_w = $this->input->post('price_w');			
			print_r($weight_id);
			for($i=0;$i<count($weight_id);$i++)
			{
				$data_weight = array(
					'weight_id'=>$weight_id[$i],	
					'size_name'=>$size_w[$i],
					'price'=>$price_w[$i]
					);		
			}
		}
		die();
		$orignal_price = $this->input->post('rate');
		$offer = $this->input->post('offer');
		$disc = $orignal_price * $offer /100;
		$rate =$orignal_price - $disc;
		$data=array(
		'main_category_id'=>$this->input->post('main_category_id'),
		'category_id'=>$this->input->post('category_id'),
		'pet_type_id'=>$this->input->post('pet_type_id'),
		'plan_name'=>$this->input->post('plan_name'),
		'description'=>$this->input->post('description'),
		'orignal_price'=>$this->input->post('rate'),		
		'rate'=>$rate,
		//'rate_title'=>$this->input->post('rate_title'), 
		'offer'=>$this->input->post('offer'),
		'brand_id'=>$this->input->post('brand_id'),
		'stock'=>$this->input->post('stock'),
		'vendor_id'=>$user_id,			
		);	
	
		$this->form_validation->set_rules('category_id', 'Category Name', 'required');
		$this->form_validation->set_rules('pet_type_id', 'Category Name', 'required');
		$this->form_validation->set_rules('plan_name', 'Category Name', 'required');
		$this->form_validation->set_rules('description', 'Category Name', 'required');
		//$this->form_validation->set_rules('bullet_title', 'Category Name', 'required');
		//$this->form_validation->set_rules('bullet_points', 'Category Name', 'required');
		$this->form_validation->set_rules('rate', 'Category Name', 'required');
		//$this->form_validation->set_rules('rate_title', 'Category Name', 'required');
		$this->form_validation->set_rules('offer', 'Category Name', 'required');
		$this->form_validation->set_rules('brand_id', 'Category Name', 'required');
		if ($this->form_validation->run() == FALSE)
		{	
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$this->edit_product();
		} 
		else 
		{
			$userfile = $this->input->post('userfile');
			if(empty($userfile))
			{
				$newid = $this->model->edit_product($product_id,$data);	
				//echo "successfully added";
				
				if($user_id =="1")
				{
					$this->list_product();
				}
				else
				{
					$this->list_product_vendor();
				}	
				
			}
			else
			{
				$newid = $this->model->edit_product($product_id,$data);
				$this->upload_image($newid);
			
				
				if($user_id =="1")
				{
					$this->list_product();
				}
				else
				{
					$this->list_product_vendor();
				}					
			}						
		}
	}
	public function get_sub_cat()
	{
		$id=$this->input->post('id'); 
		$data['posts'] = $this->model->get_sub_cat($id);
		//print_r($data);
		$html= "<select id='category_id' name='category_id' class='form-control'>";
		foreach($data['posts'] as $row)
		{			$html= $html."<option value='$row->id'>$row->catogories_name</option>";
		}	
		$html= $html. "</select>";
		echo $html;		 
	}
	public function search_sub_cat()
	{
		$id=$this->input->post('id');
		$data['posts'] = $this->model->search_sub_cat($id);
		//$data["posts"] = $this->model->get_product();		
		$this->load->view("admin/product_list", $data);// View data according to array.
	}	
	public function edit_product()
	{
		$product_id = $this->uri->segment(3);
		$data['posts'] = $this->model->select_product($product_id);	
		
		$this->load->view('admin/edit_product',$data);
		
	}
	
	function do_upload($newid)
	{       
		$this->load->library('upload');

		$files = $_FILES;
		$cpt = count($_FILES['userfile']['name']);
		for($i=0; $i<$cpt; $i++)
		{           
			$_FILES['userfile']['name']= $files['userfile']['name'][$i];
			$_FILES['userfile']['type']= $files['userfile']['type'][$i];
			$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
			$_FILES['userfile']['error']= $files['userfile']['error'][$i];
			$_FILES['userfile']['size']= $files['userfile']['size'][$i];    
			
			
				$newp=$newid;
		//upload an image options
		$config = array();
		$config['upload_path']   =   "uploads/"; 
		$config['file_name']	 =  $_FILES['userfile']['name'];
		$config['allowed_types'] =   "gif|jpg|jpeg|png";  
		$config['max_size']      =   "5000"; 
		$config['max_width']     =   "1907"; 
		$config['max_height']    =   "1280"; 
		$config['overwrite']     = FALSE;

			$this->upload->initialize($config);
			if(!$this->upload->do_upload())
			{ 
				echo $this->upload->display_errors();
			} 
			else
			{		  
				$finfo= $this->upload->data(); 
				$fileName = $_FILES['userfile']['name'];
                $images[] = $fileName;
			}
		}
		$fileName = implode(',',$images);
		/*    print_r($fileName);
	   die(); */
		    $this->model->save_image($newid,$fileName);
		//$this->model->save_img($newp, "image", $finfo['file_ext']);
	}
	
	public function add_service1()
	{
		
		$data=array(
		'service_name'=>$this->input->post('service_name')
		);	
		$this->form_validation->set_rules('service_name', 'Service Name', 'required');
		if ($this->form_validation->run() == FALSE)
		{	
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$this->load->view('header');
			$this->load->view('top_header');
			$this->load->view('sidebar');
			$this->load->view('add_service');
			$this->load->view('footer');
		} 
		else 
		{
			$newid = $this->model->add_service($data);	
			$this->upload_service_master($newid);
			echo "successfully added";
			$this->list_service();			
		}
	}	
	
	
	
	public function upload_service_master($newid)
	{
		$newp=$newid;
		$this->load->library('upload');
			$config['upload_path']   =   "uploads/"; 
			$config['file_name']	 =   $newp;
			$config['overwrite']	 = 	 TRUE;
			$config['allowed_types'] =   "gif|jpg|jpeg|png";  
			$config['max_size']      =   "5000"; 
			$config['max_width']     =   "1907"; 
			$config['max_height']    =   "1280"; 
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('userfile'))
			{ 
				echo $this->upload->display_errors();
			} 
			else
			{		  
				$finfo= $this->upload->data(); 
				//   $data['uploadInfo'] = $finfo; 
				$this->model->save_service_master($newp, "image", $finfo['file_ext']);
			}
	}                                          
	public function list_product()
	{
		$data["posts"] = $this->model->get_product();
		
		$this->load->view("admin/product_list", $data);// View data according to array.		
	}
	public function top_selling_product()
	{
		$data["posts"] = $this->model->get_product();		 
		$this->load->view("admin/product_selling_top", $data);// View data according to array.		
	}
	public function add_top_selling()
	{
		$product=$this->input->post('product'); 
		
		$results_zero = $this->model->chng_top_selling_prod_zero();
		
		$results_one = $this->model->chng_top_selling_prod_one($product);	
				
		if($results_one)
		{
			$this->top_selling_product();
		}
		
	
		
	}
	public function add_attribute()
	{
		$attr_id=$this->input->post('attr_id'); 
		$product_id=$this->input->post('product_id'); 
		$price = $this->input->post('select_price');
		$userfile = $this->input->post('userfile');
		//print_r($_FILES['userfile']['name']);
	
		if($attr_id == '1')
		{
			$color=$this->input->post('color'); 
			for($i=0;$i<count($color);$i++)
			{
				$data=array(
				'product_id'=>$product_id,
				'attribute_name	'=>$color[$i],				
				'price'=>$this->input->post('select_price'),
				'img'=>"http://www.discovermypet.in/ci_DMP/uploads/".$_FILES['userfile']['name'][$i],
				'atr_id'=>$attr_id );				
							
				$newid = $this->model->add_attribute($data);
			
								
				//$col = implode(",",$color);
			}	
				$this->do_upload1($newid);
		
		}
		else
		{		
			$select_size=$this->input->post('select_size'); 
			$data=array(
				'product_id'=>$product_id,
				'attribute_name	'=>$this->input->post('select_size'),				
				'price'=>$this->input->post('select_price'),
				'img'=>"http://www.discovermypet.in/ci_DMP/uploads/".$_FILES['userfile']['name'][0],
				'atr_id'=>$attr_id );
				$newid = $this->model->add_attribute($data);
				
				$this->do_upload1($newid);
				
		}
	
		$this->list_product();		
	}
	
	public function edit_attribute()
	{
		$attr_id=$this->input->post('attr_id'); 
		$product_id=$this->input->post('product_id');
		$userfile=$this->input->post('userfile'); 
		$price=$this->input->post('price'); 
		$this->model->delete_attribute($product_id,$attr_id);			
		
		if($attr_id == '1')
		{
				
			$color=$this->input->post('color'); 
			
			for($i=0;$i<count($color);$i++)
			{
				$data=array(
				'product_id'=>$product_id,
				'attribute_name	'=>$color[$i],				
				'price'=>$price[$i],
				'img'=>$userfile[$i],
				'atr_id'=>$attr_id );				
							
				$newid = $this->model->add_attribute($data);			
			}	
				
		
		}
		else
		{
			$select_size=$this->input->post('select_size'); 
			for($i=0;$i<count($select_size);$i++)
			{
				if($select_size[$i] =='')
				{
					$i++;
				}
				$data=array(
				'product_id'=>$product_id,
				'attribute_name	'=>$select_size[$i],				
				'price'=>$price[$i],
				'img'=>$userfile[$i],
				'atr_id'=>$attr_id );				
							
				$newid = $this->model->add_attribute($data);	
			}	
			
			
		}
		
		$this->list_product();

	}
	function do_upload1($newid)
	{       
		$this->load->library('upload');
		$files = $_FILES;
		$cpt = count($_FILES['userfile']['name']);
		for($i=0; $i<$cpt; $i++)
		{           
			$_FILES['userfile']['name']= $files['userfile']['name'][$i];
			$_FILES['userfile']['type']= $files['userfile']['type'][$i];
			$_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
			$_FILES['userfile']['error']= $files['userfile']['error'][$i];
			$_FILES['userfile']['size']= $files['userfile']['size'][$i]; 
			
			$newp=$newid;
			//upload an image options
			$config = array();
			$config['upload_path']   =   "uploads/"; 
			$config['file_name']	 =  $_FILES['userfile']['name'];
			$config['allowed_types'] =   "gif|jpg|jpeg|png";  
			$config['max_size']      =   "5000"; 
			$config['max_width']     =   "1907"; 
			$config['max_height']    =   "1280"; 
			$config['overwrite']     = FALSE;
			
			$this->upload->initialize($config);
			if(!$this->upload->do_upload())
			{ 
				echo $this->upload->display_errors();
			} 
			else
			{		  
				$finfo= $this->upload->data(); 
				$fileName = $_FILES['userfile']['name'];
                $images[] = $fileName;
			}
		//	$fileName = implode(',',$images);
			//$this->model->save_image_attribute($newid,$fileName);
			
		}
	} 
	function do_upload_att($att_id)
	{       
		$this->load->library('upload');
		$files = $_FILES;
		$cpt = count($_FILES['userfile_att']['name']);
		for($i=0; $i<$cpt; $i++)
		{           
			$_FILES['userfile_att']['name']= $files['userfile_att']['name'][$i];			
			$_FILES['userfile_att']['type']= $files['userfile_att']['type'][$i];
			$_FILES['userfile_att']['tmp_name']= $files['userfile_att']['tmp_name'][$i];
			$_FILES['userfile_att']['error']= $files['userfile_att']['error'][$i];
			$_FILES['userfile_att']['size']= $files['userfile_att']['size'][$i]; 
			
			$newp=$att_id;
			//upload an image options
			$config = array();
			$config['upload_path']   =   "uploads/"; 
			$config['file_name']	 =  $_FILES['userfile_att']['name'];
			$config['allowed_types'] =   "gif|jpg|jpeg|png";  
			$config['max_size']      =   "5000"; 
			$config['max_width']     =   "1907"; 
			$config['max_height']    =   "1280"; 
			$config['overwrite']     = FALSE;
			
			$this->upload->initialize($config);
			if(!$this->upload->do_upload())
			{ 
				echo $this->upload->display_errors();
			} 
			else
			{		  
				$finfo= $this->upload->data(); 
				$fileName = $_FILES['userfile_att']['name'];
                $images[] = $fileName;
			}
		//	$fileName = implode(',',$images);
			$this->model->save_image_attribute($att_id,$fileName);
			
		}
	} 
	public function import()
	{		
		$this->load->view('admin/import');					
	}		
	public function add_vet()
	{
		$this->load->view('header');
		$this->load->view('top_header');
		$this->load->view('sidebar');
		$this->load->view('add_form_service');
		$this->load->view('footer');		
	} 
	public function upload_image_service($newid)
	{
		$m = $_FILES['userfile']['name'];      
		$n = $_FILES['userfile1']['name']; 				
		$newp=$newid.'_personal';
		$newc=$newid.'_commercial';
		$this->load->library('upload');
		if ($m !== "")
		{	 	 
			$config['upload_path']   =   "uploads/"; 
			$config['file_name']	 =   $newp;
			$config['overwrite']	 = 	 TRUE;
			$config['allowed_types'] =   "gif|jpg|jpeg|png";  
			$config['max_size']      =   "5000"; 
			$config['max_width']     =   "1907"; 
			$config['max_height']    =   "1280"; 
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('userfile'))
			{ 
				echo $this->upload->display_errors();
			} 
			else
			{		  
				$finfo= $this->upload->data(); 
				//   $data['uploadInfo'] = $finfo; 
				$this->model->save_imgurl_service($newp, "person_image", $finfo['file_ext']);
			}
		}
		if ($n !== "")
		{		
			$config['upload_path']   =   "uploads/"; 
			$config['file_name']	 = 	$newc;
			$config['overwrite']	 = 	  TRUE;
			$config['allowed_types'] =   "gif|jpg|jpeg|png";  
			$config['max_size']      =   "5000"; 
			$config['max_width']     =   "1907"; 
			$config['max_height']    =   "1280"; 
			
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('userfile1'))
			{ 
				echo $this->upload->display_errors();
			} 
			else
			{		  
				$finfo= $this->upload->data(); 
				$this->model->save_imgurl_service	($newc, "hospital_image", $finfo['file_ext']);
			}
		}
	}
	public function add_vete1()
	{	
		$this->form_validation->set_rules('service_name[]', 'service name', 'required');
		if ($this->form_validation->run() == FALSE)
		{	
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$this->load->view('header');
			$this->load->view('top_header');
			$this->load->view('sidebar');
			$this->load->view('add_form_service');
			$this->load->view('footer');		     
		}	
		else 
		{
			$service_name = $this->input->post('service_name');
			$data=array(
			'name'=>$this->input->post('name'),
			//'year_of_experience'=>$this->input->post('year_of_experience'),
			'address1'=>$this->input->post('address1'),
			'address2'=>$this->input->post('address2'),
			'city'=>$this->input->post('city'),
			'state'=>$this->input->post('state'),
			'pincode'=>$this->input->post('pincode'),
			'longitude'=>$this->input->post('longitude'),
			'latitude'=>$this->input->post('latitude'),
			'working_time'=>$this->input->post('working_time'),   	  
			'hospital_image'=>$this->input->post('hospital_image'),
			'practice_at'=>$this->input->post('practice_at'),
			'phone_no'=>$this->input->post('phone_no'),  
			'person_image'=>NULL,
			'hospital_image'=>NULL,
			'service_id'=>implode(",", $service_name)
			);	
			$newid = $this->model->add_data($data);	
			$this->upload_image_service($newid);
			echo "successfully added";
			$this->load->view('header');
			$this->load->view('top_header');
			$this->load->view('sidebar');
			$this->load->view('add_form_service');
			$this->load->view('footer');					
		}
	}	
	public function list_vet()
	{
		$data["posts"] = $this->model->get_all_service();
	//	$this->load->view('header');
	//	$this->load->view('top_header');
	//	$this->load->view('sidebar');
		$this->load->view("list_vet_service", $data);// View data according to array.		
	//	$this->load->view('footer');		
	}
	public function add_service()
	{
		$this->load->view('header');
		$this->load->view('top_header');
		$this->load->view('sidebar');
		$this->load->view('add_service');
		$this->load->view('footer');			
	}
	public function list_service()
	{
		$data["posts"] = $this->model->get_service();
		$this->load->view('header');
		$this->load->view('top_header');
		$this->load->view('sidebar');
		$this->load->view("list_service", $data);// View data according to array.		
		$this->load->view('footer');		
	}	
	function importcsv()
	{		
		
        $data['error'] = '';    //initialize image upload error array to empty
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
       // $config['max_size'] = '1000'; 
        $this->load->library('upload', $config); 
		$service_id = $this->input->post('service_id');
        if (!$this->upload->do_upload())   // If upload failed, display error
		{
			$data['error'] = $this->upload->display_errors();		
			$this->import();
		}
		else
		{
			
		$file_data = $this->upload->data();
		$file_path =  './uploads/'.$file_data['file_name'];
		
		if ($this->csvimport->get_array($file_path)) 
		{
			$i = 1;
			$csv_array = $this->csvimport->get_array($file_path);
			foreach ($csv_array as $row) 
			{	
				$insert_data = array(
				'name'=>trim($row['Name']),
				'address1'=>trim($row['Address']),
				'phone_no'=>trim($row['Phone No']),				
				'email'=>trim($row['Email ID']),
								
				'city'=>"Pune",						
				'service_cat_id'=>$service_id
				);
			
				$res = $this->model->insert_csv($insert_data);
				if(!$res)
				{					
					$this->session->set_flashdata('Error', 'Csv Data not impoted ');
				}
				else
				$this->session->set_flashdata('success', 'Csv Data Imported Succesfully ');				
			}
		
		
			   $this->import();              
		}
		else 
			$data['error'] = "Error occured";
		  $this->import(); 
		}
    } 
	public function import_product_vendor()
	{
		$this->load->view('admin/import_product_vendor');
	}
	
	public function import_product()
	{
		$this->load->view('admin/import_product');
	}
	function import_product_csv_vendor()
	{
		$vendor_id = $this->input->post('vendor');
		$data['error'] = '';    //initialize image upload error array to empty
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '10000'; 
        $this->load->library('upload', $config); 
         // If upload failed, display error
        if (!$this->upload->do_upload())
		{
			$data['error'] = $this->upload->display_errors();
			$this->import_product();
		}
		else
		{
			$file_data = $this->upload->data();
			$file_path =  './uploads/'.$file_data['file_name'];
			
			if ($this->csvimport->get_array($file_path)) 
			{
				$i = 1;
				$csv_array = $this->csvimport->get_array($file_path);				
				foreach ($csv_array as $row) 
				{	
					$main_cat_id = $this->model->select_main_cat_id($row['Main Category']);	
					$sub_cat_id = $this->model->select_sub_cat_id($row['Sub Category']);
					$breed_id = $this->model->select_pet_type_id($row['Breed']);		
					$pet_type_id = $this->model->select_pet_type_id($row['Pet Type']);	
					
					$res_pro = $this->model->chck_prod($vendor_id,$main_cat_id,$sub_cat_id,$breed_id,$pet_type_id,$row['Product/Brand Name']);
					if($res_pro)
					{
						$size = $row['Size'];
						$weight_id =  $this->model->select_weight_id($row['Weight']);
						$res_att = $this->model->chck_att($res_pro,$weight_id,$size);
						if($res_att)
						{
							$update_data = array(
								'product_id'=>$res_pro,
								'weight_id'=>$weight_id,
								'size_name'=>$size,
								'price'=>trim($row['Price'])
							); 
							$res =$this->model->update_att_csv($update_data,$res_att);
						}
						else
						{
							$insert_data = array(
								'product_id'=>$res_pro,
								'weight_id'=>$weight_id,
								'size_name'=>$size,
								'price'=>$row['Price']
							);
							$res =$this->model->insert_att_csv($insert_data);
						}
					}
					else
					{
						$res_pro_avail = $this->model->chck_pro($row['Product/Brand Name']);
						if($res_pro_avail)
						{
							$data["product"] = $this->model->get_delete($res_pro_avail);
							print_r($data);
							
						}
						else
						{
							echo "No product avialble";
						}
						
					}
				}
				$this->list_product_vendor();
			}
			else 	
			{	
				$data['error'] = "Error occured";		
				$this->import_product(); 
			}       
		}			
	}	
	function import_product_csv()
	{		
        $data['error'] = '';    //initialize image upload error array to empty
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '10000'; 
        $this->load->library('upload', $config); 
         // If upload failed, display error
        if (!$this->upload->do_upload())
			{
				$data['error'] = $this->upload->display_errors();
				$this->import_product();
		    }
		else
			{
            $file_data = $this->upload->data();
            $file_path =  './uploads/'.$file_data['file_name'];
			
            if ($this->csvimport->get_array($file_path)) 
			{
				$i = 1;
                $csv_array = $this->csvimport->get_array($file_path);				
                foreach ($csv_array as $row) 
				{	
					$main_cat_id = $this->model->select_main_cat_id($row['Main Category']);	
					$sub_cat_id = $this->model->select_sub_cat_id($row['Sub Category']);
					$breed_id = $this->model->select_pet_type_id($row['Breed']);		
					$pet_type_id = $this->model->select_pet_type_id($row['Pet Type']);	
					$vendor_id =  $this->model->select_vendor_id($row['Vendor Name']);
					$orignal_price = $row['Price'];		
					$offer = $row['Offer'];	
					$dis_rate = $orignal_price * $offer / 100;	
					$rate = $orignal_price - $dis_rate;					
				 	$res_pro_ven = $this->model->chck_pro_ven($vendor_id,$row['Product/Brand Name']);
					if($res_pro_ven)
					{						
						/* $update_data = array(
							'vendor_id'=>$vendor_id,
							'service_id'=>"2",
							'main_category_id'=>$main_cat_id,
							'category_id'=>$sub_cat_id,
							'pet_type_id'=>$pet_type_id,
							'plan_name'=>trim($row['Product/Brand Name']),
							'description'=>trim($row['Description']),
							'rate'=>$rate,							'orignal_price'=>trim($row['Price']),
							'offer'=>trim($row['Offer']),
							'image'=>"http://discovermypet.in/ci_DMP/uploads/".trim($row['Image']),
							'brand_id'=>$brand_id,
							//'stock'=>trim($row['Stock']),
							'details'=>trim($row['Product Details']),
							 ); */
							//	$res =this->model->update_product_csv($update_data,$res_pro_ven);
							$res = $res_pro_ven;
					}
					else	
					{
						$img = trim($row['Image']);
						$imgs = explode(",",$img);
						for($i=0;$i<count($imgs);$i++)
						{
							$img_array[$i] = "http://www.discovermypet.in/ci_DMP/uploads/".$imgs[$i];
						}
						$imgg = implode(",",$img_array);
						
						$brand_id = $this->model->select_brand_id($row['Brand']);
						$insert_data = array(
						'vendor_id'=>$vendor_id,
						'service_id'=>"2",		
						'main_category_id'=>$main_cat_id,
						'category_id'=>$sub_cat_id,	
						'pet_type_id'=>$pet_type_id,	
						'plan_name'=>trim($row['Product/Brand Name']),		
						'description'=>trim($row['Description']),
						'rate'=>$rate,				
						'orignal_price'=>trim($row['Price']),
						'offer'=>trim($row['Offer']),
						'image'=>$imgg,
						'brand_id'=>$brand_id,		
						'stock'=>trim($row['Stock']),	
						'details'=>trim($row['Product Details']),
						);
						
						$res = $this->model->insert_product_csv($insert_data);	
					}
					$weight_id =  $this->model->select_weight_id($row['Weight']);					
					$insert_attr = array(
						'product_id'=>$res,
						'weight_id'=>$weight_id,
						'size_name'=>trim($row['Size']),
						'price'=>trim($row['Price Attribute'])	 
						);					
					$res1 = $this->model->insert_att_csv($insert_attr);  
                }	
				$this->list_product();      				
            }
				else 	
				{	
					$data['error'] = "Error occured";		
					$this->import_product(); 
				}        
            }
    } 
     
    /* Send SMS */
    public function importsms_user()
	{
		$this->load->view('admin/importsms_user');
	}
	function import_sms_csv()
	{	
		$user_id = $this->session->userdata('user_id');
        $data['error'] = '';    //initialize image upload error array to empty
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '10000'; 
        $this->load->library('upload', $config); 
         // If upload failed, display error
        if (!$this->upload->do_upload())
			{
				$data['error'] = $this->upload->display_errors();
				$this->importsms_user();
		    }
		else
			{
            $file_data = $this->upload->data();
            $file_path =  './uploads/'.$file_data['file_name'];
            		
            if ($this->csvimport->get_array($file_path)) 
			{
				$i = 1;
                $csv_array = $this->csvimport->get_array($file_path);
                foreach ($csv_array as $row) 
				{	
					$mobile_no = $row['phn_no'];
					$name = $row['name'];
					$res_user = $this->model->chck_user_mob($user_id,$mobile_no); 		
					
					if($res_user)
					{				
						$insert_data = array(							
							'name'=>trim($row['name']),
							'phn_no'=>trim($row['phn_no'])							
							 );
						$res = $this->model->update_sms_csv($name,$insert_data); 
						
					}
					else
					{
						
						  $insert_data = array(							
							'name'=>trim($row['name']),
							'phn_no'=>trim($row['phn_no']),
							'vendor_id'=>$user_id,
							
							 );
						$res = $this->model->insert_sms_csv($insert_data);	 
						 	  
					}
					
			    }	
					$this->session->set_flashdata('success', '1');  
				   //$this->list_sendsms();	
				   redirect('welcome/list_sendsms');  

            }
			else 
                $data['error'] = "Error occured";
              $this->importsms_user(); 
            }
    } 
    public function list_sendsms()
	{
		$user_id = $this->session->userdata('user_id');
		$data["users"] = $this->model->list_sendsms($user_id);
		
		$this->load->view("admin/list_sendsms", $data);// View data according to array.		
	}
	function select_usersms()
	{
		$url = "https://play.google.com/store/apps/details?id=discovermypet.navitorhealthcare&hl=en";
		$drname = $this->session->userdata('username');
		$drname = ucwords($drname);
		if(empty($_POST['ids']))
		{
			$this->session->set_flashdata('error', '0');			
		}
		else
		{
			foreach($_POST['ids'] as $selected)
			{
				$ids[]=$selected;
			} 
			for ($i=0; $i < sizeof($ids); $i++)
			{ 
				//echo $ids[$i];
			 $data=$this->model->get_data($ids[$i]);
				foreach ($data as $row)
				{		
					$user_msg = urlencode("Dear Pet Owner, I '".$drname."' is pleased to recommend you a Free Download of India's First Unique Pet APP 'Discover My Pet'. Experience Powerful Innovation in Pet World.https://play.google.com/store/apps/details?id=discovermypet.navitorhealthcare&hl=en");
					$mobile = "91".$row->phn_no;
					$this->send_sms($user_msg, $mobile);
					$this->session->set_flashdata('success', '2');  
					$this->model->update_count($ids[$i]); 
				}
				
			}
		}
		
		redirect("Welcome/list_sendsms");
	}	
	function select_usersms_master()
	{
		$sms_template = $this->input->post('sms_template');	
		if(empty($_POST['ids']))
		{
			$this->session->set_flashdata('error', '0');			
		}
		else
		{
			foreach($_POST['ids'] as $selected)
			{
				$ids[]=$selected;
			} 
			for ($i=0; $i < sizeof($ids); $i++)
			{ 
				$data['mobile'] = $this->model->get_data_app_user($ids[$i]);
			
				foreach($data['mobile'] as $rows)				
				{
					$mobile = $rows->mobile;
					$name = $rows->name;
				}				
				$data_base[0]['body'] = $sms_template; // Tests
				$vars = array(
				  '{$name}'       => $name
				);
				$sms_template = strtr($data_base[0]['body'], $vars);				
				$user_msg = urlencode($sms_template);			
				$this->send_sms($user_msg, $mobile);				
				$this->model->update_count_app_users($ids[$i]);
			}			
		}			
		$this->session->set_flashdata('success', '2');  
		redirect("Welcome/cam_send_sms");
	}
	function select_usersms_master_email()
	{
		$email_template = $this->input->post('email_template');			
		if(empty($_POST['ids']))
		{
			$this->session->set_flashdata('error', '0');			
		}
		else
		{
			foreach($_POST['ids'] as $selected)
			{
				$ids[]=$selected;
			} 
			for ($i=0; $i < sizeof($ids); $i++)
			{ 
				$data['email'] = $this->model->get_data_app_user($ids[$i]);
			
				foreach($data['email'] as $rows)				
				{
					$email = $rows->email;					
				}				
					$config = Array(       
						'protocol' => 'sendmail',
						'smtp_host' => 'your domain SMTP host',
						'smtp_port' => 25,
						'smtp_user' => 'SMTP Username',
						'smtp_pass' => 'SMTP Password',
						'smtp_timeout' => '4',
						'mailtype'  => 'html',
						'charset'   => 'iso-8859-1');
					$this->load->library('email', $config);		
						
					$this->email->from('info@discovermypet.in');
					$this->email->to($email); 
					$this->email->subject('DMP Email cam');
					
					$data = array("key"=>'value');
		
					$body = $this->load->view($email_template,$data,TRUE);		
					$this->email->message($body);

					if($this->email->send()) 
					$this->session->set_flashdata("email_sent","Email sent successfully."); 
					else 
					$this->session->set_flashdata("email_sent","Error in sending Email.");
										
				$this->model->update_count_app_users_email($ids[$i]);
			}			
		}			
		$this->session->set_flashdata('success', '2');  
		redirect("Welcome/cam_send_email");
	}
	function select_usersms_master_grp_email()
	{
		$email_template = $this->input->post('email_template');		
		$subject =	$this->model->select_subject($email_template);
	
		if(empty($_POST['ids']))
		{
			$this->session->set_flashdata('error', '0');			
		}
		else
		{
			foreach($_POST['ids'] as $selected)
			{
				$ids[]=$selected;
			} 
			for ($i=0; $i < sizeof($ids); $i++)
			{ 
				$data['email'] = $this->model->get_data_user($ids[$i]);
			
				foreach($data['email'] as $rows)				
				{
					$email = $rows->email;					
				}			
					$config = Array(       
						'protocol' => 'sendmail',
						'smtp_host' => 'your domain SMTP host',
						'smtp_port' => 25,
						'smtp_user' => 'SMTP Username',
						'smtp_pass' => 'SMTP Password',
						'smtp_timeout' => '4',
						'mailtype'  => 'html',
						'charset'   => 'iso-8859-1');
					$this->load->library('email', $config);		
						
					$this->email->from('info@discovermypet.in','Discover My Pet');
					$this->email->to($email); 
					$this->email->subject($subject);
					
					$data = array("key"=>'value');
		
					$body = $this->load->view($email_template,$data,TRUE);		
					$this->email->message($body);

					if($this->email->send()) 
						echo "hiii";
					else 
					echo "byee";
				
										
				$this->model->update_count_app_users_email($ids[$i]);
			}			
		}			
		$this->session->set_flashdata('success', '2');  
		redirect("Welcome/cam_send_grp_email");
	}
	public function cam_send_grp_sms()
	{
		$data["users"] = $this->model->get_email_grp_user();
		$this->load->view("admin/cam_send_grp_sms",$data); 
	}	
	function select_usersms_master_grp_sms()
	{		
		$sms_template = $this->input->post('sms_template');	
		if(empty($_POST['ids']))
		{
			$this->session->set_flashdata('error', '0');			
		}
		else
		{
			foreach($_POST['ids'] as $selected)
			{
				$ids[]=$selected;
			} 
			for ($i=0; $i < sizeof($ids); $i++)
			{ 
				$data['mobile'] = $this->model->get_data_user($ids[$i]);
			
				foreach($data['mobile'] as $rows)				
				{					
					$mobile = "91".$rows->phn_no;
					$name = $rows->name;
				}				
				$data_base[0]['body'] = $sms_template; // Tests
		$vars = array(
					'$url' => "https://play.google.com/store/apps/details?id=discovermypet.navitorhealthcare&hl=en",
					'$url1' =>"https://itunes.apple.com/in/app/discovermypet/id1125498169?mt=8",
					'$name' =>$name
				);				
				$sms_template = strtr($data_base[0]['body'], $vars);					
				$user_msg = urlencode($sms_template);			
				$this->send_sms($user_msg, $mobile);			
				$this->model->update_count_app_users($ids[$i]);
			}			
		}			
		$this->session->set_flashdata('success', '2');  
		redirect("Welcome/cam_send_grp_sms");
	}	
	public function excel()
	{
			$this->excel->setActiveSheetIndex(0);
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle('Addressbook');
			//set cell A1 content with some text
			$this->excel->getActiveSheet()->setCellValue('A1', 'Addressbook');
			$this->excel->getActiveSheet()->setCellValue('A4', 'Last name');
			$this->excel->getActiveSheet()->setCellValue('B4', 'Phone');
			$this->excel->getActiveSheet()->setCellValue('C4', 'Email');
			//merge cell A1 until C1
			$this->excel->getActiveSheet()->mergeCells('A1:C1');
			//set aligment to center for that merged cell (A1 to C1)
			$this->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			//make the font become bold
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
			$this->excel->getActiveSheet()->getStyle('A1')->getFill()->getStartColor()->setARGB('#333');
			for($col = ord('A'); $col <= ord('C'); $col++)
			{
				//set column dimension
				$this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
				 //change the font size
				$this->excel->getActiveSheet()->getStyle(chr($col))->getFont()->setSize(12);
				 
				$this->excel->getActiveSheet()->getStyle(chr($col))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			//retrive contries table data
			$rs = $this->db->get('tbl_sevice_details');
			$exceldata="";
			foreach ($rs->result_array() as $row)
			{
				$exceldata[] = $row;
			}
			//Fill data 
			$this->excel->getActiveSheet()->fromArray($exceldata, null, 'A4');
			 
			$this->excel->getActiveSheet()->getStyle('A4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$this->excel->getActiveSheet()->getStyle('C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			 
			$filename='PHPExcelDemo.xls'; //save our workbook as this file name
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache

			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
			//if you want to save it as .XLSX Excel 2007 format
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');			 
	}
	public function product_details()
	{
		$this->load->view("product_details");// View data according to array.			
	}
	public function add_blog()
	{		
		$this->load->view("admin/blog_details");// View data according to array.				
	}
	
	public function add_blog_details()
	{
		date_default_timezone_set("Asia/Kolkata");
		$date = date('Y-m-d h:m:s');
		$fcmRegIds = array();
		$message = array();
		$data=array(
		'title'=>$this->input->post('title'),
		'created_date'=>$date,
		'description'=>$this->input->post('details'));
		$this->form_validation->set_rules('details', 'Details', 'required');
		$this->form_validation->set_rules('title', 'Title', 'required');
		if ($this->form_validation->run() == FALSE)
		{	
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$this->add_blog();			
		}
		else 
		{
			$newid = $this->model->add_blog_detai($data);
			$this->upload_image_blog($newid);			
		//	echo "successfully added";
			
			$message = $this->input->post('title');
			$data["users"] = $this->model->get_active_user();		
			define("GOOGLE_API_KEY", "AIzaSyDL_2nRnXC_6W4U1xAu4zPa1OXGnNp47Ks");			
			foreach($data["users"] as $rows)
			{
				$insert_blog = array(
					'type' =>'blog',
					'who_id' =>$rows->id,
					'is_read' =>'0',
					'created_date' =>$date,
					'timeline_id' =>$newid 
				);
				$this->model->update_notification($insert_blog);		
		
				$gcm_id = $rows->gcm_id;					
				array_push($fcmRegIds, $gcm_id);
				//array_push($message,$user_msg);			
			
				$url = 'https://android.googleapis.com/gcm/send';
				$fields = array(
				'registration_ids' => $fcmRegIds,
				'data' => array("message" =>$message)
				);		

				$headers = array(
					'Authorization: key=' . GOOGLE_API_KEY,
					'Content-Type: application/json'
				);
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);	
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
				$result = curl_exec($ch);
				
				if ($result === FALSE) {
					die('Curl failed: ' . curl_error($ch));
				}
				curl_close($ch);			
			}					
				$this->list_blog();			
		}
	}
	public function edit_blog()
	{
		$id = $this->uri->segment(3);
		$data["posts"] = $this->model->edit_blog($id);	
		$this->load->view('admin/edit_blog',$data);		
	}
	public function edit_blog1()
	{
		$id = $this->input->post('id');
		$data=array(
		'title'=>$this->input->post('title'),
		'description'=>$this->input->post('details'));
		
		$this->model->edit_blog_detai($data,$id);
		if($_FILES['userfile']['name']!='')
		{
			$this->upload_image_blog($id);
		}
			
		$this->list_blog();					
		
	}
	public function upload_image_blog($newid)
	{
		$newp=$newid;
		$this->load->library('upload');
			$config['upload_path']   =   "uploads/"; 
			$config['file_name']	 =   $newp;
			$config['overwrite']	 = 	 TRUE;
			$config['allowed_types'] =   "gif|jpg|jpeg|png";  
			$config['max_size']      =   "5000"; 
			$config['max_width']     =   "1907"; 
			$config['max_height']    =   "1280"; 
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('userfile'))
			{ 
				echo $this->upload->display_errors();
			} 
			else
			{		  
				$finfo= $this->upload->data(); 
				//   $data['uploadInfo'] = $finfo; 
				$this->model->save_blog($newp, "image", $finfo['file_ext']);
			}
	}                   
	public function list_blog()
	{
		$data["posts"] = $this->model->get_blog();		
		$this->load->view("admin/list_blog", $data);// View data according to array.		
	}
	public function delet_blog()
	{
		$blog_id = $this->uri->segment(3);
		$this->model->delete_blog($blog_id);
		$this->session->set_flashdata('success', '2');		
		$this->list_blog();		
	}
	
	
	public function add_product_details()
	{
		$data=array(
		'product_id'=>$this->input->post('product_id'),
		'details'=>$this->input->post('details'));
		$this->form_validation->set_rules('product_id', 'Product ID', 'required');
		$this->form_validation->set_rules('details', 'Details', 'required');
		if ($this->form_validation->run() == FALSE)
		{	
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$this->product_details();			
		}
		else 
		{
			$this->model->add_product_detai($data);	
			echo "successfully added";
			$this->product_details();			
		}
	}	
	public function get_product_details()
	{
		$data["posts"] = $this->model->get_product_detail();
		$this->load->view("list_product_details", $data);// View data according to array.		
	}	
	 public function get_product_details_vendor()
	{
		$user_id = $this->session->userdata('user_id');	
		$data["posts"] = $this->model->get_product_detail_vendor($user_id);
		$this->load->view('header');
		$this->load->view('top_header');
		$this->load->view('sidebar');
		$this->load->view("list_product_details", $data);// View data according to array.		
		$this->load->view('footer');
	}	 
	
	
	public function get_transaction_details()
	{
		
		$user_id = $this->session->userdata('user_id');	
		if($user_id =="1")
		{
				$data["posts"] = $this->model->get_trasaction();
				//print_r($data);
				
						$this->load->view("admin/get_trasaction", $data);// View data according to array.	
						
		}
		else
		{
			$user_id = $this->session->userdata('user_id');	
			$data["posts"] = $this->model->get_trasaction_vendor_id($user_id);
			$this->load->view("get_trasaction1", $data);// View data according to array.	
			//print_r($data);
				
				
		}	
	}
	public function view_transaction()
	{
		$id = $this->input->post('id');
		$data["posts"] = $this->model->get_trasaction_detail($id);	
		if($data =="")
		{
			echo "No Records";
		}
		else
		{
			$this->load->view("admin/get_trasaction_details", $data);// View data according to array.		
		}
			
	}
	public function get_transaction_vendor()
	{
		 $data1["vendor_transaction"] = $this->model->vendor_transaction();	
		
			/*foreach($data1["vendor_transaction"] as $row1)
			{
					$id = $row1->cart_master_id;
					$data["posts"] = $this->model->get_trasaction_vendor($id);				
			}
		print_r($data);
		//die();
	  */
		
		$this->load->view("admin/get_trasaction_vendor",$data1);// View data according to array.	
		
	}
	
	public function social()
	{
		$data["posts"] = $this->model->timeline();		
		$this->load->view("admin/get_social", $data);// View data according to array.
	}
	public function delete_social()
	{
		$social_id = $this->uri->segment(3);
		$this->model->delete_social($social_id);
		$this->session->set_flashdata('success', '2');		
		$this->social();		
	}
	public function view_social()
	{
		$id = $this->input->post('id');		
		$data['posts'] = $this->model->view_timeline($id);			
		$this->load->view("view_social", $data,$data1);// View data according to array.
	}
	public function edit_social()
	{
		$id = $this->input->post('id');		
		$data["posts"] = $this->model->get_timeline($id);	
		$this->load->view("edit_social", $data);// View data according to array.		
	}
	
	public function list_tips()
	{
		$data["posts"] = $this->model->get_tips();		
		$this->load->view("get_tips", $data);// View data according to array.		
	}
	public function edit_tips()
	{
		$id = $this->input->post('id');		
		$data["posts"] = $this->model->get_tip($id);	
		$this->load->view("edit_tips", $data);// View data according to array.		
	}
	/***** Vendor *****/
	public function profile()
	{
		$user_id = $this->session->userdata('user_id');	
		$data["posts"] = $this->model->get_profile($user_id);	
		$this->load->view("profile", $data);// View data according to array.
		
	}
	public function edit_profile()
	{
		$data=array(
		'name'=>$this->input->post('name'),
		'orgnisation_name'=>$this->input->post('orgnisation_name'),
		'email'=>$this->input->post('email'),
		'website'=>$this->input->post('website'),
		'address'=>$this->input->post('address'),
		'mobile'=>$this->input->post('mobile'),		
		'land_line1'=>$this->input->post('land_line1'),
		'land_line2'=>$this->input->post('land_line2'),
		'password'=>$this->input->post('password')
		);			
		$user_id = $this->session->userdata('user_id');	
		$this->model->edit_vendor($user_id,$data);		
		$this->session->set_flashdata('success', '1');		
		$this->profile();		
		
	}
	public function edit_profile1()
	{
		$id = $this->input->post('id');
		$data=array(
		'name'=>$this->input->post('name'),
		'orgnisation_name'=>$this->input->post('orgnisation_name'),
		'email'=>$this->input->post('email'),
		'website'=>$this->input->post('website'),
		'address'=>$this->input->post('address'),
		'mobile'=>$this->input->post('mobile'),		
		'land_line1'=>$this->input->post('land_line1'),
		'land_line2'=>$this->input->post('land_line2'),
		'password'=>$this->input->post('password')
		);	
		
		$this->model->edit_vendor($id,$data);		
		$this->session->set_flashdata('success', '1');	
	
		$this->profile1($id);		
		
	}
	public function profile1($id)
	{
		$data["rows"] = $id;
		$data["posts"] = $this->model->get_profile($id);	
		$this->load->view("profile1", $data);// View data according to array.
		
	}
	
	public function delet_vendor()
	{
		$vendor_id = $this->uri->segment(3);
		$this->model->delete_vendor($vendor_id);
		$this->session->set_flashdata('success', '2');		
		$this->list_vendor();		
	}
	
	public function setting()
	{
		$user_id = $this->session->userdata('user_id');			
		$this->load->view("password");// View data according to array.	
	}
	public function add_vendor()
	{		
		$this->load->view("admin/add_vendor");			
	}
	public function edit_vendor()
	{
		$vendor_id = $this->uri->segment(3);
		$data["rows"] = $vendor_id;
		
		$data["posts"] = $this->model->get_profile($vendor_id);
		/* print_r($data);		
		die(); */
		$this->load->view("profile1", $data);// View data according to array.
			
	}
	public function add_vendor1()
	{
		$is_distributer = $this->input->post('is_distributer');
		$email = $this->input->post('email');
		$mobile = $this->input->post('mobile');
				 
		$data=array(
		'name'=>$this->input->post('name'),
		'orgnisation_name'=>$this->input->post('orgnisation_name'),
		'email'=>$this->input->post('email'),
		'website'=>$this->input->post('website'),
		'address'=>$this->input->post('address'),
		'city'=>$this->input->post('city'),
		'mobile'=>$this->input->post('mobile'),		
		'land_line1'=>$this->input->post('land_line1'),
		'land_line2'=>$this->input->post('land_line2'),
		'is_app_distributer'=>$this->input->post('is_distributer'),
		'password'=>$this->input->post('password')
		);	
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('orgnisation_name', 'Orgnisation Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		//$this->form_validation->set_rules('website', 'Website', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required');
		//$this->form_validation->set_rules('land_line1', 'Office Landline No.1', 'required');
		//$this->form_validation->set_rules('land_line2', 'Office Landline No.2', 'required');
		$this->form_validation->set_rules('password',"Password","trim|required|min_length[5]|max_length[12]");
		
		if ($this->form_validation->run() == FALSE)
		{	
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			$this->load->view("admin/add_vendor");		
		} 
		else 
		{
			$res_already_email = $this->model->chck_vendor_email($email);
			$res_already_mobile = $this->model->chck_vendor_mobile($mobile);
			if($res_already_email OR $res_already_mobile)
			{
				if($res_already_mobile)
				{
					$this->session->set_flashdata('error', '1');
				}
				if($res_already_email)
				{
					$this->session->set_flashdata('derror', '2');
				}
								
				$this->load->view("admin/add_vendor");	
			}
			else
			{
				$this->model->add_vendor($data);						
				$config = Array(       
					'protocol' => 'sendmail',
					'smtp_host' => 'your domain SMTP host',
					'smtp_port' => 25,
					'smtp_user' => 'SMTP Username',
					'smtp_pass' => 'SMTP Password',
					'smtp_timeout' => '4',
					'mailtype'  => 'html',
					'charset'   => 'iso-8859-1');
				$this->load->library('email', $config);
		
				$id=$this->input->post('id');
				
				$password=$this->input->post('password');		
				
										
				$this->email->from('info@discovermypet.in');
				$this->email->to($email); 
				$this->email->subject('Your account has been activated');
				$body = $this->load->view('emails/active_mail.php',$data,TRUE); 
				$this->email->message($body);
		
				if($this->email->send()) 
				$this->session->set_flashdata("email_sent","Email sent successfully."); 
				else 
				$this->session->set_flashdata("email_sent","Error in sending Email."); 
				$url = "http://www.discovermypet.in/ci_DMP/";
				if($is_distributer =='0')
				{
					$type = "Vendorship";
				}
				else
				{
					$type = "Distributorship";
				}				
				$user_msg = urlencode("Congratulation Your Discovermypet '".$type."' account has been created. Below your details URL '".$url."' , Email '".$email."' , Password '".$password."'.");				
				$mobile = "91".$mobile;
				$this->send_sms($user_msg, $mobile);
			
				$this->list_vendor();	
		}				
		}
	}
	public function send_sms($user_msg, $mobile)
	{
		$sms_url = "http://smslane.com/vendorsms/pushsms.aspx?user=discovermypet&password=abcdefg@1234&msisdn=$mobile&sid=PETAPP&msg=$user_msg&fl=0&gwid=2";	
		
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$sms_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
	} 
	public function edit_password()
	{
		$user_id = $this->session->userdata('user_id');
		$old_pwd = $this->input->post('old_pwd');
		$result = $this->model->chck_pwd($old_pwd);
		if($result)
		{
			$new_pwd = $this->input->post('new_pwd');
			$confirm_pwd = $this->input->post('confirm_pwd');
			if($new_pwd == $confirm_pwd)
			{
				$result = $this->model->save_pwd($new_pwd,$user_id);
				$this->session->set_flashdata('success', '1');	
				 $this->profile();
			}
			else
			{
				 $this->session->set_flashdata('derror', '2');	
				 $this->setting();
			}
			
		}
		else
		{
			$this->session->set_flashdata('derror', '1');	
			 $this->setting();
		}
		
	}
	public function forget()
	{		
		$this->load->view("forget");// View data according to array.			
	}
	public function forget_link()
	{
		
		$forget_text = $this->input->post('forget_text');
		$email = $this->input->post('email');
		if($forget_text == 'By Email')
		{
			$config = Array(       
				'protocol' => 'sendmail',
				'smtp_host' => 'your domain SMTP host',
				'smtp_port' => 25,
				'smtp_user' => 'SMTP Username',
				'smtp_pass' => 'SMTP Password',
				'smtp_timeout' => '4',
				'mailtype'  => 'html',
				'charset'   => 'iso-8859-1');
				$this->load->library('email', $config);		
				
				$password = rand(10000, 99999); 
				$data=array(
					'password'=>$password);
				
				$result = $this->model->set_password($email,$data);
					
										
				$this->email->from('info@discovermypet.in');
				$this->email->to($email); 
				$this->email->subject('Forgot Password');
				$body = $this->load->view('emails/forget_mail.php',$data,TRUE);
				$this->email->message($body);
		
				if($this->email->send()) 
				$this->session->set_flashdata("email_sent","Email sent successfully."); 
				else 
				$this->session->set_flashdata("email_sent","Error in sending Email."); 	
				$this->index();
		}
		else
		{
			$mobile = $this->input->post('mobile');
			
			$password = rand(10000, 99999);
			$data=array(
					'password'=>$password);
					$result = $this->model->set_password_mobile($mobile,$data);
			$user_msg = urlencode("Your New Password '".$password."'.");
			$mobile = "91".$mobile;
			$this->send_sms($user_msg, $mobile);
			$this->session->set_flashdata('derror', '1');				
			$this->index();			
		}
		
	}
	public function list_product_vendor()
	{ 
		$user_id = $this->session->userdata('user_id');	
		$data["posts"] = $this->model->get_product_vendor($user_id);
		if($data["posts"] =="")
		{
			$this->session->set_flashdata('success', '1');
			$this->add_product();			
		}
		else
		{			
			$this->load->view("admin/product_list", $data);// View data according to array.				
		}		
	}
	public function list_vendor()
	{
		
		$data["posts"] = $this->model->get_vendor();		
		$this->load->view("admin/list_vendor", $data);
				
	}
	public function sms_master()
	{
		$this->load->view("admin/sms_master");		
	}
	public function add_sms_master()
	{
		$data=array(
		'short_heading'=>$this->input->post('title'),
		'description'=>$this->input->post('details')		
		);	
		$this->model->insert_sms_master($data);
		$this->list_sms_master();		
	}
	public function add_group()
	{
		$user_id = $this->session->userdata('user_id');
		$data1=array(
		'grp_name'=>$this->input->post('group_name'),
		'vendor_id'=>$user_id		
		);	
		$group_id = $this->model->insert_group_master($data1);
			
		$data['error'] = '';    //initialize image upload error array to empty
        $config['upload_path'] = './uploads/';
		//$config['max_size'] = '10000'; 
        $config['allowed_types'] = 'csv';
	    $this->load->library('upload', $config); 
	
        if (!$this->upload->do_upload())   // If upload failed, display error
		{						
			$data['error'] = $this->upload->display_errors();			
			$this->cam_send_grp_email();
		}
		else
		{			
			$file_data = $this->upload->data();
			$file_path =  './uploads/'.$file_data['file_name'];
			if ($this->csvimport->get_array($file_path)) 
			{
				$i = 1;
				$csv_array = $this->csvimport->get_array($file_path);
				foreach ($csv_array as $row) 
				{	
					$insert_data = array(
					'name'=>trim($row['Name']),					
					'phn_no	'=>trim($row['Phone No']),											
					'email'=>trim($row['Email']),											
					'group_id'=>$group_id,											
					'vendor_id'=>$user_id
					);					
					$res = $this->model->insert_csv_cam_grp($insert_data);
					if(!$res)
					{					
						$this->session->set_flashdata('Error', 'Csv Data not impoted ');
					}
					else
					$this->session->set_flashdata('success', 'Csv Data Imported Succesfully ');	
				}		
			    $this->cam_send_grp_email();              
			}
		else 
			$data['error'] = "Error occured";
			$this->cam_send_grp_email(); 
		}		
	}
	public function search_group_email()
	{
		$id=$this->input->post('id'); 
		$data['group_id'] = $id;
		$data['users'] = $this->model->search_group($id);	
		$this->load->view("admin/cam_send_grp_email",$data);		
	}
	public function search_group_sms()
	{
		$id=$this->input->post('id'); 
		$data['group_id'] = $id;
		$data['users'] = $this->model->search_group($id);	
		$this->load->view("admin/cam_send_grp_sms",$data);		
	}
	public function cam_send_grp_email()
	{
		$data["users"] = $this->model->get_email_grp_user();
		$this->load->view("admin/cam_send_grp_email",$data);
	}	
	public function list_sms_master()
	{
		$data["sms_master"] = $this->model->list_sms_master();
		$this->load->view("admin/list_sms_master",$data);			
	}
	public function cam_send_sms()
	{
		$data["users"] = $this->model->get_active_user();
		$this->load->view("admin/cam_send_sms",$data);		
	}
	public function app_user()
	{
		$data["users"] = $this->model->get_active_user();
		$this->load->view("admin/app_users",$data);
	}
	public function search_user()
	{
		$array = array();
		$array1 = array();
		$array2  = array();
		$array3  = array();
		$array4  = array();
		
		$city = $this->input->post('city');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		
		if($city =="-1" AND empty($from_date) AND empty($to_date))
		{
			$this->app_user();
			
		}
		if($city !="-1")
		{
			$array1  = array('city =' => $city);
		}
		if($from_date != "")
		{
			$from_date1 = explode("/",$from_date);
			$from_date = $from_date1[2]."-".$from_date1[0]."-".$from_date1[1];
			$array2 = array('created_date >='=> $from_date);
		}		
		if($to_date != "")
		{
			$to_date1 = explode("/",$to_date);
			$to_date = $to_date1[2]."-".$to_date1[0]."-".$to_date1[1];
			$array3 = array('created_date <='=> $to_date);
		}
		$array4 =  array('is_active '=> '1');
		$array = array_merge($array1, $array2,$array3,$array4); 	
		
		$data["users"] = $this->model->search_active_user($array);
		$this->load->view("admin/app_users",$data);
	}
	function get_lat_long($address)
	{
		$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=India";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		curl_close($ch);
		$response_a = json_decode($response);
		
		$origLat = $response_a->results[0]->geometry->location->lat;
		
		$origLon = $response_a->results[0]->geometry->location->lng;
		return $response_a;
	}
	public function email_master()
	{
		$this->load->view("admin/email_master");		
	}
	public function add_email_master()
	{	
		$config['upload_path']   = $_SERVER["DOCUMENT_ROOT"]."/ci_DMP/application/views/emails/";	
		$config['allowed_types'] = '*';
		$config['max_size']  = 10000;
		$config['max_width']  = 1024;
		$config['max_height']  = 7680;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('attach'))
		{
			$error = array('error' => $this->upload->display_errors());			
			$this->load->view('admin/email_master', $error);
		}
		else
		{
			//$data = array('upload_data' => $this->upload->data());
			$fileName = $_FILES['attach']['name'];
			$data=array(
			'subject'=>$this->input->post('subject'),
			'file_path'=>"emails/".$fileName,
			'title'=>$this->input->post('title')		
			);	
		
			$this->model->insert_email_master($data);
			$this->load->view('admin/email_master', $data);
		}	
	}
	public function list_email_master()
	{
		$data["email_master"] = $this->model->list_email_master();
		$this->load->view("admin/list_email_master",$data);	
	}
	public function cam_send_email()
	{
		$data["users"] = $this->model->get_active_user();
		$this->load->view("admin/cam_send_email",$data);		
	}

	public function logout()
	{
		$newdata = array(
		'user_id'   =>'',		
		'email'   =>'',		
		'logged_in' => FALSE);
		$this->session->unset_userdata($newdata );
		$this->session->sess_destroy();
		$this->index();		  
	}
	/*
	public function search_date()
	{	 
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$data['posts'] = $this->model->search($from_date,$to_date); 
		$this->load->view('header');
		$this->load->view('top_header');
		$this->load->view('sidebar');
		$this->load->view('get_trasaction', $data);
		$this->load->view('footer');	
	}
	
	public function sorting_asc_id()
	{
		$data["posts"] = $this->model->sort_asc_id();
		$this->load->view('header');
		$this->load->view('top_header');
		$this->load->view('sidebar');
		$this->load->view("get_trasaction", $data);// View data according to array.		
		$this->load->view('footer');		
	}
	public function sorting_des_id()
	{
		$data["posts"] = $this->model->sort_des_id();		
		$this->load->view("get_trasaction", $data);// View data according to array.		
	}
	public function delete_product1()
	{		
		$data=array(
		'service_id'=>$this->input->post('service_id'));			
		$id = $this->input->post('id');
		$this->model->delete_product($data,$id);
		echo "succefully Delete..";
		$user_id = $this->session->userdata('user_id');	
			if($user_id =="1")
			{
				$this->list_product();
			}
			else
			{
				$this->list_product_vendor();
			}
							
	}
	
	
	*/
	
	/* public function upload_image($newid)
	{
		$newp=$newid;
		$this->load->library('upload');
			$config['upload_path']   =   "uploads/"; 
			$config['file_name']	 =   $newp;
			$config['overwrite']	 = 	 TRUE;
			$config['allowed_types'] =   "gif|jpg|jpeg|png";  
			$config['max_size']      =   "5000"; 
			$config['max_width']     =   "1907"; 
			$config['max_height']    =   "1280"; 
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('userfile'))
			{ 
				echo $this->upload->display_errors();
			} 
			else
			{		  
				$finfo= $this->upload->data(); 
				//   $data['uploadInfo'] = $finfo; 
				$this->model->save_imgurl($newp, "image", $finfo['file_ext']);
			}
	} */
	
}
