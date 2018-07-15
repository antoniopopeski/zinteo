<!DOCTYPE html>
<html>
<head>
<title><?php echo $page_title?></title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet"
	href="<?php echo base_url()?>/assets/shop/public/css/main.css"
	type="text/css" />
<link rel="stylesheet"
	href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link href="http://fonts.googleapis.com/css?family=PT+Sans+Narrow"
	rel="stylesheet" type="text/css">
<script type="text/javascript"
	src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.3.min.js"></script>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script
	src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"
	type="text/javascript"></script>
<link
	href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css"
	rel="stylesheet" />
<script
	src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<script
	src="<?php echo base_url()?>/assets/shop/public/js/site-functions.js"></script>


</head>
<body>
	<div class="wrapper">
		<header class="header">
			<a class="logo" href="#"> <img
				src="<?php base_url()?>/assets/shop/public/assets/img/logo.jpg" />
			</a> <i class="fa fa-bars" onclick="togle()"></i>
			<ul>
    <?php if ($this->uri->segment(1) == 'dashboard' OR $this->uri->segment(1) == 'users') {?>
    <li><a href="<?php echo base_url()?>user/dashboard/">Dashboard</a></li>
				<li><a href="<?php echo base_url()?>user/profile/">My Profile</a></li>
				<li><a href="">Invoice Address</a></li>
				<li><a href="">History</a></li>
    <?php } else {?>
      <li><a href="<?php echo base_url()?>user/dashboard/">Dashboard</a></li>
				<li><a href="<?php echo base_url()?>user/profile/">My Profile</a></li>

				<li><a href="">Veterian</a></li>
				<li><a href="">Delivery Address</a></li>
				<li><a href="">Payment Type</a></li>
				<li><a href="">Place Order</a></li>
      <?php }?>  
    </ul>
		</header>
		<main>
        <?php echo view($main, $data)?>
    </main>
		<footer>
			<p>Copyright © 2015. Zinteo</p>
		</footer>
	</div>
</body>
</html>