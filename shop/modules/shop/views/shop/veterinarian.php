<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>	
<script>

</script>
<main>
<div class="title">
	<h2><?php echo lang("Veterenian")?></h2>
	<a href="<?php echo base_url()?>shop/veterinarian/1" style="padding: 10px 0px 0px !important;"><?php echo lang("Skip this")?></a>
</div>
<form class="form-horizontal" method="post">
	<div class="form-group">
		<label for="" class="col-sm-3 control-label"><?php echo lang("Who is your veterinarian?")?></label>
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<select name="veterianid" id="veterianid" class="form-control">
		           		<option value="">-</option>
                       <?php foreach ($vets as  $v) {?>
                       	<option value="<?php echo $v->getId()?>"><?php echo $v->getName()?> <?php echo $v->getLastName()?>, <?php echo $v->getCity()?></option>
                       <?php }?>
                       </select>
		</div>
	</div>
	 
	<div class="form-group">
		
		<label for="inputPassword3" class="col-sm-3 control-label"></label>
		<label for="inputPassword3" class="col-sm-9 control-label" style="text-align: left;"><?php echo lang("Your veterenian is not on the list?")?> 
		<a href="#" style="font-size:inherit!important;color:#736049!important;padding: 5px;text-decoration:underline;" class="control-label" id="add-new-vet"><?php echo lang("Click here to add new veterenian.")?></a></label>
		
	</div>
	
		
	<div id="new-vet-insert" style="display:none">
	<hr/>
	
		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label"><?php echo lang("Country")?>?</label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<select name="country" id="country" class="form-control">
		           	<option value="0">-</option>
		           <?php foreach ($countries as $c) {?>
		           	<option value="<?php echo $c->getId();?>"><?php echo $c->getCountry();?></option>
		           <?php }?>
	           </select>
			</div>
		</div> 

		<div class="form-group">
			<label for="inputPassword3" class="col-sm-3 control-label"><?php echo lang("City")?>?</label>
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<select name="vetcity" id="city" class="form-control">
		           	<option value="0">-</option>
	           </select>
			</div>
		</div>

	<div class="form-group">
		<label for="inputPassword3" class="col-sm-3 control-label"><?php echo lang("Name")?>?</label>
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<input type="text" class="form-control" name="vetname" id="vetname"
				placeholder="">
		</div>
	</div>
	
	
<!-- 		<div class="form-group">
		<label for="inputPassword3" class="col-sm-3 control-label"><?php echo lang("City")?>?</label>
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<input type="text" class="form-control" name="vetcity" id="vetcity"
				placeholder="">
		</div>
	</div> -->
	
	</div>
	<div class="form-group">
		<label for="" class="col-sm-3 control-label"></label>
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<button class="btn-orange" type="submit"><?php echo lang("Continue")?></button>
		</div>

	</div>

</form>
</main>

<script type="text/javascript">
	$(".myaccount").click(function(e){
	e.preventDefault();
	$c = confirm("<?php echo lang("Are you sure to cancel payment process?")?>");

	if ($c == true )
	{
			window.location.href = "/shop/shop/myorders";
	}
	else 
	{
			return false;
	}
})

	$("#country").on('change', function(){
	var cid = $(this).val();
	$.ajax({
	    url : '/shop/shop/a_getCities',
	    type : 'post',
	    data : 'countryid=' + cid,
	    success : function(res){
	       
	        $('#city').find('option').remove().end();
	        $('#count').val(0);
	        
	        var products = $.parseJSON(res); 
	       
	        var options;
	        // $("#city").append($('<option>', {value:0, text:'-'}));
	        $.each(products, function(k, v){
	            
	            options =  $('<option>').val(v.id).text(v.city);
	            $(options).appendTo($("#city"));
	        });
	   
	    },
	    error : function(err) {
	        console.log(err);
	    }
	});
})

</script>