$(function(){
	
	$(document).on('click','.fc-day',function(){
		var date = $(this).attr('data-date');
		
		$.get('index.php?r=event/create',{'date':date},function(data){
			alert(data);
				$('#modal').modal('show')
				.find('#modalContent')
				.html(data);
			
		});
		
	
		
	});
	//get the click of the create button
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
	    $('#abrirPDF').on('click', function (e) {
        var $this = $(this);
        $.ajax({
            url: 'GetUrl',
            async: false,
            success: function (url) {
                $this.attr("href", url);
                $this.attr("target", "_blank");
            },
            error: function () {
                e.preventDefault();
            }
        });
    })
});

$(function(){
	$('#copyRut').click(function(){
		var n1 = document.getElementById('profesionalmedico-rut');
		var n2 = document.getElementById('profesionalespecialidad-rut');
		n2.value = n1.value;
	});
});