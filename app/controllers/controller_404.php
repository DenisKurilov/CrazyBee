<?php

class Controller_404 extends Controller
{
	
	function action_index()
	{
		$this->view->name = '404';
		$this->view->generate();
	}

}

?>