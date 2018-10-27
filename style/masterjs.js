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

// for taking pictues

var videoObj    = { "video": true },
    errBack        = function(error){
        // alert("Video capture error: ", error.code);
    };

// Ask the browser for permission to use the Webcam
if(navigator.getUserMedia){                    // Standard
    navigator.getUserMedia(videoObj, startWebcam, errBack);
}else if(navigator.webkitGetUserMedia){        // WebKit
    navigator.webkitGetUserMedia(videoObj, startWebcam, errBack);
}else if(navigator.mozGetUserMedia){        // Firefox
    navigator.mozGetUserMedia(videoObj, startWebcam, errBack);
};

function startWebcam(stream){

    var myOnlineCamera    = getElementById('myOnlineCamera'),
        video            = myOnlineCamera.querySelectorAll('video'),
        canvas            = myOnlineCamera.querySelectorAll('canvas');

    video.width = video.offsetWidth;

    if(navigator.getUserMedia){                    // Standard
        video.src = stream;
        video.play();
    }else if(navigator.webkitGetUserMedia){        // WebKit
        video.src = window.webkitURL.createObjectURL(stream);
        video.play();
    }else if(navigator.mozGetUserMedia){        // Firefox
        video.src = window.URL.createObjectURL(stream);
        video.play();
    };

    // Click to take the photo
    $('#webcam-popup .takephoto').click(function(){
        // Copying the image in a temporary canvas
        var temp = document.createElement('canvas');

        temp.width  = video.offsetWidth;
        temp.height = video.offsetHeight;

        var tempcontext = temp.getContext("2d"),
            tempScale = (temp.height/temp.width);

        temp.drawImage(
            video,
            0, 0,
            video.offsetWidth, video.offsetHeight
        );

        // Resize it to the size of our canvas
        canvas.style.height    = parseInt( canvas.offsetWidth * tempScale );
        canvas.width        = canvas.offsetWidth;
        canvas.height        = canvas.offsetHeight;
        var context        = canvas.getContext("2d"),
            scale        = canvas.width/temp.width;
        context.scale(scale, scale);
        context.drawImage(bigimage, 0, 0);
    });
};