$(document).ready(function(){


//$(document).ready(function(){
//  
//    // Toggle Nav on Click
//    $('.fa').click(function() {
//    $('ul').toogle();
//    
//    
//   }); 
//});

//         $(document).ready(function() {
//
//            $(".fa").click(function(){
//               $("ul").slideToggle( 'slow', function(){ 
//                 
//               });
//            });
//         });
function togle() {
    if ( ! $('.header ul').is(':visible') ) {
        $(".header ul").slideDown("slow");
    } else {
        $(".header ul").slideUp("slow");
    }
}

function submitSearchForm(){
	$("#search-form").submit();
}
$(function(){
	
	
	//search
	$(".filter").click(function(e){
		//e.preventDefault();
		
		var cls = $(this).attr('class');
		
		var filter_class = cls.split(" ").pop();
		
		if (filter_class =='show_all' || filter_class =='only_dogs' || filter_class == 'only_cats') {
			$("#first_filter").val(filter_class);
		}  
		
		if (filter_class == 'date' || filter_class =='name' || filter_class=='price_asc' || filter_class=='price_desc') {
			$("#last_filter").val(filter_class);
		}
		
				
		$("#search-form").submit();
	})

	$(".filter_main").click(function(e){
		var brand_id = $(this).attr('data-brandid');
		$("#brand").val(brand_id);
		$("#search-form").submit();
	})

	$("#brands").on('change', function(){
		brand_id=$("#brands :selected").val();
		$("#brand").val(brand_id);
		$("#search-form").submit();
	})
	// eof search
	
	
	$("#add-new-vet").click(function(e){
		e.preventDefault();
		
		$("#new-vet-insert").toggle();
	})
	
	$("#veterianid").select2();

		
	$("#veterianid").change(function(){
		var id = $(this).val();
		$.ajax({
			url : "http://vetshop.maloto.pw/shop/getvetinfo",
			type : "post",
			data : "id=" + id,
			success : function(res) {
				$("#city").val(res);
			},
			error : function(err) {
				console.log(err);
			}
		});
	})
	
	 
	
	$("#new-user").click(function(){
		$("#password").attr("disabled", true);
		$("#button-login").text("Register");
	})
	
	$("#existing-user").click(function(){
		$("#password").attr("disabled", false);
		$("#button-login").text("Login");
	})

	$("#countryid").change(function(){
		
		var cid = $(this).val();
		
		$.ajax({
			
			url : '/shop/user/dashboard/getcities',
		type : 'post',
			data : 'countryid=' + cid,
		success : function(res) {
			console.log(res);
			},
			error : function(err) {
				console.log(err);
			}
			
		});
	}).trigger('change');
});




	
function togle() {
    if ( ! $('.header ul').is(':visible') ) {
        $(".header ul").slideDown("slow");
    } else {
        $(".header ul").slideUp("slow");
    }
}
$(".wrapper .header ul li a").on('click', function(){
     $(this).addClass("changeColor");
  });

});
