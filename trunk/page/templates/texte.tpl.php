{include file="header.tpl.php"}

{literal}
<script type="text/javascript" src="../src/javascript/textBaustein_hinzu.js"></script>
{/literal} 

<div class="item">

	<h1>&raquo; Verwaltung &raquo; Textbausteine verwalten</h1>
	<div class="catdescr" id="txt_add_show"><img src="images/ppl_add.png" alt="hinzufuegen" title="Textbaustein anlegen" /> Neuen Textbaustein anlegen</div>
	<div id="txt_add_form">
		<fieldset>
	    	<form name="txt_add" id="txt_add" action="" method="post">
	        	<div>
	        		<label for="bstTitel">Titel: </label>
	        		<input name="bstTitel" type="text" id="bstTitel" class="styled" size="35" maxlength="30" />
	        		<label class="error" for="bstTitel" id="bstTitel_error">Bitte geben Sie einen Titel an</label>
	        	</div>
	        	<div>
	        		<label for="bstText">Text: </label>
	        		<textarea name="bstText" id="bstText" rows="20" cols="40"></textarea>
	        		<label class="error" for="bstText" id="bstText_error">Bitte geben Sie einen Text f&uuml;r den Baustein an</label>
	        	</div>
				<input name="bstAdd" type="submit" id="submit" value="&raquo; Speichern " />
			</form>
		</fieldset>	
	</div>
</div>
<div class="item">
	<div class="catdescr">Vorhandene Textbausteine</div>
	<span class="return_wert"></span>
	<div id="textbausteine">
		{if is_array($textBaustein_list)}
		<table>
			<tr>
				<th>Titel</th>
				<th></th>				
			</tr>
			{foreach name=aussen item=baustein from=$textBaustein_list}						
			<tr>
				<td>{$baustein.titel}</td>
				<td>
					<a href=""><img src="images/ppl_view.png" alt="edit" title="Baustein anzeigen / editieren" /></a>
				</td>
			</tr>
			{/foreach}
		</table>
		{else}
			{$textBaustein_list}
		{/if}
	</div>
</div>

{include file="navigation.tpl.php"}
{include file="footer.tpl.php"}