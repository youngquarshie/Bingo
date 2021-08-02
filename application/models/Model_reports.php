<?php 

class Model_reports extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*getting the total months*/
	private function months()
	{
		return array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');
	}

	/* getting the year of the orders */
	public function getOrderYear()
	{
		$sql = "SELECT * FROM records WHERE paid_status = ?";
		$query = $this->db->query($sql, array(1));
		$result = $query->result_array();
		
		$return_data = array();
		foreach ($result as $k => $v) {
			$date = date('Y', $v['date_sold']);
			$return_data[] = $date;
		}

		$return_data = array_unique($return_data);

		return $return_data;
	}

	// getting the order reports based on the year and moths
	public function getOrderData($year)
	{	
		if($year) {
			$months = $this->months();
			
			$sql = "SELECT * FROM records WHERE paid_status = ?";
			$query = $this->db->query($sql, array(1));
			$result = $query->result_array();

			$final_data = array();
			foreach ($months as $month_k => $month_y) {
				$get_mon_year = $year.'-'.$month_y;	

				$final_data[$get_mon_year][] = '';
				foreach ($result as $k => $v) {
					$month_year = date('Y-m', $v['date_sold']);

					if($get_mon_year == $month_year) {
						$final_data[$get_mon_year][] = $v;
					}
				}
			}	


			return $final_data;
			
		}
	}

	public function getRecordDatabyDate($date)
	{	
		if($date) {

			$current_date = strtotime(date('Y-m-d'));
			$sql="
			INSERT INTO weekly_reports (
				gross_amount, 
				net_amount,
				no_of_books,
				total_wins,
				total_balance,
				date_generated
			)
			SELECT 
				SUM(gross_amount), 
				SUM(net_amount),
				SUM(no_of_books),
				SUM(total_wins),
				SUM(total_balance),
				$current_date
			FROM 
				records
				INNER JOIN records_item ON records_item.record_id = records.r_id
			WHERE 
			records.date_added IN ($date)
			";

			$query = $this->db->query($sql);
			$record_id = $this->db->insert_id();
		

			if($query){

			$sql="SELECT SUM(amount) FROM expenses WHERE expense_date IN ($date)";
			$query = $this->db->query($sql);
			$re = $query->result_array();	

			$total_expenses = $re[0]["SUM(amount)"];

			$sql="SELECT SUM(total_balance) FROM records INNER JOIN records_item ON records_item.record_id = records.r_id 
			INNER JOIN games ON records.game_id = games.id WHERE records.date_added IN ($date)";
			$query = $this->db->query($sql);
			$result = $query->result_array();

			$total_balance= $result[0]["SUM(total_balance)"];

			if($total_balance < 0 ){

				$actual_balance = $total_balance + $total_expenses;
			}
			else{

				$actual_balance = $total_balance - $total_expenses;

			}

			$record_item=array(
				'actual_total_balance' => $actual_balance,
				'expenses' => $total_expenses,
				
		   	);

			$this->db->where('id', $record_id);
			$this->db->update('weekly_reports', $record_item);

			return true;


			}



			
		}
	}



	public function getWeeklyData()
	{	
		
			// $sql = "SELECT * FROM records INNER JOIN records_item ON records.o_id=records_item.order_id 
			$sql="SELECT * FROM weekly_reports";
			$query = $this->db->query($sql);
			$result = $query->result_array();	

			return $result;

	}

	public function getOrderDatabyGame($game)
	{	
		if($game) {
			
			$sql = "SELECT * FROM records INNER JOIN records_item ON records.r_id=records_item.record_id 
			INNER JOIN games ON records.game_id = games.id
			WHERE records.game_id = ? ";
			$query = $this->db->query($sql, array($game));
			$result = $query->result_array();	


			return $result;
			
		}
	}

	public function getOrderDatabyProduct($product_id)
	{	
		if($product_id) {
			
			$sql = "SELECT * FROM records INNER JOIN records_item ON records.o_id=records_item.order_id 
			INNER JOIN products ON records_item.product_id = products.p_id
			WHERE records.paid_status = ? and products.p_id = ? ";
			$query = $this->db->query($sql, array(1, $product_id));
			$result = $query->result_array();	


			return $result;
			
		}
	}

	public function getAllProducts()
	{	
	
			
			$sql = "SELECT * FROM products 
			INNER JOIN categories ON products.category_id =categories.id 
			ORDER BY products.name ASC";
			$query = $this->db->query($sql);
			$result = $query->result_array();	


			return $result;
			
	}

	public function getAllStockLogs()
	{	
	
			$sql = "SELECT * FROM product_stock_logs
			INNER JOIN products ON products.p_id = product_stock_logs.product_id
			INNER JOIN users ON product_stock_logs.user_id = users.id
			ORDER BY product_stock_logs.date_created DESC";
			$query = $this->db->query($sql);
			$result = $query->result_array();	

			return $result;
			
	}

	

	public function getProductData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM products where p_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM products ORDER BY p_id DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
}