$(window).add(document).on('ready load resize DOMSubtreeModified', function () {
    let windowWidth = $(window).width(),
        $body = $('body').removeClass('is-desktop is-tablet is-mobile');

    if (windowWidth >= 1024) {
        $body.addClass('is-desktop');
    } else if (windowWidth >= 769) {
        $body.addClass('is-tablet');
    } else {
        $body.addClass('is-mobile');
    }
});

$(document).ready(function () {
    /**
     * Init jQuery UI plugins
     */
    $('.ui-sortable').sortable();
});
