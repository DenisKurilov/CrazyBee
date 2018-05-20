<?php

class Controller_Admin extends Controller
{
	function __construct()
	{
		$this->model = new Model_Admin();
		$this->view = new View();
	}
	
	function action_index()
	{
		$this->view->data = $this->model->get_data();		
		$this->view->name = 'admin';
		$this->view->generate();
	}


}


?>