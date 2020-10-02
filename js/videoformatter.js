(function (Drupal, $) {

  'use strict';

  Drupal.behaviors.iq_video_thumbnail = {
    attach: function (context, settings) {

      $(document).ready(function() {
    
        var video_wrapper = $('.yt-video-embed', context);
        // Check to see if youtube wrapper exists
        if (video_wrapper.length) {
          // If user clicks on the video wrapper load the video.
          video_wrapper.on('click', function(){
            // Load iframe on click of thumbnail.
            // Pull the youtube url and title from the data attributes on the wrapper element.
            $(this).html('<div class="iframe-responsive"><iframe allowfullscreen frameborder="0" class="embed-responsive-item" src="' +  $(this).data('yt-url') + '" title="' +  $(this).data('yt-title') + '"></iframe></div>');
          });
        }

      });
    }
  }

}(Drupal, jQuery));
