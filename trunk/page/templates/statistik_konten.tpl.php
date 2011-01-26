{include file="header.tpl.php"}

{literal}
<!--<script type="text/javascript" src="../src/javascript/buchungen.js"></script>-->
{/literal}

<div class="item">
	<h1>&raquo; Statistik &raquo; Aktueller Barbestand</h1>
	<br />
	<p>
		Der aktuelle Barbestand der Kaffeekasse betr&auml;gt <b>{$baseAccountSum*-1|ger_number_format} &euro;</b>
	</p>
</div>

<div class="item">

	<h1>&raquo; Statistik &raquo; Benutzerkonten &Uuml;bersicht</h1>
	<br />
	{if is_array($member_list)}
	<table>
		<tr>
			<th>Benutzer</th>
			<th>Kto. Stand</th>
<!--			<th colspan="2">Optionen</th>-->
		</tr>
		{foreach name=aussen item=member from=$member_list}
			{if $member.status == 1}
				{assign var='mid' value=$member.id}
				<tr>
					<td>
						{$member.name}, {$member.vorname}
						<input type="hidden" id="hidden" value="{$member.id}" />
					</td>
					{if $memberAccountSum.$mid < 0}
						<td class="betrag" style="color:#FF0000;">{$memberAccountSum.$mid|ger_number_format} &euro;</td>
					{else}
						<td class="betrag">{$memberAccountSum.$mid|ger_number_format} &euro;</td>
					{/if}
		<!--			<td><img src="images/table_view.png" alt="anzeigen" title="Kontobewegungen anzeigen" id="" /></td>-->
		<!--			<td><img src="images/pdf.gif" alt="anzeigen" title="PDF Kontoauszug erzeugen" id="" /></td>-->
				</tr>
			{/if}
		{/foreach}	
	</table>
	{else}
		{$member_list}
	{/if}
</div>


{include file="navigation.tpl.php"}
{include file="footer.tpl.php"}