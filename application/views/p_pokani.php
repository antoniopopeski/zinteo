<script>
FB.init({
	appId  : '648648968491961',
	status : true,
	cookie : true,
	frictionlessRequests: true, 
	oauth: true,
	//xfbml  : false
});

function pokani()
{
	FB.ui({
	method: 'apprequests',
	filters: ['app_non_users'],<?php
	if(isset($vekjePokaneti) && !empty($vekjePokaneti))
	{
		$lista = ",";
		foreach($vekjePokaneti as $p)
		{
			$lista .= $lista.$p->id.",";
		}
		$lista = trim($lista, ',');
		echo "exclude_ids : [".$lista."],";
	}?>
	//display: 'popup',
	//data: <?php echo $user->fb_id; ?>,
	message: "I'm playing betting game, will you join me and win some awesome prizes..",
	redirect_uri: "<?php echo base_url();?>"
		/*"http://test.tztdevelop.com/fblogin/invite/<?php echo $user->fb_id; ?>/"*/
	}, snimiPokani);
}
function snimiPokani(response) {
	$.ajax({
		url: "<?php echo base_url('ajax/pokaneti');?>",
		type: "POST",
		data: {"data": response},
		error: function()
		{
			$('#rezultat').html("error");
		},
		success: function(data)
		{
			$('#rezultat').html(data);
		}
	});
}
</script>
<button onclick="pokani();">Invite friends</button>
<div id="rezultat"></div>