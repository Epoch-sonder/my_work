<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>



	<input id="brigade-person" type="" name="">
	<br>

	<select name="" id="trainingprocessViewPeople" multiple="multiple" style="width: 200px; height: 250px">
		<option value="1">Первый</option>
		<option value="2">Второй</option>
		<option value="3">Третий</option>
		<option value="4">Четвертый</option>
	</select>

	<select name="" id="trainingprocessPeople" multiple="multiple" style="width: 200px; height: 250px">
		<option value="5">Пятый</option>
	</select>
	

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script> -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script type="text/javascript">
	
$("#trainingprocessPeople").dblclick(function(){
    var eventar = event.target;
    if (eventar.nodeName == 'OPTION'){
         $('#trainingprocessViewPeople').append(eventar).prop('selected', false); 
         // $('#trainingprocessViewPeople option').prop('selected', true);
         // var numPeople = $('#trainingprocessViewPeople').val().join();
         // $('#brigade-person').val(numPeople)
         listUpdate()
         $('#trainingprocessViewPeople option').prop('selected', false);
    }
});

$("#trainingprocessViewPeople").dblclick(function(){
    var eventar = event.target;
    if (eventar.nodeName == 'OPTION'){
         // $('#trainingprocessPeople option[value=NO]').remove();
         $('#trainingprocessPeople').append(eventar).prop('selected', false);
         // $('#trainingprocessViewPeople option').prop('selected', true);
         // alert( $('#trainingprocessViewPeople option').length )

         // var numPeople=''
         // if ( $('#trainingprocessViewPeople option').length == 0) numPeople = ''
         // else 
         	// numPeople = $('#trainingprocessViewPeople').val().join();
    //      	$('#trainingprocessViewPeople option').each(function(){
				//     numPeople += $(this).val() + ' '
				// });
    //      $('#brigade-person').val(numPeople);

    listUpdate()
         // $('#trainingprocessViewPeople option').prop('selected', false);
         $('#trainingprocessPeople option').prop('selected', false);
    }
});

function listUpdate() {
	var numPeople=''
   $('#trainingprocessViewPeople option').each(function(){
	    numPeople += $(this).val() + ' '
	});
   $('#brigade-person').val(numPeople);
}

listUpdate()

</script>

</body>
</html>