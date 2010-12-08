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

						var ma_id = $("select#ma_id").val();
						if (ma_id == "0") {
							$("label#ma_id_error").show();
							$("select#ma_id").focus();
							return false;
						}
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
						
						var dataString = 'bareinzahlung=1&ma_id=' + ma_id + '&bemerkung=' + bemerkung + '&betrag=' + betrag;
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
							$('#lastPayments').fadeOut('slow').load('../src/processes/process_kasse.php?zeigeEinzahlungen=1').fadeIn("slow");
							$('#payment').get(0).reset();
							$('.return_wert').fadeOut('slow');							
						} else {
							$('.return_wert').html("Fehler beim eintragen der Zahlung!")										
										.hide().fadeIn(1500);
						}
						return false;
					});
});
