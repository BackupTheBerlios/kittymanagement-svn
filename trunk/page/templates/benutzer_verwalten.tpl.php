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
	
	<div class="catdescr">Benutzerliste</div>
			{if is_array($member_list)}
			<table>
				<tr>
					<th>Name</th>
					<th>Nachname</th>
					<th>Email</th>
					<th></th>
				</tr>
				{foreach name=aussen item=member from=$member_list}						
				<tr>
					<td>{$member.vorname}</td>
					<td>{$member.name}</td>
					<td>{$member.email}</td>
					<td>
						<a href=""><img src="images/ppl_view.png" style="width:16px; height:16px;" alt="edit" title="Benutzer anzeigen / editieren" /></a>
					</td>
				</tr>
				{/foreach}
			</table>
			{else}
				{$member_list}
			{/if}
</div>

{include file="navigation.tpl.php"}
{include file="footer.tpl.php"}