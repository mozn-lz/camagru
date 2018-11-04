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

clearButton.addEventListener('change', function (e) {
    photos.innerHTML = '';
    
});
