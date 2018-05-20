<?php

/*
Главный класс представления
*/

class View
{
	
	public $template_view = 'template_view.php';
	public $name;
	public $data;
	
	// генерация страницы
	function generate()
	{
		
		include 'app/views/'.$this->template_view;
	}
}

?>