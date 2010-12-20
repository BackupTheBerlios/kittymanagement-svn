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
	$('#usr_add_form').hide();
	
	$('#usr_add_show')
			.toggle(
					function() {
						$('#usr_add_form').show("slow");
					},
					function() {
						$('#usr_add_form').hide("slow");
					}
			);
	
	$('#usr_add_show').css({ cursor : "pointer" });

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
						if (typeof(kategorie) == "undefined") {
							$("label#kategorie_error").show();
							$("input#kategorie").focus();
							return false;
						}
						var buchen = $("input#buchen:checked").val();
						if (typeof(buchen) == "undefined") {
							buchen = 0;
						}
						var mail = $("input#mail:checked").val();
						if (typeof(mail) == "undefined") {
							mail = 0;
						}
						
						var dataString = 'user_add=1&vname=' + vname + '&nname=' + nname + '&email=' + email + '&kategorie=' + kategorie + '&buchen=' + buchen + '&mail=' + mail;
//						alert (dataString);return false;

						var return_val;
						$.ajax({
							type : "POST",
							async : false,
							url : "../src/processes/process_benutzer.php",
							data : dataString,
							success : function(value) {
								return_val = value;
							}						
						});
						if(return_val != -666) {
							$('.return_wert').html(return_val)										
										.hide().fadeIn(1500);
							$('#benutzerliste').fadeOut('slow').load('../src/processes/process_benutzer.php?zeigeBenutzer=1').fadeIn("slow");
							$('#user_add').get(0).reset();
							$('#usr_add_form').fadeOut('slow');
						} else {
							$('.return_wert').html("Schwerwiegender Fehler!!!")										
										.hide().fadeIn(1500);
						}
						return false;
					});
});
