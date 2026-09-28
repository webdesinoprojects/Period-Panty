<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin_model');
	}
	
	public function index()
	{
		$this->check_admin_login('IS_LOGIN');
		if(isset($_POST['login']))
		{
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			if(empty($email) || empty($password))
			{
				$this->session->set_flashdata('msg','<div class="alert alert-danger">Invalid login credentials. please try again</div>');
				redirect('admin');
			}
			else
			{
				$rows = $this->admin_model->admin_login($email,$password);
				if(count($rows)==1)
				{
					if($rows[0]->status==0)
					{
						$this->session->set_flashdata('msg','<div class="alert alert-warning">Your account has been disabled. Please contact your system administrator.</div>');
						redirect('admin/');
					}
					else
					{
						$admin_data = array('ADMIN_ID'=>$rows[0]->id,'ADMIN_ROLE'=>$rows[0]->role,'ADMIN_EMAIL'=>$rows[0]->email, 'ADMIN_AUTH'=>$rows[0]->authority);
						$this->session->set_userdata($admin_data);
						redirect('admin/dashboard');
					}
				}
				else
				{
					$this->session->set_flashdata('msg','<div class="alert alert-danger">Invalid login credentials. please try again</div>');
					redirect('admin');
				}
			}
		}	
		$this->load->view('admin/login');
	}
	
	public function dashboard()
	{
		$this->check_admin_login('IS_NOT_LOGIN');
		$data['All_USERS'] = $this->user_model->get_all_users_by_ststus('all');
		$data['ACTIVE_USERS'] = $this->user_model->get_all_users_by_ststus('1');
		$data['INACTIVE_USERS'] = $this->user_model->get_all_users_by_ststus('0');

		// --- Dashboard metrics -------------------------------------------------
		// tbl_order.create_date is a VARCHAR holding "Y-m-d h:i:s A", not a
		// DATETIME, so every date operation has to go through STR_TO_DATE with
		// that exact mask. Sorting or grouping on the raw column would order
		// lexically and silently produce wrong months.
		// NOTE: delete_flag is enum('0','1'). MySQL compares an ENUM against a
		// NUMBER by index position (1-based), not by value, so `delete_flag = 0`
		// matches nothing at all while `delete_flag = '0'` matches correctly.
		// Every comparison below must pass the string.
		$fmt = "STR_TO_DATE(create_date, '%Y-%m-%d %h:%i:%s %p')";

		$data['STAT_ORDERS']   = (int) $this->db->where('delete_flag', '0')->count_all_results('tbl_order');
		$data['STAT_PRODUCTS'] = (int) $this->db->where('delete_flag', '0')->count_all_results('tbl_products');
		$data['STAT_USERS']    = is_array($data['All_USERS']) ? count($data['All_USERS']) : 0;

		$rev = $this->db->select('IFNULL(SUM(final_amount),0) AS total', FALSE)
						->where('delete_flag', '0')->get('tbl_order')->row();
		$data['STAT_REVENUE'] = $rev ? (float) $rev->total : 0;

		// Last 6 months of order volume and value, oldest first.
		$data['CHART_ROWS'] = $this->db
			->select("DATE_FORMAT($fmt, '%b %y') AS label,
					  DATE_FORMAT($fmt, '%Y-%m') AS ym,
					  COUNT(*) AS orders,
					  IFNULL(SUM(final_amount),0) AS revenue", FALSE)
			->where('delete_flag', '0')
			->where("$fmt IS NOT NULL", NULL, FALSE)
			->group_by('ym, label')->order_by('ym', 'ASC')
			->limit(6)->get('tbl_order')->result();

		// Order status split for the doughnut.
		$data['STATUS_ROWS'] = $this->db
			->select('status, COUNT(*) AS c', FALSE)
			->where('delete_flag', '0')->group_by('status')
			->get('tbl_order')->result();

		$data['RECENT_ORDERS'] = $this->db
			->select('id, order_no, final_amount, status, payment_status, create_date', FALSE)
			->where('delete_flag', '0')
			->order_by($fmt, 'DESC', FALSE)
			->limit(8)->get('tbl_order')->result();

		// Customer signups by month. tbl_users.create_date IS a real DATETIME
		// (unlike tbl_order.create_date), so it can be grouped directly.
		$data['CUSTOMER_ROWS'] = $this->db
			->select("DATE_FORMAT(create_date, '%b %y') AS label,
					  DATE_FORMAT(create_date, '%Y-%m') AS ym,
					  COUNT(*) AS signups", FALSE)
			->where('create_date IS NOT NULL', NULL, FALSE)
			->group_by('ym, label')->order_by('ym', 'ASC')
			->limit(12)->get('tbl_users')->result();

		// Catalogue spread: how many live products sit in each category.
		// The delete_flag filter stays in WHERE rather than in the JOIN condition:
		// CI3 escapes compound ON clauses and mangled "a = b AND c = 0", which
		// silently returned an empty set.
		$data['CATEGORY_ROWS'] = $this->db
			->select('c.title AS label, COUNT(p.id) AS total', FALSE)
			->from('tbl_categories c')
			->join('tbl_products p', 'p.cat_id = c.id', 'inner')
			->where('p.delete_flag', '0')
			->group_by('c.id, c.title')
			->order_by('total', 'DESC')
			->limit(8)->get()->result();

		$this->load->view('admin/dashboard',$data);
	}
	
	public function logout()
	{
		$this->session->unset_userdata('ADMIN_ID');
		$this->session->unset_userdata('ADMIN_EMAIL');
		$this->session->unset_userdata('ADMIN_ROLE');		
		$this->session->sess_destroy();
		redirect('admin');
	}
	
	function check_admin_login($check_type)
	{
		if($check_type=='IS_LOGIN')
		{	
			$admin_id = $this->session->userdata('ADMIN_ID');
			if(!empty($admin_id))
			{
				redirect('admin/dashboard');
			}
		}
		if($check_type=='IS_NOT_LOGIN')
		{	
			$admin_id = $this->session->userdata('ADMIN_ID');
			if(empty($admin_id))
			{
				redirect('admin');
			}
		}
	}
}
