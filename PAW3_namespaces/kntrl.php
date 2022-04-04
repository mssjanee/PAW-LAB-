<?php
require_once 'init.php';

switch ($action) {
	default : // 'calcView'
		$ctrl = new app\controllers\KredytCtrl();
		$ctrl->generateView ();
	break;
	case 'kredytCompute' :
		$ctrl = new app\controllers\KredytCtrl();
		$ctrl->process ();
	break;
}
