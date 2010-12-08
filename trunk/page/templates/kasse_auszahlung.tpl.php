{include file="header.tpl.php"}

{literal}
<script type="text/javascript" src="../src/javascript/auszahlung.js"></script>
{/literal}

<div class="item">

	<h1>&raquo; Kasse &raquo; Ausgabe buchen</h1>
	<fieldset>
		<form name="spending" id="spending" action="" method="post">
			<div>
				<label for="bemerkung">Bemerkung:</label>
				<select name="bemerkung" id="bemerkung" class="styled">
					<option value="0" selected="selected">&nbsp;-- Bemerkung ausw&auml;hlen --&nbsp;&nbsp;</option>
					<option value="Einkauf - Kaffee">Einkauf - Kaffee</option>
					<option value="Einkauf - Milch">Einkauf - Milch</option>
					<option value="Einkauf - Zucker">Einkauf - Zucker</option>
				</select>
				<label class="error" for="bemerkung" id="bemerkung_error">Bitte w&auml;hlen Sie eine Buchungsbemerkung</label>
			</div>
			<div>
				<label for="betrag">Betrag:</label>
				<input name="betrag" type="text" id="betrag" class="styled betrag" size="8" maxlength="8" /> EURO (&euro;)
				<label class="error" for="betrag" id="betrag_error">Bitte geben Sie einen Betrag an</label>
			</div>
			<input name="ausgabe" type="submit" id="submit" value="&raquo; Speichern " />&nbsp;<span class="return_wert"></span>
		</form>
	</fieldset>
</div>

<div class="item">

	<h1>&raquo; &Uuml;bersicht der letzten {$spendingDisplayCount} Ausgaben</h1>
	<div id="lastSpendings">
		{if is_array($spendingList) }
			<table>
				<tr>
					<th>Datum</th>
					<th>Bemerkung</th>
					<th>Betrag</th>
				</tr>
				{foreach name=aussen item=spending from=$spendingList}
				<tr>	
				{foreach key=key item=val from=$spending}
					{if $key == "datum"}
						<td>{$val}</td>
					{/if}
					{if $key == "bemerkung"}
						<td>{$val}</td>
					{/if}
					{if $key == "betrag"}
						<td class="betrag">{$val} &euro;</td>
					{/if}
				{/foreach}
				</tr>
			{/foreach}
			</table>
		{else}
			{$spendingList}
		{/if}
	</div>
</div>

{include file="navigation.tpl.php"}
{include file="footer.tpl.php"}