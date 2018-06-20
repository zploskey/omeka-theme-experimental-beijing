(function($) {
    $(function() {
        var jcarousel = $('.jcarousel');

        jcarousel
            // Set carousel height to the target image's li height.
            .on('jcarousel:targetin jcarousel:reload', 'li', function() {
              jcarousel.height($(this).height());
            })
            .jcarousel({
                wrap: 'circular'
            });

        $('.jcarousel-control-prev')
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next')
            .jcarouselControl({
                target: '+=1'
            });

        $('.jcarousel-pagination')
            .on('jcarouselpagination:active', 'a', function() {
                $(this).addClass('active');
            })
            .on('jcarouselpagination:inactive', 'a', function() {
                $(this).removeClass('active');
            })
            .on('click', function(e) {
                e.preventDefault();
            })
            .jcarouselPagination({
                perPage: 1,
                item: function(page) {
                    return '<a href="#' + page + '">' + page + '</a>';
                }
            });

        function resizeCarousel() {
            jcarousel.height($('.jcarousel li:first').height());
        }

        $(window).load(resizeCarousel);
        $(window).resize(resizeCarousel);

    });
})(jQuery);
