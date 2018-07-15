$(document).ready(function() {
    
    
    var count_h1 = $("#main_content_text").find("h1");
      
    //$("#main_content_text").find("h1").find("p").h
    
    var counter = 1;
    
  
    
    $('#main_content_text h1').each(function(){ 
        counter++;
        var $set = $(this).nextUntil("h1").andSelf();
        $set.wrapAll('<div class="hide_content" id="content_'+counter+'"/>');
    });
    
    
    
    $(".hide_content p").hide();
    $(".hide_content div").hide();
    
    
    
    $(".hide_content").click(function(){
        var id = $(this).attr('id');
        
        //$("#"+id).find("p").css("display","");
        $("#"+id).find("p").toggle();
        $("#"+id).find("div").toggle();
    })
    
    $(".logo_page").on("click", function() {
        var go_to_url = 'http://'+location.hostname;
  
  //this will redirect us in new tab
///  window.open(go_to_url);
        window.location.replace(go_to_url);
      // $(location).attr('href',location.hostname); 
      
     // console.log(location.hostname);
    });
	 $(".responsive_spans").on("click", function() {
	// $(".responsive_sub").css("display", "none");
	 $(this).nextAll('ul').eq(0).slideToggle('slow');
		//$(this).next('ul').show(500).css("display", "inline-block");
       // $('.responsive_sub').slideToggle('slow');
    });
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
        
        $("body").addClass("overlay-bg")
    });
    $('#contact-form-close').on('click', function(e) {
        e.preventDefault();
        $("body").removeClass("overlay-bg");
       $('.contact_form').fadeOut();
    });
    


    $("#contact-form-send").click(function(){
        
        var name = $("#contact_form_name").val();
        var email = $("#contact_form_email").val();
        var question = $("#contact_form_question").val();
        
        var data = {name : name,  email : email, quesiton : question};
        
        var site_name = 'http://vetfriend.maloto.pw/';
        
        $.ajax({
            url : site_name + 'page/contact',
            type : 'post',
            data : data,
           
            success : function(res) {
                $(".contact-form-message").show(); 
                
                setTimeout(function() {
                    $('.contact_form').fadeOut(1);
                    $("body").removeClass("overlay-bg");
              }, 5000);
            },
            error : function(err) {
                console.log(err);
            }
        }).done(function(){
            $(".contact-form-message").show(); 
            
            setTimeout(function() {
                $('.contact_form').fadeOut(1);
                $("body").removeClass("overlay-bg");
          }, 5000);
           
        });
       
      
      
       // console.log(name); console.log(email); console.log(question);
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