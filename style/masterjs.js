

/**/
/*     set select to overlay */
/**/

var overlay_options = document.getElementById('photo_overlay');

function set_overlay(ova) {
	console.log(ova);

	document.getElementById('image').src = ova;
}

overlay_options.addEventListener('change', function (e) {
	
	switch (document.getElementById().value) {
		case "https://dumielauxepices.net/sites/default/files/catwoman-clipart-face-883550-3607898.png":
		set_overlay("https://dumielauxepices.net/sites/default/files/catwoman-clipart-face-883550-3607898.png");
		break;
		case "http://shopforclipart.com/images/funny-face-clipart/20.jpg":
		set_overlay("http://shopforclipart.com/images/funny-face-clipart/20.jpg");
		break;
		case "http://www.transparentpng.com/thumb/anonymous-mask/face-mask-funny-fear-nickname-face-anonymous-mask-png-images--15.png":
		set_overlay("http://www.transparentpng.com/thumb/anonymous-mask/face-mask-funny-fear-nickname-face-anonymous-mask-png-images--15.png");
		break;
		case "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRbZ-iwDmJ742m1J2SudaOQJ7qbCLdEruSfTQYoZOPVf6yR8y_Z4Q":
		set_overlay("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRbZ-iwDmJ742m1J2SudaOQJ7qbCLdEruSfTQYoZOPVf6yR8y_Z4Q");
		break;
		case "https://png.pngtree.com/element_pic/16/12/01/5b3008293536496b29c22ef56c3c9e92.jpg":
		set_overlay("https://png.pngtree.com/element_pic/16/12/01/5b3008293536496b29c22ef56c3c9e92.jpg");
		break;
		case "https://www.clipartmax.com/png/middle/18-187369_face-glasses-clipart-funny-face-icon-png.png":
		set_overlay("https://www.clipartmax.com/png/middle/18-187369_face-glasses-clipart-funny-face-icon-png.png");
		break;
		
		default:
		break;
	}
}, false);