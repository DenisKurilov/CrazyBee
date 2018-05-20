<?php

class Controller_Task extends Controller
{

	function __construct()
	{
		$this->model = new Model_Task();
		$this->view = new View();
	}
	
	function action_index()
	{
		$this->view->data = $this->model->get_data();		
		$this->view->name = 'task';
		$this->view->generate();
	}
	
	function action_check()
	{
		$this->view->data = $this->model->do_check();
	}
	
	function action_text()
	{
		$this->view->data = $this->model->do_text();
	}
	
}

?>