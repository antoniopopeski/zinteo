<!DOCTYPE html>
<html>
<head>
<title><?php echo isset($page_title) ? $page_title : "Zinteo"?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet"
	href="<?php echo base_url()?>assets/shop/css/main.css" type="text/css" />
<link rel="stylesheet"
	href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link href="http://fonts.googleapis.com/css?family=PT+Sans+Narrow"
	rel="stylesheet" type="text/css">
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script type="text/javascript"
	src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.3.min.js"></script>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script
	src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"
	type="text/javascript"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>	
	
<script type="text/javascript"
	src="<?php echo base_url()?>assets/shop/js/site-functions.js"></script>

<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	
	<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
</head>
<?php 


?>

<body>
	<div class="wrapper">
<div class="header-wrap">
<?php 
$current_url = $this->uri->segment(1);

$lang = request ( 'languages/languages/set_language' )->decode ( 'json' )->exec ();
echo $lang->view;
?>
	<?php if (is_logged()) {?>
  		<p><?php echo lang("You Are logged as")?>: <?php echo User::getCurrent()->getEmail()?></p>
		<a class="myaccount" <?php echo ($current_url == 'placeorder') ? 'id="placeorder_myaccount"' : ""?>  href="/shop/shop/myorders"><?php echo lang("my orders")?></a>
  		<a href="<?php echo base_url()?>user/logout"><?php echo lang("logout")?></a>	
	<?php  } else {?>
	<p><?php echo lang("You are not logged in.")?></p>
	<?php if ($current_url != 'login') {?>
		<p><a href="<?php echo base_url()?>user/login"><?php echo lang("login")?></a></p>
	<?php }?>
	<?php }?>	
	</div>
	
		<header class="header">
			<a class="logo" href="<?php echo base_url()?>" style="line-height: 5;"> <img
				src="https://scontent-frt3-1.xx.fbcdn.net/hphotos-xap1/v/t1.0-9/1450230_620288344695821_465157499_n.png?oh=d7fa896710af2a6d2f7503700c620fbb&oe=5753B9B7" style="width: 30%;float: left;"/> <i style="margin-left: 5px;"></i> <b>Zinteo</b>
			</a> <i class="fa fa-bars" onclick="togle()"></i>
			
			
			<?php if (is_logged()) {?>
			
			<?php if (!isset($active_menu['none'])) {?>
			<ul>
				<li><?php if(isset($active_menu['login'])) {?><img
					src="<?php echo base_url()?>assets/shop/assets/img/menu-logo.png" /> <?php  }?><a style="cursor: default; <?php if (isset($active_menu['login']))  echo "color: #f09f1e !important" ?> " onclick="return false;" ><?php echo lang("Login")?></a></li>
				
				<li><?php if (isset($active_menu['veterian'])) {?><img
					src="<?php echo base_url()?>assets/shop/assets/img/menu-logo.png" /><?php }?><a style="cursor: default; <?php if (isset($active_menu['veterian']))  echo "color: #f09f1e !important" ?> " ><?php echo lang("Veterinarian")?></a></li>
				<li><?php if (isset($active_menu['deliveryaddress'])) {?><img
					src="<?php echo base_url()?>assets/shop/assets/img/menu-logo.png" /><?php }?><a style="cursor: default; <?php if (isset($active_menu['deliveryaddress']))  echo "color: #f09f1e !important" ?> "><?php echo lang("Delivery Address")?></a></li>
				<li><?php if (isset($active_menu['paymenttype'])) {?><img
					src="<?php echo base_url()?>assets/shop/assets/img/menu-logo.png" /><?php }?><a style="cursor: default;<?php if (isset($active_menu['paymenttype']))  echo "color: #f09f1e !important" ?> "><?php echo lang("Payment Type")?></a></li>
				<li><?php if (isset($active_menu['placeorder'])) {?><img
					src="<?php echo base_url()?>assets/shop/assets/img/menu-logo.png" /><?php }?><a style="cursor: default; <?php if (isset($active_menu['placeorder']))  echo "color: #f09f1e !important" ?> "><?php echo lang("Place Order")?></a></li>
			</ul>
			<?php } else {?>
			<ul>
			  <li><a style="cursor: default;"><?php echo lang("Login")?></a></li>
			  <li><a style="cursor: default;"><?php echo lang("Veterinarian")?></a></li>
		      <li><a style="cursor: default;"><?php echo lang("Delivery Address")?></a></li>
		      <li><a style="cursor: default;"><?php echo lang("Payment Type")?></a></li>
		      <li><a style="cursor: default;"><?php echo lang("Place Order")?></a></li>
		       </ul> 
			<?php }?>
			<?php } else {?>
			<?php 
				$uri_segment =  $this->uri->segment(1); 
			?>
			<ul>
	
		        <li><a onclick="return false;" style="cursor: default;" href=""><?php echo lang("Login")?></a></li>
		      
		        <li><a onclick="return false;" style="cursor: default;" class="menu-item" href=""><?php echo lang("Veterinarian")?></a></li>
		        <li><a onclick="return false;" style="cursor: default;" class="menu-item" href=""><?php echo lang("Delivery Address")?></a></li>
		        <li><a onclick="return false;" style="cursor: default;" class="menu-item" href=""><?php echo lang("Payment Type")?></a></li>
		        <li><a onclick="return false;" style="cursor: default;" class="menu-item" href=""><?php echo lang("Place Order")?></a></li>
    </ul>
			<?php }?>
			<div class="status">
			<?php if (isset($page_status)) {?>
			   <?php echo lang("Shopping status")?>: <?php echo $page_status?>
			<?php }?>
	
	</div>
		</header>

   
   <?php  echo view($main, $data)?>
    
    
    <footer>
			<p><?php echo lang("Copyright");?> &copy 2015. Zinteo</p>
		</footer>
	</div>
</body>
</html>
<?php 
	// $link=explode('/', $_SERVER['PHP_SELF']);
	// if(isset($link[3])){
	// 	$link=$link[3];
	// } else {
	// 	$link=NULL;
	// }
	
	$link=$this->uri->segment(1);

?>
<script type="text/javascript">
	$(".logo").click(function(e){
		e.preventDefault();
		<?php
		  if($link=='ccpayment' || $link=='placeorder' || $link=='paymenttype' || $link=='delivery' ){?>
		$c = confirm("<?php echo lang("Are you sure to cancel payment process?")?>");

		if ($c == true )
		{
				window.location.href = "<?php echo base_url()?>";
		}
		else 
		{
				return false;
		}
		<?php echo "test"; } else { echo "test2";?>
				window.location.href = "<?php echo base_url()?>"
		<?php } ?>
	})
</script>