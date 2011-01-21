$(function() {
	$('a[name=userDetails]').click(function() {

		var url = '../src/processes/process_benutzer.php?showUsrDetails=1';

		var dialog = $('<div style="display:hidden;" class="usrDetails"></div>').appendTo('body');
		var usrId = $(this).attr('id');
		
		dialog.load(
				url + '&usrId=' + usrId,
				{},
				function (responseText, textStatus, XMLHttpRequest) {
					
					$('.usrDetails').html(responseText);
					
					dialog.dialog({
						title: 'Benutzer anzeigen / editieren',
						width: 400,
						modal: true,
						buttons: {
							'Speichern': function() {
								var form = $(this).find('form');
								var return_val;
								$.ajax({
									type : "POST",
									async : false,
									url : "../src/processes/process_benutzer.php?updateUserData=1",
									data : form.serialize(),
									dataType: 'json',
									success : function(value) {
										return_val = value;
									}						
								});
								
								if(return_val['stammDaten']) {
									$('#stammUpd').html(return_val['stammDaten']);								
								}
								if(return_val['status']) {
									$('#statusUpd').html(return_val['status']);
								}
								
								$('#benutzerliste').fadeOut('slow').load('../src/processes/process_benutzer.php?zeigeBenutzer=1').fadeIn("slow");
								$(this).delay(3000).queue(function() { $(this).dialog("close"); });
								
								return false;
							},
							'Abbrechen': function() { 
								$(this).dialog("close"); 
							}
						},
						close: function() { $(this).remove(); }						
					});
				}
		);
		
		return false;
		
	});
});