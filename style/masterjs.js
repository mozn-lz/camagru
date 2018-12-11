function confirmation() {
	var confirm = prompt("Are you ssure you want to delete your account?\nEnter your password");
	if (confirm != null) {
		document.getElementById("delete_user").value = "confirm"
	}
}

// const passwd = document.getElementById('reg_password1').value;
// passwd.addEventListner('blur', function () {
// 	if (passwd.length < 6) {
// 		alert("too_short");
// 		return("too_short");
// 	} else if (passwd.length > 50) {
// 		alert("too_long");
// 		return("too_long");
// 	} else if (passwd.search(/\d/) == -1) {
// 		alert("no_num");
// 		return("no_num");
// 	} else if (passwd.search(/[a-zA-Z]/) == -1) {
// 		alert("no_letter");
// 		return("no_letter");
// 	} else if (passwd.search(/[^a-zA-Z0-9\!\@\#\$\%\^\&\*\(\)\_\+\.\,\;\:]/) != -1) {
// 		alert("bad_char");
// 		return("bad_char");
// 	}
// 	alert("oukey!!");
// 	return("ok");
// });


