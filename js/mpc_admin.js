var $j = jQuery.noConflict();

$j(function(){

$j('#one_more_field').click(function(){
	var ourHtml = '<tr><td><input type="text" name="title[]"></td></tr>';
	
	$j(ourHtml).appendTo('#addable');
	
})

$j('#ten_more_fields').click(function(){
	var i = 0;
	while(i <=10 ){
		var ourHtml = '<tr><td><input type="text" name="title[]"></td></tr>';
		$j(ourHtml).appendTo('#addable');		
		i++;		
	}
})
	
	






   



});


