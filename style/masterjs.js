function password(params) {
	if
}
function empty(elment) {
	if (typeof element.value.trim() === 'undefined')
		alert("Element is requird");
	if (element.n) {
		
	}
}

var reg_fname = document.getElementById(reg_fname);
reg_fname.addEventListener("onblur", empty(reg_fname));
var reg_sname = document.getElementById(reg_sname);
reg_sname.addEventListener("onblur", empty(reg_sname));
var reg_email = document.getElementById(reg_email);
reg_email.addEventListener("onblur", empty(reg_email));
var reg_password1 = document.getElementById(reg_password1);
reg_password1.addEventListener("onblur", empty(reg_password1));
var reg_password2 = document.getElementById(reg_password2);
reg_password2.addEventListener("onblur", function (params) {
	password(reg_password2, reg_password2)
	empty(reg_password2);
});

var loginEmail = document.getElementById(loginEmail);
loginEmail.addEventListener("onblur", empty(loginEmail));
var loginPassword = document.getElementById(loginPassword);
loginPassword.addEventListener("onblur", empty(loginPassword));