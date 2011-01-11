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
	$('#txt_add_form').hide();
	
	$('#txt_add_show')
			.toggle(
					function() {
						$('#txt_add_form').show("slow");
					},
					function() {
						$('#txt_add_form').hide("slow");
					}
			);
	
	$('#txt_add_show').css({ cursor : "pointer" });

	$("#submit")
			.click(
					function() {
						$('.error').hide();

						var titel = $("input#bstTitel").val();
						if (titel == "") {
							$("label#bstTitel_error").show();
							$("input#bstTitel").focus();
							return false;
						}
						var text = $("textarea#bstText").val();
						if (text == "") {
							$("label#bstText_error").show();
							$("textarea#bstText").focus();
							return false;
						}						
						
						var dataString = 'baustein_add=1&titel=' + titel + '&text=' + text;
						alert (dataString);return false;

						var return_val;
						$.ajax({
							type : "POST",
							async : false,
							url : "../src/processes/process_textbausteine.php",
							data : dataString,
							success : function(value) {
								return_val = value;
							}						
						});
						if(return_val != -666) {
							$('.return_wert').html(return_val)										
										.hide().fadeIn(1500);
							$('#benutzerliste').fadeOut('slow').load('../src/processes/process_textbausteine.php?zeigeBenutzer=1').fadeIn("slow");
							$('#user_add').get(0).reset();
							$('#usr_add_form').fadeOut('slow');
						} else {
							$('.return_wert').html("Schwerwiegender Fehler!!!")										
										.hide().fadeIn(1500);
						}
						return false;
					});
});
