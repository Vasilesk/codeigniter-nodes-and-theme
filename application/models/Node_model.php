<?php
class Node_model extends CI_Model {
	
	private $nodes_per_page;
	private $nodes_table_name;
	private $site_base_url;

	public function __construct()
	{
			$this->load->database();
			$this->load->library('pagination');
			
			$this->nodes_per_page = 10;
			$this->nodes_table_name = 'table_name';
			$this->site_base_url = 'http://example.com';
	}

	private function get_node_count()
	{
		$query = $this->db->query("SELECT COUNT(*) FROM `$this->nodes_table_name` WHERE `status`= 1");
		return $query->result_array()[0]['COUNT(*)'];
	}
	
	private function get_max_node_number()
	{
		$query = $this->db->query("SELECT MAX(`id`) FROM `$this->nodes_table_name`");
		return $query->result_array()[0]['MAX(`id`)'];
	}
	
	private function get_max_page_number()
	{
		return 1+floor($this->Node_model->get_node_count()/$this->nodes_per_page);
	}
	
	public function node_id_out_of_range($id)
	{
		if(!preg_match('/^[0-9]{1,}$/', $id) || $id < 1 || $id > $this->get_max_node_number())
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function page_number_out_of_range($page_number)
	{
		if(!preg_match('/^[0-9]{1,}$/', $page_number) || $page_number < 1 || $page_number > $this->get_max_page_number())
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
		
	public function get_node($id = 1)
	{
		$query = $this->db->get_where($this->nodes_table_name, array('id' => $id,'status' => 1));
		return $query->row_array();
	}

	public function get_pagination()
	{
        $pagination_config['base_url'] = $this->site_base_url.'/page/';
		$pagination_config['total_rows'] = $this->Node_model->get_node_count();
		$pagination_config['per_page'] = $this->nodes_per_page;
		$pagination_config['first_link'] = 'Первая';
		$pagination_config['last_link'] = 'Последняя';
		$pagination_config['use_page_numbers'] = TRUE;
		$pagination_config['full_tag_open'] = '<ul class="pagination">'; // Bootstrap class 'pagination'
		$pagination_config['full_tag_close'] = '</ul>';
		$pagination_config['num_tag_open'] = '<li>';
		$pagination_config['num_tag_close'] = '</li>';
		$pagination_config['cur_tag_open'] = '<li class="active"><a href="#">'; // <a> to use Bootstrap class 'active'
		$pagination_config['cur_tag_close'] = '</a></li>';
		$pagination_config['prev_tag_open'] = '<li>';
		$pagination_config['prev_tag_close'] = '</li>';
		$pagination_config['next_tag_open'] = '<li>';
		$pagination_config['next_tag_close'] = '</li>';
		$pagination_config['first_tag_open'] = '<li>';
		$pagination_config['first_tag_close'] = '</li>';
		$pagination_config['last_tag_open'] = '<li>';
		$pagination_config['last_tag_close'] = '</li>';
								
		$this->pagination->initialize($pagination_config); 

		return $this->pagination->create_links();
	}
	
	public function get_nodes_of_page($page = 1)
	{
		$records_before = ($page-1) * $this->nodes_per_page;
		$query = $this->db->query("SELECT * FROM  `$this->nodes_table_name` WHERE  `status` = 1 ORDER BY `id` DESC LIMIT $records_before , $this->nodes_per_page");
		return $query->result_array();
	}
}
