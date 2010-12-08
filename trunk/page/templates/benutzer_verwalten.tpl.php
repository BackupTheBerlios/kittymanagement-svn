{include file="header.tpl.php"}

{literal}
<script type="text/javascript" src="../src/javascript/benutzer_hinzu.js"></script>
{/literal}


<div class="item">

	<h1>&raquo; Verwaltung &raquo; Benutzer verwalten</h1>
	<div class="catdescr">Benutzer hinzuf&uuml;gen</div>
	
	<fieldset>
    	<form name="user_add" id="user_add" action="" method="post">
        	<div>
        		<label for="vname">Name: </label>
        		<input name="vname" type="text" id="vname" class="styled" />
        		<label class="error" for="vname" id="vname_error">Bitte geben Sie einen Vornamen an</label>
        	</div>
        	<div>
        		<label for="nname">Nachname: </label>
        		<input name="nname" type="text" id="nname" class="styled" />
        		<label class="error" for="nname" id="nname_error">Bitte geben Sie einen Nachnamen</label>
        	</div>
        	<div>
        		<label for="email">eMail Adresse: </label>
        		<input name="email" type="text" id="email" class="styled" />
        		<label class="error" for="email" id="email_error">Bitte geben Sie eine g&uuml;ltige eMail Adresse an</label>
        	</div>
			<div>
				<label for="kategorie">Kategorie:</label>
				<input type="radio" name="kategorie" value="ma" id="kategorie" /> Mitarbeiter&nbsp;&nbsp;
				<input type="radio" name="kategorie" value="hiwi" id="kategorie" /> HiWi<br />
				<label class="error" for="kategorie" id="kategorie_error">Bitte w&auml;hlen Sie eine Teilnehmerkategorie</label>
			</div>
			<div>
				<label for="buchen">Beitrittsmonat buchen? </label>
				<input type="checkbox" name="buchen" value="1" id="buchen" checked="checked" /> Beitrittsmonat buchen<br />
				<label class="error" for="buchen" id="buchen_error">Bitte w&auml;hlen eine Option!</label>
			</div>
			<input name="user_add" type="submit" id="submit" value="&raquo; Speichern " />&nbsp;<span class="return_wert"></span>
		</form>
	</fieldset>	
	


	<div class="catdescr">Benutzer bearbeiten</div>
	<form name="mitgliedEdit" action="" method="post">
		<input type="text" name="vname" /> Vorname<br />
		<input type="text" name="nname" /> Nachname<br />
		<input type="text" name="email" /> Email Adresse<br />
		<input type="radio" name="faktor" value="ma" /> Mitarbeiter&nbsp;&nbsp;
		<input type="radio" name="faktor" value="hiwi" /> HiWi<br />
		<input type="checkbox" name="aktiv" /> Inaktiv?<br />	
		<input type="submit" class="submit" name="aendern" value="&Auml;nderungen &uuml;bernehmen" disabled />
	</form>

	<div class="catdescr">Benutzerliste</div>
	
	{if is_array($member_list) }
		Name&nbsp;Nachname&nbsp;Email&nbsp;<br />
		{foreach name=aussen item=member from=$member_list}
			{foreach key=key item=val from=$member}
				{if $key == "name"} {$val}, {/if} {if $key == "vorname"} {$val}, {/if} {if $key == "email"} {$val} {/if}
			{/foreach} <a href="">[ Details ]</a> <a href="">[ Edit ]</a><br />
		{/foreach}
	{else}
		{$member_list}
	{/if}
</div>

{include file="navigation.tpl.php"}
{include file="footer.tpl.php"}