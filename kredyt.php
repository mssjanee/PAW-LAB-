<?php
require_once dirname(__FILE__).'/../config.php';


$kwota = $_REQUEST['kwota'];
$ile_lat = $_REQUEST['ile_lat'];
$oprocentowanie = $_REQUEST['oprocentowanie'];

if(!isset($kwota) && isset($ile_lat) && isset($oprocentowanie)) {
	$messages [] = 'Błędnie wywołanie aplikacji.Brak jednego z parametrów.';
	}
	
	if($kwota == "") {
	$messages [] = 'Nie podano kwoty';
	}
    if($ile_lat == "") {
	$messages [] = 'Nie podano ilości lat';
    }

    if($oprocentowanie == "") {
	$messages [] = 'Nie podano ilość procentów';
    }

if(empty($messages)){
	if(!is_numeric($kwota)){
	$messages [] = 'Kwota nie jest liczbą całkowitą';
	}
	if(!is_numeric($ile_lat)){
		$messages [] = 'Ilość lat nie jest liczbą całkowitą';
	}
	if(!is_numeric($oprocentowanie)){
		$messages [] = 'Oprocentowanie nie jest liczbą całkowitą';
	}
}

if(empty($messages)){
	
	$kwota = intval($kwota);
	$ile_lat = intval($ile_lat);
	$oprocentowanie = intval($oprocentowanie);
	
	$result = ($oprocentowanie * $ile_lat * $kwota + $kwota)/($ile_lat * 12);
}
include 'kredyt_view.php';
