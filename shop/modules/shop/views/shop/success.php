
<main>
        <div class="title">
        <?php if(isset($_SESSION['banktransfer'])){ ?>
            <h2><?php echo lang("Payment successfully made.")?></h2>
	   		 <h5><?php echo lang("Thanks for purchasing. Your prouct is expected to arrive in 5 days.")?></h5>
	   		 <?php } else {?> 
	             <h2><?php echo lang("Payment successfully made.")?></h2>
	 	   		 <h5><?php echo lang("Thanks for purchasing. \n However you still havent paid for your product, please go to my orders on the top right corner, and press Pay now. After you pay the invoice, your product is expected to arive in 5 days")?></h5>
	   		 <?php }
	   		 unset($_SESSION['banktransfer']);
	   		 ?>
        </div>

<form class="form-horizontal">
    
    <a href="<?php echo base_url()?>shop/myorders" class="btn-orange" ><?php echo lang("see list of your orders")?></a>
</form>
</main>

