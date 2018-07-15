$(document).ready(function () {
    $(".open_responsive").on("click", function () {
        $('.responsive_menu').slideToggle('slow');
    });
    $(".open_responsive_fixed").on("click", function () {
        $('.responsive_menu_fixed').slideToggle('slow');
    });
    $('.menu_element a').smoothScroll();

    $('.menu_element a').click(function (event) {
        event.preventDefault();
        var link = this;
        $.smoothScroll({
            scrollTarget: link.hash
        });
    });
    $('.menu_fixed a').smoothScroll();

    $('.menu_fixed a').click(function (event) {
        event.preventDefault();
        var link = this;
        $.smoothScroll({
            scrollTarget: link.hash
        });
    });

    $('.responsive_menu_fixed a').smoothScroll();
    $('.responsive_menu_fixed a').click(function (event) {
        event.preventDefault();
        var link = this;
        $.smoothScroll({
            scrollTarget: link.hash
        });
    });
    $('.responsive_menu a').smoothScroll();
    $('.responsive_menu a').click(function (event) {
        event.preventDefault();
        var link = this;
        $.smoothScroll({
            scrollTarget: link.hash
        });
    });
    $('.responsive_menu').on('click', 'a', function () {
        $('.responsive_menu').toggle();
    });
    $('.responsive_menu').on({
        'touchstart': function () {
            $('.responsive_menu').toggle();
        }
    });
    $('.responsive_menu').on({
        'touchstart': function () {
            $('.responsive_menu').toggle();
        }
    });
});

$(document).on('scroll', function () {
    if ($('.menu').length) {
        if (!$('.menu').isOnScreen() && !$('.l_logo').isOnScreen()) {
            $('.menu_fixed').show();
        } else {
            $('.menu_fixed').hide();
        }
    }
    if ($('.page_menu').length) {
        if (!$('.page_menu').isOnScreen() && !$('.l_logo').isOnScreen()) {
            $('.menu_fixed').show();
        } else {
            $('.menu_fixed').hide();
        }
    }
    if (!$('.open_responsive').isOnScreen() && !$('.l_logo').isOnScreen()) {
        $('.open_responsive_fixed').css({
            'display': 'inline-block',
        });
    } else {
        $('.open_responsive_fixed').css({
            'display': 'none',
        });
    }
});

$.fn.isOnScreen = function () {
    var viewport = {};
    viewport.top = $(window).scrollTop();
    viewport.bottom = viewport.top + $(window).height();
    var bounds = {};
    bounds.top = this.offset().top;
    bounds.bottom = bounds.top + this.outerHeight();
    return ((bounds.top <= viewport.bottom) && (bounds.bottom >= viewport.top));
};