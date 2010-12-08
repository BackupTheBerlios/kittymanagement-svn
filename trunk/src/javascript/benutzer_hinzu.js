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

						var vname = $("input#vname").val();
						if (vname == "") {
							$("label#vname_error").show();
							$("input#vname").focus();
							return false;
						}
						var nname = $("input#nname").val();
						if (nname == "") {
							$("label#nname_error").show();
							$("input#nname").focus();
							return false;
						}
						var email = $("input#email").val();
						if (email == "") {
							$("label#email_error").show();
							$("input#email").focus();
							return false;
						}
						var kategorie = $("input#kategorie:checked").val();
						if (kategorie == "") {
							$("label#kategorie_error").show();
							$("input#kategorie").focus();
							return false;
						}
						var buchen = $("input#buchen:checked").val();
						if (typeof(buchen) == "undefined") {
							buchen = 0;
						}
						
						var dataString = 'user_add=1&vname=' + vname + '&nname=' + nname + '&email=' + email + '&kategorie=' + kategorie + '&buchen=' + buchen;
						alert (dataString);return false;

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
