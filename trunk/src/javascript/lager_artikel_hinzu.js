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

	$('#artikel_add_form').hide();
	
	$('#artikel_add_show')
			.toggle(
					function() {
						$('#artikel_add_form').show("slow");
					},
					function() {
						$('#artikel_add_form').hide("slow");
					}
			);
	
	$('#artikel_add_show').css({ cursor : "pointer" });
	
	$("#submit")
			.click(
					function() {
						$('.error').hide();

						var sorte = $("input#sorte").val();
						if (sorte == "") {
							$("label#sorte_error").show();
							$("input#sorte").focus();
							return false;
						}
						var uom = $("input#uom").val();
						if (uom == "") {
							$("label#uom_error").show();
							$("input#uom").focus();
							return false;
						}
						var uom_short = $("input#uom_short").val();
						if (uom_short == "") {
							$("label#uom_short_error").show();
							$("input#uom_short").focus();
							return false;
						}
						var size = $("input#size").val();
						if (size == "") {
							$("label#size_error").show();
							$("input#size").focus();
							return false;
						}
						
						var dataString = 'artikel_add=1&sorte=' + sorte + '&uom=' + uom + '&uom_short=' + uom_short + '&size=' + size;
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
						if(return_val != -666) {
							$('.return_wert').html(return_val)										
										.hide().fadeIn(1500);
							$('#lagerartikel').fadeOut('slow').load('../src/processes/process_lager.php?zeigeArtikel=1').fadeIn("slow");
							$('#artikelHinzu').get(0).reset();
							$('#artikel_add_form').fadeOut('slow');
						} else {
							$('.return_wert').html("Schwerwiegender Fehler!!!")										
										.hide().fadeIn(1500);
						}
						return false;
					});
});
