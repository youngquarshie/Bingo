<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Records extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'records';

		$this->load->model('model_records');
		$this->load->model('model_company');
		$this->load->model('model_game');
		$this->load->model('model_unit');
	}

	/* 
	* It only redirects to the manage order page
	*/
	public function index()
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }
		$today_date = date('Y-m-d');		
		$this->data['selected_day'] = $today_date;

		$this->data['page_title'] = 'Manage records';
		$this->render_template('records/index', $this->data);		
	}

	/*
	* Fetches the records data from the records table 
	* this function is called from the datatable ajax function
	*/
	

	public function fetchrecordsData()
	{
		$result = array('data' => array());

		$submited_date = $this->uri->segment(3);

		
		$data = $this->model_records->getRecordDatabyDate($submited_date);

	
		foreach ($data as $key => $value) {

			// $count_total_item = $this->model_records->countOrderItem($value['r_id']);
			$date = date('d-m-Y', $value['date_added']);
			$time = date('h:i a', $value['time_added']);

			$date_time = $date . ' ' . $time;

			// button
			$buttons = '';

			if(in_array('updateOrder', $this->permission)) {
				$buttons .= '<a target="__blank" href="'.base_url('records/update/'.$value['record_id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
			}

			// if(in_array('ViewOrder', $this->permission)) {
			// 	$buttons .= ' <a href="'.base_url('records/view/'.$value['r_id']).'" class="btn btn-default"><i class="fa fa-eye"></i></a>';
			// }

			if(in_array('deleteOrder', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['r_id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			if($value['total_balance'] < 0) {
				$paid_status = '<span class="label label-warning">L</span>';
				
			}
			else {
				$paid_status = '<span class="label label-success">P</span>';	
			}

			$result['data'][$key] = array(
				$value['name_of_game'],
				$value['winning_draw'],
				"GH¢"." ".$value['total_wins'],
				"GH¢"." ".$value['gross_amount'],
				"GH¢"." ".$value['net_amount'],
				"GH¢"." ".$value['total_balance'].$paid_status,
				$date_time,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}

	/*
	* If the validation is not valid, then it redirects to the create page.
	* If the validation for each input field is valid then it inserts the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/
	public function create()
	{
		if(!in_array('createOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Add Record';

		$this->form_validation->set_rules('game', 'Game', 'trim|required');
		$this->form_validation->set_rules('gross_amount', 'Gross Amount', 'trim|required');
		$this->form_validation->set_rules('books_no', 'No of Books', 'trim|required');
		$this->form_validation->set_rules('wins_no', 'No of Wins', 'trim|required');
		$this->form_validation->set_rules('draw', 'Winning Draw', 'trim|required');
		// $this->form_validation->set_rules('currency-field', 'No of Wins', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) { 
			
			// echo $intV = doubleval(str_replace(",","",$this->input->post('currency-field')));
			
			//  //(double)$this->input->post('currency-field');
			// exit();
        	
        	$record_id = $this->model_records->create();
        	
        	if($record_id) {
        		$this->session->set_flashdata('success', 'Record Successfully created');
        		//redirect('records/update/'.$order_id, 'refresh');
				redirect('records/index', 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('records/create/', 'refresh');
        	}
        }
        else {
            // false case
        	$company = $this->model_company->getCompanyData(1);
        	$this->data['game'] = $this->model_game->getActiveGame();        
            $this->data['unit'] = $this->model_unit->getActiveUnit();
			$this->data['check'] = $this->model_records->getRecordToday();


            $this->render_template('records/create', $this->data);
        }	
	}

	/*
	* It gets the product id passed from the ajax method.
	* It checks retrieves the particular product data from the product id 
	* and return the data into the json format.
	*/
	public function getProductValueById()
	{
		$product_id = $this->input->post('product_id');
		
		if($product_id) {
			echo json_encode($product_data);
		}
	}

	public function checkqty()
	{
		$qty = $this->input->post('current_qty');
		
		
	}

	/*
	* It gets the all the active product inforamtion from the product table 
	* This function is used in the order page, for the product selection in the table
	* The response is return on the json format.
	*/
	public function getTableProductRow()
	{
		echo json_encode($products);
	}

	/*
	* If the validation is not valid, then it redirects to the edit records page 
	* If the validation is successfully then it updates the data into the database 
	* and it stores the operation message into the session flashdata and display on the manage group page
	*/

	public function update($id)
	{
		if(!in_array('updateOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		if(!$id) {
			redirect('dashboard', 'refresh');
		}

		$this->data['page_title'] = 'Update Record';

		$this->form_validation->set_rules('game', 'Game', 'trim|required');
		$this->form_validation->set_rules('gross_amount', 'Gross Amount', 'trim|required');
		$this->form_validation->set_rules('books_no', 'No of Books', 'trim|required');
		$this->form_validation->set_rules('wins_no', 'No of Wins', 'trim|required');
		$this->form_validation->set_rules('draw', 'Winning Draw', 'trim|required');
		
	
        if ($this->form_validation->run() == TRUE) {        	
        	
        	$update = $this->model_records->update($id);
        	
        	if($update == true) {
        		$this->session->set_flashdata('success', 'Successfully updated');
        		redirect('records/update/'.$id, 'refresh');
        	}
        	else {
        		$this->session->set_flashdata('errors', 'Error occurred!!');
        		redirect('records/update/'.$id, 'refresh');
        	}
        }
        else {
            // false case
        	// $company = $this->model_company->getCompanyData(1);
    

        	$result = array();

		
        	$record_data = $this->model_records->getRecordsData($id);
			

    		$result['record'] = $record_data;
    		//$records_item = $this->model_records->getrecordsItemData($records_data['r_id']);

	
			$this->data['game'] = $this->model_game->getActiveGame(); 
    		$this->data['record_data'] = $result;
			$this->data['unit'] = $this->model_unit->getActiveUnit();
		
            $this->render_template('records/edit', $this->data);
        }
	}

	/*
	* It removes the data from the database
	* and it returns the response into the json format
	*/
	public function remove()
	{
		if(!in_array('deleteOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$order_id = $this->input->post('order_id');

        $response = array();
        if($order_id) {
            $delete = $this->model_records->remove($order_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the product information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refersh the page again!!";
        }

        echo json_encode($response); 
	}

	/*
	* It gets the product id and fetch the order data. 
	* The order print logic is done here 
	*/
	public function printDiv($id)
	{
		if(!in_array('viewOrder', $this->permission)) {
            redirect('dashboard', 'refresh');
        }

		$this->data['page_title'] = 'Print Order Details';
        
		if($id) {
			$order_data = $this->model_records->getRecordsData($id);
			$records_items = $this->model_records->getrecordsItemData($id);
			$company_info = $this->model_company->getCompanyData(1);
			// $order_date = $date;
			$paid_status = ($order_data['paid_status'] == 1) ? "Paid" : "Unpaid";

			$html = '<!-- Main content -->
			<!DOCTYPE html>
			<html>
			<head>
			  <meta charset="utf-8">
			  <meta http-equiv="X-UA-Compatible" content="IE=edge">
			  <title>AdminLTE 2 | Invoice</title>
			  <!-- Tell the browser to be responsive to screen width -->
			  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
			  <!-- Bootstrap 3.3.7 -->
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/bootstrap/dist/css/bootstrap.min.css').'">
			  <!-- Font Awesome -->
			  <link rel="stylesheet" href="'.base_url('assets/bower_components/font-awesome/css/font-awesome.min.css').'">
			  <link rel="stylesheet" href="'.base_url('assets/dist/css/AdminLTE.min.css').'">
			</head>
			<body onload="window.print();">
			
			<div class="wrapper">
			  <section class="invoice">
			    <!-- title row -->
			    <div class="row">
			      <div class="col-xs-12">
			        <h2 class="page-header">
			          '.$company_info['company_name'].'
			        </h2>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- info row -->
			    <div class="row invoice-info">
			      
			      <div class="col-sm-4 invoice-col">
			        
			        <b>Bill ID:</b> '.$order_data['bill_no'].'<br>
			        <b>Name:</b> '.$order_data['customer_name'].'<br>
			        <b>Phone:</b> '.$order_data['customer_phone'].'
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <!-- Table row -->
			    <div class="row">
			      <div class="col-xs-12 table-responsive">
			        <table class="table table-striped">
			          <thead>
			          <tr>
			            <th>Product name</th>
			            <th>Price</th>
			            <th>Qty</th>
			            <th>Amount</th>
			          </tr>
			          </thead>
			          <tbody>'; 

			          foreach ($records_items as $k => $v) {

			          	
			          	$html .= '<tr>
				            <td>'.$product_data['name'].'</td>
				            <td>'.$v['rate'].'</td>
				            <td>'.$v['order_qty'].'</td>
				            <td>'.$v['amount'].'</td>
			          	</tr>';
			          }
			          
			          $html .= '</tbody>
			        </table>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->

			    <div class="row">
			      
			      <div class="col-xs-6 pull pull-right">

			        <div class="table-responsive">
			          <table class="table">
			            <tr>
			              <th style="width:50%">Gross Amount:</th>
			              <td>'.$order_data['gross_amount'].'</td>
			            </tr>';

			            if($order_data['vat_charge'] > 0) {
			            	$html .= '<tr>
				              <th>Vat Charge ('.$order_data['vat_charge_rate'].'%)</th>
				              <td>'.$order_data['vat_charge'].'</td>
				            </tr>';
			            }
			            
			            
			            $html .=' <tr>
			              <th>Discount:</th>
			              <td>'.$order_data['discount'].'</td>
			            </tr>
			            <tr>
			              <th>Net Amount:</th>
			              <td>'.$order_data['net_amount'].'</td>
			            </tr>
			            <tr>
			              <th>Paid Status:</th>
			              <td>'.$paid_status.'</td>
			            </tr>
			          </table>
			        </div>
			      </div>
			      <!-- /.col -->
			    </div>
			    <!-- /.row -->
			  </section>
			  <!-- /.content -->
			</div>
		</body>
	</html>';

			  echo $html;
		}
	}

}