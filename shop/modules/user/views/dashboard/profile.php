<div class="title">
	<h2>Profile</h2>

</div>
<form method="post" action="" style="border-bottom: none;">
	<input type="hidden" name="uid" value="<?php echo $user->getId()?>">
	<div class="gform-body">
		<ul>
			<li><label><?php echo lang("First name")?>?</label> <input
				type="input" name="firstname"
				value="<?php echo $user->getFirstName()?>" /></li>
			<li><label><?php echo lang("Last name")?>?</label> <input
				type="input" name="lastname"
				value="<?php echo $user->getLastName()?>" /></li>

			<li><label><?php echo lang("Country")?>?</label> <input type="input"
				name="country" value="<?php echo $user->getCountry()?>" /></li>


			<li><label><?php echo lang("City")?>?</label> <input type="input"
				name="city" value="<?php echo $user->getCity()?>" /></li>

			<!-- 
                    <li>
                    	<label><?php echo lang("Country")?></label>
                    	<select name="countryid" id="countryid">
                    		<option value="" ></option>
                    		<?php foreach ( $countries as $country ) {?>
                    			<option value="<?php echo $country->getId()?>"><?php echo $country->getCountry()?></option>
                    		<?php } ?>
                    	</select>
                    </li>
                    
                    <li>
                    	<label><?php echo lang("City")?></label>
                    	<select name="cityid" id="cityid">
                    	</select>
                    </li>
                     -->

			<li><label><?php echo lang("Address")?>?</label> <input type="input"
				name="address" value="<?php echo $user->getAddress()?>" /></li>

			<li><label><?php echo lang("Zip")?>?</label> <input type="input"
				name="zip" value="<?php echo $user->getZip()?>" /></li>



			<li class="checkbox">
				<button type="submit"><?php echo lang("Save")?></button>
			</li>
		</ul>
	</div>
</form>
