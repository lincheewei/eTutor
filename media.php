<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>RTC Playround</title>
    </head>
    <body>
        <video id="video" src="" autoplay >

        </video>

        <video id="blob-video" controls>

        </video>

        <button id="record" name="button">start recording</button>
        <button id="stop" name="button">stop recording</button>
        <script type="text/javascript">
        var videoStream;
var recorder;
var isRecording = false
var blobsArray = [];
// A quick demo to see how to best store video data from mediarecorder API as chunks to be transported and played back later.

navigator.mediaDevices.getUserMedia({
    audio: true,
    video: true
    })
    .then(function (stream) {
    videoStream = stream;
    document.getElementById('video').srcObject = stream;
})

function videoDataHandler (event) {
    var blob = event.data;
    document.getElementById('blob-video').setAttribute('src', window.URL.createObjectURL(blob));
};

var createMediaPlayer = function () {
    window.recorder = new MediaRecorder(videoStream, {
        mimeType: 'video/webm'
    });
    window.recorder.ondataavailable = videoDataHandler;
};

var recordButton = document.getElementById('record');
recordButton.addEventListener('click', function (e) {
    isRecording = true;
    createMediaPlayer();
    window.recorder.start();
});

var stepButton = document.getElementById('stop');
stepButton.addEventListener('click', function (e) {
    isRecording = false;
    window.recorder.stop();
})
        </script>
    </body>
</html>