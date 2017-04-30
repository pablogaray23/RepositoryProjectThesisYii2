$(function(){
	$('#modalButton').click(function(){
		$('#modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
});

$(function(){
	$('.ajax_button').click(function(){
		$('#modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
});

$(function(){
	$('#editButton').click(function(){
		$('#modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
});

$(function(){
	$('#copyRut').click(function(){
		var n1 = document.getElementById('profesionalmedico-rut');
		var n2 = document.getElementById('profesionalespecialidad-rut');
		n2.value = n1.value;
	});
});