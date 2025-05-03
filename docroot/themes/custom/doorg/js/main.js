document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.region-header');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Check if the #vimeo-video element is present on the page
    const videoElement = document.querySelector("#vimeo-video");
    if (!videoElement) {
        return; // Exit if the element is not found
    }

    // Get Vineo video ID from the data-vimeo-id attribute
    const videoWrapper = document.getElementById('video-wrapper');
    const vimeoVideoId = videoWrapper.getAttribute('data-vimeo-idz');
    const vimeoPlayerCtrl = videoWrapper.getAttribute('data-vimeo-controls');
    const os = videoWrapper.getAttribute('data-ios');
    // Custom control buttons
    const playPauseBtn = document.getElementById('play-pause-btn');
    const playPauseIcon = document.getElementById('play-pause-icon');
    const muteUnmuteBtn = document.getElementById('mute-unmute-btn');
    const muteUnmuteIcon = document.getElementById('mute-unmute-icon');

    const playerCtrl = (vimeoPlayerCtrl =="4") ? true : false;
    const autoPlay = (vimeoPlayerCtrl =="2" || vimeoPlayerCtrl =="0") ? true : false;
    const mute = (vimeoPlayerCtrl =="3" || vimeoPlayerCtrl =="1") ? false : true;
    const looped = (vimeoPlayerCtrl =="3" || vimeoPlayerCtrl =="1") ? false : true;

    var options = {
        id: vimeoVideoId,
        loop: looped,
        autoplay: autoPlay,  // Autoplay the video
        muted: mute,  // Always start muted
        controls: playerCtrl  // Hide default Vimeo controls
    };



    // Define your Vimeo video ID
    //const vimeoVideoId = "1015292071";  // Replace with actual Vimeo video ID

    // Your Vimeo API access token
    const accessToken = "cdb1d632438615a4d89ce92429fb8c6d";  // Replace with actual OAuth token

    // Vimeo API endpoint for the video
    const vimeoApiUrl = `https://api.vimeo.com/videos/${vimeoVideoId}`;

    // Function to get the video URL from Vimeo API
    fetch(vimeoApiUrl, {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${accessToken}`
        }
    })
    .then(response => response.json())
    .then(data => {
        // Extract the link for the video file with HD quality (or choose other qualities)
        const videoUrl = data.files.find(file => file.quality === 'hd').link;

        // Set the video source in the <video> element
        videoElement.src = videoUrl;
        // Set the video to loop
        videoElement.loop = looped;
        // Set the video to autoplay
        videoElement.autoplay = autoPlay;
        // Set the video to muted
        videoElement.muted = mute;
    })
    .catch(error => console.error('Error fetching video:', error));

        // Initialize Vimeo Player
       // var player = new Vimeo.Player(videoElement, options);
        // Conditionally render Play/Pause button based on the flag
        //console.log(player);
        if (vimeoPlayerCtrl =="1" || vimeoPlayerCtrl =="3") {
            console.log('vimeoPlayerCtrl: ' + vimeoPlayerCtrl);
            playPauseBtn.style.display = 'block';  // Show play/pause button

            if (vimeoPlayerCtrl =="3") {
                muteUnmuteIcon.src = '/themes/custom/doorg/unmute.svg';  // Change to mute icon
            }

            // If the video plays to completion, reset the play button
            videoElement.addEventListener('ended', function(e) {
                playPauseIcon.src = '/themes/custom/doorg/play-2.svg';  // Change to play icon
            })
    
            playPauseBtn.addEventListener('click', function () {
                if (videoElement.paused) {
                    videoElement.play();
                    if (os == "1") {
                        playPauseIcon.src = '/themes/custom/doorg/play-2.svg';  // Change to play icon
                        videoElement.removeAttribute('style');
                    } else {
                        playPauseIcon.src = '/themes/custom/doorg/pause.svg';  // Change to pause icon
                    }
                    playPauseBtn.classList.remove('initial');
                } else {
                    videoElement.pause();
                    playPauseIcon.src = '/themes/custom/doorg/play-2.svg';  // Change to play icon
                }
            });
        }

        if (vimeoPlayerCtrl =="2" || vimeoPlayerCtrl =="3") {
            muteUnmuteBtn.style.display = 'block';  // Show mute/unmute button
    
            muteUnmuteBtn.addEventListener('click', function () {
                if (videoElement.muted) {
                    videoElement.muted = false;
                    muteUnmuteIcon.src = '/themes/custom/doorg/unmute.svg';  // Change to unmute icon
                } else {
                    videoElement.muted = true;
                    muteUnmuteIcon.src = '/themes/custom/doorg/mute.svg';  // Change to mute icon
                }
            });
        }

});

// Select all .media-hover-overlay elements
document.querySelectorAll('.media-hover-overlay').forEach(function(overlay) {
    // Add a click event listener to each overlay
    overlay.addEventListener('click', function() {
        // Find the sibling link by navigating to the previous sibling
        var link = overlay.previousElementSibling.querySelector('.field__item a');
        
        // Check if the link exists before triggering the click
        if (link) {
            link.click();
        }
    });
});

// Google map overlay
document.addEventListener('DOMContentLoaded', function() {
    if (!document.querySelector('.map-overlay')) {
        return; // Exit if the element is not found
    }
    const overlay = document.querySelector('.map-overlay');
    const overlayText = overlay.querySelector('.overlay-text');
  
    overlay.addEventListener('click', function() {
      if (overlay.classList.contains('collapsed')) {
        overlay.classList.remove('collapsed');
        overlayText.innerHTML = 'Open the map ▼';
      } else {
        overlay.classList.add('collapsed');
        overlayText.innerHTML = 'Close the map ▲';
      }
    });
  });

  document.addEventListener('DOMContentLoaded', function() {
    const lightbox = GLightbox({
      selector: '.glightbox',  // Target all links with the class 'glightbox'
      autoplayVideos: true
    });
  });