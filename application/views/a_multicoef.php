<h2>Add multiple coeficients</h2>
<?php if(isset($poraka) && $poraka):
if(is_array($poraka)):
?>
<div id="info">
<?php
foreach ($poraka as $p):
?>
	<label <?php echo (strpos($p, 'Error')!==false)?'style="background-color: #F00; display: block;"':
		'style="background-color: #0F0; display: block;"';?>><?php echo $p; ?></label>
<?php
endforeach;
?>
</div>
<?php
else: ?>
<div id="info"<?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>>
	<label><?php echo $poraka; ?></label>
</div>
<?php
endif;
endif;
?>
<form method="post" action="<?php echo base_url("admin_multicoef");?>">
	<?php 
	$br = 0;
	$maxCel = 101;
	foreach($lista as $s):
	?>
	<fieldset class="pole">
		<legend><?php echo $s->id.": ".$s->domasni." vs ".$s->gosti; ?></legend>
		<fieldset style="display: inline-block; vertical-align: top;">
			<legend>Final result</legend>
			<div class="pole">
				<div class="labeler" style="text-align: right;">1</div>
				<div class="elements">
					<select class="cel">
					<?php for($i = 1; $i < $maxCel; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>.<select class="dec">
					<?php for($i = 0; $i < 10; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[prv][<?php echo $br;?>]" value="1">
				</div>
			</div>
			<div class="pole">
				<div class="labeler" style="text-align: right;">X</div>
				<div class="elements">
					<select class="cel">
					<?php for($i = 1; $i < $maxCel; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>.<select class="dec">
					<?php for($i = 0; $i < 10; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[x][<?php echo $br;?>]" value="1">
				</div>
			</div>
			<div class="pole">
				<div class="labeler" style="text-align: right;">2</div>
				<div class="elements">
					<select class="cel">
					<?php for($i = 1; $i < $maxCel; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>.<select class="dec">
					<?php for($i = 0; $i < 10; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[vtor][<?php echo $br;?>]" value="1">
				</div>
			</div>
		</fieldset>
		<fieldset style="display: inline-block; vertical-align: top;">
			<legend>Goals</legend>
			<div class="pole">
				<div class="labeler" style="text-align: right;">0-1</div>
				<div class="elements">
					<select class="cel">
					<?php for($i = 1; $i < $maxCel; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>.<select class="dec">
					<?php for($i = 0; $i < 10; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[golovi0do1][<?php echo $br;?>]" value="1">
				</div>
			</div>
			<div class="pole">
				<div class="labeler" style="text-align: right;">2-3</div>
				<div class="elements">
					<select class="cel">
					<?php for($i = 1; $i < $maxCel; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>.<select class="dec">
					<?php for($i = 0; $i < 10; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[golovi2do3][<?php echo $br;?>]" value="1">
				</div>
			</div>
			<div class="pole">
				<div class="labeler" style="text-align: right;">4-6</div>
				<div class="elements">
					<select class="cel">
					<?php for($i = 1; $i < $maxCel; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>.<select class="dec">
					<?php for($i = 0; $i < 10; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[golovi4do6][<?php echo $br;?>]" value="1">
				</div>
			</div>
			<div class="pole">
				<div class="labeler" style="text-align: right;">7+</div>
				<div class="elements">
					<select class="cel">
					<?php for($i = 1; $i < $maxCel; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>.<select class="dec">
					<?php for($i = 0; $i < 10; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[golovi7plus][<?php echo $br;?>]" value="1">
				</div>
			</div>
		</fieldset>
		<fieldset style="display: inline-block; vertical-align: top;">
			<legend>First half - Final result</legend>
			<div style="float: left; vertical-align: top;">
				<div class="pole">
					<div class="labeler" style="text-align: right;">1-1</div>
					<div class="elements">
						<select class="cel">
						<?php for($i = 1; $i < $maxCel; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>.<select class="dec">
						<?php for($i = 0; $i < 10; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>
						<input type="hidden" class="target" style="width: 50px;" name="koeficient[prvprv][<?php echo $br;?>]" value="1">
					</div>
				</div>
				<div class="pole">
					<div class="labeler" style="text-align: right;">1-X</div>
					<div class="elements">
						<select class="cel">
						<?php for($i = 1; $i < $maxCel; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>.<select class="dec">
						<?php for($i = 0; $i < 10; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>
						<input type="hidden" class="target" style="width: 50px;" name="koeficient[prvx][<?php echo $br;?>]" value="1">
					</div>
				</div>
				<div class="pole">
					<div class="labeler" style="text-align: right;">1-2</div>
					<div class="elements">
						<select class="cel">
						<?php for($i = 1; $i < $maxCel; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>.<select class="dec">
						<?php for($i = 0; $i < 10; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>
						<input type="hidden" class="target" style="width: 50px;" name="koeficient[prvvtor][<?php echo $br;?>]" value="1">
					</div>
				</div>
			</div>
			<div style="float: left; vertical-align: top;">
				<div class="pole">
					<div class="labeler" style="text-align: right;">X-1</div>
					<div class="elements">
						<select class="cel">
						<?php for($i = 1; $i < $maxCel; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>.<select class="dec">
						<?php for($i = 0; $i < 10; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>
						<input type="hidden" class="target" style="width: 50px;" name="koeficient[xprv][<?php echo $br;?>]" value="1">
					</div>
				</div>
				<div class="pole">
					<div class="labeler" style="text-align: right;">X-X</div>
					<div class="elements">
						<select class="cel">
						<?php for($i = 1; $i < $maxCel; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>.<select class="dec">
						<?php for($i = 0; $i < 10; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>
						<input type="hidden" class="target" style="width: 50px;" name="koeficient[xx][<?php echo $br;?>]" value="1">
					</div>
				</div>
				<div class="pole">
					<div class="labeler" style="text-align: right;">X-2</div>
					<div class="elements">
						<select class="cel">
						<?php for($i = 1; $i < $maxCel; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>.<select class="dec">
						<?php for($i = 0; $i < 10; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>
						<input type="hidden" class="target" style="width: 50px;" name="koeficient[xvtor][<?php echo $br;?>]" value="1">
					</div>
				</div>
			</div>
			<div style="float: left; vertical-align: top;">
				<div class="pole">
					<div class="labeler" style="text-align: right;">2-1</div>
					<div class="elements">
						<select class="cel">
						<?php for($i = 1; $i < $maxCel; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>.<select class="dec">
						<?php for($i = 0; $i < 10; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>
						<input type="hidden" class="target" style="width: 50px;" name="koeficient[vtorprv][<?php echo $br;?>]" value="1">
					</div>
				</div>
				<div class="pole">
					<div class="labeler" style="text-align: right;">2-X</div>
					<div class="elements">
						<select class="cel">
						<?php for($i = 1; $i < $maxCel; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>.<select class="dec">
						<?php for($i = 0; $i < 10; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>
						<input type="hidden" class="target" style="width: 50px;" name="koeficient[vtorx][<?php echo $br;?>]" value="1">
					</div>
				</div>
				<div class="pole">
					<div class="labeler" style="text-align: right;">2-2</div>
					<div class="elements">
						<select class="cel">
						<?php for($i = 1; $i < $maxCel; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>.<select class="dec">
						<?php for($i = 0; $i < 10; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						</select>
						<input type="hidden" class="target" style="width: 50px;" name="koeficient[vtorvtor][<?php echo $br;?>]" value="1">
					</div>
				</div>
			</div>
		</fieldset>
		<fieldset style="display: inline-block; vertical-align: top;">
			<legend>Under/Over goals</legend>
			<div class="pole">
				<div class="labeler" style="text-align: right;">Over</div>
				<div class="elements">
					<select class="cel">
					<?php for($i = 1; $i < $maxCel; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>.<select class="dec">
					<?php for($i = 0; $i < 10; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[ov][<?php echo $br;?>]" value="1">
				</div>
			</div>
			<div class="pole">
				<div class="labeler" style="text-align: right;">Under</div>
				<div class="elements">
					<select class="cel">
					<?php for($i = 1; $i < $maxCel; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>.<select class="dec">
					<?php for($i = 0; $i < 10; $i++): ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
					</select>
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[un][<?php echo $br;?>]" value="1">
			<input type="hidden" name="koeficient[natprevar_id][<?php echo $br;?>]" value="<?php echo $s->id;?>">
				</div>
			</div>
		</fieldset>
	</fieldset>
	<hr style="border: 0.5px solid #CCC; margin: 7px 0;">
	<?php 
	$br++;
endforeach;?>
	<div class="pole">
		<div class="elements">
			<input type="submit" value="SET COEFICIENTS">
		</div>
	</div>
</form>
<script type="text/javascript">
<?php if(false):?>
$("input[type='text']").live('focus', function () {
	$(this).val('');
});
$("input[type='text']").live ('keyup', function (e) {
	var tekst = $(this).val();
	var duzina = tekst.length - 1;
	var posleden = tekst.substring(duzina, duzina + 1);
	var brojka = parseInt(posleden);
	if(isNaN(brojka) && posleden != '.')
	{
		if(posleden == ',')
			tekst = tekst.substring(0,duzina) + '.';
		else
			tekst = tekst.substring(0,duzina);
	}
	if(tekst.length > 0 && posleden != '.' && posleden != ',')
		$(this).val(parseFloat(tekst));
	else 
		$(this).val(tekst);
});
$( "input[type='text']" ).spinner({ step: 0.01, min: 1, max: 100, numberFormat: "n" });
<?php endif;?>
function presmetaj(obj, tip)
{
	var vrednost = 1;
	if(tip == 'cel')
	{
		var celDel = parseInt(obj.val());
		var decimalenDel = parseInt(obj.siblings('.dec').val());
		vrednost = celDel + decimalenDel/10;
	} else {
		var decimalenDel = parseInt(obj.val());
		var celDel = parseInt(obj.siblings('.cel').val());
		vrednost = celDel + decimalenDel/10;
	}
	obj.siblings('.target').val(vrednost);
	//alert(vrednost);
}
$('.cel').change(function(){
	presmetaj($(this), 'cel');
});
$('.dec').change(function(){
	presmetaj($(this), 'dec');
});
</script>