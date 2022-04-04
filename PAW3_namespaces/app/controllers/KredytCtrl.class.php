<?php
namespace app\controllers;

use app\forms\KredytForm;
use app\transfer\KredytResult;

class KredytCtrl {

	private $form;   
	private $result; 

	public function __construct(){
	
		$this->form = new KredytForm();
		$this->result = new KredytResult();
	}
	
	public function getParams(){
		$this->form->kwota = getFromRequest('kwota');
		$this->form->ile_lat = getFromRequest('ile_lat');
		$this->form->proc = getFromRequest('proc');
	}
	
	public function validate() {
	
		if (! (isset ( $this->form->kwota ) && isset ( $this->form->ile_lat ) && isset ( $this->form->proc ))) {
	
			return false;
		}
		
	
		if ($this->form->kwota == "") {
			getMessages()->addError('Nie podano kwoty');
		}
		if ($this->form->ile_lat == "") {
			getMessages()->addError('Nie podano liczby lat');
		}
		
		if ($this->form->proc == "") {
			getMessages()->addError('Nie podano oprocentowania');
		}
		

		if (! getMessages()->isError()) {
			

			if (! is_numeric ( $this->form->kwota )) {
				getMessages()->addError('Kwota nie jest liczbą całkowitą');
			}
			
			if (! is_numeric ( $this->form->ile_lat )) {
				getMessages()->addError('Liczba lat nie jest liczbą całkowitą');
			}
			
			if (! is_numeric ( $this->form->proc )) {
				getMessages()->addError('Oprocentowanie nie jest liczbą całkowitą');
			}
		}
		
		return ! getMessages()->isError();
	}
	
	public function process(){

		$this->getParams();
		
		if ($this->validate()) {
				

			$this->form->kwota = intval($this->form->kwota);
			$this->form->ile_lat = intval($this->form->ile_lat);
			$this->form->proc = intval($this->form->proc);
			getMessages()->addInfo('Parametry poprawne.');
				
			$this->result->result = ((($this->form->proc/100) * $this->form->ile_lat * $this->form->kwota) + $this->form->kwota)/($this->form->ile_lat * 12);
			
			getMessages()->addInfo('Wykonano obliczenia.');
		}
		
		$this->generateView();
	}
	
	
	public function generateView(){
		
		getSmarty()->assign('page_title','Kalkulator Kredytowy');
		getSmarty()->assign('page_description','Kolejne rozszerzenia dla aplikacja z jednym "punktem wejścia". Do nowej struktury dołożono automatyczne ładowanie klas wykorzystując w strukturze przestrzenie nazw.');
		getSmarty()->assign('page_header','Kontroler główny');
					
		getSmarty()->assign('form',$this->form);
		getSmarty()->assign('res',$this->result);
		
		getSmarty()->display('KredytView.tpl'); 
	}
}
