
<form class="delivery-form" method="post" action="">
	<div class="title">
		<h2>Invoice Address</h2>

	</div>
                        <?php foreach ($invoiceaddress as $da) {?>
            <div class="gform-body">


		<ul>
			<li><label>First Name</label> <input type="text" name="firstname"
				value="<?php echo $da->firstname?>" /></li>
			<li><label>Last Name</label> <input type="text" name="lastname"
				value="<?php echo $da->lastname?>" /></li>
			<li><label>Street</label> <input type="text" name="street"
				value="<?php echo $da->street?>" /></li>
			<li><label>Street No.</label> <input type="text" name="streetno"
				value="<?php echo $da->streetno?>" /></li>
			<li><label>Zip-Code</label> <input type="text" name="zip"
				value="<?php echo $da->zip?>" /></li>
			<li><label>City</label> <input type="text" name="city"
				value="<?php echo $da->city?>" /></li>
			<li><label>Country</label> <input type="text" name="country"
				value="<?php echo $da->country?>" /></li>
			<li><label>Telefon</label> <input type="text" name="phone"
				value="<?php echo $da->phone?>" /></li>
			<li><label>Email</label> <input type="text" name="email"
				value="<?php echo $da->email?>" /></li>

			<li class="checkbox"><span>Use this invoice address</span> <input
				type="radio" name="invoiceaddress" value="<?php echo $da->id?>" /></li>



		</ul>

	</div>
                 	<?php }?>    
                 	            <div class="gform-body">


		<ul>

			<li class="checkbox" id="first-submit">
				<button type="submit" name="submit">Next</button>
			</li>
			<li class="checkbox" id="first-submit"><a
				href="<?php echo base_url()?>shop/insertinvoiceaddress">Insert new
					invoice address</a></li>
		</ul>
	</div>

</form>