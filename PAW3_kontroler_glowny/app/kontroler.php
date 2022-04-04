<?php

require_once dirname (__FILE__).'/../config.php';

$action = $_REQUEST['action'];

switch ($action) {
	default : // 'KredytView'
		include_once $conf->root_path.'/app/calc/KredytCtrl.class.php';
		$kontroler = new KredytCtrl ();
		$kontroler->generateView ();
	break;
	case 'kredytCompute' :
		include_once $conf->root_path.'/app/calc/KredytCtrl.class.php';
		$kontroler = new KredytCtrl ();
		$kontroler->process ();
	break;
	
}
