<?php
require_once dirname(__FILE__).'/../config.php';

// KONTROLER strony kalkulatora

// W kontrolerze niczego nie wysyła się do klienta.

include _ROOT_PATH.'/app/security/check.php';


function getParams(&$kwota,&$ile_lat,&$proc){
	$kwota = isset($_REQUEST['kwota']) ? $_REQUEST['kwota'] : null;
	$ile_lat = isset($_REQUEST['ile_lat']) ? $_REQUEST['ile_lat'] : null;
	$proc = isset($_REQUEST['proc']) ? $_REQUEST['proc'] : null;	
}


function validate(&$kwota,&$ile_lat,&$proc,&$messages){

	if ( ! (isset($kwota) && isset($ile_lat) && isset($proc))) {

		return false;
	}


	if ( $kwota == "") {
		$messages [] = 'Nie podano kwoty';
	}
	if ( $ile_lat == "") {
		$messages [] = 'Nie podano ilości lat';
	}
	if ( $proc == "") {
		$messages [] = 'Nie podano oprocentowania';
	}


	if (count ( $messages ) != 0) return false;
	

	if (! is_numeric( $kwota )) {
		$messages [] = 'Kwota nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $ile_lat )) {
		$messages [] = 'Ilość lat nie jest liczbą całkowitą';
	}	
	if (! is_numeric( $proc )) {
		$messages [] = 'Oprocentowanie nie jest liczbą całkowitą';
	}	

	if (count ( $messages ) != 0) return false;
	else return true;
}

function process(&$kwota,&$ile_lat,&$proc,&$messages,&$result){
	
	

	$kwota = intval($kwota);
	$ile_lat = intval($ile_lat);
	$proc = intval($proc);
	
	$result = ($proc * $ile_lat * $kwota + $kwota)/($ile_lat * 12);
}

$kwota = null;
$ile_lat = null;
$proc = null;
$result = null;
$messages = array();


getParams($kwota,$ile_lat,$proc);
if ( validate($kwota,$ile_lat,$proc,$messages) ) { 
	process($kwota,$ile_lat,$proc,$messages,$result);
}


include 'kredyt_view.php';