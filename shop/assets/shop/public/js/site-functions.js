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




$(function(){
	$("#new-user").click(function(){
		$("#password").attr("disabled", true);
	})
	
	$("#existing-user").click(function(){
		$("#password").attr("disabled", false);
	})
	
	$("#countryid").change(function(){
		
		var cid = $(this).val();
		
		$.ajax({
			
			url : '/user/dashboard/getcities',
		type : 'post',
			data : 'countryid=' + cid,
		success : function(res) {
			console.log(res);
			},
			error : function(err) {
				console.log(err);
			}
			
		});
	})
	 // $(".js-example-basic-single").select2();
	


	
	
	
	
	
	
	
	
	
	
	
	
	
	
})