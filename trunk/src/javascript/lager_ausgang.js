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
	
//	$("#showCupCount").css("display", "none");
	$("#isCoffee").click(function() { 
		if($("#isCoffee").is(":checked")) {
			$("#showCupCount").show("fast");
		} else {
			$("#showCupCount").hide("fast");
		}
	});
	
	
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
						var ekId = $("select#artikel").val();
						if (ekId == "0") {
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
						
						var cupCount = -1;
						var isCoffee = $("input#isCoffee:checked").val();
						if (typeof(isCoffee) != "undefined") {
							cupCount = $("input#cupCount").val();
							if (cupCount == "") {
								$("label#cupCount_error").show();
								$("input#cupCount").focus();
								return false;
							}
						}
												
						var dataString = 'lager_ausgang=1&datum=' + datum + '&ekId=' + ekId + '&size=' + size + '&cupCount=' + cupCount;
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
							$('#lagerausgaenge').fadeOut('slow').load('../src/processes/process_lager.php?zeigeAusgaenge=1').fadeIn("slow");
							$('#lagerAusgang').get(0).reset();
							$('.return_wert').fadeOut('slow');							
						} else {
							$('.return_wert').html("Hier ist ein genereller Fehler aufgetreten!")										
										.hide().fadeIn(1500);
						}
						return false;
					});
});