{extends file="main.tpl"}

{block name=content}

<div class="pure-menu pure-menu-horizontal bottom-margin">
	<a href="{$conf->action_url}logout"  class="pure-menu-heading pure-menu-link">wyloguj</a>
	<span style="float:right;">użytkownik: {$user->login}, rola: {$user->role}</span>
</div>

<form action="{$conf->action_url}calcCompute" method="post" class="pure-form pure-form-aligned bottom-margin">
	<legend>Kalkulator Kredytowy</legend>
	<fieldset>
        <div class="pure-control-group">
			<label for="id_x">Kwota: </label>
			<input id="id_x" type="text" placeholder="kwota" name="x" value="{$form->kwota}" />
		</div>
        <div class="pure-control-group">
			<label for="id_y">Liczba lat: </label>
			<input id="id_y" type="text" placeholder="liczba lat" name="y" value="{$form->ile_lat}" />
		</div>
		
        <div class="pure-control-group">
			<label for="id_z">Oprocentowanie: </label>
			<input id="id_y" type="text" placeholder="oprocentowanie" name="y" value="{$form->proc}" />
		</div>
		<div class="pure-controls">
			<input type="submit" value="Oblicz" class="pure-button pure-button-primary"/>
		</div>
	</fieldset>
</form>	

{include file='messages.tpl'}

{if isset($res->result)}
<div class="messages info">
	Wynik: {$res->result}
</div>
{/if}

{/block}