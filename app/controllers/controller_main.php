<?php

class Controller_Main extends Controller
{

	function action_index()
	{	
		$this->view->name = 'main';
		$this->view->generate();
	}
}

?>