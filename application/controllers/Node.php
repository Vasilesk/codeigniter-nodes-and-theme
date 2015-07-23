<?php
class Node extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Node_model');
		$this->load->library('Theme');
	}

	public function index()
	{
		//  I use in routes.php: $route['node'] = 'node/page';
	}
	
	public function page($page_number = 1)
	{
		if($this->Node_model->page_number_out_of_range($page_number))
		{
			show_404();
		}
		
		$data['nodes'] = $this->Node_model->get_nodes_of_page($page_number);
		
        $data['title'] = 'My site';
		$data['pagination'] = $this->Node_model->get_pagination();
        
        $this->theme->add_body_content('node/index');

        $this->theme->display($data);
	}

	public function view($id = NULL)
	{
		
		if($this->Node_model->node_id_out_of_range($id))
		{
			show_404();
		}
		
		$data['node'] = $this->Node_model->get_node($id);

        if (empty($data['node']))
        {
                show_404(); // the node has status 0 (not published)
        }

        $data['title'] = $data['node']['title'];

        $this->theme->add_body_content('node/view', $data);
        $this->theme->display($data);
	}
}
