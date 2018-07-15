$(document).ready(function() {
	
	
	$('#to').datepicker({
		   format: 'yyyy-mm-dd'
	});
	
	
	$('#from').datepicker({
	      format: 'yyyy-mm-dd'
	});
	
	  var admin_table =  $('#admin_table').DataTable({
	        responsive: true,
	        "order": [[ 0, "desc" ]],
	        
	    
	    });
	   
	
	
   var table =  $('#mytable').DataTable({
        responsive: true,
        "order": [[ 1, "desc" ]],
        
    
    });
   
  
   table.columns( '.select-filter' ).every( function () {
	    var that = this;
	 
	    // Create the select list and search operation
	    var select = $('<select />')
	        .appendTo(
	            this.footer()
	        )
	        .on( 'change', function () {
	            that
	                .search( $(this).val() )
	                .draw();
	        } );
	 
	    // Get the search data for the first column and add to the select list
	    this
	        .cache( 'search' )
	        .sort()
	        .unique()
	        .each( function ( d ) {
	            select.append( $('<option value="'+d+'">'+d+'</option>') );
	        } );
	} );
      
    $('#search-user').on( 'change', function () {
        table
            .columns( 2)
            .search($("#search-user :selected").val())
            .draw();
       
    } );
    
    $('#search-product').on( 'change', function () {
        table
            .columns( 3)
            .search($("#search-product :selected").val())
            .draw();
    
    } );
    
    $('#search-brand').on( 'change', function () {
        table
            .columns( 4)
            .search($("#search-brand :selected").val())
            .draw();
       
    } );
    $('#search-price').on( 'change', function () {
        table
            .columns( 5)
            .search($("#search-price :selected").val())
            .draw();
      
    } );
    $('#search-discount').on( 'change', function () {
        table
            .columns(6)
            .search($("#search-discount :selected").val())
            .draw();
      
    } );
    $('#search-country').on( 'change', function () {
        table
            .columns( 7)
            .search($("#search-country :selected").val())
            .draw();
      
    } );

    $('#search-city').on( 'change', function () {
        table
            .columns( 8)
            .search($("#search-city :selected").val())
            .draw();
    } );
    
    $('#search-zip').on( 'change', function () {
        table
            .columns( 9)
            .search($("#search-zip :selected").val())
            .draw();
      
    } );

    $('#search-deliverey-type').on( 'change', function () {
        table
            .columns( 10)
            .search($("#search-deliverey-type :selected").val())
            .draw();
    } );

    $('#search-payment-type').on( 'change', function () {
        table
            .columns( 11)
            .search($("#search-payment-type :selected").val())
            .draw();
      
    } );

    $('#search-vet').on( 'change', function () {
        table
            .columns( 12)
            .search($("#search-vet :selected").val())
            .draw();
      
    } );

    $('#search-delivered').on( 'change', function () {
        table
            .columns( 14)
            .search( this.value )
            .draw();
      
    } );
    $('#search-paid').on( 'change', function () {
        table
            .columns( 13)
            .search( this.value )
            .draw();
      
    } );
    $("#productcategoryid").on('change', function(){
        var pid = $(this).val();
  
        
        $.ajax({
            url : '/shop/admin/warehouse/a_getproducts',
            type : 'post',
            data : 'productcategoryid=' + pid,
            success : function(res){
               
                $('#productid').find('option').remove().end();
                $('#count').val(0);
                
                var products = $.parseJSON(res); 
               
                var options;
                $("#productid").append($('<option>', {value:0, text:'-'}));
                $.each(products, function(k, v){
                    
                    options =  $('<option>').val(v.id).text(v.name);
                    $(options).appendTo($("#productid"));
                });
           
            },
            error : function(err) {
                console.log(err);
            }
        });
    });
    
    
    $("#productid").on('change', function(){
        var pid = $(this).val();
 
        $.ajax({
            url : '/shop/admin/warehouse/a_getproductcount',
            type : 'post',
            data : 'productid=' + pid,
            success : function(res){
               
                var product = $.parseJSON(res); 
                $('#count').val(product.count);
                $("#instockcount").html(product.count);
           
            },
            error : function(err) {
                console.log(err);
            }
        });
    });

        
    $("#fadeSuccess").fadeOut(5000);
    
} );

$(".paidclass").click(function(){
    var ajdi=$(this).attr('data-paidinvoice');

    $.ajax({
        url : '/shop/admin/orders/paidornot',
        type : 'post',
        data : {orderid:ajdi},
        success : function(res){
            $(".paidresponse"+ajdi).html(res);
            if(res=='Yes'){
                $(".paidresponsetd"+ajdi).parent().removeClass('danger').addClass('success');
                $(".paidresponse"+ajdi).removeClass('btn-danger').addClass('btn-success');
            } else {
                $(".paidresponsetd"+ajdi).parent().removeClass('success').addClass('danger');
                $(".paidresponse"+ajdi).removeClass('btn-success').addClass('btn-danger');
            }
        }
    });

})

$(".statusclass").click(function(){
    var ajdi=$(this).attr('data-status');

    $.ajax({
        url : '/shop/admin/orders/status',
        type : 'post',
        data : {orderid:ajdi},
        success : function(res){
            $(".statusresponse"+ajdi).html(res);
            if(res=='Yes'){
                $(".statusresponse"+ajdi).removeClass('btn-danger').addClass('btn-success');
            } else {
                $(".statusresponse"+ajdi).removeClass('btn-success').addClass('btn-danger');
            }
        }
    });

})

function deleteItem(controller, id) {
    
    if (confirm('Are you sure you want to delete this item?')) {
       // alert('yes');
        
        window.location.href = "/shop/admin/" + controller + "/delete/" + id;
    }
}
