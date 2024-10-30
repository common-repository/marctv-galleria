(function ($) {

    $(document).ready(function ($) {

        var thumbnails = true;
        var height = 0.53;
        var linksize = marctvgalleriajs.linksize;

        var fullscreen = 'full';

        if ($(window).width() < marctvgalleriajs.breakpoint ) {
            linksize = marctvgalleriajs.breaksize;
            fullscreen = marctvgalleriajs.fullscreen;
            thumbnails = false;
            height = 0.43;
            $("body").addClass('no-thumbnails');
        }



        if ($(".marctv-gallery").length > 0) {

            var gaEvent = function (category, action, label) {

                if (window._gaq && _gaq.push) {
                    _gaq.push(['_trackEvent', category, action, label]);
                }

                if (window.ga && ga.create) {
                    ga('send', 'event', {
                        eventCategory: category,
                        eventAction: action,
                        eventLabel: label
                    });
                }
            };

            Galleria.loadTheme('/wp-content/plugins/marctv-galleria/galleria/themes/classic/galleria.classic.js');

            $(".marctv-gallery").galleria({
                width: "auto",
                height: height,
                idleMode: true,
                responsive: true,
                preload: 2,
                idleTime: 2000,
                initialTransition: "none",
                debug: false,
                showInfo: true,
                imageCrop: true,
                fullscreenCrop: true,
                trueFullscreen: true,
                fullscreenDoubleTap: true,
                thumbnails: thumbnails,
                dataConfig: function (img) {
                    return {
                        title: $(img).attr('title'),
                        description: $(img).parents('.gallery-item').find('.gallery-caption').text(),
                        image: $(img).data(linksize),
                        thumb: $(img).data("thumbnail"),
                        big: $(img).data(fullscreen)
                    };

                },
                extend: function () {

                    var gallery = this;

                    gallery.addElement('info-fullscreen');
                    gallery.append({
                        'container': ['info-fullscreen']
                    });

                    this.bind("image", function(e) {

                        var num = e.index.toString()

                        if(e.index > 0){
                            gaEvent('galleria','image_clicked',num);
                        }
                    });

                    gallery.$('info-fullscreen').click(function () {
                        gallery.toggleFullscreen(); // toggles the fullscreen
                        gaEvent('galleria','fullscreen_toggle','');
                    });

                }
            });

        }
    });
})(jQuery);
