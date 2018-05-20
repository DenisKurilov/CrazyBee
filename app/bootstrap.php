<?php

// подключаем файлы ядра
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';

// роутинг и настройки
require_once 'core/lib.php';
require_once 'core/config.php';
require_once 'core/route.php';

// запускаем роутинг
Route::start(); 

?>