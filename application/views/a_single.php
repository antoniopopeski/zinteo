<h2>Add single match with coeficients</h2>
<?php if(isset($poraka) && $poraka):?>
<div id="info" <?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>><?php echo "<label>".$poraka."</label>"; ?></div>
<?php endif;?>
<form id='target' method="post" action="<?php echo base_url("admin_single");?>">
<div style="height: 100%; position: relative; background-color: #EEE; padding: 10px; margin: 0;">
	<div style="width: 420px; display: inline-block;">
		<div class="pole">
			<div class="labeler">Championship</div>
			<div class="elements">
				<select id="sampionat">
					<option selected="selected" disabled="disabled">Select a league</option>
					<?php foreach($lista as $t): ?>
					<option value="<?php echo $t->id; ?>"><?php echo $t->ime; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="pole">
			<div class="labeler">Season</div>
			<div class="elements">
				<select id="sezona">
				</select>
			</div>
		</div>
		<div class="pole">
			<div class="labeler">Round</div>
			<div class="elements">
				<select id="kolo" name="kolo_id">
				</select><button id="addRound">+</button>
			</div>
		</div>
		<div class="pole">
			<div class="labeler">Date</div>
			<div class="elements"><input id="datum" name="datum" class="date"></div>
		</div>
		<div class="pole">
			<div class="labeler">Time start</div>
			<div class="elements"><input name="pocetok" id="pocetok" class="time"></div>
		</div>
		<div class="pole">
			<div class="labeler">Time end</div>
			<div class="elements"><input name="kraj" id="kraj" class="time"></div>
		</div>
		<div class="pole">
			<div class="labeler">Publish date</div>
			<div class="elements"><input name="vnesen" disabled="disabled" value="<?php 
				echo date_create("now")->format("Y-m-d H:i");?>"></div>
		</div>
		<div class="pole">
			<div class="labeler">Visible on public site</div>
			<div class="elements"><input id="viz" name="vidliv" class="datetime"></div>
		</div>
	</div>
	<div style="display: inline-block; vertical-align: top;" id="dropdown">
		<div class="pole">
			<div class="elements">Home team&nbsp;<select class="timovi" name="domasni">
			</select>
			</div>
			<div class="elements">Away team&nbsp;<select class="timovi" name="gosti">
			</select>
			</div>
		</div>
	</div><br>
	<fieldset class="pole">
	<legend>Coeficients</legend>
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
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[prv]" value="1">
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
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[x]" value="1">
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
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[vtor]" value="1">
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
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[golovi0do1]" value="1">
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
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[golovi2do3]" value="1">
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
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[golovi4do6]" value="1">
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
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[golovi7plus]" value="1">
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
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[prvprv]" value="1">
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
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[prvx]" value="1">
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
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[prvvtor]" value="1">
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
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[xprv]" value="1">
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
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[xx]" value="1">
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
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[xvtor]" value="1">
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
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[vtorprv]" value="1">
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
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[vtorx]" value="1">
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
					<input type="hidden" class="target" style="width: 50px;" name="koeficient[vtorvtor]" value="1">
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
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[ov]" value="1">
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
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[un]" value="1">
			</div>
		</div>
	</fieldset>
</fieldset>
	<input type="submit" value="ADD MATCH">
</div>
</form>
<div id="dialog"></div>
<script type="text/javascript" src="<?php echo base_url()?>js/combobox.js"></script>
<script type="text/javascript">
$('form').validate({
	rules: {
		"domasni": {team: true},
		"gosti": {team: true}
	},
	messages: {
		"domasni": {required: 'This field is required'},
		"gosti": {required: 'This field is required'}
	}
});
$.validator.addMethod("team", function( value, element, param ) {
    var broj = parseInt(value);
    return (broj > 0);
}, "Select a team");
$('#link').button();
$('.date').datepicker({dateFormat: "dd M yy", minDate: new Date()});
$('.time').timepicker({timeFormat: "hh:mm"});
$('.time').keyup(function(){
	var tekst = $(this).val();
	if(tekst.length == 2)
		tekst += ":";
	if(tekst.length > 5)
		tekst = tekst.substring(0,5);
	$(this).val(tekst);
});
$('.datetime').datetimepicker({dateFormat: "dd M yy,", timeFormat: "hh:mm", minDate: new Date()});
$('#addRound').click(function(){
var sezona = parseInt($("#sezona").val());
if(isNaN(sezona))
    sezona = 0;
if(sezona > 0)
{
    $("#dialog").html('<h3>Add new round <input id="newRound"></h3>');
    $("#dialog").dialog({
	        resizable: false,
	        modal: true,
	        buttons: {
	    		'Cancel': function() {
	    		    $(this).dialog('destroy');
	    		},
	    		'Add round': function() {
	    			$.ajax({
	    				url: "<?php echo base_url()."ajax/addRoundPlus"?>",
	    				type: "POST",
	    				data: {id: $('#sezona').val(), nov: $('#newRound').val()},
	    				success: function(data)
	    				{
	    					$('#kolo').html(data);
	    				}
	    			});
	    		    $(this).dialog('destroy');
	    		}
	        },
	        autoOpen: false
	    });
	    $("#dialog").dialog('open');
}
else
{
	$("#dialog").html('<h3>You need to select a championship and a season, before adding a new round</h3>');
    $("#dialog").dialog({
	        resizable: false,
	        modal: true,
	        buttons: {
	    		'OK': function() {
	    		    $(this).dialog('destroy');
	    		}
	        },
	        autoOpen: false
	    });
	    $("#dialog").dialog('open');
}
return false;
});
$('#datum').change(function(){
	var datum = $(this).datepicker('getDate');
	datum.setDate(datum.getDate() - 3);
	$('#viz').datetimepicker('setDate', datum);
});
$('#pocetok').change(function(){
	var time = $('#pocetok').val();
	var text = time.split(':');
	var saat = parseInt(text[0]);
	var minute = parseInt(text[1]);
	saat = saat + 2;
	$('#kraj').timepicker('setTime', saat+':'+minute);
});
//$('#kraj').timepicker('setTime', '15:36');
$('#sampionat').change(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/optionsSezona');?>",
		type: "POST",
		data: {id: $(this).val()},
		success: function(data)
		{
			$('#sezona').html(data);$.ajax({
				url: "<?php echo base_url('ajax/optionsKolo');?>",
				type: "POST",
				data: {id: $('#sezona').val()},
				success: function(data)
				{
					$('#kolo').html(data);
				}
			});
		}
	});
});
$('#sezona').change(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/optionsKolo');?>",
		type: "POST",
		data: {id: $(this).val()},
		success: function(data)
		{
			$('#kolo').html(data);
		}
	});
});
$('#kolo').change(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/optionsTimovi');?>",
		type: "POST",
		data: {id: $(this).val()},
		success: function(data)
		{
			$('.timovi').html(data);
			$('.timovi').combobox();
		}
	});
});
$('.timovi').combobox();

function setKoeficient(cel, dec, aktiven){
	var koef = parseFloat($(cel).val()) + parseFloat($(dec).val())/10;
	if(aktiven==1)
		cel.siblings('.target').val(koef);
	else
		dec.siblings('.target').val(koef);
}
$('.cel').change(function () {
	setKoeficient($(this), $(this).siblings('.dec')[0], 1);
});
$('.dec').change(function () {
	setKoeficient($(this).siblings('.cel')[0], $(this), 2);
});
</script>