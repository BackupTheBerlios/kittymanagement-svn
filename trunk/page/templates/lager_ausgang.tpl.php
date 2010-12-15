{include file="header.tpl.php"} 

{literal}
<script type="text/javascript" src="../src/javascript/lager_ausgang.js"></script>
{/literal} 

<div class="item">

	<h1>&raquo; Lager &raquo; Ausgang buchen</h1>
	
	<fieldset>
		<form name="lagerAusgang" id="lagerAusgang" action="" method="post">
			<div>
				<label for="datum">Entnahmedatum </label>
				<input name="datum"	type="text" id="datum" class="styled" size="8" maxlength="10" />
				<label class="error" for="datum" id="datum_error">Bitte geben Sie ein Entnahmedatum an</label>
			</div>
			<div>
				<label for="artikel">Artikel </label>
				<select name="artikel" id="artikel" class="styled">
        			<option value="0" selected="selected">&nbsp;-- Artikel ausw&auml;hlen --&nbsp;&nbsp;</option>
        			{if is_array($lagerBestand)}
						{foreach name=aussen item=artikel from=$lagerBestand}
							<option value="{$artikel.ekId}">{$artikel.artSorte} ({$artikel.artSize|ger_number_format} {$artikel.artUOMshort}) [Lagerbestand: {$artikel.lagerBestand}]</option>
						{/foreach}
					{else}
						<span class="error">Hier ist ein schwerer Fehler aufgetreten</span>
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
				<label for="isCoffee"></label>
				<input type="checkbox" name="isCoffee" value="1" id="isCoffee" checked="checked" /> Ist Kaffeeentnahme
			</div>
			<div id="showCupCount">
				<label for="cupCount">Z&auml;hlerstand Kaffee </label>
				<input name="cupCount" type="text" id="cupCount" class="styled betrag" size="8" maxlength="8" />
				<label class="error" for="size_short" id="cupCount_error">Bitte geben Sie einen Z&auml;hlerstand an</label>
			</div>
			
			<input name="ausbuchen" type="submit" id="submit" value="&raquo; Speichern " />&nbsp;<span class="return_wert"></span>
		</form>
	</fieldset>	
</div>

<div class="item">
	<h1>&raquo; &Uuml;bersicht der letzten {$storageOutgoingsDisplayCount} Lagerausg&auml;nge</h1>
	<div id="lagerausgaenge">
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
