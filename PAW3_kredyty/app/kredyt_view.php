<?php
require_once dirname(__FILE__).'/../config.php'; ?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
 <head>
<meta charset="utf-8" />
<title>Kredyty</title>
</head> 
<body>
<form action="<?php print(_APP_URL);?>/app/kredyt.php" method="post" />
Kwota:
<input type="text" name="kwota" value = "<?php isset($kwota)?print($kwota):print('');?>" /> <br /> <br /> 
Ile lat:
<input type="text" name="ile_lat" value="<?php isset($ile_lat)?print($ile_lat):print('')?>" /> <br /><br /> 
Oprocentowanie:
<input type="text" name="oprocentowanie" value="<?php isset($oprocentowanie)?print($oprocentowanie):print('')  ?>" /> <br /> <br /> 
<input type="submit" value="Oblicz" />
</form>

<?php
if(isset($messages)){
	if(count($messages) > 0){
		echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
foreach ($messages as $key => $msg) {
	echo '<li>'.$msg.'</li>';
}
echo '</ol>';
	}
}
?>

<?php if (isset($result)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;">
<?php echo 'Rata misięczna: '.$result; ?>
</div>
<?php } ?>
</body>
</html>
