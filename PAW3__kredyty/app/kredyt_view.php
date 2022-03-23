<?php

?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Kalkulator</title>
	<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
</head>
<body>

<div style="width:90%; margin: 2em auto;">

<form action="<?php print(_APP_ROOT); ?>/app/kredyt.php" method="post" class="pure-form pure-form-stacked">
	<legend>Kalkulator kredytów</legend>
	<fieldset>
		Kwota: 
		<input  type="text" name="kwota" value="<?php out($kwota) ?>" />
		Ilość lat:
		<input  type="text" name="ile_lat" value="<?php out($ile_lat) ?>" />
		Oprocentowanie:
		<input  type="text" name="proc" value="<?php out($proc) ?>" />
	
	</fieldset>	
	<input type="submit" value="Oblicz" class="pure-button pure-button-primary" />
</form>	

<?php

if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin-top: 1em; padding: 1em 1em 1em 2em; border-radius: 0.5em; background-color: #f88; width:25em;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($result)){ ?>
<div style="margin-top: 1em; padding: 1em; border-radius: 0.5em; background-color: #ff0; width:25em;">
<?php echo 'Rata misięczna: '.$result; ?>
</div>
<?php } ?>

</div>

</body>
</html>