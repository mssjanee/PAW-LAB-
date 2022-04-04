<?php 
require_once dirname(__FILE__).'/../config.php';

require_once _ROOT_PATH.'/lib/smarty/Smarty.class.php';

function getParams(&$form){
	$form['kwota'] = isset($_REQUEST['kwota'])?$_REQUEST['kwota']:null;
	$form['ile_lat'] = isset($_REQUEST['ile_lat'])?$_REQUEST['ile_lat']:null;
	$form['proc'] = isset($_REQUEST['proc'])?$_REQUEST['proc']:null;
}

function validate(&$form,&$infos,&$msgs,&$hide_intro){
	if( ! (isset($form['kwota']) && isset($form['ile_lat']) && isset($form['proc']) )) return false;
	$hide_intro = true;
	$infos [] = 'Przekazano parametry.';
	
	if( $form['kwota'] == "") $msgs [] = 'Nie podano kwoty';
	if( $form['ile_lat'] == "") $msgs [] = 'Nie podano liczby lat';
	if( $form['proc'] == "") $msgs [] = 'Nie podano oprocentowania';
	
	if ( count($msgs) == 0) {
		if (! is_numeric( $form['kwota'])) $msgs [] = 'Kwota nie jest liczbą całkowitą.';
		if (! is_numeric( $form['ile_lat'])) $msgs [] = 'Liczba lat nie jest liczbą całkowitą.';
		if (! is_numeric( $form['proc'])) $msgs [] = 'Oprocentowanie jest liczbą całkowitą.';
	}
	
	if (count($msgs)>0)  return false;
	else return true;
}

function process(&$form,&$msgs,&$ifos,&$result){
	$infos [] = 'Parametry poprawne.Wykonuję obliczenia.';
	
	$form['kwota'] = floatval($form['kwota']);
	$form['ile_lat'] = floatval($form['ile_lat']);
	$form['proc'] = floatval($form['proc']);
	
	
	$result = ((($form['proc']/100) * $form['ile_lat'] * $form['kwota']) + $form['kwota'])/($form['ile_lat'] *12);
}

$form = null;
$infos = array();
$messages = array();
$result = null;
$hide_intro = false;

getParams($form);
if ( validate($form,$infos,$messages,$hide_intro) ){
	process($form,$infos,$messages,$result);
}



$smarty = new Smarty();

$smarty->assign('app_url',_APP_URL);
$smarty->assign('root_path',_ROOT_PATH);
$smarty->assign('page_title','Kalkulator kredytowy');
$smarty->assign('page_description','Profesjonalne szablonowanie oparte na bibliotece Smarty');
$smarty->assign('page_header','Szablony Smarty');

$smarty->assign('hide_intro',$hide_intro);

$smarty->assign('form',$form);
$smarty->assign('result',$result);
$smarty->assign('messages',$messages);
$smarty->assign('infos',$infos);


$smarty->display(_ROOT_PATH.'/app/kredyt.html');