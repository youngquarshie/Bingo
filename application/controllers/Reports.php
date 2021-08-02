<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Admin_Controller 
{	
	public function __construct()
	{
		parent::__construct();
		$this->data['page_title'] = 'Reports';
		$this->load->model('model_reports');
		$this->load->model('model_records');
		$this->load->model('model_game');
	}

	/* 
    * It redirects to the report page
    * and based on the year, all the records data are fetch from the database.
    */
	public function index()
	{
		if(!in_array('viewReports', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
		
		$today_year = date('Y');

		if($this->input->post('select_year')) {
			$today_year = $this->input->post('select_year');
		}

		$parking_data = $this->model_reports->getOrderData($today_year);
		$this->data['report_years'] = $this->model_reports->getOrderYear();
		

		$final_parking_data = array();
		foreach ($parking_data as $k => $v) {
			
			if(count($v) > 1) {
				$total_amount_earned = array();
				foreach ($v as $k2 => $v2) {
					if($v2) {
						$total_amount_earned[] = $v2['gross_amount'];						
					}
				}
				$final_parking_data[$k] = array_sum($total_amount_earned);	
			}
			else {
				$final_parking_data[$k] = 0;	
			}
			
		}
		
		$this->data['selected_year'] = $today_year;
		$this->data['company_currency'] = $this->company_currency();
		$this->data['results'] = $final_parking_data;

		$this->render_template('reports/index', $this->data);
	}

	public function products_reports()
	{
		if(!in_array('viewReports', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Products Reports';
		
		$today_date = date('Y-m-d');		
		$this->data['selected_day'] = $today_date;
		$this->data['company_currency'] = $this->company_currency();



		$this->render_template('reports/products_reports', $this->data);
	}

	

	public function generate()
	{
		if(!in_array('viewReports', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Generate Weekly Reports';
		$this->data['check'] = $this->model_records->CheckForReportGenerate(); 



		$this->render_template('reports/generate', $this->data);
	}

	public function weekly_reports()
	{
		if(!in_array('viewReports', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Daily Sales Reports';
		

		// $this->data['selected_day'] = $today_date;
		$this->data['company_currency'] = $this->company_currency();
		



		$this->render_template('reports/weekly_reports', $this->data);
	}

	

	public function sales_by_game_reports()
	{
		if(!in_array('viewReports', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Records by Game Reports';
		$this->data['game'] = $this->model_game->getActiveGame();  
		$this->data['company_currency'] = $this->company_currency();



		$this->render_template('reports/sales_by_game_reports', $this->data);
	}


	public function fetchOrderData()
	{
		$result = array('data' => array());

		//$submited_date = $this->uri->segment(3);
		

		$previous_date =array();
    	
		$m= date("m");

		$de= date("d");

		$y= date("Y");

		for($i=0; $i<=5; $i++){
      
		
		$previous_date[]= strtotime(date('Y-m-d',mktime(0,0,0,$m,($de-$i),$y)));

		echo date('d-m-y:D',mktime(0,0,0,$m,($de-$i),$y)); 

		echo "<br>";

		}

    	
		$onlydates= (implode(",", $previous_date));
		
		

		$data = $this->model_reports->getRecordDatabyDate($onlydates);

		echo $data;
		// if($data){
		// 	redirect('reports/weekly_reports', 'refresh');
		// }

		
	}



	public function weeklyData()
	{
		

		$data = $this->model_reports->getWeeklyData();

		foreach ($data as $key => $value) {
				
			$date = date('d-m-Y', $value['date_generated']);
			// $time = date('h:i a', $value['time_added']);

			// $date_time = $date . ' ' . $time;

			if($value['total_balance'] < 0) {
				$paid_status = 'color:red';
				
			}
			else {
				$paid_status = 'color:green';	
			}

			$result['data'][$key] = array(
				'',
				$value['total_wins'],
				"¢"." ".number_format($value['gross_amount']),
				"¢"." ".number_format($value['net_amount']),
				"¢"." "."<span style=".$paid_status.">".number_format($value['total_balance'])."</span>",
				$date
			);
		} 

		

		echo json_encode($result);
	}


	public function fetchOrderDatabyGame()
	{
		$result = array('data' => array());

		$submited_game = $this->uri->segment(3);
		
		$data = $this->model_reports->getOrderDatabyGame($submited_game);

		foreach ($data as $key => $value) {

				
			$date = date('d-m-Y', $value['date_added']);
			$time = date('h:i a', $value['time_added']);

			$date_time = $date . ' ' . $time;

			if($value['total_balance'] < 0) {
				$paid_status = 'color:red';
				
			}
			else {
				$paid_status = 'color:green';	
			}

			$result['data'][$key] = array(
				'',
				$value['name_of_game'],
				$value['no_of_books'],
				$value['no_of_wins'],
				"¢"." ".number_format($value['gross_amount']),
				"¢"." ".number_format($value['net_amount']),
				"¢"." "."<span style=".$paid_status.">".number_format($value['total_balance'])."</span>",
				$date_time
			);
		} // /foreach

		

		echo json_encode($result);
	}

	

	public function fetchAllProducts()
	{
		$result = array('data' => array());
		
		$data = $this->model_reports->getAllProducts();
	
		foreach ($data as $key => $value) {

				
		
            $qty_status = '';
            if($value['qty'] <= 10) {
                $qty_status = '<span class="label label-warning">Low !</span>';
            } else if($value['qty'] <= 0) {
                $qty_status = '<span class="label label-danger">Out of stock !</span>';
            }


			$result['data'][$key] = array(
                $value['name']." ".$value['variation_name'],
				"GH¢".$value['wholesale_price'],
				"GH¢".$value['price'],
                $value['qty'],
				"GH¢".$value['profit'],
				
			);
		} // /foreach

		

		echo json_encode($result);
	}


}	