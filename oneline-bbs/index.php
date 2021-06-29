<?php
define("BASE_DIR", dirname(__FILE__) . "/");
define("CLASS_DIR", BASE_DIR . "class/");
define("VIEW_DIR", BASE_DIR . "view/");

require_once(CLASS_DIR . "Controller.class.php");

Controller::execute();
?>