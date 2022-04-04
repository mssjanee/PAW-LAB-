<?php
// W skrypcie definicji kontrolera nie trzeba dołączać żadnego skryptu inicjalizacji.
// Konfiguracja, Messages i Smarty są dostępne za pomocą odpowiednich funkcji.
// Kontroler ładuje tylko to z czego sam korzysta.

require_once 'KredytForm.class.php';
require_once 'KredytResult.class.php';

/** Kontroler kalkulatora
 * @author Przemysław Kudłacik
 *
 */
class KredytCtrl {

	private $form;   //dane formularza (do obliczeń i dla widoku)
	private $result; //inne dane dla widoku

	/** 
	 * Konstruktor - inicjalizacja właściwości
	 */
	public function __construct(){
		//stworzenie potrzebnych obiektów
		$this->form = new KredytForm();
		$this->result = new KredytResult();
	}
	
	/** 
	 * Pobranie parametrów
	 */
	public function getParams(){
		$this->form->kwota = getFromRequest('kwota');
		$this->form->ile_lat = getFromRequest('ile_lat');
		$this->form->proc = getFromRequest('proc');
	}
	
	/** 
	 * Walidacja parametrów
	 * @return true jeśli brak błedów, false w przeciwnym wypadku 
	 */
	public function validate() {
		// sprawdzenie, czy parametry zostały przekazane
		if (! (isset ( $this->form->kwota ) && isset ( $this->form->ile_lat ) && isset ( $this->form->proc ))) {
			// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
			return false;
		}
		
		// sprawdzenie, czy potrzebne wartości zostały przekazane
		if ($this->form->kwota == "") {
			getMessages()->addError('Nie podano kwoty');
		}
		if ($this->form->ile_lat == "") {
			getMessages()->addError('Nie podano liczby lat');
		}
		
		if ($this->form->proc == "") {
			getMessages()->addError('Nie podano oprocentowania');
		}
		
		// nie ma sensu walidować dalej gdy brak parametrów
		if (! getMessages()->isError()) {
			
			// sprawdzenie, czy $x i $y są liczbami całkowitymi
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
	
	/** 
	 * Pobranie wartości, walidacja, obliczenie i wyświetlenie
	 */
	public function process(){

		$this->getParams();
		
		if ($this->validate()) {
				
			//konwersja parametrów na int
			$this->form->kwota = intval($this->form->kwota);
			$this->form->ile_lat = intval($this->form->ile_lat);
			$this->form->proc = intval($this->form->proc);
			getMessages()->addInfo('Parametry poprawne.');
				
			$this->result->result = ((($this->form->proc/100) * $this->form->ile_lat * $this->form->kwota) + $this->form->kwota)/($this->form->ile_lat * 12);
			getMessages()->addInfo('Wykonano obliczenia.');
		}
		
		$this->generateView();
	}
	
	
	/**
	 * Wygenerowanie widoku
	 */
	public function generateView(){
		//nie trzeba już tworzyć Smarty i przekazywać mu konfiguracji i messages
		// - wszystko załatwia funkcja getSmarty()
		
		getSmarty()->assign('page_title','Kalkulator Kredytowy');
		getSmarty()->assign('page_description','Aplikacja z jednym "punktem wejścia". Zmiana w postaci nowej struktury foderów, skryptu inicjalizacji oraz pomocniczych funkcji.');
		getSmarty()->assign('page_header','Kontroler główny');
					
		getSmarty()->assign('form',$this->form);
		getSmarty()->assign('res',$this->result);
		
		getSmarty()->display('KredytView.html'); // już nie podajemy pełnej ścieżki - foldery widoków są zdefiniowane przy ładowaniu Smarty
	}
}
