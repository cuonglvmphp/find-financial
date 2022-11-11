
$("#success-alert").hide();
$('select').on('input',function(e){
    $('#server_error').text('')
});

$('input').on('input',function(e){
    $('#server_error').text('')
});

$.validator.addMethod(
    "validateDob",
    function(value, element) {
        var re = /^([0]?[1-9]|[1][0-2])[./-]([0]?[1-9]|[1|2][0-9]|[3][0|1])[./-]([0-9]{4}|[0-9]{2})$/;
        return (this.optional(element) && value=="") || re.test(value);
    },
    "Invalid Date Of Birth"
);

$("#form2").validate({
    rules: {
        firstname: "required",
        lastname: "required",
        email: {
            required: true,
            email: true
        },
        gender: "required",
        dob: {
            required: true,
            validateDob: true
        },
        phone: "required",
        address: "required",
        city: "required",
        zip: "required",
        state: "required",
    },
    messages: {
        firstname: "Please enter your firstname",
        lastname: "Please enter your lastname",
        email: "Please enter a valid email address",
        gender: "Please choose your gender",
    },
    submitHandler: function(form) { 
        submitDataUser(form)
    }
});

function submitDataUser (form) {
   $('#cover-spin').css('display', 'block')
    var data = $('#form2').serialize();
    $.ajax({
        url: '../services/InsertDataLead.php',
        data: data,
        type: 'POST',
        success :  function(resp)
        {
            $('#cover-spin').css('display', 'none')
            if (resp.message === 'success') {
                setCookieUser(convertFormToJSON($('#form2')))
                $("#success-alert").fadeTo(2000, 500).slideUp(500, function() {
                    $("#success-alert").slideUp(500);
                });
            } else {
                $('#server_error').text(resp.message)
            }
        },
        error: function(jqXHR, textStatus, error){
            alert("Submit error, please try again!");
            $('#cover-spin').css('display', 'none')
            return false;
        },
    });
}

function setCookieUser (datas) {
    const gender = datas.gender === 0 ? "M" : "F"
    setss("f1", datas.email);
    setss("f2", datas.firstname);
    setss("f3", datas.lastname);
    setss("f4", gender);
    setss("f5", datas.address);
    setss("f6", datas.city);
    setss("f7", datas.state);
    setss("f8", datas.zip);
    setss("f9", datas.dob);
    setss("f10", datas.phone);
    setss("f11", datas.utm_source);
}

function convertFormToJSON(form) {
    const array = $(form).serializeArray();
    const json = {};
    $.each(array, function () {
      json[this.name] = this.value || "";
    });
    return json;
  }

// vanilla-masker
function inputHandler(masks, max, event) {
	var c = event.target;
	var v = c.value.replace(/\D/g, '');
	var m = c.value.length > max ? 1 : 0;
	VMasker(c).unMask();
	VMasker(c).maskPattern(masks[m]);
	c.value = VMasker.toPattern(v, masks[m]);
}

var telMask = ['(999) 999-9999', '(999) 999-9999'];
var tel = document.querySelector('#phone');
VMasker(tel).maskPattern(telMask[0]);
tel.addEventListener('input', inputHandler.bind(undefined, telMask, 10), false);


var dobMask = ['99-99-9999', '99-99-9999'];
var dob = document.querySelector('#dob');
VMasker(dob).maskPattern(dob[0]);
dob.addEventListener('input', inputHandler.bind(undefined, dobMask, 8), false);

var zipMask = ['99999-9999', '99999-9999'];
var zip = document.querySelector('#zip');
VMasker(dob).maskPattern(dob[0]);
zip.addEventListener('input', inputHandler.bind(undefined, zipMask, 9), false);
window.onunload = function(){};
