<?php

require_once $conf->root_path.'/lib/smarty/Smarty.class.php';
require_once $conf->root_path.'/lib/Messages.class.php';
require_once $conf->root_path.'/app/calc/KredytForm.class.php';
require_once $conf->root_path.'/app/calc/KredytResult.class.php';


class KredytCtrl {

	private $msgs;   //wiadomości dla widoku
	private $infos;  //informacje dla widoku
	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $result; //inne dane dla widoku
	private $hide_intro; //zmienna informująca o tym czy schować intro

	
	public function __construct(){
		
		$this->msgs = new Messages();
		$this->form = new KredytForm();
		$this->result = new KredytResult();
		$this->hide_intro = false;
	}
	
	
	public function getParams(){
		$this->form->kwota = isset($_REQUEST ['kwota']) ? $_REQUEST ['kwota'] : null;
		$this->form->ile_lat = isset($_REQUEST ['ile_lat']) ? $_REQUEST ['ile_lat'] : null;
		$this->form->proc = isset($_REQUEST ['proc']) ? $_REQUEST ['proc'] : null;
	}
	
	
	public function validate() {
		
		if (! (isset ( $this->form->kwota ) && isset ( $this->form->ile_lat ) && isset ( $this->form->proc ))) {
			
			return false;
		} else { 
			$this->hide_intro = true; //przyszły pola formularza - schowaj wstęp
		}
		
		
		if ($this->form->kwota == "") {
			$this->msgs->addError('Nie podano kwoty');
		}
		if ($this->form->ile_lat == "") {
			$this->msgs->addError('Nie podano liczby lat');
		}
		if ($this->form->proc == "") {
			$this->msgs->addError('Nie podano oprocentowania');
		}
		
	
		if (! $this->msgs->isError()) {
			
			
			if (! is_numeric ( $this->form->kwota )) {
				$this->msgs->addError('Kwota nie jest liczbą całkowitą');
			}
			
			if (! is_numeric ( $this->form->ile_lat )) {
				$this->msgs->addError('Liczba lat nie jest liczbą całkowitą');
			}
			
		   if (! is_numeric ( $this->form->proc )) {
				$this->msgs->addError('Oprocentowanie nie jest liczbą całkowitą');
			}
		}
		
		return ! $this->msgs->isError();
	}
	
	
	public function process(){

		$this->getparams();
		
		if ($this->validate()) {
				
			//konwersja parametrów na int
			$this->form->kwota = intval($this->form->kwota);
			$this->form->ile_lat = intval($this->form->ile_lat);
			$this->form->proc = intval($this->form->proc);
			$this->msgs->addInfo('Parametry poprawne.');
				
			$this->result->result = ((($this->form->proc/100) * $this->form->ile_lat * $this->form->kwota) + $this->form->kwota) / ($this->form->ile_lat * 12);
			
			$this->msgs->addInfo('Wykonano obliczenia.');
		}
		
		$this->generateView();
	}
	
	public function generateView(){
		global $conf;
		
		$smarty = new Smarty();
		$smarty->assign('conf',$conf);
		
		$smarty->assign('page_title','Kalkulator Kredytowy');
		$smarty->assign('page_description','Aplikacja z jednym "punktem wejścia". Model MVC, w którym jeden główny kontroler używa różnych obiektów kontrolerów w zależności od wybranej akcji - przekazanej parametrem.');
		$smarty->assign('page_header','Kontroler główny');
				
		$smarty->assign('hide_intro',$this->hide_intro);
		
		$smarty->assign('msgs',$this->msgs);
		$smarty->assign('form',$this->form);
		$smarty->assign('res',$this->result);
		
		$smarty->display($conf->root_path.'/app/calc/KredytView.html');
	}
}
