<?php

class Model_Admin extends Model
{
	
	public function get_data()
	{	
		
		$res['admin'] = 0;
		
	
		// авторизация
		if(isset($_SESSION['session_hash'])){ 
			if ($_SESSION['session_hash'] === C_SESSION_HASH){
				$res['admin'] = 1;
			};
		};


		// аутентификация
		if (isset($_POST['user']) and isset($_POST['password'])) {
			if (($_POST['user'] === 'admin') and ($_POST['password'] === '123')){
				$_SESSION['session_hash'] = C_SESSION_HASH;
				$res['admin'] = 1;
			}else{
				$res['admin'] = -1;
			};
		};

		// выход
		if (isset($_POST['logout'])) {
			$_SESSION['session_hash'] = '';
			$res['admin'] = 0;
		};




		return $res;
	
		
	}

}

?>
