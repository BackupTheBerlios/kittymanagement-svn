{include file="header.tpl.php"}

{literal}
<script type="text/javascript" src="../src/javascript/buchungen.js"></script>
{/literal}

<div class="item">

	<h1>&raquo; Verwaltung &raquo; Monatsbeitr&auml;ge buchen</h1>
	<div class="catdescr">Konfigurations&uuml;bersicht</div>
	<p>
		{if $contributionCalculationComment == "fix"}
			Die Beitragsberechnung erfolgt auf Basis eines fix definierten Beitragssatzes.
		{else}
			Die Beitragsberechnung erfolgt dynamisch auf Basis der letzten Eink&auml;ufe, Ausgaben, Verbr&auml;uche und der R&uuml;cklagenbildung.
		{/if}
	</p>
	<table>
		<tr>
			<th>Kategorie</th>
			<th>Faktor</th>
			<th>Beitrag in &euro;</th>
		</tr>
		<tr>	
			<td>Mitarbeiter</td>
			<td class="betrag">{$contributionFactorMA}</td>
			<td class="betrag" id="betrag_ma">{$contributionMA}</td>
		</tr>
		<tr>	
			<td>HiWi's</td>
			<td class="betrag">{$contributionFactorHiWi}</td>
			<td class="betrag" id="betrag_hiwi">{$contributionHiWi}</td>
		</tr>
	</table>
	
	{if is_array($member_list)}
	<div class="catdescr">Buchungs&uuml;bersicht</div>
	<form name="contributions" id="contributions" action="" method="post">
		<input name="buchungen" type="submit" id="submit" value="&raquo; Buchungen erzeugen" />
	</form>
	<table>
		<tr>
			<th>Teilnehmer</th>
			<th>Faktor</th>
			<th>Beitragsmonat</th>
			<th>Buchung</th>
		</tr>
		{foreach name=aussen item=member from=$member_list}
		<tr>
			<td>
				{$member.name}, {$member.vorname}
				<input type="hidden" id="hidden" value="{$member.id}" />
				<input type="hidden" id="{$member.id}" value="{$member.faktor}" />
			</td>
			<td class="betrag">
				{if $member.faktor == "hiwi"} HiWi {/if}
				{if $member.faktor == "ma"} MA {/if}
			</td>
			<td id="{$member.id}_contribMonth"></td>
			<td id="{$member.id}_contribEntered"></td>
		</tr>
		{/foreach}	
	</table>
	{else}
		{$member_list}
	{/if}
</div>


{include file="navigation.tpl.php"}
{include file="footer.tpl.php"}