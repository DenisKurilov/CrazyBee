$(document).ready(function(){

	// обновление имени
	$("#uname").keyup(function(){
		$("#pre_uname").text($("#uname").val());
	});

	// обновление email
	$("#email").keyup(function(){
		$("#pre_email").text($("#email").val());
	});

	// обновление текста задачи
	$("#tasktext").keyup(function(){
		$("#pre_tasktext").text($("#tasktext").val());
	});

	// закрыти алертов
    $(".close").click(function(){
        $("#myAlert").alert("close");
    });	

	// обновление статуса
	$(".my-checkbox").click(function() {
		var check_active = $(this).is(':checked') ? 1 : 0;
		var check_id = $(this).attr('value');

		$.ajax({
			type: "POST",
			url: "/task/check",
			data: {id: check_id, active: check_active}
		});
	});	

	// оподготовка модального окна
    $("[class*='my-btn']").click(function(){
		document.getElementById('my_modal_form').reset();
		var my_id = $(this).attr('value');
		$("#modaltaskid").text(my_id);
		$("#modaltasktext").text($("[data-id="+my_id+"]").text());
        $("#myModal").modal();
    });
	
    // обновление текста задачи
    $(".ok-modal").click(function(){
		modal_id = $("#modaltaskid").text();
		modal_text = $("#modaltasktext").val();
		$("[data-id="+modal_id+"]").text(modal_text);
		
		$.ajax({
			type: "POST",
			url: "/task/text",
			data: {id: modal_id, tasktext: modal_text}
		});
    });
	
});

// предпросмотр рисунка
function readURL(input) {
if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('#pre_imgfile')
        .attr('src', e.target.result)
        .width(320)
        .height(240);
    };
    reader.readAsDataURL(input.files[0]);
  }
};

