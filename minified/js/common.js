$(function(){
	var baseURL = '',
		redirectLinkInput = $('#redirect_link'),
		historyBox = $('#history'),
		errors = $('#error-messages');
	
	function showMessage(text,type,glyph){
		if (!text) return;
		
		type = type || 'danger';
		glyph = glyph || 'exclamation';
		
		errors
			.empty()
			.html('<div class="alert alert-'+type+'" role="alert"><span class="glyphicon glyphicon-'+glyph+'-sign"></span> '+text+'</div>')
			.children()
			.first()
			.fadeIn(300)
			.delay(2000)
			.fadeOut(800,function(){
				$(this).remove();
			});
	}
	
	function updateHistory(){
		historyBox.load('history.php');
	}
	
	$('#encrypt-form').on('submit',function(e){
		e.preventDefault();
		
		var $this = $(this);
		
		redirectLinkInput.val('');
		
		$
		.ajax({
			type: $this.attr('type') || 'post',
			url: $this.attr('action') || '',
			data: $this.serialize(),
			dataType: 'json'
		})
		.done(function(data){
			if (data.error) {
				showMessage(data.message);
			}
			else {
				redirectLinkInput.val(data.redirect_link || baseURL + data.id);
				showMessage('Done!','success','ok');
				updateHistory();
			}
		})
		.fail();
	});
	
	updateHistory();
});