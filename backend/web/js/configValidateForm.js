function validateDate(begin_date, end_date)
{
    var x_date = begin_date.substring(6, 10)+begin_date.substring(3, 5)+begin_date.substring(0, 2);      
    var y_date = end_date.substring(6, 10)+end_date.substring(3, 5)+end_date.substring(0, 2);
    var a_date = parseInt(x_date);
    var b_date = parseInt(y_date);
    if ((a_date < b_date) || (isNaN(b_date))) 
    {
        $('#mesage').addClass("hide").removeClass("message-color");
        $(':input[type="submit"]').prop('disabled', false);
        $('#documents-effective_date-kvdate').removeClass("has-error").addClass("has-success");
        $('#administrative_end-kvdate').removeClass("has-error").addClass("has-success");
        $('#end_time').removeClass("time-color").css("color","#00a65a");
    }
    else if ((isNaN(a_date))&&(b_date != 0))
    {  
        if (document.getElementById('documents-effective_date-kvdate')) {
            $('#mesage').addClass("hide").removeClass("message-color").html("Ngày ban hành chưa có giá trị.");
            $('#mesage').removeClass("hide").addClass("message-color").innerHTML = "html";
            $('#documents-effective_date-kvdate').addClass("has-error").removeClass("has-success");
        }
        else if (document.getElementById('administrative_end-kvdate')) {
            $('#mesage').addClass("hide").removeClass('message-color').html("Ngày thành lập chưa có giá trị");
            $('#mesage').removeClass("hide").addClass('message-color').innerHTML = "html";
            $('#administrative_end-kvdate').addClass("has-error").removeClass("has-success");
        }


        $(':input[type="submit"]').prop('disabled', true);
        $('#end_time').addClass('time-color').css("color","#dd4b39");
    }
    else
    {
        if (document.getElementById('documents-effective_date-kvdate')) {
           $('#mesage').removeClass("hide").addClass('message-color').html("Ngày hết hiệu lực phải lớn hơn ngày ban hành.");
           $('#mesage').removeClass("hide").addClass('message-color').innerHTML = "html";
           $('#documents-effective_date-kvdate').addClass("has-error").removeClass("has-success");

       }
       else if (document.getElementById('administrative_end-kvdate')) {
        $('#mesage').removeClass("hide").addClass('message-color').html("Ngày hết hiệu lực phải lớn hơn ngày thành lập.");
        $('#mesage').removeClass("hide").addClass('message-color').innerHTML = "html";
        $('#administrative_end-kvdate').addClass("has-error").removeClass("has-success");
    }

    $(':input[type="submit"]').prop('disabled', true);
    $('#end_time').addClass('time-color').css("color","#dd4b39");

}
}

$('#administrative_end').on('change keyup click', function() { 
    var begin = document.getElementById('administrative_begin').value;
    var end =  $(this).val();     
    validateDate(begin,end);
});

//
$('#administrative_end').bind('paste', function() {
    var self = $(this);
    var orig = self.val();
    setTimeout(function() {
        var end = text_diff(orig, $(self).val());
        var begin = document.getElementById('administrative_begin').value;
        validateDate(begin,end);
    });
});
//
$('#administrative_begin').on('change keyup click ', function(){

    var begin = $(this).val();
    var end = document.getElementById('administrative_end').value;
    if(document.getElementById('administrative_end')){
      validateDate(begin, end);
  }
  else{
    $('#mesage').addClass("hide").removeClass('message-color');
    $(':input[type="submit"]').prop('disabled', false);
    $('#administrative_end-kvdate').removeClass("has-error").addClass("has-success");
    $('#end_time').removeClass('time-color ').css("color","#00a65a");

}
});
//
$('#administrative_begin').bind('paste', function() {
    var self = $(this);
    var orig = self.val();
    setTimeout(function() {
        var begin = text_diff(orig, $(self).val());
        var end = document.getElementById('administrative_end').value;
        validateDate(begin,end);
    });
});


$('#documents-effective_date').on('change keyup click', function() { 
    var end =  $(this).val();
    var begin = document.getElementById('documents-publish_date').value;
    validateDate(begin,end);
});  
//
$('#documents-effective_date').bind('paste', function() {
    var self = $(this);
    var orig = self.val();
    setTimeout(function() {
        var end = text_diff(orig, $(self).val());
        var begin = document.getElementById('documents-publish_date').value;
        validateDate(begin,end);
    });
});
//
$('#documents-publish_date').on('change keyup click ', function(){
    var begin = $(this).val();
    var end = document.getElementById('documents-effective_date').value;
    if (document.getElementById('documents-effective_date')) {
        validateDate(begin, end);
    }
    else{
        $('#mesage').addClass("hide").removeClass('message-color');
        $(':input[type="submit"]').prop('disabled', false);
        $('#documents-effective_date-kvdate').removeClass("has-error").addClass("has-success");
        $('#end_time').removeClass('time-color ').css("color","#00a65a");
    }
    
});
//
$('#documents-publish_date').bind('paste', function() {
    var self = $(this);
    var orig = self.val();
    setTimeout(function() {
        var begin = text_diff(orig, $(self).val());
        var end = document.getElementById('documents-effective_date').value;
        validateDate(begin,end);
    });
});

function validatebirtday(birthday, now){
    var x_date = birthday.substring(6, 10)+birthday.substring(3, 5)+birthday.substring(0, 2);      
    var y_date = now.substring(6, 10)+now.substring(3, 5)+now.substring(0, 2);
    var a_date = parseInt(x_date);
    var b_date = parseInt(y_date);
    if ((a_date < b_date) || (isNaN(a_date)))  {
        $('#mesage-birthday').addClass("hide").removeClass("message-color");
        $(':input[type="submit"]').prop('disabled', false);
        $('#birthday-kvdate').removeClass("has-error").addClass("has-success");
        $('#birthday-label').removeClass("time-color").css("color","#00a65a");

    }
    else if (a_date >= b_date){
        $('#mesage-birthday').addClass("hide").removeClass("message-color").html("Ngày sinh phải nhỏ hơn ngày hiện tại.");
        $('#mesage-birthday').removeClass("hide").addClass("message-color").innerHTML = "html";
        $('#birthday-kvdate').addClass("has-error").removeClass("has-success");
        $(':input[type="submit"]').prop('disabled', true);
        $('#birthday-label').addClass('time-color').css("color","#dd4b39");
    }

};


$('#birthday').on('change keyup click', function(){
    var today = moment().format('D-MM-YYYY');
    var to_birthday = $(this).val();
    validatebirtday(to_birthday,today );
});

$('#birthday').bind('paste', function() {
    var self = $(this);
    var orig = self.val();
    setTimeout(function() {
        var to_birthday = text_diff(orig, $(self).val());
        var today = moment().format('D-MM-YYYY');
        searchValidate(to_birthday, today);
    });
});

function searchValidate(before, after){
    var x_date = before.substring(6, 10)+before.substring(3, 5)+before.substring(0, 2);      
    var y_date = after.substring(6, 10)+after.substring(3, 5)+after.substring(0, 2);
    var a_date = parseInt(x_date);
    var b_date = parseInt(y_date);
    if (a_date >= b_date ) {
        $('#search-date').addClass("hide").removeClass("message-color").html("Ngày bắt đầu phải nhỏ hơn ngày kết thúc.");
        $('#search-date').removeClass("hide").addClass("message-color").innerHTML = "html";
        $('#before_date-kvdate').addClass("has-error");
        $('#after_date-kvdate').addClass("has-error");      
        $(':input[type="submit"]').prop('disabled', true);

    }
    else{
        $('#search-date').addClass("hide").removeClass("message-color");
        $(':input[type="submit"]').prop('disabled', false);
        $('#before_date-kvdate').removeClass("has-error");
        $('#after_date-kvdate').removeClass("has-error");
    }
};

$('#before_date').on('change keyup click', function(){
    var before_date_search = $(this).val();
    var after_date_search = document.getElementById('after_date').value;
    searchValidate(before_date_search, after_date_search);
})
$('#after_date').on('change keyup click', function(){
    var after_date_search = $(this).val();
    var before_date_search = document.getElementById('before_date').value;
    searchValidate(before_date_search, after_date_search);
});

function text_diff(first, second) {
        var start = 0;
        while (start < first.length && first[start] == second[start]) {
            ++start;
        }
        var end = 0;
        while (first.length - end > start && first[first.length - end - 1] == second[second.length - end - 1]) {
            ++end;
        }
        end = second.length - end;
        return second.substr(start, end - start);
}
$('#before_date').bind('paste', function() {
    var self = $(this);
    var orig = self.val();
    setTimeout(function() {
        var before_date_search = text_diff(orig, $(self).val());
        var after_date_search = document.getElementById('after_date').value;
        searchValidate(before_date_search, after_date_search);
    });
});
$('#after_date').bind('paste', function() {
    var self = $(this);
    var orig = self.val();
    setTimeout(function() {
        var after_date_search = text_diff(orig, $(self).val());
        var before_date_search = document.getElementById('before_date').value;
        searchValidate(before_date_search, after_date_search);
    });
});
//
$(".dropdown-toggle").dropdown();
