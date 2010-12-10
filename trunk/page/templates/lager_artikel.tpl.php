{include file="header.tpl.php"} 

{literal}
<script type="text/javascript" src="../src/javascript/lager_artikel_hinzu.js"></script>
{/literal} 

<div class="item">

	<h1>&raquo; Verwaltung &raquo; Lagerartikel verwalten</h1>
	<div class="catdescr" id="artikel_add_show"><img src="images/inv_add.png" alt="hinzufuegen" title="Lagerartikel anlegen" /> Artikel anlegen</div>
	<div id="artikel_add_form">
		<fieldset>
			<form name="artikelHinzu" id="artikelHinzu" action="" method="post">
				<div>
					<label for="sorte">Sorte (Beschreibung) </label>
					<input name="sorte"	type="text" id="sorte" class="styled" />
					<label class="error" for="sorte" id="sorte_error">Bitte geben Sie eine Artikelsorte an</label>
				</div>
				<div>
					<label for="uom">Mengeneinheit </label>
					<input name="uom" type="text" id="uom" class="styled" />
					<label class="error" for="uom" id="uom_error">Bitte geben Sie eine Mengeneinheit an</label>
				</div>
				<div>
					<label for="uom_short">Mengeneinheit K&uuml;rzel </label>
					<input name="uom_short" type="text" id="uom_short" class="styled" />
					<label class="error" for="uom_short" id="uom_short_error">Bitte geben Sie ein K&uuml;rzel f&uuml;r die Mengeneinheit an</label>
				</div>
				<div>
					<label for="size">Verpackungsgr&ouml;&szlig;e </label>
					<input name="size" type="text" id="size" class="styled" />
					<label class="error" for="size" id="size_error">Bitte geben Sie eine Verpackungsgr&ouml;&szlig;e an</label>
				</div>
				
				<input name="artikelAnlegen" type="submit" id="submit" value="&raquo; Speichern " />
			</form>
		</fieldset>
	</div>
	
</div>

<div class="item">
	<div class="catdescr">vorhandene Lagerartikel</div>
	<span class="return_wert"></span>
	<div id="lagerartikel">
		{if is_array($lagerArtikel)}
		<table>
			<tr>
				<th>Sorte</th>
				<th>Verpackungsgr&ouml;&szlig;e</th>
			</tr>
			{foreach name=aussen item=artikel from=$lagerArtikel}						
			<tr>
				<td>{$artikel.sorte}</td>
				<td class="betrag">{$artikel.size} {$artikel.uom_short}</td>
			</tr>
			{/foreach}
		</table>
		{else}
			{$lagerArtikel}
		{/if}
	</div>
</div>

{include file="navigation.tpl.php"}
{include file="footer.tpl.php"}
