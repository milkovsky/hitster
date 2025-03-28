(function () {
  document.addEventListener("DOMContentLoaded", function() {
    let songUri = 'spotify:track:0VfXQxbM0doaDw2fMI8Ima?si=ce8dd0d2e33a4344';

    class HirsterPlayer {

      constructor(controller) {
        let self = this;

        this.spotifyController = controller;
        this.spotifyController.addListener('ready', () => {
          this.showPlayer();
        });

        this.play = document.getElementById('play-track');
        this.pause = document.getElementById('pause-track');
        this.player = document.getElementById('player');
        this.loading = document.getElementById('loading');

        this.play.addEventListener("click", function() {
          self.playTrack();
        });
        this.pause.addEventListener("click", function() {
          self.pauseTrack();
        });
      }

      showPlayer = function() {
        this.player.style.display = 'block';
        this.loading.style.display = 'none';
      }

      playTrack = function() {
        if (this.spotifyController) {
          this.spotifyController.play();
          this.play.style.display = 'none';
          this.pause.style.display = 'inline-block';
        }
      }

      pauseTrack = function() {
        if (this.spotifyController) {
          this.spotifyController.pause();
          this.play.style.display = 'inline-block';
          this.pause.style.display = 'none';
        }
      }

    }

    window.onSpotifyIframeApiReady = (IFrameAPI) => {
      const element = document.getElementById('spotify-player');
      const options = {
      uri: songUri,
    };	
      if (window.location.search === '?secrets') {	
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