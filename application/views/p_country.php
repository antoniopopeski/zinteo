<div id="container" class="leftcss"
	style="padding: 24px; text-align: justify; font-size: 16px; line-height: 20px;">
	<div class="sodrzina">
		<form method="post">
			<div class="pole">
				<div class="labeler">Select you country</div>
				<div class="elements">
					<select name="country">
						<option disabled="disabled"<?php 
							echo (!$user->drzava_id)?' selected="selected"':''?>>Select a valid country</option>
						<?php foreach ($drzavi as $d):?>
						<option value="<?php echo $d->id?>"<?php 
							echo ($user->drzava_id == $d->id)?' selected="selected"':''?>><?php echo $d->ime?></option>
						<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="pole">
				<div class="labeler">Select you timezone</div>
				<div class="elements">
					<select name="timezone">
						<?php include "application/views/datetimezones.php"?>
					</select>
				</div>
			</div>
			<input type="submit" value="SAVE">
		</form>
	</div>
</div>