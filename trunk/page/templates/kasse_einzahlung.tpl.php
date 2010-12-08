{include file="header.tpl.php"}

{literal}
<script type="text/javascript" src="../src/javascript/einzahlung.js"></script>
{/literal}

<div class="item">

	<h1>&raquo; Kasse &raquo; Einzahlung buchen</h1>
    <fieldset>
    	<form name="payment" id="payment" action="" method="post">
        	<div>
        		<label for="ma_id">Teilnehmer:</label>
        		<select name="ma_id" id="ma_id" class="styled">
        			<option value="0" selected="selected">&nbsp;-- Teilnehmer ausw&auml;hlen --&nbsp;&nbsp;</option>
        			{if is_array($member_list)}
						{foreach name=aussen item=member from=$member_list}
							<option value="{$member.id}">{$member.name}, {$member.vorname}</option>
						{/foreach}
					{else}
						{$member_list}
					{/if}
        		</select>
        		<label class="error" for="ma_id" id="ma_id_error">Bitte w&auml;hlen Sie einen Teilnehmer aus</label>
        	</div>
			<div>
				<label for="bemerkung">Bemerkung:</label>
				<select name="bemerkung" id="bemerkung" class="styled">
					<option value="0" selected="selected">&nbsp;-- Bemerkung ausw&auml;hlen --&nbsp;&nbsp;</option>
					<option value="Bareinzahlung - Monatsbeitrag">Bareinzahlung - Monatsbeitrag</option>
					<option value="Bareinzahlung - Sonstiges">Bareinzahlung - Sonstiges</option>
					<option value="Umbuchung - Milchkauf">Umbuchung - Milchkauf</option>
				</select>
				<label class="error" for="bemerkung" id="bemerkung_error">Bitte w&auml;hlen Sie eine Buchungsbemerkung</label>
			</div>
			<div>
				<label for="betrag">Betrag:</label>
				<input name="betrag" type="text" id="betrag" class="styled betrag" size="8" maxlength="8" /> EURO (&euro;)
				<label class="error" for="betrag" id="betrag_error">Bitte geben Sie einen Betrag an</label>
			</div>
			<input name="bareinzahlung" type="submit" id="submit" value="&raquo; Speichern " />&nbsp;<span class="return_wert"></span>
		</form>
	</fieldset>	
</div>
	
<div class="item">

	<h1>&raquo; &Uuml;bersicht der letzten {$paymentDisplayCount} Einzahlungen</h1>
	<div id="lastPayments">
		{if is_array($paymentList) }
			<table>
				<tr>
					<th>Datum</th>
					<th>Teilnehmer</th>
					<th>Bemerkung</th>
					<th>Betrag</th>
				</tr>
				{foreach name=aussen item=payment from=$paymentList}
				<tr>	
				{foreach key=key item=val from=$payment}
					{if $key == "datum"}
						<td>{$val}</td>
					{/if}
					{if $key == "name"}
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