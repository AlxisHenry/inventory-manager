<?php
session_start();
define("ROOT", $_SERVER['DOCUMENT_ROOT']);
define("COMPONENTS", ROOT . '/components');
define("VIEWS", ROOT . '/views');
define("ASSETS", ROOT . '/assets');
define("DOMAIN", "http://localhost:5050/");
//if ($_SERVER['SERVER_PORT'] == 81) {
//    define("DOMAIN", "http://colhccdlic01:81/");
//} else {
//    define("DOMAIN", "http://colhccdlic01/");
//}
