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
							
							var dataString = 'bucheBeitrag=1&ma_id=' + this.value + '&faktor=' + faktor + '&betrag=' + betrag;

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
							
//							alert(return_val['month']);
//							alert(return_val['success']);
//							return false;
							
							if(return_val['success'] == 1) {
								$("#" + this.value + "_contribMonth").html(return_val['month']);
								$("#" + this.value + "_contribEntered").animate({backgroundColor:"#008000"},700);
							} else {
								$("#" + this.value + "_contribMonth").html(return_val['month']);
								$("#" + this.value + "_contribEntered").animate({backgroundColor:"#FF0000"},700);
								$("#" + this.value + "_contribEntered").css({'color' : '#FFFFFF', 'font-weight' : 'bold'});
								$("#" + this.value + "_contribEntered").html(return_val['successComment']);
							}

						});

						return false;
					});
});
