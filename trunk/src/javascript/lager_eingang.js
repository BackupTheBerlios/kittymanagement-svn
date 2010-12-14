$(function() {
	$('.error').hide();
	$('input.text-input').css({
		backgroundColor : "#FFFFFF"
	});
	$('input.text-input').focus(function() {
		$(this).css({
			backgroundColor : "#FFDDAA"
		});
	});
	$('input.text-input').blur(function() {
		$(this).css({
			backgroundColor : "#FFFFFF"
		});
	});
	
	$('#datum').datepicker();
	
	$("#submit")
			.click(
					function() {
						$('.error').hide();
		
						var datum = $("input#datum").val();
						if (datum == "") {
							$("label#datum_error").show();
							$("input#datum").focus();
							return false;
						}
						var artikel = $("select#artikel").val();
						if (artikel == "0") {
							$("label#artikel_error").show();
							$("select#artikel").focus();
							return false;
						}
						var size = $("input#size").val();
						if (size == "") {
							$("label#size_error").show();
							$("input#size").focus();
							return false;
						}
						var preis_einzel = $("input#preis_einzel").val();
						var preis_gesamt = $("input#preis_gesamt").val();
						
						if ((preis_einzel == "") && (preis_gesamt == "")) {
							$("label#preis_error").show();
							return false;
						}
						
						var dataString = 'lager_eingang=1&datum=' + datum + '&artikel=' + artikel + '&size=' + size + '&preis_einzel=' + preis_einzel + '&preis_gesamt=' + preis_gesamt;
//						alert (dataString);return false;
		
						var return_val;
						$.ajax({
							type : "POST",
							async : false,
							url : "../src/processes/process_lager.php",
							data : dataString,
							success : function(value) {
								return_val = value;
							}						
						});
						if(return_val == 1) {
							$('.return_wert').html("Zahlung erfolgreich eingetragen")										
										.hide().fadeIn(1500);
							$('#lagereingaenge').fadeOut('slow').load('../src/processes/process_lager.php?zeigeEingaenge=1').fadeIn("slow");
							$('#lagerEingang').get(0).reset();
							$('.return_wert').fadeOut('slow');							
						} else {
							$('.return_wert').html("Fehler beim eintragen der Zahlung!")										
										.hide().fadeIn(1500);
						}
						return false;
					});
});