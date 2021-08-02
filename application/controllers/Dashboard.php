<?php 

class Dashboard extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Dashboard';
		
		$this->load->model('model_records');
		$this->load->model('model_users');

	}

	/* 
	* It only redirects to the manage category page
	* It passes the total product, total paid records, total users, and total stores information
	into the frontend.
	*/
	public function index()
	{
		// $this->data['total_paid_records'] = $this->model_records->countTotalPaidrecords();
		// $this->data['total_users'] = $this->model_users->countTotalUsers();
		$this->data['total_wins'] = $this->model_records->countTotalWins();
		$this->data['total_gross'] = $this->model_records->countTotalGross();
		$this->data['total_net'] = $this->model_records->countTotalNet();
		$this->data['total_balance'] = $this->model_records->countTotalBalance();

		$user_id = $this->session->userdata('id');
		$username = $this->session->userdata('username');
		$is_admin = ($user_id == 1) ? true :false;
		$is_admin2 = ($user_id == 6) ? true :false;

		$this->data['is_admin'] = $is_admin;
		$this->data['is_admin2'] = $is_admin2;
		$this->render_template('dashboard', $this->data);
	}
}