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

  });

}());