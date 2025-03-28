(function () {
  document.addEventListener("DOMContentLoaded", function() {
    const params = new URLSearchParams(window.location.search);
    if (!params.has('song-uri')) {
      document.getElementById('message').textContent = 'No song-uri was found.';
      return;
    }

    function convertSpotifyUrlToUri(url) {
      return url.replace("https://open.spotify.com/", "spotify:").replace(/track\//, 'track:');
    }

    let songUri = convertSpotifyUrlToUri(params.get('song-uri'));

    class HirsterPlayer {

      constructor(controller) {
        let self = this;

        this.spotifyController = controller;
        this.spotifyController.addListener('ready', () => {
          this.showPlayer();
        });

        this.play = document.getElementById('play-track');
        this.player = document.getElementById('player');
        this.message = document.getElementById('message');

        this.play.addEventListener("click", function() {
          self.playTrack();
        });
        this.pause.addEventListener("click", function() {
          self.pauseTrack();
        });
      }

      showPlayer = function() {
        this.player.style.display = 'block';
        this.message.style.display = 'none';
      }

      playTrack = function() {
        if (this.spotifyController) {
          this.spotifyController.togglePlay();
        }
      }
    }

    window.onSpotifyIframeApiReady = (IFrameAPI) => {
      const element = document.getElementById('spotify-player');
      const options = {
      uri: songUri,
    };	
      if (params.has('secrets')) {	
        document.getElementById('player-wrapper').style.visibility = 'visible';
      }
      else {
        options.width = 0;
        options.height = 0;	
      }
      IFrameAPI.createController(element, options, (controller) => {
        let player = new HirsterPlayer(controller);
      });
    };

    // QR-Code reader.
    let html5QrCode = null; 
    document.getElementById('scan-code').addEventListener("click", function() {
      let readerWrapper = document.getElementById('reader-wrapper');
      if (readerWrapper.style.display === 'none') {
        readerWrapper.style.display = 'block';

        html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start(
          {
            facingMode: "environment" // Uses external camera.
          },
          {
              fps: 10, // Frames per second.
              qrbox: 250, // Scanning area size.
          },
          (decodedText, decodedResult) => {
            if (decodedText.startsWith(window.location.hostname)) {
              window.location.href(decodedText);
            }
          },
          (errorMessage) => {
              // Scanning error.
              console.log(errorMessage);
          }
        ).catch(err => {
            console.log('Can not connect camera!', err);
        });
      }
       else {
         if (html5QrCode) {
          html5QrCode.stop();
         }
        readerWrapper.style.display = 'none';
      }
    });

    

  });

}());