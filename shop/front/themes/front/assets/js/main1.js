$(document).ready(function() {
    $(".open_responsive").on("click", function() {
        $('.responsive_menu').slideToggle('slow');
    });
    $('.wrapper').on('click', '.ask_expert_btn', function() {
        var $doc = $(document),
            $win = $(window),
            $this = $('.contact_form'),
            offset = $this.offset(),
            dTop = offset.top - $doc.scrollTop(),
            dBottom = $win.height() - dTop - $this.height(),
            dLeft = offset.left - $doc.scrollLeft(),
            dRight = $win.width() - dLeft - $this.width();
        $('.contact_form').fadeIn();
    });
    $('.wrapper').on('click', '.send_q', function() {
        $('.contact_form').fadeOut();
    });
    $(".open_responsive_fixed").on("click", function() {
        $('.responsive_menu_fixed').slideToggle('slow');
    });
    $('.external_link').smoothScroll();

    $('.external_link').click(function(event) {
        event.preventDefault();
        var link = this;
        
        $.smoothScroll({
            scrollTarget: link.hash
        });
    });
 

    $('.responsive_menu_fixed a').smoothScroll();
    $('.responsive_menu_fixed a').click(function(event) {
        event.preventDefault();
        var link = this;
        $.smoothScroll({
            scrollTarget: link.hash
        });
    });
    $('.responsive_menu a').smoothScroll();
    $('.responsive_menu a').click(function(event) {
        event.preventDefault();
        var link = this;
        $.smoothScroll({
            scrollTarget: link.hash
        });
    });
    $('.responsive_menu').on('click', 'a', function() {
        $('.responsive_menu').toggle();
    });
    $('.responsive_menu').on({
        'touchstart': function() {
            $('.responsive_menu').toggle();
        }
    });
    $('.responsive_menu').on({
        'touchstart': function() {
            $('.responsive_menu').toggle();
        }
    });
});

$(document).on('scroll', function() {
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



$.fn.isOnScreen = function() {
    var viewport = {};
    viewport.top = $(window).scrollTop();
    viewport.bottom = viewport.top + $(window).height();
    var bounds = {};
    bounds.top = this.offset().top;
    bounds.bottom = bounds.top + this.outerHeight();
    return ((bounds.top <= viewport.bottom) && (bounds.bottom >= viewport.top));
};