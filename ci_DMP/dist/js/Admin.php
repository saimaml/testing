<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_home_model');		
	}	
	function index()
	{
	  if($this->session->userdata('is_logged_in'))
	  {		  
		$this->load->view('admin/home');
      }
	  else
	  {
        	$this->load->view('login');	
      }
	}
	function home() 
	{
		$this->load->view('home');
	}	
 	function validate_credentials()
	{	
		
		$user_name = $this->input->post('user_name');
		$password = $this->input->post('password');
		$is_valid = $this->Admin_home_model->validate($user_name, $password);
		if($is_valid)
		{
			$data = array(
				'user_name' => $user_name,
				'is_logged_in' => true
			);
			$this->session->set_userdata($data);
				$this->load->view('admin/home');
		}
		else
		{
			$data['message_error'] = TRUE;
			$this->load->view('login', $data);	
		}
	}
	/* Add News */
	function add_news()
	{
		$this->load->view('admin/add_news');
	}
	function add_news1()
	{
		$data=array(		
		'title'=>$this->input->post('title'),
		'description'=>$this->input->post('description'),
		'type'=>'news',
		'created_date'=>date('Y-m-d'));	
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		if ($this->form_validation->run() == FALSE)
		{	
			$this->add_news();
		}
		else 
		{
			$id = $this->Admin_home_model->add_news($data);	
			$this->upload_image($id);
			echo "successfully added";
			$this->list_news();			
		}			
	}	
	public function upload_image($id)
	{	
		$this->load->library('upload');
			$config['upload_path']   =   "uploads/news/"; 
			$config['file_name']	 =   $id;
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
				$this->Admin_home_model->save_imgurl($id, "img", $finfo['file_ext']);
			}
	}
	function delete_news()
	{
		$id = $this->input->post('id');
		$this->Admin_home_model->news_delete($id);
		$this->list_news();
	}
	function list_news()
	{
		$this->data['news']=$this->Admin_home_model->news_list();	
		$this->load->view('admin/news_list',$this->data);	
	}
	function add_question()
	{
		$this->load->view('admin/add_question');
	}	
	function add_question1()
	{
		$data=array(		
		'title'=>$this->input->post('title'),
		'description'=>$this->input->post('description'),
		'type'=>'question',
		'created_date'=>date('Y-m-d'));	
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		if ($this->form_validation->run() == FALSE)
		{	
			$this->add_question();
		}
		else 
		{
			$id = $this->Admin_home_model->add_news($data);	
			$this->upload_image($id);
			echo "successfully added";
			$this->list_question();			
		}			
	}		
	
	function list_question()
	{
		$this->data['question']=$this->Admin_home_model->question_list();	
		$this->load->view('list_ques_all',$this->data);	
	}
	
	function edit_question()
	{
		$id=$this->input->post('id');
		$this->data['question']=$this->Admin_home_model->select_question($id);
		$this->load->view('edit_question',$this->data);	 
	}
	function edit_question_list()
	{
		$id=$this->input->post('id');
		$this->data['question']=$this->Admin_home_model->select_question($id);
		$this->load->view('edit_question_list',$this->data);	 
	}
	function edit_question1()
	{		
		$id=$this->input->post('id');
		$update_data = array(
			   'title'=>$this->input->post('title'),
			   'description'=>$this->input->post('description'),
				 );
		$result=$this->Admin_home_model->edit_question($id,$update_data);
		$this->upload_image($id);
		$data['user_id'] = $this->Admin_home_model->select_question_user_id($id);
		foreach($data['user_id'] as $row){
		$user_id =  $row->user_id;
		}		
		$this->view_question_list1($user_id);	
	}
	function edit_question_list1()
	{		
		$id=$this->input->post('id');
		$update_data = array(
			   'title'=>$this->input->post('title'),
			   'description'=>$this->input->post('description'),
				 );
		$result=$this->Admin_home_model->edit_question($id,$update_data);
		$this->upload_image($id);		
		$this->list_question();	
	}
	function delete_category()
	{
		$id=$this->input->post('id');
		$result=$this->Admin_home_model->delete_category($id);
		$this->list_category();
	}
	function delete_question()
	{
		$id = $this->input->post('id');
		$this->Admin_home_model->news_delete($id);
		$this->list_question();		
	}
	function delete_article()
	{
		$id = $this->input->post('id');
		$this->Admin_home_model->news_delete($id);
		$this->list_article();		
	}
	function list_article()
	{
		$this->data['news']=$this->Admin_home_model->article_list();	
		$this->load->view('admin/article_list',$this->data);
	}
	
	/* Add Article */
	function add_article()
	{
		$this->load->view('admin/add_article');
	}		
	
	function add_article1()
	{
		$data=array(		
		'title'=>$this->input->post('title'),
		'description'=>$this->input->post('description'),
		'type'=>'article',
		'created_date'=>date('Y-m-d'));	
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		if ($this->form_validation->run() == FALSE)
		{	
			$this->add_article();
		}
		else 
		{
			$id = $this->Admin_home_model->add_news($data);	
			$this->upload_image($id);
			echo "successfully added";
			$this->list_article();			
		}			
	}	
	
	
	
	
	/* Home */	

	function add_home()
	{	
		foreach($_POST['amenities'] as $selected)
		{
			$ids[]=$selected;
		}
		$bdata= array(
			'project_name' => $this->input->post('project_name'),
			'builder_name' => $this->input->post('builder_name'),
			'address' => $this->input->post('address'),
			'pincode' => $this->input->post('pincode'),
			'home_project_type' => $this->input->post('p_status'),
			'city' => $this->input->post('city'),
			'amenities' =>serialize($ids)
			);
		$this->data['h_data']=$this->Admin_home_model->add_home($bdata);
		$this->load->view('admin/create_flat',$this->data);
	}
	function search_home()
	{
		$home_name=$this->input->post('home_name');
		$this->data['amenities']=$this->Admin_home_model->amenities_list();
		$this->data['homes']=$this->Admin_home_model->search_home($home_name);
		$this->load->view('admin/home_list',$this->data);	
	}	
	function user_list()
	{
		$this->data['users']=$this->Admin_home_model->user_list();	
		$this->load->view('admin/list_user',$this->data);
	}
	function view_question_list()
	{
		$id=$this->input->post('id');
		$this->data['question']=$this->Admin_home_model->question_user($id);
		$this->load->view('question_list',$this->data);		
	}
	function view_question_list1($id)
	{		
		$this->data['question']=$this->Admin_home_model->question_user($id);
		$this->load->view('question_list',$this->data);		
	}
	function active_user()
	{
		$id=$this->input->post('id');
		$this->data['users']=$this->Admin_home_model->active_user($id);
		$this->load->view('admin/edit_user',$this->data);	 
	}
	function edit_user()
	{
		$id=$this->input->post('id');
		$this->data['users']=$this->Admin_home_model->active_user($id);
		$this->load->view('admin/user_details',$this->data);	 
	}
	function edit_user_active()
	{
		 $config = Array(       
            'protocol' => 'sendmail',
            'smtp_host' => 'your domain SMTP host',
            'smtp_port' => 25,
            'smtp_user' => 'SMTP Username',
            'smtp_pass' => 'SMTP Password',
            'smtp_timeout' => '4',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );
		 $this->load->library('email', $config);
		
		$id=$this->input->post('id');
		$email=$this->input->post('email');		
		$data = array('name'=>$this->input->post('name'));
		$update_data = array('is_active'=>1 );
		$result=$this->Admin_home_model->edit_user_active($id,$update_data);
		$this->email->from('poonams@indiawebinfotech.com', 'Poonam Shinde');
		$this->email->to($email); 
		$this->email->subject('Your account has been activated');
		$body = $this->load->view('emails/active_mail.php',$data,TRUE);
		$this->email->message($body);
		
		if($this->email->send()) 
		$this->session->set_flashdata("email_sent","Email sent successfully."); 
		else 
		$this->session->set_flashdata("email_sent","Error in sending Email."); 
		$this->user_list();			 
	}
	function edit_user_inactive()
	{
		$id=$this->input->post('id');
		$update_data = array('is_active'=>0 );
		$result=$this->Admin_home_model->edit_user_inactive($id,$update_data);
		$this->user_list();			 
	}	
	function logout()
	{
		$this->session->sess_destroy();
		$this->load->view('login');	
	}
 
}