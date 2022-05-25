$(window).add(document).on('ready load resize', function () {
    var windowWidth = $(window).width(),
        $body = $('body').removeClass('is-desktop is-tablet is-mobile');

    if (windowWidth >= 1024) {
        $body.addClass('is-desktop');
    } else if (windowWidth >= 769) {
        $body.addClass('is-tablet');
    } else {
        $body.addClass('is-mobile');
    }
});
