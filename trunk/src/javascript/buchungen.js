$(function() {
	$("#submit")
			.click(
					function() {						
						var ma_ids = new Array();
						
						$("input#hidden").each(function(i) {
							var faktor = $("input#" + this.value).val();
							var betrag = $("td#betrag_" + faktor).text();
							var return_val = new Array();
							
							ma_ids[i] = this.value;
							
							var mail = $("input#mail:checked").val();
							if (typeof(mail) == "undefined") {
								mail = 0;
							}
							
							var dataString = 'bucheBeitrag=1&ma_id=' + this.value + '&faktor=' + faktor + '&betrag=' + betrag + '&mail=' + mail;

//							alert(dataString); return false;
							
							$.ajax({
								type : "POST",
								async : false,
								url : "../src/processes/process_kasse.php",
								data : dataString,
								dataType: 'json',
								success : function(value) {
									return_val = value;
								}						
							});
							
							if(return_val['success'] == 1) {
								$("#" + this.value + "_contribMonth").html(return_val['month']);
								$("#" + this.value + "_contribEntered").animate({backgroundColor:"#008000"},700);
								if(mail == 1 && return_val['mailSend'] == 1) {
									$("#" + this.value + "_contribMailSend").animate({backgroundColor:"#008000"},700);
								} else if(mail == 1 && return_val['mailSend'] != 1) {
									$("#" + this.value + "_contribMailSend").animate({backgroundColor:"#FF0000"},700);
								}
							} else {
								$("#" + this.value + "_contribMonth").html(return_val['month']);
								$("#" + this.value + "_contribEntered").animate({backgroundColor:"#FF0000"},700);
								$("#" + this.value + "_contribEntered").css({'color' : '#FFFFFF', 'font-weight' : 'bold'});
								$("#" + this.value + "_contribEntered").html(return_val['successComment']);
								if(mail == 1) {
									$("#" + this.value + "_contribMailSend").animate({backgroundColor:"#FF0000"},700);
								}
							}

						});

						return false;
					});
});
