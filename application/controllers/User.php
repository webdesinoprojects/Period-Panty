<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->library('upload');
		 $this->load->library('image_lib');
	}
	
	public function register()
	{

		$data['RESULT'] = $this->page_model->get_page_by_id(20);

	    $this->load->view('front/user/register',$data);
	}
	
	
	public function register_process()
	{
	    error_reporting(0);
		$user_id = $this->session->userdata('USER_ID');
		$redirect_url = '';
		$response['status'] = 0;
		$response['message'] = '';
		$link = $this->setting_model->get_all_setting();
		if(isset($_GET['redirect']) && !empty($_GET['redirect']))
		{
			$redirect_url = $_GET['redirect'];
		}


    	$this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email Number', 'trim|required|is_unique[tbl_users.email]',array(
            'required'      => 'You have not provided %s.',
            'is_unique'     => 'Email already Exists or his email has already an account with '.$link[0]->title
            )  );
	    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('confirm_password', 'Password', 'trim|required|matches[password]');
		$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
		if ($this->form_validation->run() == TRUE)
		{	
		    
		    
		        $postdata['fname'] = $_POST['fname'];
                $postdata['lname'] = $_POST['lname'];
                $postdata['email'] = $_POST['email'];
                $postdata['contact_no'] = $_POST['contact_no'];
				$postdata['password'] = base64_encode($_POST['password']);
				$postdata['status'] = '1';
				$postdata['email_verify'] = '1';
				$postdata['create_date'] = date('Y-m-d h:i:s');
				$user_id = $this->user_model->insert_user($postdata);
				$link=$this->setting_model->get_all_setting();
				if( $postdata['email']){
        			$this->load->library('email');	
        			$this->email->set_mailtype("html");
        			$this->email->set_newline("\r\n");				
        			$htmlContent = 'Thanks for signing up!<br>
        							Your account has been created, you can login with the following credentials<br>
        							<strong>Email: </strong>'.$postdata['email'].'<br><strong>Password: </strong>'.base64_decode($postdata['password']).'<br><br>
        							<br><br>Thanks<br>'.$link[0]->title;;
        			$this->email->to(trim($postdata['email']));
        			$this->email->from($link[0]->from_email,$link[0]->title);
        			$this->email->subject($link[0]->title.':: Thank You For registration !');
        			$this->email->message($htmlContent);				
        			$this->email->send();
				}
    			$response['status'] = 1; 
			    $response['url'] = base_url('user/login/') ;
				$response['message'] = '<div class="alert alert-success">Your Account is created, Please check your email inbox</div>';	
				unset($_SESSION['referral']) ; 

    				
		}else{

			 $response['message'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
			
		}

		echo json_encode($response);
	}
	

	public function onepage_register_process()
	{
	    error_reporting(0);
		$user_id = $this->session->userdata('USER_ID');
		$redirect_url = '';
		$response['status'] = 0;
		$response['message'] = '';
		$link = $this->setting_model->get_all_setting();
        $this->form_validation->set_rules('email', 'email', 'trim|required|is_unique[tbl_users.email]',array(
            'required'      => 'You have not provided %s.',
            'is_unique'     => 'Email already Exists or his Email has already an account with '.$link[0]->title
            )  );
    	$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_error_delimiters('<div class="error"><i class="fa fa-warning"></i>&nbsp', '</div>');
		if ($this->form_validation->run() == TRUE)
		{	
                   
                unset($_POST['confirm_password']);
                $postdata['email'] = $_POST['email'];
				$postdata['password'] = base64_encode($_POST['password']);
				$postdata['status'] = '1';
				$postdata['email_verify'] = '1';
				$postdata['create_date'] = date('Y-m-d h:i:s');
	            $postdata['phone_verify'] ="1";
				$user_id = $this->user_model->insert_user($postdata);
					$this->load->library('email');	
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n");				
				$htmlContent = 'Thanks for signing up!<br>
								Your account has been created, you can login with the following credentials<br>
								<strong>Email: </strong>'.$_POST['email'].'<br><strong>Password: </strong>'.($_POST['password']).'<br><br>
								Please click this link to Verify your account email: <a href='.base_url('user/verifyemail/'.$token).'>Click Here</a> or <br> '.base_url('user/verifyemail/'.$token).'<br><br><br>Thanks<br>'.$link[0]->title;;
				$this->email->to(trim($_POST['email']));
				$this->email->from($link[0]->email,$link[0]->title);
				$this->email->subject($link[0]->title.':: Confirm your Account email!');
				$this->email->message($htmlContent);				
				$this->email->send(); 
				$rows =  $this->user_model->get_user_by_id($user_id);
				$admin_data = array('USER_ID'=>$rows[0]->id,'USER_NAME'=>$rows[0]->fname.' '.$rows[0]->lname,'USER_EMAIL'=>$rows[0]->email);
				$this->session->set_userdata($admin_data);
				$response['status'] = 1; 						
				$response['url'] = base_url('checkout/onepage') ;
				$response['message'] = '<div class="alert alert-success">Your Account is created, Please check your email inbox,spam and approve your account</div>';
    				
		}else{

			 $response['message'] = '<div class="alert alert-danger">'.validation_errors().'</div>';
			
		}

		echo json_encode($response);
	}
	
    public function login()
	{
        if(isset($_GET['redirect_url'])){
            
          $_SESSION['redirect']   = $_GET['redirect_url'] ; 
        }
		$data['RESULT'] = $this->page_model->get_page_by_id(15);

	    $this->load->view('front/user/login',$data);
	}
	

	public function login_process()
	{

		$user_id = $this->session->userdata('USER_ID');
		$redirect_url = '';
		$response['status'] = 0;
		$response['message'] = '';
		if(isset($_SESSION['redirect']) && !empty($_SESSION['redirect']))
		{
		 $redirect_url = $_SESSION['redirect'];
		}

		if(isset($_POST['email']))
		{
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			if(empty($email) || empty($password))
			{
				  $response['message'] = '<div class="alert alert-danger">Invalid login credentials</div>'; 
			}
			else
			{
				$rows = $this->user_model->user_login($email,base64_encode($password));
				if(count($rows)>0)
				{
					if($rows[0]->status==1)
					{
					    $_SESSION['user_session'] = $gen_refer_code   = substr(md5(rand(100, 2147483647)), 0, 15);
					    $_SESSION['guest'] = 'No';
						$admin_data = array('USER_ID'=>$rows[0]->id,'USER_NAME'=>$rows[0]->fname.' '.$rows[0]->lname,'USER_EMAIL'=>$rows[0]->email);
						$this->session->set_userdata($admin_data);
						$response['status'] = 1; 
 						$response['message'] = '<div class="alert alert-success">Login successfully.</div>'; 						
 						$response['signup-box-msg-2'] = '<div class="alert alert-success">Login successfully.</div>'; 						

						if(!empty($redirect_url))
						{
							$response['url'] = base_url($redirect_url) ;
						}
						else
						{
						     if(count($this->cart->contents()) > 0){ 

						    	$response['url'] = base_url('cart') ;

						     }else{
						     	
						     	$response['url'] = base_url('user/profile/') ;
						     }
						}
						unset($_SESSION['redirect']);
				
					}
					else
					{
						$response['message'] = '<div class="alert alert-danger">this account is inactive.</div>'; 
					}	
				}
				else
				{
					 $response['message'] = '<div class="alert alert-danger">Invalid login credentials</div>'; 
					
				}			
			}
		}

		
		echo json_encode($response);
	}
	
	public function logout()
	{
		$this->session->unset_userdata('USER_ID');
		$this->session->unset_userdata('USER_EMAIL');
		$this->session->unset_userdata('USER_NAME');
		$this->session->unset_userdata('user_session');
		redirect('');
	}
	
	function verifyemail()
	{
		$args = func_get_args();
		if(count($args)>0)
		{
			$rows = $this->user_model->get_user_by_email_activate_token($args[0]);
			if(count($rows)==1)
			{
				$user_id = $rows[0]->id;
				$upd_data['status'] = '1';
				$upd_data['email_verify'] = '1';				
				$upd_data['activate_token'] = '';
				$this->user_model->update_user($user_id,$upd_data);
				$this->session->set_flashdata('msg','<div class="alert alert-success">your account has been activated successfully.</div>');
				redirect('');
			}else
			{
				$this->session->set_flashdata('msg','<div class="alert alert-warning">security token does not match</div>');
				redirect('');
			}	
		}
		else
		{
			$this->session->set_flashdata('msg','<div class="alert alert-warning">security token does not match</div>');
			redirect('');
		}	
	}
	
	 
    public function forgot_password()
	{

		$data['RESULT'] = $this->page_model->get_page_by_id(21);

	    $this->load->view('front/user/forgot-password',$data);
	}
	
	public function forgot_password_process()
	{

		error_reporting();
		ini_set("display_errors", 1);

	
			$email = $this->input->post('email');
			if(empty($email))
			{
				$this->session->set_flashdata('msg','<div class="alert alert-danger">Please enter a valid email.</div>');
				
			}
			else
			{
				$user_data = $this->user_model->check_email($email);
				if(count($user_data)==0)
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger">Email does not matched</div>');
				
				}	
				else
				{
					$user_id = $user_data[0]->id;
					$token = sha1($user_id.time().$_POST['email']);
					$upd_data['forgot_token'] = $token;
					$this->user_model->update_user($user_id,$upd_data);
				     $link = $this->setting_model->get_all_setting();
			       $this->load->library('email');
                   $this->email->set_mailtype("html");
					$this->email->set_newline("\r\n");				
					//Email content
				    $htmlContent = 'Dear '. $user_data[0]->fname.' '.$user_data[0]->lname .',
								<br>Please click bellow link to reset your password. <a href='.base_url('user/reset_password/'.$token).'>Click Here</a> 
								or If you are not able to access the above link, copy & paste the entire url in your browser address bar and press enter.
								<br> '.base_url('user/reset_password/'.$token).'<br><br><br>Thanks<br>'.$link[0]->title;;
					$this->email->to(trim($_POST['email']));
					$this->email->from($link[0]->from_email,$link[0]->title);
				    $this->email->subject($link[0]->title.':: Reset your Account Password!');
			
					$this->email->message($htmlContent);
				    $sendmail = 	$this->email->send();
				
					if($sendmail){

					
						$this->session->set_flashdata('msg','<div class="alert alert-success">Please check your inbox/spam for an email we just sent you with instructions for how to reset your password</div>');
					}else{
				
						
					     

						$this->session->set_flashdata('msg','<div class="alert alert-danger">Error ,Please Try Again !!! </div>');
					}
				
				}
			}	
	
		echo $this->session->flashdata('msg');
	}
	
	function reset_password()
	{
		$args = func_get_args();
		if(count($args)>0)
		{
			$rows = $this->user_model->get_user_by_forgot_password_token($args[0]);
			if(count($rows)==1)
			{
				if(isset($_POST['reset_password']))
				{	
					$npwd = $this->input->post('npwd');
					$opwd = $this->input->post('cpwd');
					if(empty($npwd) || empty($opwd))
					{
						$this->session->set_flashdata('msg','<div class="alert alert-danger">please fill all field.</div>');
						redirect('user/reset_password/'.$args[0]);
					}
					else
					{
						if($npwd!=$npwd)
						{
							$this->session->set_flashdata('msg','<div class="alert alert-danger">New password and Confirm password not matched.</div>');
							redirect('user/reset_password/'.$args[0]);
						}
						else
						{
							$user_id = $rows[0]->id;
							$upd_data['forgot_token'] = '';
							$upd_data['password'] = base64_encode($npwd);
							$this->user_model->update_user($user_id,$upd_data);				
							$this->session->set_flashdata('msg','<div class="alert alert-success">your password has been changed successfully</div>');
							
						
							redirect('user/login');
						}	
						
					}	
				}
				$this->load->view('front/user/reset-password');
			}else
			{
				$this->session->set_flashdata('msg','Security Token Link Expire');
			    $this->load->view('front/user/error');
			}	
		}
		else
		{
			$this->session->set_flashdata('msg','Security Token Link Expire. Generate Another Token');
		    $this->load->view('front/user/error');
		}
	}

	public function profile()
	{
		$user_id = $this->session->userdata('USER_ID');
		if(empty($user_id)){ redirect(''); }
		$data['user']  = $this->user_model->get_user_by_id($user_id);
		$data['RESULT'] = $this->page_model->get_page_by_id(23);
		$data['discounted_products'] = $this->product_model->get_home_products($filter_array_2 = ['status'=>'1' ],4,'id','asc');
		$this->load->view('front/account/profile',$data);
	}

	function edit_profile()
	{
		$user_id = $this->session->userdata('USER_ID');
		if(empty($user_id)){ redirect(''); }		
		
		if(isset($_POST['updateprofile']))
		{
			$post_data = $this->input->post();
			unset($post_data['updateprofile']);
			$this->user_model->update_user($user_id,$post_data);
			$this->session->set_flashdata('msg','<div class="alert alert-success">Your profile has been updated successfully</div>');
			redirect('user/edit_profile');
		}	
		$data['user']  = $this->user_model->get_user_by_id($user_id);
		$data['RESULT'] = $this->page_model->get_page_by_id(23);
		$this->load->view('front/account/edit_profile',$data);
	}
	
	public function change_password()
	{

		
		$user_id = $this->session->userdata('USER_ID');
		if(empty($user_id)){ redirect(''); }
		
		if(isset($_POST['changepass']))
		{
			$post_data = $this->input->post();
			if(empty($post_data['opwd']) || empty($post_data['npwd']) || empty($post_data['cpwd']))
			{
				$this->session->set_flashdata('msg','<div class="alert alert-danger">Please fill all field</div>');
				redirect('user/change_password');
			}
			else
			{
				if($post_data['opwd']==base64_decode($post_data['form_key']))
				{
					if($post_data['npwd']==$post_data['cpwd'])
					{
						unset($post_data['opwd']);
						unset($post_data['cpwd']);
						unset($post_data['form_key']);
						$post_data['password']= base64_encode($post_data['npwd']);
						unset($post_data['changepass']);
						unset($post_data['npwd']);						
						$this->user_model->update_user($user_id,$post_data);
						$this->session->set_flashdata('msg','<div class="alert alert-success">Your password has been changed successfully</div>');
						redirect('user/change_password');
						
					}
                    else
					{
						$this->session->set_flashdata('msg','<div class="alert alert-danger">New password and Confirm password not matched.</div>');
						redirect('user/change_password');
					}	
				}
				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger">Old password not matched.</div>');
					redirect('user/change_password');
				}				
			}			
		}	
	  
		$data['user']  = $this->user_model->get_user_by_id($user_id);
		$data['RESULT'] = $this->page_model->get_page_by_id(25);
		$this->load->view('front/account/change_password',$data);
	}
	
	public function profile_picture()
	{
		$user_id = $this->session->userdata('USER_ID');
		if(empty($user_id)){ redirect(''); }
		
		$login_user_data = $this->user_model->get_user_by_id($user_id);
		if(isset($_POST['uploadpicture']))
		{


			if(empty($_FILES['picture']['name']))
			{


				$this->session->set_flashdata('msg','<div class="alert alert-danger">please choose valid image.</div>');
				redirect('user/profile_picture');
			}
			else
			{
				//print_R($_FILES);die;
				$allow_ext = array('png','jpg','jpeg','JPEG','gif');
				$file_ext = image_extension($_FILES['picture']['name']);
				if(in_array($file_ext,$allow_ext))
				{
					$file_name = create_image_unique($_FILES['picture']['name']);
					$tmp_name = $_FILES['picture']['tmp_name'];
					$path = 'uploads/profile_pic/'.$file_name;
					move_uploaded_file($tmp_name,$path);
					$upd_data['image'] = $file_name;						
					$this->user_model->update_user($user_id,$upd_data);
					delete_file('uploads/profile_pic/',$login_user_data[0]->image);
					$this->session->set_flashdata('msg','<div class="alert alert-success">Profile image has been change.</div>');
					redirect('user/profile_picture');
				}
				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger">Invalid image format.</div>');
					redirect('user/profile_picture');
				}
			}	
		}
		
		$data['RESULT']  = $login_user_data;
		$this->load->view('front/account/change_avatar',$data);
	}
	
	function my_orders()
	{
		$user_id = $this->session->userdata('USER_ID');
		if(empty($user_id)){ redirect(''); }
		$data['RESULT'] = $this->page_model->get_page_by_id(24);
		$data['user']  = $this->user_model->get_user_by_id($user_id);
		$data['ORDER']  = $this->order_model->get_user_order($user_id);
		$this->load->view('front/account/my_orders',$data);
	}

	function view_order()
	{
		
		$args = func_get_args();
		$data['ORDER'] =$ORDER= $this->order_model->get_order_data_by_order_no($args[0]);

		if (isset($_POST['cancel_order'])) {
			$update_data['status'] = 'Cancelled';	
		    $update_data['remarks'] = ",Order <b> Cancelled </b> <br> by user on <br>".date('Y-m-d h:i:s A');
		    $update_data['modified_date'] =  date('Y-m-d h:i:s A');;
			$this->db->where('order_no',$args[0]);
	    	$this->db->update('tbl_order', $update_data);

	    	if($ORDER[0]->payment_status == 'Paid'){
	    			$transaction_amt =$ORDER[0]->final_amount ; 
	    			$remarks = 'Order No-'.$args[0].'<br>- Cancelation refund amount Rs '. $ORDER[0]->final_amount ; 
	    			$this->update_wallet($transaction_amt , $remarks) ; 
	    	}
	    	redirect('user/view_order/'.$args[0]) ; 
	    	
		}
	    $data['RESULT'] = $this->page_model->get_page_by_id(24);
		$data['ORDER'] = $this->order_model->get_order_data_by_order_no($args[0]);
		$this->load->view('front/account/view_order',$data);
	}

	function wishlist()
	{
		$user_id = $this->session->userdata('USER_ID');
		if(empty($user_id)){ redirect(''); }	
		$data['RESULT'] = $this->page_model->get_page_by_id(29);
		$data['user']  = $this->user_model->get_user_by_id($user_id);
		$data['PRODUCTS']  = $this->product_model->get_user_wishlist($user_id);
	   $data['RESULT'] = $this->page_model->get_page_by_id(31);
		$this->load->view('front/account/my_wishlist',$data);
	}


	
	public function remove_wishlist()
	{
		$args = func_get_args();
		$this->user_model->delete_wishlist($args[0]);
		redirect('user/wishlist');
	}
	


	
	public function cancel_order(){

	    	$postdata = $this->input->post();
	    	$data['status'] = 'Cancelled' ; 
	    	$data['remarks'] = $postdata['remarks'] ; 
	    	$this->db->where('order_id',$postdata['order_id']);
	    	$this->db->where('pro_id',$postdata['pro_id']);
		    $this->db->update('tbl_order_item',$data);
			$this->session->set_flashdata('msg','<div class="alert alert-success">Product has been cancelled.</div>');
			redirect('user/my_orders');
	}

}
