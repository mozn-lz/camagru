let width = 500,
    height = 0,
    filter = 'none',
    streaming = false;

const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photos = document.getElementById('photos');
const photoButton = document.getElementById('photo-button');
const clearButton = document.getElementById('clear-button');
const photoFiller = document.getElementById('photo-filler');

navigator.mediaDevices.getUserMedia({video: true, audio: false})
.then(function(stream) {
    // Link to video source
    video.srcObject = stream;
    // Play video
    video.play();
})
.catch(function (err) {
    console.log(`Error: ${err}`);
});

// Play when ready 
video.addEventListener('canplay', function (e) {
    if(!streaming) {
        height = video.videoHeight / (video.videoWidth/ width);
        video.setAttribute('width', width);
        video.setAttribute('height', height);
        canvas.setAttribute('width', width);
        canvas.setAttribute('height', height);

        streaming = true;
    }
}, false);
// Photo button Event Listener
photoButton.addEventListener('click', function (e) {
    takePicture();
    e.preventDefault();
}, false);

function takePicture() {
    // Create Canvas
    const context = canvas.getContext('2d');
    if (width && height) {
        canvas.width = width;
        canvas.height = height;
        // Draw image of the video on the canvas
        context.drawImage(video, 0, 0, width, height);

        // Create image from canvas
        const imgUrl = canvas.toDataURL('image/png');
        // Creane image element
        const img = document.createElement('img');
        img.setAttribute('src', imgUrl);

        photos.appendChild(img);
    }
}

/**/
/*     set select to overlay */
/**/


function set_overlay(ova) {
    document.getElementById('image').src=ova;
}

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