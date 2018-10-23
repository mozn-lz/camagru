// document.getElementById("main").addEventListener("click", alert("js words\nI am sure") );
function validateRegForm() {
	var errLog = "";
	var errCnt = 0;
	var reg_uName = document.getElementById("reg_uName").value;
	var reg_fName = document.getElementById("reg_fName").value;
	var reg_sName = document.getElementById("reg_sName").value;
	var reg_email = document.getElementById("reg_email").value;
	var password1 = document.getElementById("password1").value;
	var password2 = document.getElementById("password2").value;
alert("krf");
	if (empty(reg_uName.trim())){
		errCnt++;
		errLog = errLog + "User name is empty\n";
	}
	if (empty(reg_fName.trim())){
		errCnt++;
		errLog = errLog + "First name is empty\n";
	}
	if (empty(reg_sName.trim())){
		errCnt++;
		errLog = errLog + "Surname is empty\n";
	}
	if (empty(reg_email.trim())){
		errCnt++;
		errLog = errLog + "Email is empty\n";
	}
	if (empty(password1.trim())){
		errCnt++;
		errLog = errLog + "Password1 is empty\n";
	}
	if (empty(password2.trim())){
		errCnt++;
		errLog = errLog + "Password2 is empty\n";
	}
	if (!empty(password1.trim()) && !empty(password2.trim()))
		if( password1 !== password2) {
		errCnt++;
		errLog = errLog + "Passwords Do not match\n";
	}
	if (errCnt == 0) {
		return (true);
	}
	alert(errCnt + "errors detected!\n" + errLog);
	return (false);
}
