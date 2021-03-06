{include file="header.tpl.php"} 

{literal}
<script type="text/javascript" src="../src/javascript/lager_eingang.js"></script>
{/literal} 

<div class="item">

	<h1>&raquo; Lager &raquo; Eingang buchen</h1>
	
	<fieldset>
		<form name="lagerEingang" id="lagerEingang" action="" method="post">
			<div>
				<label for="datum">Einkaufsdatum </label>
				<input name="datum"	type="text" id="datum" class="styled" size="8" maxlength="10" />
				<label class="error" for="datum" id="datum_error">Bitte geben Sie ein Einkaufsdatum an</label>
			</div>
			<div>
				<label for="artikel">Artikel </label>
				<select name="artikel" id="artikel" class="styled">
        			<option value="0" selected="selected">&nbsp;-- Artikel ausw&auml;hlen --&nbsp;&nbsp;</option>
        			{if is_array($lagerArtikel)}
						{foreach name=aussen item=artikel from=$lagerArtikel}
							<option value="{$artikel.id}">{$artikel.sorte} ({$artikel.size|ger_number_format} {$artikel.uom_short})</option>
						{/foreach}
					{else}
						{$lagerArtikel}
					{/if}
        		</select>
        		<label class="error" for="artikel" id="artikel_error">Bitte w&auml;hlen Sie einen Artikel aus</label>
        	</div>
			<div>
				<label for="size">St&uuml;ck / Pakete </label>
				<input name="size" type="text" id="size" class="styled betrag" size="8" maxlength="8" />
				<label class="error" for="size_short" id="size_error">Bitte geben Sie eine St&uuml;ckzahl an</label>
			</div>
			<div>
				<label for="preis_einzel">Einzelpreis </label>
				<input name="preis_einzel" type="text" id="preis_einzel" class="styled betrag" size="8" maxlength="8" /> EURO (&euro;)				
			</div>
			<div>
				<u>oder</u>
				<label class="error" for="preis" id="preis_error">Sie m&uuml;ssen einen Einzel oder Gesamtpreis angeben</label>
			</div>
			<div>
				<label for="preis_gesamt">Gesamtpreis </label>
				<input name="preis_gesamt" type="text" id="preis_gesamt" class="styled betrag" size="8" maxlength="8" /> EURO (&euro;)
			</div>
			
			<input name="einbuchen" type="submit" id="submit" value="&raquo; Speichern " />&nbsp;<span class="return_wert"></span>
		</form>
	</fieldset>	
</div>

<div class="item">
	<h1>&raquo; &Uuml;bersicht der letzten {$storageEntryDisplayCount} Lagereing&auml;nge</h1>
	<div id="lagereingaenge">
		{if is_array($letzteEingaenge)}
		<table>
			<tr>
				<th>Datum</th>
				<th>Anzahl</th>
				<th>Preis pro Stck.</th>
				<th>Sorte</th>
			</tr>
			{foreach name=aussen item=eingang from=$letzteEingaenge}
			<tr>
				<td>{$eingang.datum}</td>
				<td class="betrag">{$eingang.anzahl}</td>
				<td class="betrag">{$eingang.pps|ger_number_format} &euro;</td>
				<td>{$eingang.sorte} ({$eingang.size|ger_number_format} {$eingang.uoms})</td>
			</tr>
			{/foreach}
		</table>
		{else}
			{$letzteEingaenge}
		{/if}
	</div>
</div>

{include file="navigation.tpl.php"}
{include file="footer.tpl.php"}
