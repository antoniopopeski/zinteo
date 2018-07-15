<!DOCTYPE html>
<html lang="en" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<title>
	<?php
	if(isset($title))
		echo $title;
	else 
		echo "Zinteo";
	?>
	</title>
	<link rel="icon" type="image/png" href="<?php echo base_url();?>icon.png" />
	<link type="text/css" href="<?php echo base_url();?>css/vader/jquery-ui.min.css" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.ui.touch-punch.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui.min.js"></script>
	<link rel="Stylesheet" type="text/css" href="<?php echo base_url();?>css/default1.css" />
	<link rel="Stylesheet" type="text/css" href="<?php echo base_url();?>css/slicknav.css" />
	<link rel="Stylesheet" type="text/css" href="<?php echo base_url();?>css/component.css" />
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.datetimepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.form.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/modernizr.min.js"></script>
	<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-45926963-1', 'zinteo.com');
	  ga('send', 'pageview');
	</script>
	<?php
	if(isset($style))
	{
		echo '<link type="text/css" href="'.base_url()."css/".$style.'" rel="Stylesheet" >';
	}
	if(isset($js))
	{
		if($js == "tablesorter")
		{
		?>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.dataTables.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.dataTables.css">
		<?php
		}
		else
		{
			?>
		<script type="text/javascript" src="<?php echo base_url();?>js/<?php echo $js;?>"></script>
		<?php
		}
	}
	?>
	<style type="text/css">
	body
	{
		<?php if(file_exists("./images/background.jpeg")):?>
		background: url("<?php echo base_url();?>images/background.jpeg");
		<?php elseif (file_exists("./images/background.png")):?>
		background: url("<?php echo base_url();?>images/background.png");
		<?php endif;?>
		background-color: #2b2b2c;
		background-position: center top;
		background-repeat: no-repeat;
		background-attachment:fixed;
	}
	<?php if($this->uri->segment(1)=="home" || $this->uri->segment(1)=="balance" 
		|| $this->uri->segment(2)=="balance"):?>
	#podvizno, #homepage {
		background-color: transparent;
		background: url("/images/football_stadium_back.png");
		background-size: 100%;
		background-position: left top;
		background-repeat: no-repeat;
		background-attachment:fixed;
	}
	<?php endif;?>
	</style>
	<link href="<?php echo base_url();?>css/mQuery.css" rel="stylesheet" type="text/css">
	<script src="<?php echo base_url();?>js/respond.min.js"></script>
</head>
<body>
<div id="fb-root"></div>
<div id="contentWrapper">
	<div id="pageTitle"><?php echo (isset($title))?$title:''; ?></div>
	<?php if(isset($user) && ($this->uri->segment(1)=="matches" || $this->uri->segment(1)=="home")):?>
	<div class="maxTipovi"><?php echo (is_object($user))?(int)$user->bids + (int)$user->tmpBids:0;?></div>
	<?php endif;?>
	<?php //include "pub_header.php";?>
	<?php include "pub_nav.php";?>
	<div id="podvizno"><!--  --><?php include $content.EXT;?></div><!--  -->
	<?php if($this->uri->segment(1)=="matches" || $this->uri->segment(2)=="bets" || $this->uri->segment(1)=="bets"){
		include "pub_footer.php";
	} ?>
</div>
	<script type="text/javascript">
	if($('#info').text().length > 10)
	{
		$('#info').delay(5000).slideUp(500);
	}
	$(window).ready(function(){
		setTimeout(function() { window.scrollTo(0, 1); }, 100);
		$('.maxTipovi').click(function(){
			location.replace('<?php echo base_url('home/dailybids')?>');
		});
		$('#footer_mybets').click(function(){
			location.replace('<?php echo base_url('bets')?>');
		});
		$('#footer_rec').click(function(){
			location.replace('<?php echo base_url('matches/recommended')?>');
		});
		$('#footer_fav').click(function(){
			location.replace('<?php echo base_url('matches/favorites')?>');
		});
		$('#footer_all').click(function(){
			location.replace('<?php echo base_url('matches/all')?>');
		});
	});
	</script>
	<script src="<?php echo base_url();?>js/classie.js"></script>
	<script type="text/javascript">
	var btnCaller;
	var dialog;
	function setupNatprevari()
	{
		dialog = $("#dialog").dialog({
			closeOnEscape: true,
			modal: true,
			resizable: false,
			draggable: false,
			open: function(event, ui) { 
				$(".ui-dialog-titlebar-close").hide();
				$(".ui-dialog-titlebar").css('background-color', 'transparent'); 
				$('.ui-widget-overlay').bind('click', function() {
					dialog.dialog('close');
				});
			},
			beforeClose: function(event, ui) {
				var tip = $('#moreOption td.selected').find('#tip').val();
				var koef = $('#moreOption td.selected').find('#koef').val();
				var tekst = $('#moreOption td.selected').text();
				if(tip != null && koef != null)
					moreSelected(tip, koef, tekst);
			},
			autoOpen: false
		});
		var natprevari = new Array();
		var tipovi = new Array();
		var koeficienti = new Array();
		$('#submit').click(function(){
			$('form#target').submit();
			//alert(tipovi + ':' + natprevari + ':' + koeficienti);
		});
		function presmetaj()
		{
			var suma = 0;
			var ulog = parseInt($('#ulog').val());
			for(var i=0; i < natprevari.length; i++)
			{
				suma = suma + ulog * koeficienti[i]/natprevari.length;
			}
			if(suma == 0)
			{
				$("#placebet").hide();
				<?php if($this->uri->segment(1)!='home'): ?>
				$('#table').css('padding-bottom','0px');
				<?php endif; ?>
			}
			else
			{
				$("#placebet").show();
				<?php if($this->uri->segment(1)!='home'): ?>
				$('#table').css('padding-bottom','75px');
				<?php endif; ?>
			}
		}
		function deselectiraj(matchID)
		{
			var listaNatprevari = $(".matchDiv");
			for(var i = 0; i < listaNatprevari.length; i++)
			{
				var div = listaNatprevari[i];
				var natprevarID = parseInt($(div).find('#match_id').val());
				if(natprevarID == matchID)
				{
					$(div).find('.selected').removeClass('selected');
				}
			} 
		}
		$('.home').click(function(){
			if(!!(btnCaller))
				btnCaller.text('More');
			var maxBets = parseInt($('.maxTipovi').text());
			//$(this).siblings('.selected').removeClass('selected');
			$(this).closest('.matchDiv').find('.selected').removeClass('selected');
			var matchID = parseInt($(this).closest('.matchDiv').find('#match_id').val());
			var tip = '1';
			var koeficient = parseFloat($(this).find('#koeficient').val());
			var indeks = $.inArray(matchID, natprevari);
			if(indeks == -1)// dali e nov bit 
			{
				if(maxBets > natprevari.length)
				{
					$(this).addClass('selected');
					natprevari.push(matchID);
					tipovi.push(tip);
					koeficienti.push(koeficient);
				}
				else
				{
					alert("You don't have any bids left to bet on matches");
				}
			}
			else
			{
				if(tipovi[indeks] == tip)
				{
					$(this).removeClass('selected');
					deselectiraj(natprevari[indeks]);
					natprevari.splice(indeks, 1);
					tipovi.splice(indeks, 1);
					koeficienti.splice(indeks, 1);
				}
				else
				{
					deselectiraj(natprevari[indeks]);
					$(this).addClass('selected');
					tipovi[indeks] = tip;
					koeficienti[indeks] = koeficient;
				}
			}
			$('#natprevariArray').val(natprevari);
			$('#tipoviArray').val(tipovi);
			$('#koeficientiArray').val(koeficienti);
			presmetaj();
		});
		$('.away').click(function(){
			if(!!(btnCaller))
				btnCaller.text('More');
			var maxBets = parseInt($('.maxTipovi').text());
			//$(this).siblings('.selected').removeClass('selected');
			$(this).closest('.matchDiv').find('.selected').removeClass('selected');
			var matchID = parseInt($(this).closest('.matchDiv').find('#match_id').val());
			var tip = '2';
			var koeficient = parseFloat($(this).find('#koeficient').val());
			var indeks = $.inArray(matchID, natprevari);
			if(indeks == -1)
			{
				if(maxBets > natprevari.length)
				{
					$(this).addClass('selected');
					natprevari.push(matchID);
					tipovi.push(tip);
					koeficienti.push(koeficient);
				}
				else
				{
					alert("You don't have any bids left to bet on matches");
				}
			}
			else
			{
				if(tipovi[indeks] == tip)
				{
					$(this).removeClass('selected');
					deselectiraj(natprevari[indeks]);
					natprevari.splice(indeks, 1);
					tipovi.splice(indeks, 1);
					koeficienti.splice(indeks, 1);
				}
				else
				{
					deselectiraj(natprevari[indeks]);
					$(this).addClass('selected');
					tipovi[indeks] = tip;
					koeficienti[indeks] = koeficient;
				}
			}
			$('#natprevariArray').val(natprevari);
			$('#tipoviArray').val(tipovi);
			$('#koeficientiArray').val(koeficienti);
			presmetaj();
		});
		$('.draw').click(function(){
			if(!!(btnCaller))
				btnCaller.text('More');
			var maxBets = parseInt($('.maxTipovi').text());
			//$(this).siblings('.selected').removeClass('selected');
			$(this).closest('.matchDiv').find('.selected').removeClass('selected');
			var matchID = parseInt($(this).closest('.matchDiv').find('#match_id').val());
			var tip = '0';
			var koeficient = parseFloat($(this).find('#koeficient').val());
			var indeks = $.inArray(matchID, natprevari);
			if(indeks == -1)
			{
				if(maxBets > natprevari.length && koeficient > 1)
				{
					$(this).addClass('selected');
					natprevari.push(matchID);
					tipovi.push(tip);
					koeficienti.push(koeficient);
				}
				else
				{
					alert("You don't have any bids left to bet on matches");
				}
			}
			else
			{
				if(tipovi[indeks] == tip)
				{
					$(this).removeClass('selected');
					deselectiraj(natprevari[indeks]);
					natprevari.splice(indeks, 1);
					tipovi.splice(indeks, 1);
					koeficienti.splice(indeks, 1);
				}
				else
				{
					deselectiraj(natprevari[indeks]);
					$(this).addClass('selected');
					tipovi[indeks] = tip;
					koeficienti[indeks] = koeficient;
				}
			}
			$('#natprevariArray').val(natprevari);
			$('#tipoviArray').val(tipovi);
			$('#koeficientiArray').val(koeficienti);
			presmetaj();
		});
		function moreSelected(tip, koeficient, tekst){
			btnCaller.text(tekst);
			var maxBets = parseInt($('.maxTipovi').text());
			btnCaller.closest('.matchDiv').find('.selected').removeClass('selected');
			var matchID = parseInt(btnCaller.closest('.matchDiv').find('#match_id').val());
			var indeks = $.inArray(matchID, natprevari);
			if(indeks == -1)
			{
				if(maxBets > natprevari.length)
				{
					btnCaller.addClass('selected');
					natprevari.push(matchID);
					tipovi.push(tip);
					koeficienti.push(koeficient);
				}
				else
				{
					alert("You don't have any bids left to bet on matches");
				}
			}
			else
			{
				if(tipovi[indeks] == tip)
				{
					//btnCaller.removeClass('selected');
					btnCaller.text('More');
					natprevari.splice(indeks, 1);
					tipovi.splice(indeks, 1);
					koeficienti.splice(indeks, 1);
				}
				else
				{
					btnCaller.addClass('selected');
					tipovi[indeks] = tip;
					koeficienti[indeks] = koeficient;
				}
			}
			$('#natprevariArray').val(natprevari);
			$('#tipoviArray').val(tipovi);
			$('#koeficientiArray').val(koeficienti);
			presmetaj();
		}
		function oznaciIzbrano()
		{
			var matchID = parseInt(btnCaller.closest('.matchDiv').find('#match_id').val());
			var indeks = $.inArray(matchID, natprevari);
			//alert('najdeni matchID: ' + matchID + ' i indeks u listu: ' + indeks);
			if(indeks > -1)
			{
				$('#moreOption td #tip[value='+tipovi[indeks]+']').closest('td').addClass('selected');
				//alert('pretrazeno');
			}
		}
		$('.moreBtn').click(function(){
			btnCaller = $(this);
			$.ajax({
				url: "<?php echo base_url()."pajax/more"?>",
				type: "POST",
				data: {id: parseInt($(this).closest('.matchDiv').find('#match_id').val())},
				success: function(html)
				{
					$("#dialog").html(html);
					selectable();
					dialog.dialog('open');
					oznaciIzbrano();
				}
			});
		});
		function selectable()
		{
			$('#moreOption td').click(function(){
				$('#moreOption td.selected').removeClass('selected');
				$(this).addClass('selected');
				dialog.dialog('close');
			});
		}
		presmetaj();
	}
	setupNatprevari();
	</script>
</body>
</html>
