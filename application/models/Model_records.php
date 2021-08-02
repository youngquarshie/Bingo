<?php 

class Model_records extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getRecordsData($id = null)
	{
		$user_id = $this->session->userdata('id');
		if($id) {
			$sql = "SELECT * FROM records 
			INNER JOIN users ON users.id = records.user_id
			INNER JOIN records_item ON records.r_id=records_item.record_id
			INNER JOIN games ON records.game_id = games.id
			WHERE records.r_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM records 
		INNER JOIN records_item ON records.r_id=records_item.record_id ORDER BY r_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	/* get the records data */


	public function getRecordDatabyDate($date)
	{	$user_id = $this->session->userdata('id');
		if($date) {
			$selected_date= strtotime($date);
			
			$sql = "SELECT * FROM records 
			INNER JOIN users ON users.id = records.user_id
			INNER JOIN records_item ON records.r_id=records_item.record_id
			INNER JOIN games ON records.game_id = games.id
			WHERE records.date_added = ? and records.user_id =?
			ORDER BY records.r_id DESC";
			$query = $this->db->query($sql, array($selected_date, $user_id));
			$result = $query->result_array();	


			return $result;
			
		}
	}

	// get the records item data
	public function getrecordsItemData($order_id = null)
	{
		if(!$order_id) {
			return false;
		}

		$sql = "SELECT * FROM records_item 
		INNER JOIN records ON records_item.record_id = records.r_id WHERE records.r_id = ?";
		$query = $this->db->query($sql, array($order_id));
		return $query->result_array();
	}

	public function create()
	{
		$user_id = $this->session->userdata('id');
		//$bill_no = 'KCL-'.strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 4));

		
    	$data = array(
    		'game_id' => $this->input->post('game'),
			'user_id' => $user_id,
    		'date_added' => strtotime(date('Y-m-d')),
			'time_added' => strtotime(date('h:i:s a')),
    	);

		
		$insert = $this->db->insert('records', $data); 
		$record_id = $this->db->insert_id();

		if($record_id){

			$actual_gross = doubleval(str_replace(",","",$this->input->post('gross_amount')));
			
		
			//$net_amount= 0.4 * $this->input->post('gross_amount');
			$net_amount= 0.4 * $actual_gross;
			$unit_id=$this->input->post('unit');
			$sql= 'SELECT unit_value from units WHERE id = ? ';
			$query = $this->db->query($sql, array($unit_id));
			$unit_value = $query->row_array();
			
			$wins = $this->input->post('wins_no') * $unit_value['unit_value'];

			//echo number_format($wins);
			

			$balance = $net_amount - $wins;

			$record_item=array(
				'record_id' => 	$record_id,
				 'winning_draw' => $this->input->post('draw'),
				 'gross_amount' => $actual_gross,
				 'net_amount' => $net_amount,
				 'no_of_books' => $this->input->post('books_no'),
				 'no_of_wins' =>  $this->input->post('wins_no'),
				 'total_wins' =>  $wins,
				 'unit'=> $unit_value['unit_value'],
				 'total_balance' =>  $balance
				);
				
		
				$insert = $this->db->insert('records_item', $record_item);
		
			return ($record_id) ? $record_id : false;
		}

		
	}

	public function countOrderItem($order_id)
	{
		if($order_id) {
			$sql = "SELECT * FROM records_item WHERE order_id = ?";
			$query = $this->db->query($sql, array($order_id));
			return $query->num_rows();
		}
	}

	public function update($id)
	{
		if($id) {

			$data = array(
				'game_id' => $this->input->post('game')
			);

			$this->db->where('r_id', $id);
			$update = $this->db->update('records', $data);

			if($update){

			$actual_gross = doubleval(str_replace(",","",$this->input->post('gross_amount')));
			
		

			//$net_amount= 0.4 * $this->input->post('gross_amount');
			$net_amount= 0.4 * $actual_gross;
			$unit_id=$this->input->post('unit');
			$sql= 'SELECT unit_value from units WHERE id = ? ';
			$query = $this->db->query($sql, array($unit_id));
			$unit_value = $query->row_array();
			
			$wins = $this->input->post('wins_no') * $unit_value['unit_value'];

			//echo number_format($wins);
			

			$balance = $net_amount - $wins;

			$record_item=array(
				 'winning_draw' => $this->input->post('draw'),
				 'gross_amount' => $actual_gross,
				 'net_amount' => $net_amount,
				 'no_of_books' => $this->input->post('books_no'),
				 'no_of_wins' =>  $this->input->post('wins_no'),
				 'total_wins' =>  $wins,
				 'unit'=> $unit_value['unit_value'],
				 'total_balance' =>  $balance
			);

				$this->db->where('record_id', $id);
				$this->db->update('records_item', $record_item);

				return true;

			}


		}
	}



	public function remove($id)
	{
		if($id) {
			$this->db->where('r_id', $id);
			$delete = $this->db->delete('records');

			$this->db->where('record_id', $id);
			$delete_item = $this->db->delete('records_item');
			return ($delete == true && $delete_item) ? true : false;
		}
	}


	public function countTotalWins()
	{
		$sql = "SELECT SUM(total_wins) FROM weekly_reports";
		$query = $this->db->query($sql, array(1));
		return $query->result_array($sql);
	}

	public function countTotalGross()
	{
		$sql = "SELECT SUM(gross_amount) FROM weekly_reports";
		$query = $this->db->query($sql, array(1));
		return $query->result_array($sql);
	}

	public function countTotalNet()
	{
		$sql = "SELECT SUM(net_amount) FROM weekly_reports";
		$query = $this->db->query($sql, array(1));
		return $query->result_array($sql);
	}

	public function countTotalBalance()
	{
		$sql = "SELECT SUM(actual_total_balance) FROM weekly_reports";
		$query = $this->db->query($sql, array(1));
		return $query->result_array($sql);
	}

	public function getRecordToday(){
		$c_date = strtotime(date('Y-m-d'));
		$sql = "SELECT * FROM records WHERE date_added = $c_date";
		$query = $this->db->query($sql);
		$result = $query->num_rows();
		
		return $result;
	}

	public function CheckForReportGenerate(){
		
		if(date('D') == 'Sat'){
			
			$c_date = strtotime(date('Y-m-d'));
			$sql = "SELECT * FROM records WHERE date_added = $c_date";
			$query = $this->db->query($sql);
			$result = $query->num_rows();

			return $result;
		}
		else{

			return 'error';
		}

		

	}

}