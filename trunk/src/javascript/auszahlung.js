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

	$("#submit")
			.click(
					function() {
						$('.error').hide();

						var bemerkung = $("select#bemerkung").val();
						if (bemerkung == "0") {
							$("label#bemerkung_error").show();
							$("select#bemerkung").focus();
							return false;
						}
						var betrag = $("input#betrag").val();
						if (betrag == "") {
							$("label#betrag_error").show();
							$("input#betrag").focus();
							return false;
						}
						
						var dataString = 'ausgabe=1&bemerkung=' + bemerkung + '&betrag=' + betrag;
//						alert (dataString);return false;

						var return_val;
						$.ajax({
							type : "POST",
							async : false,
							url : "../src/processes/process_kasse.php",
							data : dataString,
							success : function(value) {
								return_val = value;
							}						
						});
						if(return_val == 1) {
							$('.return_wert').html("Zahlung erfolgreich eingetragen")										
										.hide().fadeIn(1500);							
							$('#lastSpendings').fadeOut('slow').load('../src/processes/process_kasse.php?zeigeAusgaben=1').fadeIn("slow");
							$('#spending').get(0).reset();
							$('.return_wert').fadeOut('slow');							
						} else {
							$('.return_wert').html("Fehler beim eintragen der Zahlung!")										
										.hide().fadeIn(1500);
						}
						return false;
					});
});
