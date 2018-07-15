<h2>Add multiple matches</h2>
<?php if(isset($poraka) && $poraka):?>
<div id="info" <?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>><?php echo "<label>".$poraka."</label>"; ?></div>
<a id="link" href="<?php echo base_url('admin_koeficienti');?>">Now set coeficients</a>
<?php endif;?>
<form id='target' method="post" action="<?php echo base_url("admin_multiple");?>">
<div style="height: 100%; position: relative; background-color: #EEE; padding: 10px; margin: 0;">
	<div style="width: 420px; display: inline-block;">
		<label>Enter data for multiple matches</label>
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
		<?php for($i=0;$i<10;$i++):?>
		<div class="pole">
			<div class="elements">Home team&nbsp;<select class="timovi" name="domasni[<?php echo $i;?>]">
			</select>
			</div>
			<div class="elements">Away team&nbsp;<select class="timovi" name="gosti[<?php echo $i;?>]">
			</select>
			</div>
		</div>
		<?php endfor;?>
	</div><br>
	<input type="submit" value="ADD MULTIPLE MATCHES">
</div>
</form>
<div id="dialog"></div>
<script type="text/javascript" src="<?php echo base_url()?>js/combobox.js"></script>
<script type="text/javascript">
$('form').validate({
	rules: {
		"domasni[0]": {team: true},
		"gosti[0]": {team: true}
	},
	messages: {
		"domasni[0]": {required: 'This field is required'},
		"gosti[0]": {required: 'This field is required'}
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
	datum.setDate(datum.getDate() - 7);
	$('#viz').datetimepicker('setDate', datum);
});
$('#pocetok').change(function(){
	var time = $('#pocetok').val();
	var text = time.split(':');
	var saat = parseInt(text[0]);
	var minute = parseInt(text[1]);
	saat = saat + 1;
	minute = minute + 45;
	if(minute > 59)
	{
		saat = saat + 1;
		minute = minute - 60;
	}
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
</script>