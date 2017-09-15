function validateDate(begin_date, end_date)
{
    var x_date = begin_date.substring(6, 10)+begin_date.substring(3, 5)+begin_date.substring(0, 2);      
    var y_date = end_date.substring(6, 10)+end_date.substring(3, 5)+end_date.substring(0, 2);
    var a_date = parseInt(x_date);
    var b_date = parseInt(y_date);
    if ((a_date < b_date) || (isNaN(b_date))) 
    {
        $('#mesage').addClass("hide").removeClass('message-color');
        $(':input[type="submit"]').prop('disabled', false);
        $('#effective_date-kvdate').removeClass("has-error");
        $('#effective_date-kvdate').addClass("has-success");
        $('#administrative_end-kvdate').removeClass("has-error");
        $('#administrative_end-kvdate').addClass("has-success");
        $('#effective_date-kvdate .input-group-addon').removeClass('addon-color').css({"border-color":"#ccc"});
        $('#administrative_end-kvdate .input-group-addon').removeClass('addon-color').css({"border-color":"#ccc"});
        $('#end_time').removeClass('time-color ');
        $('#end_time').addClass('has-success');

    }
    else if ((isNaN(a_date))&&(b_date != 0))
    {  
        if (document.getElementById('effective_date-kvdate')) {
            $('#mesage').addClass("hide").removeClass('message-color').html("Ngày ban hành chưa có giá trị");
            $('#mesage').removeClass("hide").addClass('message-color').innerHTML = "html";
            $('#effective_date-kvdate').addClass("has-error");
            $('#effective_date-kvdate').removeClass("has-success");
            $('#effective_date-kvdate .input-group-addon').addClass('addon-color').css({"border-color":"#a94442"});
        }
        else if (document.getElementById('administrative_end-kvdate')) {
            $('#mesage').addClass("hide").removeClass('message-color').html("Ngày thành lập chưa có giá trị");
            $('#mesage').removeClass("hide").addClass('message-color').innerHTML = "html";
            $('#administrative_end-kvdate').addClass("has-error");
            $('#administrative_end-kvdate').removeClass("has-success");
            $('#administrative_end-kvdate .input-group-addon').addClass('addon-color').css({"border-color":"#a94442"});
        }


        $(':input[type="submit"]').prop('disabled', true);
        $('#end_time').addClass('time-color');
        $('#end_time').removeClass('has-success');
    }
    else
    {
        if (document.getElementById('effective_date-kvdate')) {
         $('#mesage').removeClass("hide").addClass('message-color').html("Ngày hết hiệu lực phải lớn hơn ngày ban hành");
         $('#mesage').removeClass("hide").addClass('message-color').innerHTML = "html";
         $('#effective_date-kvdate').addClass("has-error");
         $('#effective_date-kvdate').removeClass("has-success");
         $('#effective_date-kvdate .input-group-addon').addClass('addon-color').css({"border-color":"#a94442"});

     }
     else if (document.getElementById('administrative_end-kvdate')) {
        $('#mesage').removeClass("hide").addClass('message-color').html("Ngày hết hiệu lực phải lớn hơn ngày thành lập");
        $('#mesage').removeClass("hide").addClass('message-color').innerHTML = "html";
        $('#administrative_end-kvdate').addClass("has-error");
        $('#administrative_end-kvdate').removeClass("has-success");
        $('#administrative_end-kvdate .input-group-addon').addClass('addon-color').css({"border-color":"#a94442"});
    }

    $(':input[type="submit"]').prop('disabled', true);
    $('#end_time').addClass('time-color');
    $('#end_time').removeClass('has-success');

}
}

$('#administrative_end').on('change keyup mouseleave', function() { 
    var begin = document.getElementById('administrative_begin').value;
    var end =  $(this).val();     
    validateDate(begin,end);
});
$('#administrative_begin').on('change keyup mouseleave', function(){

    var begin = $(this).val();
    var end = document.getElementById('administrative_end').value;
    if(document.getElementById('administrative_end')){
      validateDate(begin, end);
  }
  else{
    $('#mesage').addClass("hide").removeClass('message-color');
    $(':input[type="submit"]').prop('disabled', false);
    $('#administrative_end-kvdate').removeClass("has-error");
    $('#administrative_end-kvdate').addClass("has-success");
    $('#administrative_end-kvdate .input-group-addon').removeClass('addon-color').css({"border-color":"#ccc"});
    $('#end_time').removeClass('time-color ');
    $('#end_time').addClass('has-success ');

}
});


$('#effective_date').on('change keyup mouseleave', function() { 
    var end =  $(this).val();
    var begin = document.getElementById('publish_date').value;
    validateDate(begin,end);
}); 
$('#publish_date').on('change keyup mouseleave', function(){
    var begin = $(this).val();
    var end = document.getElementById('effective_date').value;
    if (document.getElementById('effective_date')) {
        validateDate(begin, end);
    }
    else{
        $('#mesage').addClass("hide").removeClass('message-color');
        $(':input[type="submit"]').prop('disabled', false);
        $('#effective_date-kvdate').removeClass("has-error");
        $('#effective_date-kvdate').addClass("has-success");
        $('#effective_date-kvdate .input-group-addon').removeClass('addon-color').css({"border-color":"#ccc"});
        $('#end_time').removeClass('time-color ');
        $('#end_time').addClass('has-success ');

    }
    
})

