<?php

class Model_Task extends Model
{

	/*
	Получение данных о задачах
	*/
	public function get_data()
	{	
		
		// инициализация
		$res['db'] = 1; 			// 1 - подключились; 0 - ошибка
		$res['add'] = 0;			// 1 - запись добавлена; -1 - ошибка добавления
		$res['sort'] = 1;			// способ сортировки
		$res['page'] = 1;			// текущая страница
		$res['page_count'] = 1;		// всего страниц
		$res['data'] = array();		// контет
		$res['admin'] = 0;			// режим админа

		
		// авторизация
		if(isset($_SESSION['session_hash'])){ 
			if ($_SESSION['session_hash'] === C_SESSION_HASH){
				$res['admin'] = 1;
			};
		};
		
		//сортировка
		if (isset($_GET['sort'])) {
			$res['sort'] = (int) $_GET['sort'];
			if (($res['sort'] < 1) or ($res['sort'] >3)){$res['sort'] = 1;};
			$_SESSION['sort'] = $res['sort'];
		}else{
			if(isset($_SESSION['sort'])){ 
				$res['sort'] = (int) $_SESSION['sort'];
				if (($res['sort'] < 1) or ($res['sort'] >3)){$res['sort'] = 1;};
			}else{
				$_SESSION['sort'] = $res['sort']; 
			};
		};
		$orderBy = 'uname';
		switch ($res['sort']) {
			case 1: $orderBy = 'uname'; break;
			case 2: $orderBy = 'email'; break;
			case 3: $orderBy = 'st';    break;
		};

		
		//пагинация
		if (isset($_GET['page'])) {
			$res['page'] = (int) $_GET['page'];
		};
		if ($res['page'] < 1 ){ $res['page'] = 1; };


		
		// подключение к БД
		$conn = mysqli_connect(C_DB_HOST, C_DB_USER, C_DB_PASSWORD, C_DB_NAME);
		if (!$conn) {
			$res['db'] = 0;
			return $res;
		};
		$conn->set_charset("utf8");
		

		
		
		// Добавление новой задачи
		if (isset($_POST['uname']) and isset($_POST['email']) and isset($_POST['tasktext'])) {
			$uname = $conn->real_escape_string($_POST['uname']);
			$email = $conn->real_escape_string($_POST['email']);
			$tasktext = $conn->real_escape_string($_POST['tasktext']);
			$sql = "INSERT INTO ".C_DB_TABLE." (uname, email, tasktext) VALUES ('$uname', '$email', '$tasktext')";
			
			$id = 0;
			if ($conn->query($sql) === TRUE) {
				$id = $conn->insert_id;
				if($id > 0) {
					$res['add'] = 1;
				}else{
					$res['add'] = -1;
				}
			} else {
				$res['add'] = -1;				
			};
			
			//работа с файлом
			if(isset($_FILES['imgfile']) and $id > 0){
				$ext = '';
				switch ($_FILES['imgfile']['type']) {
					case 'image/jpeg': $ext = '.jpg'; break;
					case 'image/png':  $ext = '.png'; break;
					case 'image/gif':  $ext = '.gif'; break;
				};
				if($ext){
					cropImage($_FILES['imgfile']['tmp_name'], __DIR__.'/../../img/'.$id.$ext, 320, 240);
				};
			};			
		};
		
		
		
		// Выборка всех задач
		$db_data = array();
		$sql = 'SELECT SQL_CALC_FOUND_ROWS id, IFNULL(st,0) st, uname, email, tasktext 
		        FROM '.C_DB_TABLE.' 
				ORDER BY '.$orderBy.' 
				LIMIT '.($res['page']-1)*C_ROW_COUNT.','.C_ROW_COUNT;
		$q = $conn->query($sql);
		if ($q->num_rows > 0) {
			while($row = $q->fetch_assoc()) {
				$db_data[] = $row;
			};
		};
		$res['data'] = $db_data;



		// Считаем количество страниц без повторного запроса
		$sql = "SELECT FOUND_ROWS() X From dual";
		$q = $conn->query($sql);
		if ($q->num_rows > 0) {
			while($row = $q->fetch_assoc()) {
				$res['page_count'] = (int) $row['X'];
			};
		};
		$res['page_count'] = ceil($res['page_count']/C_ROW_COUNT);



		// Отключаемся от БД
		$conn->close();



		return $res;
	
		
	}

	
	
	
	
	/*
	Проставление статуса
	*/
	public function do_check()
	{	
		$res['admin'] = 0;

		
		// авторизация
		if(isset($_SESSION['session_hash'])){ 
			if ($_SESSION['session_hash'] === C_SESSION_HASH){
				$res['admin'] = 1;
			};
		};
		if($res['admin'] <> 1){return $res;};
		

		
		// подключение к БД
		$conn = mysqli_connect(C_DB_HOST, C_DB_USER, C_DB_PASSWORD, C_DB_NAME);
		if (!$conn) {
			return $res;
		};
		$conn->set_charset("utf8");



		// Получение данных
		if (isset($_POST['id']) and isset($_POST['active']) ) {
			$id     = $conn->real_escape_string($_POST['id']);
			$active = $conn->real_escape_string($_POST['active']);
		};

		
		// Обновление
		$sql = "UPDATE ".C_DB_TABLE." SET st = '$active' WHERE id = '$id'";
		$conn->query($sql);
		
		
		return $res;
		
	}



	
	
	
	
	/*
	Обновление текста задачи
	*/
	public function do_text()
	{	
		$res['admin'] = 0;

		
		// авторизация
		if(isset($_SESSION['session_hash'])){ 
			if ($_SESSION['session_hash'] === C_SESSION_HASH){
				$res['admin'] = 1;
			};
		};
		if($res['admin'] <> 1){return $res;};
		

		
		// подключение к БД
		$conn = mysqli_connect(C_DB_HOST, C_DB_USER, C_DB_PASSWORD, C_DB_NAME);
		if (!$conn) {
			return $res;
		};
		$conn->set_charset("utf8");



		// Получение данных
		if (isset($_POST['id']) and isset($_POST['tasktext']) ) {
			$id       = $conn->real_escape_string($_POST['id']);
			$tasktext = $conn->real_escape_string($_POST['tasktext']);
		};
		

		// Обновление
		$sql = "UPDATE ".C_DB_TABLE." SET tasktext = '$tasktext' WHERE id = '$id'";
		$conn->query($sql);
		
		
		return $res;
		
	}

	
	
	
}

?>
