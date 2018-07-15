<?php
class Ajax extends CI_Controller
{
	function filtri()
	{
		$sessionData = $this->session->all_userdata();
		if(isset($_POST['sport']) && $_POST['sport'])
		{
			$sessionData['fSport'] = str_replace('s', '', $_POST['sport']);
			$this->session->set_userdata($sessionData);
		}
		else
		{
			unset($sessionData['fSport']);
			$this->session->unset_userdata('fSport');
		}
		if(isset($_POST['drzava']) && $_POST['drzava'])
		{
			$sessionData['fDrzava'] = str_replace('d', '', $_POST['drzava']);
			$this->session->set_userdata($sessionData);
		}
		else
		{
			unset($sessionData['fDrzava']);
			$this->session->unset_userdata('fDrzava');
		}
		if(isset($_POST['sampionat']) && $_POST['sampionat'])
		{
			$sessionData['fSampionat'] = str_replace('l', '', $_POST['sampionat']);
			$this->session->set_userdata($sessionData);
		}
		else
		{
			unset($sessionData['fSampionat']);
			$this->session->unset_userdata('fSampionat');
		}
		if(isset($_POST['kolo']) && $_POST['kolo'])
		{
			$sessionData['fKolo'] = str_replace('k', '', $_POST['kolo']);
			$this->session->set_userdata($sessionData);
		}
		else
		{
			unset($sessionData['fKolo']);
			$this->session->unset_userdata('fKolo');
		}
		if(isset($_POST['tim']) && $_POST['tim'])
		{
			$sessionData['fTim'] = str_replace('t', '', $_POST['tim']);
			$this->session->set_userdata($sessionData);
		}
		else
		{
			unset($sessionData['fTim']);
			$this->session->unset_userdata('fTim');
		}
		if(isset($_POST['tipTim']) && $_POST['tipTim'])
		{
			$sessionData['fTipTim'] = $_POST['tipTim'];
			$this->session->set_userdata($sessionData);
		}
		else
		{
			unset($sessionData['fTipTim']);
			$this->session->unset_userdata('fTipTim');
		}
		if(isset($_POST['topTim']) && $_POST['topTim'])
		{
			$sessionData['fTopTim'] = $_POST['topTim'];
			$this->session->set_userdata($sessionData);
		}
		else
		{
			unset($sessionData['fTopTim']);
			$this->session->unset_userdata('fTopTim');
		}
		//sluzi za cuvanje na selektiran tipper kude tiket kontroler
		if(isset($_POST['tiper']) && $_POST['tiper'])
		{
			$sessionData['fTiper'] = str_replace('t', '', $_POST['tiper']);
			$this->session->set_userdata($sessionData);
		}
		else
		{
			unset($sessionData['fTiper']);
			$this->session->unset_userdata('fTiper');
		}
		if(isset($_POST['startDate']) && $_POST['startDate'])
		{
			$date = new DateTime($_POST['startDate'], new DateTimeZone("Europe/Skopje"));
			$sessionData['fStartDate'] = $date->format("Y-m-d H:i:s");
			$this->session->set_userdata($sessionData);
		}
		else
		{
			unset($sessionData['fStartDate']);
			$this->session->unset_userdata('fStartDate');
		}
		if(isset($_POST['endDate']) && $_POST['endDate'])
		{
			$date = new DateTime($_POST['endDate'], new DateTimeZone("Europe/Skopje"));
			$date->modify("+1 day")->modify("-1 second");
			$sessionData['fEndDate'] = $date->format("Y-m-d H:i:s");//$_POST['endDate'];
			$this->session->set_userdata($sessionData);
		}
		else
		{
			unset($sessionData['fEndDate']);
			$this->session->unset_userdata('fEndDate');
		}
		if(isset($_POST['tiketDate']) && $_POST['tiketDate'])
		{
			$date = date_create_from_format("d-m-Y", $_POST['tiketDate'], new DateTimeZone("Europe/Skopje"));
			$sessionData['tiketDate'] = $date->format("Y-m-d H:i:s");
			$this->session->set_userdata($sessionData);
		}
		else
		{
			unset($sessionData['tiketDate']);
			$this->session->unset_userdata('tiketDate');
		}
		if(isset($_POST['tiperKreiran']) && $_POST['tiperKreiran'])
		{
			$sessionData['tiperKreiran'] = $_POST['tiperKreiran'];
			$this->session->set_userdata($sessionData);
		}
		else
		{
			unset($sessionData['tiperKreiran']);
			$this->session->unset_userdata('tiperKreiran');
		}
		if(isset($_POST['tiperLogiran']) && $_POST['tiperLogiran'])
		{
			$sessionData['tiperLogiran'] = $_POST['tiperLogiran'];
			$this->session->set_userdata($sessionData);
		}
		else
		{
			unset($sessionData['tiperLogiran']);
			$this->session->unset_userdata('tiperLogiran');
		}
		if(isset($_POST['days']) && $_POST['days'])
		{
			$sessionData['fDays'] = $_POST['days'];
			$this->session->set_userdata($sessionData);
		}
		else
		{
			unset($sessionData['fDays']);
			$this->session->unset_userdata('fDays');
		}
	}
	function nov_sport()
	{
		?>
<div class="pole">
	<div class="labeler">Sport</div>
	<div class="elements">
		<input name="sport[ime]">
	</div>
</div>
<div class="pole">
	<div class="labeler">Order ID</div>
	<div class="elements">
		<input name="sport[redosled]">
	</div>
</div>
<div class="pole">
	<div class="labeler">Sport image</div>
	<div class="elements">
		<input type="file" name="picture">
	</div>
</div>
<div class="pole">
	<div class="labeler" style="">Top</div>
	<div class="elements">
		<input type="radio" value="1" name="sport[top]" id="yes"><label for="yes">Yes</label>
		<input type="radio" checked="checked" value="0" name="sport[top]" id="no"><label for="no">No</label>
	</div>
</div>
<div class="pole">
	<div class="labeler" style="">Active</div>
	<div class="elements">
		<input type="radio" checked="checked" value="1" name="sport[aktiven]" id="yes"><label for="yes">Yes</label>
		<input type="radio" value="0" name="sport[aktiven]" id="no"><label for="no">No</label>
	</div>
</div>
<div class="pole">
	<div class="labeler" style="">Tie match</div>
	<div class="elements">
		<input type="radio" checked="checked" value="1" name="sport[nereseno]" id="yes"><label for="yes">Yes</label>
		<input type="radio" value="0" name="sport[nereseno]" id="no"><label for="no">No</label>
	</div>
</div>
<div class="pole">
	<div class="labeler"></div>
	<div class="elements">
		<input type="submit" value="ADD SPORT">
	</div>
</div>
<script type="text/javascript">
$("form").validate({
	rules: {
		"sport[ime]": {
			required: true,
			minlength: 4 }
	},
	messages: {
	"sport[ime]": {
		required: "Enter a sport name",
		minlength: jQuery.format("Minimum {0} characters")}
	}
});
</script>
<?php
	}
	function smeni_sport()
	{
		$this->load->model("sport");
		$item = $this->sport->oneObject($_POST['id']);
		?>
<div class="pole">
	<div class="labeler">Sport</div>
	<div class="elements">
		<input name="sport[ime]" value="<?php echo $item->ime;?>">
	</div>
</div>
<div class="pole">
	<div class="labeler">Order ID</div>
	<div class="elements">
		<input name="sport[redosled]" value="<?php echo $item->redosled;?>">
	</div>
</div>
<div class="pole">
	<div class="labeler">Sport image</div>
	<div class="elements">
		<input type="file" name="picture">
	</div>
</div>
<div class="pole">
	<div class="labeler" style="">Top</div>
	<div class="elements">
		<input type="radio"<?php echo ($item->top==1)?' checked="checked"':'';
		?> value="1" name="sport[top]" id="yes"><label for="yes">Yes</label>
		<input type="radio"<?php echo ($item->top==0)?' checked="checked"':'';
		?> value="0" name="sport[top]" id="no"><label for="no">No</label>
	</div>
</div>
<div class="pole">
	<div class="labeler" style="">Active</div>
	<div class="elements">
		<input type="radio"<?php echo ($item->aktiven==1)?' checked="checked"':'';
		?> value="1" name="sport[aktiven]" id="yes"><label for="yes">Yes</label>
		<input type="radio"<?php echo ($item->aktiven==0)?' checked="checked"':'';
		?> value="0" name="sport[aktiven]" id="no"><label for="no">No</label>
	</div>
</div>
<div class="pole">
	<div class="labeler" style="">Tie match</div>
	<div class="elements">
		<input type="radio"<?php echo ($item->nereseno==1)?' checked="checked"':'';
		?> value="1" name="sport[nereseno]" id="yes"><label for="yes">Yes</label>
		<input type="radio"<?php echo ($item->nereseno==0)?' checked="checked"':'';
		?> value="0" name="sport[nereseno]" id="no"><label for="no">No</label>
	</div>
</div>
<div class="pole">
	<div class="labeler"></div>
	<div class="elements">
		<input type="hidden" name="id" value="<?php echo $item->id;?>"> <input
			type="submit" value="EDIT SPORT">
	</div>
</div>
<script type="text/javascript">
$("form").validate({
	rules: {
		"sport[ime]": {
			required: true,
			minlength: 4 }
	},
	messages: {
	"sport[ime]": {
		required: "Enter a sport name",
		minlength: jQuery.format("Minimum {0} characters")}
	}
});
</script>
<?php
	}
	function nova_drzava()
	{
		?>
<div class="pole">
	<div class="labeler">Country</div>
	<div class="elements">
		<input name="drzava[ime]">
	</div>
</div>
<div class="pole">
	<div class="labeler">Order ID</div>
	<div class="elements">
		<input name="drzava[redosled]">
	</div>
</div>
<div class="pole">
	<div class="labeler">Country flag</div>
	<div class="elements">
		<input type="file" name="picture">
	</div>
</div>
<div class="pole">
	<div class="labeler"></div>
	<div class="elements">
		<input type="submit" value="ADD COUNTRY">
	</div>
</div>
<script type="text/javascript">
$("form").validate({
	rules: {
		"drzava[ime]": {
			required: true,
			minlength: 4 }
	},
	messages: {
	"drzava[ime]": {
		required: "Enter a country name",
		minlength: jQuery.format("Minimum {0} characters")}
	}
});
</script>
<?php
	}
	function smeni_drzava()
	{
		$this->load->model("drzava");
		$item = $this->drzava->oneObject($_POST['id']);
		?>
<div class="pole">
	<div class="labeler">Country</div>
	<div class="elements">
		<input name="drzava[ime]" value="<?php echo $item->ime;?>">
	</div>
</div>
<div class="pole">
	<div class="labeler">Order ID</div>
	<div class="elements">
		<input name="drzava[redosled]" value="<?php echo $item->redosled;?>">
	</div>
</div>
<div class="pole">
	<div class="labeler">Country flag</div>
	<div class="elements">
		<input type="file" name="picture">
	</div>
</div>
<div class="pole">
	<div class="labeler"></div>
	<div class="elements">
		<input type="hidden" name="id" value="<?php echo $item->id;?>">
		<input type="submit" value="EDIT COUNTRY">
	</div>
</div>
<script type="text/javascript">
$("form").validate({
	rules: {
		"drzava[ime]": {
			required: true,
			minlength: 4 }
	},
	messages: {
		"drzava[ime]": {
			required: "Enter a country name",
			minlength: jQuery.format("Minimum {0} characters")}
	}
});
</script>
<?php
	}
	function nov_natprevar()
	{
		$this->load->model("tim");
		$sql = "SELECT k.id, CONCAT(k.ime, ' - ', s.ime, ' - ', l.ime) AS ime 
				FROM kolo AS k INNER JOIN sezona AS s ON s.id=k.sezona_id 
				INNER JOIN sampionati AS l ON l.id=s.sampionat_id
				WHERE s.aktiven=1";
		$sampionati = $this->db->query($sql)->result();
		$vreme = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		?>
<div class="pole">
	<div class="labeler">Round - Season - Championship</div>
	<div class="elements">
		<select name="natprevar[kolo_id]" id="kolo">
			<option selected="selected" disabled="disabled">Select a championship</option>
			<?php foreach($sampionati as $t): ?>
			<option value="<?php echo $t->id; ?>">
				<?php echo $t->ime; ?>
			</option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler">
		Home Team : Away Team
	</div>
	<div class="elements">
		<select name="natprevar[domasni]" class="timovi">
			<option selected="selected" disabled="disabled">Select a team</option>
		</select> : <select name="natprevar[gosti]" class="timovi">
			<option selected="selected" disabled="disabled">Select a team</option>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler">Date</div>
	<div class="elements">
		<input name="datum" class="date" id="datum" value="">
	</div>
</div>
<div class="pole">
	<div class="labeler">Time start</div>
	<div class="elements">
		<input name="pocetok" class="time" value="">
	</div>
</div>
<div class="pole">
	<div class="labeler">Time end</div>
	<div class="elements">
		<input name="kraj" class="time" value="">
	</div>
</div>
<div class="pole">
	<div class="labeler">Publish date</div>
	<div class="elements">
		<input name="natprevar[vnesen]" readonly="readonly"	value="<?php echo $vreme->format("Y-m-d H:i");?>">
	</div>
</div>
<div class="pole">
	<div class="labeler">Visible on public site</div>
	<div class="elements">
		<input name="natprevar[vidliv]" class="datetime" id="viz" value="">
	</div>
</div>
<div class="pole">
	<div class="labeler"></div>
	<div class="elements">
		<input type="submit" value="ADD MATCH">
	</div>
</div>
<script type="text/javascript">
$('.date').datepicker({dateFormat: "yy-mm-dd", minDate: new Date()});
$('.time').timepicker({timeFormat: "hh:mm"});
$('.datetime').datetimepicker({dateFormat: "yy-mm-dd", timeFormat: "hh:mm", minDate: new Date()});
$('#datum').change(function(){
	var datum = $(this).datepicker('getDate');
	datum.setDate(datum.getDate() - 3);
	$('#viz').datepicker('setDate', datum);
});
$('#kolo').change(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/optionsTimovi');?>",
		type: "POST",
		data: {id: $(this).val()},
		success: function(data)
		{
			$('.timovi').html(data);
		}
	});
});
$("form").validate({
	rules: {
		"datum": { required: true},
		"pocetok": { required: true},
		"kraj": { required: true},
		"natprevar[vidliv]": { required: true},
		"natprevar[kolo_id]": { required: true},
		"natprevar[domasni_id]": { required: true},
		"natprevar[gosti_id]": { required: true}
	},
	messages: {
		"datum": { required: "Select a date"},
		"pocetok": { required: "Select a time"},
		"kraj": { required: "Select a time"},
		"natprevar[vidliv]": { required: "Select date and time"},
		"natprevar[kolo_id]": { required: "Select a round"},
		"natprevar[domasni_id]": { required: "Select home team"},
		"natprevar[gosti_id]": { required: "Select away team"}
	}
});
</script>
<?php
	}
	function smeni_natprevar()
	{
		$this->load->model("natprevar");
		$this->load->model("tim");
		$id = $_POST['id'];
		$sql = "SELECT o.id, o.datum, t.username, o.tip, o.ulog, o.koeficient, o.uspesen
					FROM oblozi AS o INNER JOIN tipuvaci AS t ON t.id=o.tipuvac_id
					WHERE o.natprevar_id=".$id;
		$oblozi = $this->db->query($sql)->result();
		$item = $this->natprevar->oneObject($id);
		$pocetok = date_create_from_format("Y-m-d H:i:s", $item->pocetok);
		if($pocetok > new DateTime("now", new DateTimeZone("Europe/Skopje")))
		{
			$sql = "SELECT t.* FROM timovi AS t 
					INNER JOIN sezona_tim AS st ON st.tim_id=t.id
					INNER JOIN sezona AS s ON st.sezona_id=s.id
					INNER JOIN kolo AS k ON s.id=k.sezona_id
					WHERE k.id=".$item->kolo_id." ORDER BY t.ime";
			$timovi = $this->db->query($sql)->result();
			$sql = "SELECT k.id, CONCAT(k.ime, ' - ', s.ime, ' - ', l.ime) AS ime
					FROM kolo AS k INNER JOIN sezona AS s ON s.id=k.sezona_id
					INNER JOIN sampionati AS l ON l.id=s.sampionat_id
					WHERE s.aktiven=1";
			$sampionati = $this->db->query($sql)->result();
			$pocetok = date_create_from_format("Y-m-d H:i:s", $item->pocetok);
			$vnesen = date_create_from_format("Y-m-d H:i:s", $item->vnesen);
			$vidliv = date_create_from_format("Y-m-d H:i:s", $item->vidliv);
			$kraj = date_create_from_format("Y-m-d H:i:s", $item->kraj);
		?>
<div class="pole">
	<div class="labeler" style="width: 28%;">Round - Season - Championship</div>
	<div class="elements">
		<select name="natprevar[kolo_id]" id="kolo">
			<?php foreach($sampionati as $t): ?>
			<option value="<?php echo $t->id; ?>"
			<?php echo ($item->kolo_id==$t->id)?
				' selected="selected"':'';?>>
				<?php echo $t->ime; ?>
			</option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler" style="width: 28%;">
		Home Team : Away Team
	</div>
	<div class="elements">
		<select name="natprevar[domasni]" class="timovi">
			<?php foreach($timovi as $t): ?>
			<option value="<?php echo $t->id; ?>"
			<?php echo ($item->domasni==$t->id)?
				' selected="selected"':'';?>>
				<?php echo $t->ime; ?>
			</option>
			<?php endforeach; ?>
		</select> : 
		 <select name="natprevar[gosti]" class="timovi">
			<?php foreach($timovi as $t): ?>
			<option value="<?php echo $t->id; ?>"
			<?php echo ($item->gosti==$t->id)?
				' selected="selected"':'';?>>
				<?php echo $t->ime; ?>
			</option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler" style="width: 28%;">Date</div>
	<div class="elements">
		<input name="datum" class="date" id="datum"
			value="<?php echo $pocetok->format("d M Y");?>">
	</div>
</div>
<div class="pole">
	<div class="labeler" style="width: 28%;">Time start</div>
	<div class="elements">
		<input name="pocetok" id="pocetok" class="time"
			value="<?php echo $pocetok->format("H:i");?>">
	</div>
</div>
<div class="pole">
	<div class="labeler" style="width: 28%;">Time end</div>
	<div class="elements">
		<input name="kraj" id="kraj" class="time"
			value="<?php echo $kraj->format("H:i");?>">
	</div>
</div>
<div class="pole">
	<div class="labeler" style="width: 28%;">Visible on public site</div>
	<div class="elements">
		<input name="natprevar[vidliv]" class="datetime" id="viz"
			value="<?php echo $vidliv->format("d M Y, H:i");?>">
	</div>
</div>
<div class="pole">
	<div class="labeler" style="width: 28%;"></div>
	<div class="elements">
		<input type="hidden" name="id" value="<?php echo $item->id;?>"> <input
			type="submit" value="EDIT MATCH">
	</div>
</div>
<?php if(count($oblozi) > 0):?>
<table id="adminTabela" class="dataTable addon">
	<thead>
		<tr>
			<th>#</th>
			<th>tipper</th>
			<th>date</th>
			<th>bet</th>
			<th>odd</th>
			<th>1</th>
			<th>X</th>
			<th>2</th>
			<th>1-1</th>
			<th>1-X</th>
			<th>1-2</th>
			<th>X-1</th>
			<th>X-X</th>
			<th>X-2</th>
			<th>2-1</th>
			<th>2-X</th>
			<th>2-2</th>
			<th>0-1</th>
			<th>2-3</th>
			<th>4-6</th>
			<th>7+</th>
			<th>G0-2</th>
			<th>G3+</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($oblozi as $o):
	switch ($o->uspesen) {
		case "1":
			$color = "green";
		break;
		case "0":
			$color = "red";
		break;
		
		default:
			$color = "black";
		break;
	}
	?>
		<tr>
			<td></td>
			<td><?php echo $o->username;?></td>
			<td><?php $datum = date_create_from_format("Y-m-d H:i:s", $o->datum);
			echo $datum->format("d M Y, H:i:s");?></td>
			<td><?php echo $o->ulog;?></td>
			<td><?php echo $o->koeficient;?></td>
			<td><?php if($o->tip == "1")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "0")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "2")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf1")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf2")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf3")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf4")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf5")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf6")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf7")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf8")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf9")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "g1")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "g2")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "g3")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "g4")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "u")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "o")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<?php endif;?>
<script type="text/javascript">
$('.date').datepicker({dateFormat: "dd M yy", minDate: new Date()});
$('.time').timepicker({timeFormat: "hh:mm"});
$('.datetime').datetimepicker({dateFormat: "dd M yy,", timeFormat: "hh:mm", minDate: new Date()});
$('#datum').change(function(){
	var datum = $(this).datepicker('getDate');
	datum.setDate(datum.getDate() - 3);
	$('#viz').datepicker('setDate', datum);
});
$('.time').keyup(function(){
	var tekst = $(this).val();
	if(tekst.length == 2)
		tekst += ":";
	if(tekst.length > 5)
		tekst = tekst.substring(0,5);
	$(this).val(tekst);
});
$('#kolo').change(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/optionsTimovi');?>",
		type: "POST",
		data: {id: $(this).val()},
		success: function(data)
		{
			$('.timovi').html(data);
		}
	});
});
$('#pocetok').change(function(){
	var time = $('#pocetok').val();
	var text = time.split(':');
	var saat = parseInt(text[0]);
	var minute = parseInt(text[1]);
	saat = saat + 2;
	$('#kraj').timepicker('setTime', saat+':'+minute);
});
$("form").validate({
	rules: {
		"datum": { required: true},
		"pocetok": { required: true},
		"kraj": { required: true},
		"natprevar[vidliv]": { required: true},
		"natprevar[kolo_id]": { required: true},
		"natprevar[domasni_id]": { required: true},
		"natprevar[gosti_id]": { required: true}
	},
	messages: {
		"datum": { required: "Select a date"},
		"pocetok": { required: "Select a time"},
		"kraj": { required: "Select a time"},
		"natprevar[vidliv]": { required: "Select date and time"},
		"natprevar[kolo_id]": { required: "Select a round"},
		"natprevar[domasni_id]": { required: "Select home team"},
		"natprevar[gosti_id]": { required: "Select away team"}
	}
});
$(".dataTable2").dataTable({
    "bPaginate": true,
    "sPaginationType": "full_numbers",
    "bLengthChange": false,
    "iDisplayLength" : 10,
    "bFilter": false,
    "bSort": true,
    "bDestroy" : true,
    "bInfo": false,
    "bAutoWidth": false,
    "aaSorting": [['1, "desc"']],
	"fnRowCallback": function( nRow ) {
		var strana = 0;
		var table = $.fn.dataTable.fnTables(true);
		if ( table.length > 0 ) {
			strana = $(table).dataTable().fnGetPosition(nRow);
		}
		var index = strana + 1;
		$('td:eq(0)',nRow).html(index);
		return nRow;
	},
	"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0 ] }],
    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "ALL"]],
    "oLanguage": { "sEmptyTable": "No data" }
});
</script>
<?php
		}
		else
		{
			if(count($oblozi) > 0):?>
<table id="adminTabela" class="dataTable addon">
	<thead>
		<tr>
			<th>#</th>
			<th>tipper</th>
			<th>date</th>
			<th>bet</th>
			<th>odd</th>
			<th>1</th>
			<th>X</th>
			<th>2</th>
			<th>1-1</th>
			<th>1-X</th>
			<th>1-2</th>
			<th>X-1</th>
			<th>X-X</th>
			<th>X-2</th>
			<th>2-1</th>
			<th>2-X</th>
			<th>2-2</th>
			<th>0-1</th>
			<th>2-3</th>
			<th>4-6</th>
			<th>7+</th>
			<th>G0-2</th>
			<th>G3+</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($oblozi as $o):
	switch ($o->uspesen) {
		case "1":
			$color = "green";
		break;
		case "0":
			$color = "red";
		break;
		
		default:
			$color = "black";
		break;
	}
	?>
		<tr>
			<td></td>
			<td><?php echo $o->username;?></td>
			<td><?php $datum = date_create_from_format("Y-m-d H:i:s", $o->datum);
			echo $datum->format("d M Y, H:i:s");?></td>
			<td><?php echo $o->ulog;?></td>
			<td><?php echo $o->koeficient;?></td>
			<td><?php if($o->tip == "1")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "0")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "2")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf1")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf2")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf3")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf4")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf5")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf6")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf7")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf8")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "hf9")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "g1")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "g2")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "g3")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "g4")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "u")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
			<td><?php if($o->tip == "o")
				echo '<div style="background-color: '.$color.'; height: 100%; width: 100%">&nbsp;</div>';?></td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>
<?php endif;
		}
	}
	function nov_tim()
	{
		$this->load->model("drzava");
		$this->load->model("sport");
		$drzavi = $this->drzava->getObjects("ORDER BY ime ASC");
		$sportovi = $this->sport->getObjects("ORDER BY ime ASC");
		?>
<div class="pole">
	<div class="labeler">Team</div>
	<div class="elements">
		<input name="tim[ime]">
		<input name="tim[grad]" value="">
	</div>
</div>
<div class="pole">
	<div class="labeler">Short name</div>
	<div class="elements">
		<input name="tim[kratenka]">
	</div>
</div>
<div class="pole">
	<div class="labeler">Country</div>
	<div class="elements">
		<select name="tim[drzava_id]">
			<option value="0" selected="selected" disabled="disabled">Select
				country</option>
			<?php foreach($drzavi as $t): ?>
			<option value="<?php echo $t->id; ?>">
				<?php echo $t->ime; ?>
			</option>
			<?php endforeach;?>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler">Sport</div>
	<div class="elements">
		<select name="tim[sport_id]">
			<?php foreach($sportovi as $t): ?>
			<option value="<?php echo $t->id; ?>">
				<?php echo $t->ime; ?>
			</option>
			<?php endforeach;?>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler">Type of team</div>
	<div class="elements">
		<select name="tim[tip]">
			<option value="1">Team</option>
			<option value="2">National team</option>
			<option value="3">Sportsman</option>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler" style="">TOP TEAM</div>
	<div class="elements">
		<input type="radio" value="1" name="tim[top]" id="yes"><label for="yes">Yes</label>
		<input type="radio" checked="checked" value="0" name="tim[top]" id="no"><label for="no">No</label>
	</div>
</div>
<div class="pole">
	<div class="labeler">Team logo</div>
	<div class="elements">
		<input type="file" name="picture">
	</div>
</div>
<div class="pole">
	<div class="labeler"></div>
	<div class="elements">
		<input type="submit" value="ADD TEAM">
	</div>
</div>
<script type="text/javascript">
$("form").validate({
	rules: {
		"tim[ime]": {
			required: true,
			minlength: 4 },
		"tim[drzava_id]": {
			required: true},
		"tim[sport_id]": {
			required: true}
	},
	messages: {
		"tim[ime]": {
			required: "Enter a team name",
			minlength: jQuery.format("Minimum {0} characters")},
		"tim[sport_id]": { required: "Select a sport"},
		"tim[drzava_id]": { required: "Select a country"}
	}
});
</script>
<?php
	}
	function smeni_tim()
	{
		$this->load->model("tim");
		$this->load->model("drzava");
		$this->load->model("sport");
		$item = $this->tim->oneObject($_POST['id']);
		$drzavi = $this->drzava->getObjects("ORDER BY ime ASC");
		$sportovi = $this->sport->getObjects("ORDER BY ime ASC");
		?>
<div class="pole">
	<div class="labeler">Team</div>
	<div class="elements">
		<input name="tim[ime]" value="<?php echo $item->ime;?>">
		<input name="tim[grad]" value="<?php echo $item->grad;?>">
	</div>
</div>
<div class="pole">
	<div class="labeler">Short name</div>
	<div class="elements">
		<input name="tim[kratenka]" value="<?php echo $item->kratenka;?>">
	</div>
</div>
<div class="pole">
	<div class="labeler">Country</div>
	<div class="elements">
		<select name="tim[drzava_id]">
			<?php foreach($drzavi as $t): ?>
			<option value="<?php echo $t->id; ?>"
			<?php echo ($t->id==$item->drzava_id)?
		' selected="selected"':'';?>>
				<?php echo $t->ime; ?>
			</option>
			<?php endforeach;?>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler">Sport</div>
	<div class="elements">
		<select name="tim[sport_id]">
			<?php foreach($sportovi as $t): ?>
			<option value="<?php echo $t->id; ?>"
			<?php echo ($t->id==$item->sport_id)?
		' selected="selected"':'';?>>
				<?php echo $t->ime; ?>
			</option>
			<?php endforeach;?>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler">Type of team</div>
	<div class="elements">
		<select name="tim[tip]">
			<option value="1" <?php echo ($item->tip==1)?' selected="selected"':'';?>>Team</option>
			<option value="2" <?php echo ($item->tip==2)?' selected="selected"':'';?>>National team</option>
			<option value="3" <?php echo ($item->tip==3)?' selected="selected"':'';?>>Sportsman</option>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler" style="">TOP TEAM</div>
	<div class="elements">
		<input type="radio"<?php echo ($item->top==1)?' checked="checked"':'';
		?> value="1" name="tim[top]" id="yes"><label for="yes">Yes</label>
		<input type="radio"<?php echo ($item->top==0)?' checked="checked"':'';
		?> value="0" name="tim[top]" id="no"><label for="no">No</label>
	</div>
</div>
<div class="pole">
	<div class="labeler">Team logo</div>
	<div class="elements">
		<input type="file" name="picture">
	</div>
</div>
<div class="pole">
	<div class="labeler"></div>
	<div class="elements">
		<input type="hidden" name="id" value="<?php echo $item->id;?>"> <input
			type="submit" value="EDIT TEAM">
	</div>
</div>
<script type="text/javascript">
$("form").validate({
	rules: {
		"tim[ime]": {
			required: true,
			minlength: 4 },
		"tim[drzava_id]": {
			required: true},
		"tim[sport_id]": {
			required: true}
	},
	messages: {
		"tim[ime]": {
			required: "Enter a team name",
			minlength: jQuery.format("Minimum {0} characters")},
		"tim[sport_id]": { required: "Select a sport"},
		"tim[drzava_id]": { required: "Select a country"}
	}
});
</script>
<?php
	}
	function smeni_koeficient()
	{
		$maxCel = 101;
		$this->load->model("natprevar");
		$natprevar = $this->natprevar->oneObject($_POST['id']);
		$pocetok = date_create_from_format("Y-m-d H:i:s", $natprevar->pocetok);
		if($pocetok > new DateTime("now", new DateTimeZone("Europe/Skopje")))
		{
			$sql = "natprevar_id=".$_POST['id'];
			$this->load->model("koeficient");
			$item = $this->koeficient->oneObject($sql);
			if(is_object($item)):
		?>
<fieldset style="display: inline-block; vertical-align: top;">
	<legend>Final result</legend>
	<div class="pole">
		<div class="labeler" style="text-align: right;">1</div>
		<div class="elements"><?php 
				$vrednost = explode(".", $item->prv);
				$celDel = $vrednost[0];
				if(count($vrednost)>1)
					$decDel = $vrednost[1];
				else 
					$decDel = 0;
				if($decDel > 9)
					$decDel = (int) $decDel/10;
			?><select class="cel">
			<?php for($i = 1; $i < $maxCel; $i++): ?>
				<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor; ?>
			</select>.<select class="dec">
			<?php for($j = 0; $j < 10; $j++): ?>
				<option<?php echo ($decDel==$j)?' selected="selected"':'';?> value="<?php echo $j; ?>"><?php echo $j; ?></option>
			<?php endfor; ?>
			</select>
			<input type="hidden" class="target" style="width: 50px;" name="koeficient[prv]" value="<?php echo $item->prv;?>">
		</div>
	</div>
	<div class="pole">
		<div class="labeler" style="text-align: right;">X</div>
		<div class="elements">
			<select class="cel"><?php 
			$vrednost = explode(".", $item->x);
			$celDel = (int)$vrednost[0];
			$decDel = (int)$vrednost[1];
			if($decDel > 9)
				$decDel = (int) $decDel/10;
			for($i = 1; $i < $maxCel; $i++): ?>
				<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor; ?>
			</select>.<select class="dec">
			<?php for($i = 0; $i < 10; $i++): ?>
				<option<?php echo ($decDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor; ?>
			</select>
			<input type="hidden" class="target" style="width: 50px;" name="koeficient[x]" value="<?php echo $item->x;?>">
		</div>
	</div>
	<div class="pole">
		<div class="labeler" style="text-align: right;">2</div>
		<div class="elements">
			<select class="cel"><?php 
			$vrednost = explode(".", $item->vtor);
			$celDel = (int)$vrednost[0];
			$decDel = (int)$vrednost[1];
			if($decDel > 9)
				$decDel = (int) $decDel/10;
			for($i = 1; $i < $maxCel; $i++): ?>
				<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor; ?>
			</select>.<select class="dec">
			<?php for($i = 0; $i < 10; $i++): ?>
				<option<?php echo ($decDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor; ?>
			</select>
			<input type="hidden" class="target" style="width: 50px;" name="koeficient[vtor]" value="<?php echo $item->vtor;?>">
		</div>
	</div>
</fieldset>
<fieldset style="display: inline-block; vertical-align: top;">
	<legend>Goals</legend>
	<div class="pole">
		<div class="labeler" style="text-align: right;">0-1</div>
		<div class="elements">
			<select class="cel"><?php 
			$vrednost = explode(".", $item->golovi0do1);
			$celDel = (int)$vrednost[0];
			$decDel = (int)$vrednost[1];
			if($decDel > 9)
				$decDel = (int) $decDel/10;
			for($i = 1; $i < $maxCel; $i++): ?>
				<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor; ?>
			</select>.<select class="dec">
			<?php for($i = 0; $i < 10; $i++): ?>
				<option<?php echo ($decDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor; ?>
			</select>
			<input type="hidden" class="target" style="width: 50px;" name="koeficient[golovi0do1]" value="<?php echo $item->golovi0do1;?>">
		</div>
	</div>
	<div class="pole">
		<div class="labeler" style="text-align: right;">2-3</div>
		<div class="elements">
			<select class="cel"><?php 
			$vrednost = explode(".", $item->golovi2do3);
			$celDel = (int)$vrednost[0];
			$decDel = (int)$vrednost[1];
			if($decDel > 9)
				$decDel = (int) $decDel/10;
			for($i = 1; $i < $maxCel; $i++): ?>
				<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor; ?>
			</select>.<select class="dec">
			<?php for($i = 0; $i < 10; $i++): ?>
				<option<?php echo ($decDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor; ?>
			</select>
			<input type="hidden" class="target" style="width: 50px;" name="koeficient[golovi2do3]" value="<?php echo $item->golovi2do3;?>">
		</div>
	</div>
	<div class="pole">
		<div class="labeler" style="text-align: right;">4-6</div>
		<div class="elements">
			<select class="cel"><?php 
			$vrednost = explode(".", $item->golovi4do6);
			$celDel = (int)$vrednost[0];
			$decDel = (int)$vrednost[1];
			if($decDel > 9)
				$decDel = (int) $decDel/10;
			for($i = 1; $i < $maxCel; $i++): ?>
				<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor; ?>
			</select>.<select class="dec">
			<?php for($i = 0; $i < 10; $i++): ?>
				<option<?php echo ($decDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor; ?>
			</select>
			<input type="hidden" class="target" style="width: 50px;" name="koeficient[golovi4do6]" value="<?php echo $item->golovi4do6;?>">
		</div>
	</div>
	<div class="pole">
		<div class="labeler" style="text-align: right;">7+</div>
		<div class="elements">
			<select class="cel"><?php 
			$vrednost = explode(".", $item->golovi7plus);
			$celDel = (int)$vrednost[0];
			$decDel = (int)$vrednost[1];
			if($decDel > 9)
				$decDel = (int) $decDel/10;
			for($i = 1; $i < $maxCel; $i++): ?>
				<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor; ?>
			</select>.<select class="dec">
			<?php for($i = 0; $i < 10; $i++): ?>
				<option<?php echo ($decDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor; ?>
			</select>
			<input type="hidden" class="target" style="width: 50px;" name="koeficient[golovi7plus]" value="<?php echo $item->golovi7plus;?>">
		</div>
	</div>
</fieldset>
<fieldset style="display: inline-block; vertical-align: top;">
	<legend>First half - Final result</legend>
	<div style="float: left; vertical-align: top;">
		<div class="pole">
			<div class="labeler" style="text-align: right;">1-1</div>
			<div class="elements">
				<select class="cel"><?php 
				$vrednost = explode(".", $item->prvprv);
				$celDel = (int)$vrednost[0];
				$decDel = (int)$vrednost[1];
				if($decDel > 9)
					$decDel = (int) $decDel/10;
				for($i = 1; $i < $maxCel; $i++): ?>
					<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>.<select class="dec">
				<?php for($i = 0; $i < 10; $i++): ?>
					<option<?php echo ($decDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[prvprv]" value="<?php echo $item->prvprv;?>">
			</div>
		</div>
		<div class="pole">
			<div class="labeler" style="text-align: right;">1-X</div>
			<div class="elements">
				<select class="cel"><?php 
				$vrednost = explode(".", $item->prvx);
				$celDel = (int)$vrednost[0];
				$decDel = (int)$vrednost[1];
				if($decDel > 9)
					$decDel = (int) $decDel/10;
				for($i = 1; $i < $maxCel; $i++): ?>
					<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>.<select class="dec">
				<?php for($i = 0; $i < 10; $i++): ?>
					<option<?php echo ($decDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[prvx]" value="<?php echo $item->prvx;?>">
			</div>
		</div>
		<div class="pole">
			<div class="labeler" style="text-align: right;">1-2</div>
			<div class="elements">
				<select class="cel"><?php 
				$vrednost = explode(".", $item->prvvtor);
				$celDel = (int)$vrednost[0];
				$decDel = (int)$vrednost[1];
				if($decDel > 9)
					$decDel = (int) $decDel/10;
				for($i = 1; $i < $maxCel; $i++): ?>
					<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>.<select class="dec">
				<?php for($i = 0; $i < 10; $i++): ?>
					<option<?php echo ($decDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[prvvtor]" value="<?php echo $item->prvvtor;?>">
			</div>
		</div>
	</div>
	<div style="float: left; vertical-align: top;">
		<div class="pole">
			<div class="labeler" style="text-align: right;">X-1</div>
			<div class="elements">
				<select class="cel"><?php 
				$vrednost = explode(".", $item->xprv);
				$celDel = (int)$vrednost[0];
				$decDel = (int)$vrednost[1];
				if($decDel > 9)
					$decDel = (int) $decDel/10;
				for($i = 1; $i < $maxCel; $i++): ?>
					<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>.<select class="dec">
				<?php for($i = 0; $i < 10; $i++): ?>
					<option<?php echo ($decDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[xprv]" value="<?php echo $item->xprv;?>">
			</div>
		</div>
		<div class="pole">
			<div class="labeler" style="text-align: right;">X-X</div>
			<div class="elements">
				<select class="cel"><?php 
				$vrednost = explode(".", $item->xx);
				$celDel = (int)$vrednost[0];
				$decDel = (int)$vrednost[1];
				if($decDel > 9)
					$decDel = (int) $decDel/10;
				for($i = 1; $i < $maxCel; $i++): ?>
					<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>.<select class="dec">
				<?php for($i = 0; $i < 10; $i++): ?>
					<option<?php echo ($decDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[xx]" value="<?php echo $item->xx;?>">
			</div>
		</div>
		<div class="pole">
			<div class="labeler" style="text-align: right;">X-2</div>
			<div class="elements">
				<select class="cel"><?php 
				$vrednost = explode(".", $item->xvtor);
				$celDel = (int)$vrednost[0];
				$decDel = (int)$vrednost[1];
				if($decDel > 9)
					$decDel = (int) $decDel/10;
				for($i = 1; $i < $maxCel; $i++): ?>
					<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>.<select class="dec">
				<?php for($i = 0; $i < 10; $i++): ?>
					<option<?php echo ($decDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[xvtor]" value="<?php echo $item->xvtor;?>">
			</div>
		</div>
	</div>
	<div style="float: left; vertical-align: top;">
		<div class="pole">
			<div class="labeler" style="text-align: right;">2-1</div>
			<div class="elements">
				<select class="cel"><?php 
				$vrednost = explode(".", $item->vtorprv);
				$celDel = (int)$vrednost[0];
				$decDel = (int)$vrednost[1];
				if($decDel > 9)
					$decDel = (int) $decDel/10;
				for($i = 1; $i < $maxCel; $i++): ?>
					<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>.<select class="dec">
				<?php for($i = 0; $i < 10; $i++): ?>
					<option<?php echo ($decDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[vtorprv]" value="<?php echo $item->vtorprv;?>">
			</div>
		</div>
		<div class="pole">
			<div class="labeler" style="text-align: right;">2-X</div>
			<div class="elements">
				<select class="cel"><?php 
				$vrednost = explode(".", $item->vtorx);
				$celDel = (int)$vrednost[0];
				$decDel = (int)$vrednost[1];
				if($decDel > 9)
					$decDel = (int) $decDel/10;
				for($i = 1; $i < $maxCel; $i++): ?>
					<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>.<select class="dec">
				<?php for($i = 0; $i < 10; $i++): ?>
					<option<?php echo ($decDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[vtorx]" value="<?php echo $item->vtorx;?>">
			</div>
		</div>
		<div class="pole">
			<div class="labeler" style="text-align: right;">2-2</div>
			<div class="elements">
				<select class="cel"><?php 
				$vrednost = explode(".", $item->vtorvtor);
				$celDel = (int)$vrednost[0];
				$decDel = (int)$vrednost[1];
				if($decDel > 9)
					$decDel = (int) $decDel/10;
				for($i = 1; $i < $maxCel; $i++): ?>
					<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>.<select class="dec">
				<?php for($i = 0; $i < 10; $i++): ?>
					<option<?php echo ($decDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[vtorvtor]" value="<?php echo $item->vtorvtor;?>">
			</div>
		</div>
	</div>
</fieldset>
<fieldset style="display: inline-block; vertical-align: top;">
	<legend>Under/Over goals</legend>
	<div class="pole">
		<div class="labeler" style="text-align: right;">Over</div>
		<div class="elements">
			<select class="cel"><?php 
				$vrednost = explode(".", $item->ov);
				$celDel = (int)$vrednost[0];
				$decDel = (int)$vrednost[1];
				if($decDel > 9)
					$decDel = (int) $decDel/10;
				for($i = 1; $i < $maxCel; $i++): ?>
					<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>.<select class="dec">
				<?php for($i = 0; $i < 10; $i++): ?>
					<option<?php echo ($decDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
				<?php endfor; ?>
				</select>
				<input type="hidden" class="target" style="width: 50px;" name="koeficient[ov]" value="<?php echo $item->ov;?>">
		</div>
	</div>
	<div class="pole">
		<div class="labeler" style="text-align: right;">Under</div>
		<div class="elements">
			<select class="cel"><?php 
			$vrednost = explode(".", $item->un);
			$celDel = (int)$vrednost[0];
			$decDel = (int)$vrednost[1];
			if($decDel > 9)
				$decDel = (int) $decDel/10;
			for($i = 1; $i < $maxCel; $i++): ?>
				<option<?php echo ($celDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor; ?>
			</select>.<select class="dec">
			<?php for($i = 0; $i < 10; $i++): ?>
				<option<?php echo ($decDel==$i)?' selected="selected"':'';?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php endfor; ?>
			</select>
			<input type="hidden" class="target" style="width: 50px;" name="koeficient[un]" value="<?php echo $item->un;?>">
		</div>
	</div>
</fieldset>
<div class="pole">
	<div class="labeler" style="text-align: right;"></div>
	<div class="elements">
		<input type="hidden" name="id" value="<?php echo $item->id;?>"> <input
			type="hidden" name="koeficient[natprevar_id]"
			value="<?php echo $_POST['id'];?>"> <input type="submit"
			value="EDIT COEFICIENT">
	</div>
</div>
<script type="text/javascript">
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
<?php else: ?>
<fieldset class="pole">
	<legend><?php echo $natprevar->id.": ".$natprevar->domasni." vs ".$natprevar->gosti; ?></legend>
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
				<input type="hidden" name="koeficient[natprevar_id]" value="<?php echo $natprevar->id;?>">
			</div>
		</div>
	</fieldset>
</fieldset>
<div class="pole">
	<div class="labeler" style="text-align: right;"></div>
	<div class="elements">
		<input type="hidden" name="koeficient[natprevar_id]"
			value="<?php echo $_POST['id'];?>"> <input type="submit"
			value="ADD COEFICIENT">
	</div>
</div>
<script type="text/javascript">
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
<?php
endif;
		}
	}
	function nov_sampionat()
	{
		$this->load->model("sport");
		$this->load->model("drzava");
		$sportovi = $this->sport->getObjects("ORDER BY ime ASC");
		$drzavi = $this->drzava->getObjects("ORDER BY ime ASC");
		?>
<div class="pole">
	<div class="labeler">Championship</div>
	<div class="elements">
		<input name="sampionat[ime]" value="">
	</div>
</div>
<div class="pole">
	<div class="labeler">Sport</div>
	<div class="elements">
		<select name="sampionat[sport_id]">
			<?php foreach($sportovi as $t): ?>
			<option value="<?php echo $t->id; ?>">
				<?php echo $t->ime; ?>
			</option>
			<?php endforeach;?>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler">Country</div>
	<div class="elements">
		<select name="sampionat[drzava_id]">
			<option value="0">Multiple countries</option>
			<?php foreach($drzavi as $t): ?>
			<option value="<?php echo $t->id; ?>">
				<?php echo $t->ime; ?>
			</option>
			<?php endforeach;?>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler">Championship image</div>
	<div class="elements">
		<input type="file" name="picture">
	</div>
</div>
<div class="pole">
	<div class="labeler" style="">Top</div>
	<div class="elements">
		<input type="radio" value="1" name="sampionat[top]" id="yes"><label for="yes">Yes</label>
		<input type="radio" checked="checked" value="0" name="sampionat[top]" id="no"><label for="no">No</label>
	</div>
</div>
<div class="pole">
	<div class="labeler"></div>
	<div class="elements">
		<input type="submit" value="ADD CHAMPIONSHIP">
	</div>
</div>
<script type="text/javascript">
$("form").validate({
	rules: {
		"sampionat[ime]": {
			required: true,
			minlength: 3 },
		"sampionat[sport_id]": { required: true},
		"sampionat[drzava_id]": { required: true}
	},
	messages: {
		"sampionat[ime]": {
			required: "Enter championship name",
			minlength: jQuery.format("Minimum {0} characters")},
		"sampionat[sport_id]": { required: "Select a sport"},
		"sampionat[drzava_id]": { required: "Select a country"}
	}
});
</script>
<?php
	}
	function smeni_sampionat()
	{
		$this->load->model("sampionat");
		$this->load->model("sport");
		$this->load->model("drzava");
		$item = $this->sampionat->oneObject($_POST['id']);
		$sportovi = $this->sport->getObjects("ORDER BY ime ASC");
		$drzavi = $this->drzava->getObjects("ORDER BY ime ASC");
		?>
<div class="pole">
	<div class="labeler">Championship</div>
	<div class="elements">
		<input name="sampionat[ime]" value="<?php echo $item->ime; ?>">
	</div>
</div>
<div class="pole">
	<div class="labeler">Sport</div>
	<div class="elements">
		<select name="sampionat[sport_id]">
			<?php foreach($sportovi as $t): ?>
			<option value="<?php echo $t->id; ?>"
			<?php echo ($t->id==$item->sport_id)?
		' selected="selected"':'';?>>
				<?php echo $t->ime; ?>
			</option>
			<?php endforeach;?>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler">Country</div>
	<div class="elements">
		<select name="sampionat[drzava_id]">
			<option value="0">Multiple countries</option>
			<?php foreach($drzavi as $t): ?>
			<option value="<?php echo $t->id; ?>"
			<?php echo ($t->id==$item->drzava_id)?
		' selected="selected"':'';?>>
				<?php echo $t->ime; ?>
			</option>
			<?php endforeach;?>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler">Championship image</div>
	<div class="elements">
		<input type="file" name="picture">
	</div>
</div>
<div class="pole">
	<div class="labeler" style="">Top</div>
	<div class="elements">
		<input type="radio"<?php echo ($item->top==1)?' checked="checked"':'';
		?> value="1" name="sampionat[top]" id="yes"><label for="yes">Yes</label>
		<input type="radio"<?php echo ($item->top==0)?' checked="checked"':'';
		?> value="0" name="sampionat[top]" id="no"><label for="no">No</label>
	</div>
</div>
<div class="pole">
	<div class="labeler"></div>
	<div class="elements">
		<input type="hidden" name="id" value="<?php echo $item->id;?>"> <input
			type="submit" value="EDIT CHAMPIONSHIP">
	</div>
</div>
<script type="text/javascript">
$("form").validate({
	rules: {
		"sampionat[ime]": {
			required: true,
			minlength: 3 },
		"sampionat[sport_id]": { required: true},
		"sampionat[drzava_id]": { required: true}
	},
	messages: {
		"sampionat[ime]": {
			required: "Enter championship name",
			minlength: jQuery.format("Minimum {0} characters")},
		"sampionat[sport_id]": { required: "Select a sport"},
		"sampionat[drzava_id]": { required: "Select a country"}
	}
});
</script>
<?php
	}
	function nov_kolo()
	{
		$sql = "SELECT s.id, s.ime, l.ime as liga FROM
		sezona AS s INNER JOIN sampionati as l ON s.sampionat_id=l.id";
		$sezoni = $this->db->query($sql)->result();
		?>
<div class="pole">
	<div class="labeler" style="">Round</div>
	<div class="elements">
		<input type="text" value="" name="kolo[ime]">
	</div>
</div>
<div class="pole">
	<div class="labeler" style="">Season</div>
	<div class="elements">
		<select name="kolo[sezona_id]">
			<?php foreach($sezoni as $s): ?>
			<option value="<?php echo $s->id;?>">
				<?php echo $s->ime." - ".$s->liga; ?>
			</option>
			<?php endforeach;?>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler" style=""></div>
	<div class="elements">
		<input type="submit" value="ADD ROUND">
	</div>
</div>
<script type="text/javascript">
$("form").validate({
	rules: {
		"kolo[ime]": {required: true},
		"kolo[sezona_id]": {required: true}
	},
	messages: {
		"kolo[ime]": {required: "Enter name"},
		"kolo[sezona_id]": {required: "Select a season"}
	}
});
</script>
<?php
	}
	function smeni_kolo()
	{
		$this->load->model("kolo");
		$this->load->model("sezona");
		$kolo = $this->kolo->oneObject($_POST['id']);
		$sezoni = $this->sezona->getObjects();
		?>
<div class="pole">
	<div class="labeler" style="">Round</div>
	<div class="elements">
		<input type="text" value="<?php echo $kolo->ime;?>" name="kolo[ime]">
	</div>
</div>
<div class="pole">
	<div class="labeler" style="">Season</div>
	<div class="elements">
		<select name="kolo[sezona_id]">
			<?php foreach($sezoni as $s): ?>
			<option value="<?php echo $s->id;?>"
			<?php echo ($kolo->sezona_id==$s->id)?' selected="selected"':'';?>>
				<?php echo $s->ime; ?>
			</option>
			<?php endforeach;?>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler" style=""></div>
	<div class="elements">
		<input type="hidden" value="<?php echo $kolo->id;?>" name="id"> <input
			type="submit" value="EDIT ROUND">
	</div>
</div>
<script type="text/javascript">
$("form").validate({
	rules: {
		"kolo[ime]": {required: true},
		"kolo[sezona_id]": {required: true}
	},
	messages: {
		"kolo[ime]": {required: "Enter name"},
		"kolo[sezona_id]": {required: "Select a season"}
	}
});
</script>
<?php
	}
	function nova_sezona()
	{
		$this->load->model('sampionat');
		$sampionati = $this->sampionat->getObjects("ORDER BY ime ASC");
		?>
<div class="pole">
	<div class="labeler" style="">Season</div>
	<div class="elements">
		<input type="text" value="" name="sezona[ime]">
	</div>
</div>
<div class="pole">
	<div class="labeler" style="">Championship</div>
	<div class="elements">
		<select name="sezona[sampionat_id]">
			<?php foreach($sampionati as $s): ?>
			<option value="<?php echo $s->id;?>">
				<?php echo $s->ime; ?>
			</option>
			<?php endforeach;?>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler" style=""></div>
	<div class="elements">
		<input type="submit" value="ADD SEASON">
	</div>
</div>
<script type="text/javascript">
$("form").validate({
	rules: {
		"sezona[ime]": {
			required: true,
			minlength: 4 },
		"sezona[sampionat_id]": {
			required: true}
	},
	messages: {
	"sezona[ime]": {
		required: "Enter season",
		minlength: jQuery.format("Minimum {0} characters")},
	"sezona[sampionat_id]": {
		required: "Select championship"
		}
	}
});
</script>
<?php
	}
	function smeni_sezona()
	{
		$this->load->model("sezona");
		$this->load->model('sampionat');
		$sezona = $this->sezona->oneObject($_POST['id']);
		$sampionati = $this->sampionat->getObjects("ORDER BY ime ASC");
		?>
<div class="pole">
	<div class="labeler" style="">Season</div>
	<div class="elements">
		<input type="text" value="<?php echo $sezona->ime;?>" name="sezona[ime]">
	</div>
</div>
<div class="pole">
	<div class="labeler" style="">Active season</div>
	<div class="elements">
		<input type="radio"<?php echo ($sezona->aktiven==1)?' checked="checked"':'';
		?> value="1" name="sezona[aktiven]" id="yes"><label for="yes">Yes</label>
		<input type="radio"<?php echo ($sezona->aktiven==0)?' checked="checked"':'';
		?> value="0" name="sezona[aktiven]" id="no"><label for="no">No</label>
	</div>
</div>
<div class="pole">
	<div class="labeler" style="">Championship</div>
	<div class="elements">
		<select name="sezona[sampionat_id]">
			<?php foreach($sampionati as $s): ?>
			<option value="<?php echo $s->id;?>"
			<?php echo ($sezona->sampionat_id==$s->id)?' selected="selected"':'';?>>
				<?php echo $s->ime; ?>
			</option>
			<?php endforeach;?>
		</select>
	</div>
</div>
<div class="pole">
	<div class="labeler" style=""></div>
	<div class="elements">
		<input type="hidden" value="<?php echo $sezona->id;?>" name="id">
		<input type="submit" value="EDIT SEASON">
	</div>
</div>
<script type="text/javascript">
$("form").validate({
	rules: {
		"sezona[ime]": {
			required: true,
			minlength: 4 },
		"sezona[sampionat_id]": {
			required: true}
	},
	messages: {
	"sezona[ime]": {
		required: "Enter season",
		minlength: jQuery.format("Minimum {0} characters")},
	"sezona[sampionat_id]": {
		required: "Select championship"}
	}
});
</script>
<?php
	}
	function smeni_rezultat()
	{
		$this->load->model("natprevar");
		$item = $this->natprevar->oneObject($_POST['id']);
		?>
<div class="pole">
	<div class="labeler" style="width: 150px;">Final Result</div>
	<div class="elements">
		<input style="width: 50px;" name="natprevar[domasni4]"
			value="<?php echo $item->domasni4; ?>">
	</div>
	<div class="elements">
		<input style="width: 50px;" name="natprevar[gosti4]"
			value="<?php echo $item->gosti4; ?>">
	</div>
</div>
<div class="pole">
	<div class="labeler" style="width: 150px;">Half time result</div>
	<div class="elements">
		<input style="width: 50px;" name="natprevar[domasni2]"
			value="<?php echo $item->domasni2; ?>">
	</div>
	<div class="elements">
		<input style="width: 50px;" name="natprevar[gosti2]"
			value="<?php echo $item->gosti2; ?>">
	</div>
</div>
<div class="pole">
	<div class="labeler"></div>
	<div class="elements">
		<input type="hidden" name="id" value="<?php echo $item->id;?>"> <input
			type="submit" value="EDIT SCORE">
	</div>
</div>
<script type="text/javascript">
$("form").validate({
	rules: {
	"natprevar[domasni2]": { required: true },
	"natprevar[gosti2]": { required: true },
	"natprevar[domasni4]": { required: true },
	"natprevar[gosti4]": { required: true}
	},
	messages: {
	"natprevar[domasni2]": { required: "Enter a score"},
	"natprevar[gosti2]": { required: "Enter a score"},
	"natprevar[domasni4]": { required: "Enter a score"},
	"natprevar[gosti4]": { required: "Enter a score"}
	}
});
</script>
<?php
	}
	function vidi_rezultat()
	{
		$this->load->model("natprevar");
		$item = $this->natprevar->oneObject($_POST['id']);
		?>
<div class="pole">
	<div class="labeler" style="width: 150px;">Final Result</div>
	<div class="elements">
		<?php echo $item->domasni4." : ".$item->gosti4; ?>
	</div>
</div>
<div class="pole">
	<div class="labeler" style="width: 150px;">Half time result</div>
	<div class="elements">
		<?php echo $item->domasni2." : ".$item->gosti2; ?>
	</div>
</div>
<?php
	}
	function sezoni_sampionat()
	{
		$this->load->model('sampionat');
		$sampionat = $this->sampionat->oneObject($_POST["id"]);
		$sezoni = $this->db->where('sampionat_id', $_POST["id"])->get('sezona')->result();
		echo "Available seasons for ".$sampionat->ime.": ";
		foreach($sezoni as $s):
		?>
		<button value="<?php echo $s->id;?>"><?php echo $s->ime;?></button>
		<?php 
		endforeach;
		?>
<script type="text/javascript">
$('button').click(function(){
	$.ajax({
		url: "<?php echo base_url('ajax/timovi_sampionat');?>",
		type: "POST",
		data: {id: $(this).val()},
		error: function()
		{
			$('#ipon').html("error");
		},
		success: function(data)
		{
			$('#ipon').html(data);
		}
		});
});
</script>
		<?php
	}
	function timovi_sampionat()
	{
		$this->load->model('sezona');
		$this->load->model('drzava');
		$sezona = $this->sezona->oneObject($_POST['id']);
		$sampionat = $this->db->query("SELECT * FROM sampionati WHERE id=".$sezona->sampionat_id)->row();
		?>
<form method="post" action="<?php echo base_url("admin_sampionati/select");?>">
<div class='pole'>
	<div class='labeler'>Select teams that play in the <?php echo $sampionat->ime; ?> season <?php 
		echo $sezona->ime;?></div>
	<div class='elements'><br>
		<?php
		$sql = "SELECT *,(SELECT sezona_id FROM sezona_tim WHERE tim_id=timovi.id AND sezona_id=".$sezona->id.
			") AS sezona_id FROM timovi WHERE sport_id=".$sampionat->sport_id;
		$broj=0;
		if($sampionat->drzava_id):
		$sql .= " AND drzava_id=".$sampionat->drzava_id;
		$timovi = $this->db->query($sql." ORDER BY ime ASC")->result();
		$r = 0;
		foreach ($timovi as $t):
		$r++;
		?>
		<input id="<?php echo $t->id; ?>" type="checkbox" name='timovi[<?php echo $broj;?>]' value='<?php 
		echo $t->id;?>' <?php echo ($sezona->id==$t->sezona_id)?'checked="checked"':'';?>>
		<label for="<?php echo $t->id; ?>"><?php echo ($t->grad)?$t->ime.' '.$t->grad:$t->ime; ?></label>
		<?php $broj++; 
			if($r > 5)
			{
				$r = 0;
				echo "<br>";
			}
		endforeach;
		else:
		$drzavi = $this->drzava->getObjects("ORDER BY ime ASC");
		foreach($drzavi as $d):
		$timovi = $this->db->query($sql." AND drzava_id=".$d->id." ORDER BY ime ASC")->result();
		if(count($timovi)>0):
		?>
		<br><fieldset>
			<legend><?php echo $d->ime; ?></legend>
			<input class="ttt" type="checkbox" id="<?php echo $d->ime; ?>">
			<label for="<?php echo $d->ime; ?>">Select all from <?php echo $d->ime;?></label><br>
		<?php 
			$r = 0;
			foreach ($timovi as $t):
			$r++;
			?>
			<input class="takvoto" id="<?php echo $t->id; ?>" type="checkbox" name='timovi[<?php echo $broj;?>]' value='<?php 
			echo $t->id;?>' <?php echo ($sezona->id==$t->sezona_id)?'checked="checked"':'';?>>
			<label for="<?php echo $t->id; ?>"><?php echo $t->ime; ?></label>
			<?php $broj++; 
			if($r > 4)
			{
				$r = 0;
				echo "<br>";
			}
			endforeach;?>
		</fieldset>
		<?php
		endif;
		endforeach;
		?>
		<script type="text/javascript">
		$('.ttt').click(function(){
			var sostojba = $(this).is(':checked');
			$(this).siblings('.takvoto').each(function(){
				$(this).prop('checked', sostojba);
			});
		});
		</script>
		<?php
		endif;
		?>
	</div>
</div>
<div class='pole'>
	<div class='labeler'></div>
	<div class='elements'>
		<input type='hidden' name='id' value='<?php echo $sezona->id;?>'>
		<input type='submit' value='UPDATE'>
	</div>
</div>
</form>
		<?php
	}
	function addRoundPlus()
	{
		$sezona_id = $_POST['id'];
		$nov = $_POST['nov'];
		$this->load->model('kolo');
		$data = array("sezona_id"=>$sezona_id, "ime"=>$nov);
		$this->kolo->insert($data);
		$sql = "SELECT * FROM kolo WHERE sezona_id=".$sezona_id." ORDER BY id DESC";
		$kolo = $this->db->query($sql)->result();
		?>
		<option disabled="disabled" selected="selected">Select a round</option>
		<?php
		foreach($kolo as $t):
		?>
		<option value="<?php echo $t->id;?>"><?php echo $t->ime;?></option>
		<?php
		endforeach;
	}
	function optionsSampionat()
	{
		$sql = "SELECT s.id, CONCAT_WS(' ', s.ime,'[',d.ime,']') AS ime
			FROM sampionati AS s LEFT JOIN drzavi AS d ON d.id=s.drzava_id
			WHERE sport_id=".$_POST["id"]."
			ORDER BY s.ime ASC";
		$sampionati = $this->db->query($sql)->result();
		?>
		<option disabled="disabled" selected="selected">Select a championship</option>
		<?php
		foreach($sampionati as $t):
		?>
		<option value="<?php echo $t->id;?>"><?php echo $t->ime;?></option>
		<?php
		endforeach;
	}
	function polinjaSampionat()
	{
		$sql = "SELECT * FROM sampionati WHERE sport_id=".$_POST["id"]." ORDER BY ime ASC";
		$sampionati = $this->db->query($sql)->result();
		foreach($sampionati as $s):
		?>
		<div class="meni_pole"><a href="<?php echo base_url('/teams/index/'.$s->id); ?>"><?php 
			echo $s->ime; ?></a></div>
		<?php
		endforeach;
	}
	function optionsSezona()
	{
		$sql = "SELECT * FROM sezona WHERE sampionat_id=".$_POST['id']." ORDER BY ime DESC";
		$sezona = $this->db->query($sql)->result();
		foreach($sezona as $t):
		?>
		<option<?php echo ($t->aktiven)?' selected="selected"':'';?> value="<?php echo $t->id;?>"><?php 
		echo $t->ime;?></option>
		<?php
		endforeach;
	}
	function optionsKolo()
	{
		$sql = "SELECT * FROM kolo WHERE sezona_id=".$_POST['id']." ORDER BY id DESC";
		$kolo = $this->db->query($sql)->result();
		?>
		<option disabled="disabled" selected="selected">Select a round</option>
		<?php
		foreach($kolo as $t):
		?>
		<option value="<?php echo $t->id;?>"><?php echo $t->ime;?></option>
		<?php
		endforeach;
	}
	function optionsTimovi()
	{
		$sql = "SELECT t.* FROM timovi AS t INNER JOIN sezona_tim AS k ON k.tim_id=t.id
					INNER JOIN sezona AS s ON s.id=k.sezona_id INNER JOIN kolo AS x ON x.sezona_id=s.id
					WHERE x.id=".$_POST["id"]." ORDER BY t.ime ASC";
		$timovi = $this->db->query($sql)->result();
		?><option value="0" selected="selected">SELECT A TEAM</option><?php
		foreach($timovi as $t):
		?>
		<option value="<?php echo $t->id;?>"><?php echo $t->grad." ".$t->ime;?></option>
		<?php
		endforeach;
	}
	function polinjaTimovi()
	{
		$sql = "SELECT t.* FROM timovi AS t INNER JOIN sezona_tim AS k ON k.tim_id=t.id
			INNER JOIN sezona AS s ON s.id=k.sezona_id WHERE s.sampionat_id=".$_POST["id"].
			" ORDER BY t.ime ASC";
		$timovi = $this->db->query($sql)->result();
		foreach($timovi as $t):
		?>
		<div class="meni_pole"><a href="<?php echo base_url('/teams/index/'.$t->id); ?>"><?php 
			echo $t->ime; ?></a></div>
		<?php
		endforeach;
	}
	function detaliNatprevar()
	{
	$broj = $_POST['id'];
	$sql = "SELECT d.ime AS domasni, g.ime AS gosti, domasni1, gosti1, domasni2, gosti2,s.ime AS sezona,
			domasni4, gosti4, l.ime AS sampionat, n.pocetok, n.kraj, n.vnesen, n.vidliv, c.id AS koef,
			(SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) AS oblozi
			FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id WHERE n.id=".$broj;
	$timezone = "Europe/Skopje";
	$format = "d M Y H:i";
	$data = $this->db->query($sql)->row();
	?>
	<div class="pole">
	<div class="elements"><?php echo "Championship: ".$data->sampionat;?></div>
	<div class="elements"><?php echo "Season: ".$data->sezona;?></div>
	<div class="elements"><b><?php echo $data->domasni." : ".$data->gosti;?></b></div>
	<div class="elements"><?php $datum = new DateTime($data->pocetok, new DateTimeZone($timezone)); 
	echo "Started ".$datum->format($format);?></div>
	<div class="elements"><?php $datum = new DateTime($data->kraj, new DateTimeZone($timezone)); 
	echo "Finished  ".$datum->format($format);?></div>
	</div>
	<?php
	}
	function pokaneti()
	{
		$fb_user = $this->auth->is_logged_in();
		if($fb_user)
		{
			$this->load->model('korisnik');
			$user = $this->korisnik->profil2($fb_user["username"]);
		}
		$prateno = $_POST["data"];
		//Array ( [request] => 509108689149613 [to] => Array ([0] => 651889787 )) 
		$data["request_id"] = $prateno["request"];
		$lista = $prateno["to"];
		$data["tipuvac_id"] = $user->id;
		$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$data["datum"] = $sega->format("Y-m-d H:i:s");
		$this->load->model("pokani");
		foreach($lista as $i)
		{
			$data["pokanet"] = $i;
			$query = $this->db->query("SELECT * FROM pokani WHERE pokanet=".$i);
			if($query->num_rows() === 0)
				$this->pokani->insert($data);
		}
	}
	function page()
	{
		$id = (int)$this->input->post('id');
		$this->load->model("pages");
		if($id):
		$page = $this->pages->oneObject($id);
		?>
<!-- <div class="pole">
	<div class="labeler" style="width: 100px;">Link</div>
	<div class="elements">
		<input type="text" style="width: 800px;" name="page[link]"
			value="<?php echo html_entity_decode($page->link); ?>" />
	</div>
</div> -->
<div class="pole">
	<div class="labeler" style="width: 100px;">Title</div>
	<div class="elements">
		<textarea name="page[naslov]" rows="2"
			style="resize: none; width: 800px; font-weight: bold; font-size: 17px;"><?php
			 echo html_entity_decode($page->naslov);?></textarea>
	</div>
</div>
<div class="pole">
	<div class="labeler" style="width: 100px;">Content</div>
	<div class="elements">
		<textarea name="page[tekst]" rows="15" id="sodrzina" style="resize: none; width: 800px;"><?php
			echo html_entity_decode($page->tekst);?></textarea>
	</div>
</div>
<div class="pole">
	<div class="labeler" style="width: 100px;"></div>
	<div class="elements">
		<input type="submit" class="submit" value="UPDATE" />
		<?php if($id > 7):?>
		<a style="text-decoration: none;" class="submit" href="<?php echo base_url()."admin_pages/delete/".$id; ?>">DELETE</a>
		<?php endif;?>
	</div>
</div>
<input type="hidden" name="id" value="<?php echo $id; ?>"/>

<?php
else:
?>
<!-- <div class="pole">
	<div class="labeler" style="width: 100px;">Link</div>
	<div class="elements">
		<input type="text" style="width: 800px;" name="page[link]" value="" />
	</div>
</div> -->
<div class="pole">
	<div class="labeler" style="width: 100px;">Title</div>
	<div class="elements">
		<textarea name="page[naslov]" rows="2"
			style="resize: none; width: 800px; font-weight: bold; font-size: 17px;"></textarea>
	</div>
</div>
<div class="pole">
	<div class="labeler" style="width: 100px;">Content</div>
	<div class="elements">
		<textarea name="page[tekst]" rows="15" id="sodrzina" style="resize: none; width: 800px;"></textarea>
	</div>
</div>
<div class="pole">
	<div class="labeler" style="width: 100px;"></div>
	<div class="elements">
		<input type="submit" class="submit" value="INSERT" />
	</div>
</div>
<?php
endif;
	}
	function tabelaSledenje()
	{
		$id = $this->input->post('id');
		$username = $this->input->post('username');
		$sql = "SELECT t2.username, s.od_datum FROM sledenje s INNER JOIN tipuvaci t1 ON s.tipuvac_id=t1.id
				INNER JOIN tipuvaci t2 ON s.sledi_tipuvac=t2.id WHERE t1.id=".$id;
		$lista = $this->db->query($sql)->result();
		if(count($lista) > 0):?>
		<h3>Users that <?php echo $username; ?> follow</h3>
		<table id="adminTabela" class="dataTable addon">
			<thead>
				<tr>
					<th>#</th>
					<th>username</th>
					<th>following from</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($lista as $o):?>
				<tr>
					<td></td>
					<td><?php echo $o->username;?></td>
					<td><?php $datum = date_create_from_format("Y-m-d H:i:s", $o->od_datum);
					echo $datum->format("d M Y, H:i:s");?></td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
		<?php 
		else:
		echo "This user don't follow any other user...<br>"; 
		endif;

		$sql = "SELECT t1.username, s.od_datum FROM sledenje s INNER JOIN tipuvaci t1 ON s.tipuvac_id=t1.id
				INNER JOIN tipuvaci t2 ON s.sledi_tipuvac=t2.id WHERE t2.id=".$id;
		$lista = $this->db->query($sql)->result();
		if(count($lista) > 0):?>
		<h3>Users that follow <?php echo $username; ?></h3>
		<table id="adminTabela" class="dataTable addon">
			<thead>
				<tr>
					<th>#</th>
					<th>username</th>
					<th>following from</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($lista as $o):?>
				<tr>
					<td></td>
					<td><?php echo $o->username;?></td>
					<td><?php $datum = date_create_from_format("Y-m-d H:i:s", $o->od_datum);
					echo $datum->format("d M Y, H:i:s");?></td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
		<?php 
		else:
		echo "This user is not followed by any user..."; 
		endif;
	}
	function tiket()
	{
		$this->load->model('korisnik');
		$tipuvac = $this->korisnik->oneObject($this->input->post('id'));
		$this->load->helper('string');
		$code = (int)random_string('numeric', 6);
		$code = substr($code, 0, 5);
		?>
		<div class="pole">
			<div class="labeler" style="width: 150px;">Random ticket code</div>
			<div class="elements"><input readonly="readonly" name="tiket[code]" value="<?php echo $code; ?>"></div>
		</div>
		<div class="pole">
			<div class="labeler" style="width: 150px;">Valid from:</div>
			<div class="elements"><input id="od" name="tiket[od]" value=""></div>
		</div>
		<div class="pole">
			<div class="labeler" style="width: 150px;">Valid until:</div>
			<div class="elements"><input id="do" name="tiket[do]" value=""></div>
		</div>
		<div class="pole">
			<div class="labeler" style="width: 150px;">Daily bids:</div>
			<div class="elements"><input name="tiket[bids]"></div>
		</div>
		<div class="pole">
			<div class="labeler" style="width: 150px;"></div>
			<div class="elements">
				<input type="submit" value="Create promo code">
				<input type="hidden" name="tiket[tipuvac_id]" value="<?php echo $tipuvac->id; ?>">
			</div>
		</div><br><?php 
		$format = "Y,m,d, H:i:s";
		$sql = "SELECT * FROM tiketi WHERE tipuvac_id=".$tipuvac->id." ORDER BY id ASC";
		$lista = $this->db->query($sql)->result();
		if(count($lista) > 0):?>
		<table id="adminTabela" class="dataTable addon">
			<thead>
				<tr>
					<th>#</th>
					<th>Ticket id</th>
					<th>Ticket code</th>
					<th>Valid from</th>
					<th>Valid until</th>
					<th>Daily bids</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($lista as $o):?>
				<tr>
					<td></td>
					<td><?php echo $o->id;?></td>
					<td><?php echo $o->code;?></td>
					<td><?php $datum = date_create_from_format("Y-m-d H:i:s", $o->od);
					echo $datum->format("d-m-Y");?></td>
					<td><?php $datum = date_create_from_format("Y-m-d H:i:s", $o->do);
					echo $datum->format("d-m-Y");?></td>
					<td><?php echo $o->bids;?></td>
					<td><?php if($o->aktiviran == '0000-00-00 00:00:00')
						echo 'not activated';
					else 
						echo 'activated';
					?></td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
		<?php endif;?>
		<script type="text/javascript">
		$('#do').datepicker({dateFormat: "dd-mm-yy", minDate: new Date(), 
			beforeShowDay: proverka});
		$('#od').datepicker({dateFormat: "dd-mm-yy", minDate: new Date(), 
			beforeShowDay: proverka,
	        onSelect: function() {
	        	var datum = $(this).datepicker('getDate');
	        	datum.setDate(datum.getDate() + 1);
	            $('#do').datepicker("option", "minDate", datum);
	        }
	    });
		var datumiOd = [<?php for ($i = 0; $i<count($lista); $i++)
		{
			$pocetok = new DateTime($lista[$i]->od, new DateTimeZone($tipuvac->timezone));
			if($i<count($lista)-1)
				echo "new Date('".$pocetok->format($format)."'),";
			else 
				echo "new Date('".$pocetok->format($format)."')";
		}?>];
		var datumiDo = [<?php for ($i = 0; $i<count($lista); $i++)
		{
			$kraj = new DateTime($lista[$i]->do, new DateTimeZone($tipuvac->timezone));
			if($i<count($lista)-1)
				echo "new Date('".$kraj->format($format)."'),";
			else
				echo "new Date('".$kraj->format($format)."')";
		}?>];
		function proverka(date) {
			//pravi date object od svite vrednosti i proverue dali datum e pomegju dve soodvetni vrednosti 
			var rezultat = true; //default moze da se selektira 
			for(var i = 0; i < datumiOd.length && rezultat; i++)
			{
				var pocetok = datumiOd[i];
				var kraj = datumiDo[i];
				if(date >= pocetok && date <= kraj)
					rezultat = false; 
			}
			return [rezultat, ""];
		}
		$.validator.addMethod(
			    "customDate",
			    function() {
			    	var odDatum = $('#od').datepicker('getDate');
			    	var doDatum = $('#do').datepicker('getDate');
			        return odDatum < doDatum;
			    },
			    "Please enter a valid date in the format dd-mm-yyyy."
			);
		$('#target').validate({
			rules: {
				'tiket[od]': {customDate: true},
				'tiket[do]': {customDate: true}
			},
			messages: {
				'tiket[od]': {required: 'This field is required'},
				'tiket[do]': {required: 'This field is required'}
			}
		});
		</script>
		<?php
	}
	function poraki()
	{
		$id = (int)$this->input->post('id');
		if($id)
		{
			$this->load->model('greski');
			$poraka = $this->greski->oneObject($id);
			?>
		<div class="pole">Displayed error [<?php echo $poraka->greska;?>]:</div>
		<div class="pole">
			<input name="greska[poraka]" value="<?php echo $poraka->poraka; ?>" style="width: 400px;">
		</div>
		<div class="pole">
			<div class="labeler" style="width: 150px;">
				<input type="submit" value="Save">
			</div>
			<div class="elements">
				<input type="hidden" name="id" value="<?php echo $poraka->id; ?>">
			</div>
		</div>
			<?php
		}
	}
	function natprevariMissed()
	{
		try
		{
			$sortColumn = $this->input->post('iSortCol_0');
			$sortDirection = $this->input->post('sSortDir_0');
			$pageNum = $this->input->post('iDisplayStart');
			$numberPerPage = $this->input->post('iDisplayLength');
	
			$startDate = $this->session->userdata("fStartDate");
			$endDate = $this->session->userdata("fEndDate");
			$selSampionat = $this->session->userdata("fSampionat");
			$selTim = $this->session->userdata("fTim");
			$selDays = $this->session->userdata("fDays");
			$selDrzava = $this->session->userdata("fDrzava");
			$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
			$uslov = " WHERE n.pocetok < '".$sega->format("Y-m-d H:i:s")."'
					AND n.id NOT IN (SELECT natprevar_id FROM coeficienti) AND";
			if($selSampionat || $selTim || $startDate || $endDate)
			{
				if($selSampionat)
					$uslov .= " l.id=".$selSampionat." AND";
				if($selTim)
					$uslov .= " (n.domasni=".$selTim." OR n.gosti=".$selTim.") AND";
				if($startDate)
					$uslov .= " n.pocetok >= '".$startDate."' AND";
				if($endDate)
					$uslov .= " n.pocetok <='".$endDate."' AND";
			}
			$uslov = substr($uslov, 0, strlen($uslov)-4);
			//sortiranje i pagination
			$order = " ORDER BY ";
			switch ($sortColumn)
			{
				case 2:
					$order .= "l.sport_id ".$sortDirection;
					break;
				case 3:
					$order .= "d.ime ".$sortDirection;
					break;
				case 4:
					$order .= "g.ime ".$sortDirection;
					break;
				case 7:
					$order .= "n.pocetok ".$sortDirection;
					break;
				case 9:
					$order .= "n.kraj ".$sortDirection;
					break;
				case 11:
					$order .= "l.ime ".$sortDirection;
					break;
				case 12:
					$order .= "k.ime ".$sortDirection;
					break;
				case 14:
					$order .= "n.vidliv ".$sortDirection;
					break;
				case 15:
					$order .= "oblozi ".$sortDirection;
					break;
				default:
					$order .= "n.id ".$sortDirection;
					break;
			}
			$order .= " LIMIT ".$pageNum.",".$numberPerPage;
			$ukupno = 0;
			$sql = "SELECT COUNT(n.id) AS broj FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov;
			$rezz = $this->db->query($sql)->row();
			$vkupno = (int) $rezz->broj;
			$sql = "SELECT n.id, d.ime AS domasni, g.ime AS gosti, domasni1, gosti1, domasni2, gosti2,
			domasni3, gosti3, domasni4, gosti4, l.ime AS sampionat, n.pocetok, n.kraj, n.vnesen, n.vidliv,
			c.id AS koef, (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) AS oblozi, k.ime AS kolo,
			l.sport_id FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov.$order;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			return;
		}
		$lista = $this->db->query($sql)->result();
		echo '{ "iTotalRecords":'.$vkupno.',
     		"iTotalDisplayRecords":'.$vkupno.', "aaData":[';
		$broj = 0;
		foreach($lista as $s):
		$pocetok = new DateTime($s->pocetok, new DateTimeZone("Europe/Skopje"));
		$kraj = new DateTime($s->kraj, new DateTimeZone("Europe/Skopje"));
		$vnesen = new DateTime($s->vnesen, new DateTimeZone("Europe/Skopje"));
		$vidliv = new DateTime($s->vidliv, new DateTimeZone("Europe/Skopje"));
		$denes = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$dif = $denes->diff($kraj);
		if($dif->invert===0)
			$minuti = $dif->days * 24 * 60 + $dif->h * 60 + $dif->i;
		else
			$minuti = 0 - ($dif->days * 24 * 60 + $dif->h * 60 + $dif->i);
			
		if(!$s->koef && $denes < $pocetok)
			$status = "Naked";/*
		elseif(!$s->koef && $denes > $pocetok)
		$status = "Missed";*/
		elseif(is_numeric($s->domasni4) && is_numeric($s->gosti4) &&
				is_numeric($s->domasni2) && is_numeric($s->gosti2))
				$status = "Closed";
		elseif($denes > $kraj && !(is_numeric($s->domasni4) && is_numeric($s->gosti4)
				&& is_numeric($s->domasni2) && is_numeric($s->gosti2)))
			$status = "Finished";
		elseif($minuti <= 30)
			$status = "Finish in 30min";
		elseif($denes > $pocetok && $denes < $kraj)
			$status = "Live";
		elseif($s->koef)
			$status = "Open";
		
		if(!$broj)
			echo '{';
		else 
			echo ',{';
		echo '"id":"'.$s->id.'",';
		echo '"sport":"';
		$filename = "images/sports/item_".$s->sport_id;
		if(file_exists("./".$filename.".png"))
		{
		 echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".png").'\'>';
		}
		elseif(file_exists("./".$filename.".jpg"))
		{
			echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".jpg").'\'>';
		}
		echo '",';
		echo '"hometeam":"'.$s->domasni.'",';
		echo '"awayteam":"'.$s->gosti.'",';
		echo '"final":"';
		echo (is_numeric($s->domasni4) || is_numeric($s->gosti4))?
					$s->domasni4.":".$s->gosti4:'';
		echo '",';
		echo '"half":"';
		echo (is_numeric($s->domasni2) || is_numeric($s->gosti2))?
					$s->domasni2.":".$s->gosti2:'';
		echo '",';
		echo '"date":"'.$pocetok->format("d M Y").'",';
		echo '"start":"'.$pocetok->format("H:i").'",';
		echo '"end":"'.$kraj->format("H:i").'",';
		echo '"ending":"';
		echo ($minuti>0)?$minuti:"0";
		echo '",';
		echo '"championship":"'.$s->sampionat.'",';
		echo '"round":"'.$s->kolo.'",';
		echo '"status":"'.$status.'",';
		echo '"vis":"';
		echo ($vidliv < $denes && $s->koef)?'YES':'NO';
		echo '",';
		echo '"bets":"'.$s->oblozi.'",';
		echo '"delete":"<a class=\'delete\' href=\''.base_url('admin_natprevari/delete/'.$s->id).'\'>DEL</a>",';
		echo '"color": "';
		switch ($status) {
			case "Naked":
				echo "#FF00FF";
				break;
			case "Finish in 30min":
				echo "#ff8000";
				break;
			case "Finished":
				echo "#FF0000";
				break;
			case "Closed":
				echo "#999999";
				break;
			case "Live":
				echo "#458B00";
				break;
			default:
				echo "#000000";
				break;
		}
		echo '"';
		echo '}';
		$broj++;
		endforeach;
		echo ']}';
	}
	function natprevariLive()
	{
		try
		{
			$sortColumn = $this->input->post('iSortCol_0');
			$sortDirection = $this->input->post('sSortDir_0');
			$pageNum = $this->input->post('iDisplayStart');
			$numberPerPage = $this->input->post('iDisplayLength');
	
			$startDate = $this->session->userdata("fStartDate");
			$endDate = $this->session->userdata("fEndDate");
			$selSampionat = $this->session->userdata("fSampionat");
			$selTim = $this->session->userdata("fTim");
			$selDays = $this->session->userdata("fDays");
			$selDrzava = $this->session->userdata("fDrzava");
			$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
			$uslov = " WHERE n.pocetok < '".$sega->format("Y-m-d H:i:s")."' 
				AND n.kraj > '".$sega->format("Y-m-d H:i:s")."' AND";
			if($selSampionat || $selTim || $startDate || $endDate)
			{
				if($selSampionat)
					$uslov .= " l.id=".$selSampionat." AND";
				if($selTim)
					$uslov .= " (n.domasni=".$selTim." OR n.gosti=".$selTim.") AND";
				if($startDate)
					$uslov .= " n.pocetok >= '".$startDate."' AND";
				if($endDate)
					$uslov .= " n.pocetok <='".$endDate."' AND";
			}
			$uslov = substr($uslov, 0, strlen($uslov)-4);
			//sortiranje i pagination
			$order = " ORDER BY ";
			switch ($sortColumn)
			{
				case 2:
					$order .= "l.sport_id ".$sortDirection;
					break;
				case 3:
					$order .= "d.ime ".$sortDirection;
					break;
				case 4:
					$order .= "g.ime ".$sortDirection;
					break;
				case 7:
					$order .= "n.pocetok ".$sortDirection;
					break;
				case 9:
					$order .= "n.kraj ".$sortDirection;
					break;
				case 11:
					$order .= "l.ime ".$sortDirection;
					break;
				case 12:
					$order .= "k.ime ".$sortDirection;
					break;
				case 14:
					$order .= "n.vidliv ".$sortDirection;
					break;
				case 15:
					$order .= "oblozi ".$sortDirection;
					break;
				default:
					$order .= "n.id ".$sortDirection;
					break;
			}
			$order .= " LIMIT ".$pageNum.",".$numberPerPage;
			$ukupno = 0;
			$sql = "SELECT COUNT(n.id) AS broj FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov;
			$rezz = $this->db->query($sql)->row();
			$vkupno = (int) $rezz->broj;
			$sql = "SELECT n.id, d.ime AS domasni, g.ime AS gosti, domasni1, gosti1, domasni2, gosti2,
			domasni3, gosti3, domasni4, gosti4, l.ime AS sampionat, n.pocetok, n.kraj, n.vnesen, n.vidliv,
			c.id AS koef, (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) AS oblozi, k.ime AS kolo,
			l.sport_id FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov.$order;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			return;
		}
		$lista = $this->db->query($sql)->result();
		echo '{ "iTotalRecords":'.$vkupno.',
     		"iTotalDisplayRecords":'.$vkupno.', "aaData":[';
		$broj = 0;
		foreach($lista as $s):
		$pocetok = new DateTime($s->pocetok, new DateTimeZone("Europe/Skopje"));
		$kraj = new DateTime($s->kraj, new DateTimeZone("Europe/Skopje"));
		$vnesen = new DateTime($s->vnesen, new DateTimeZone("Europe/Skopje"));
		$vidliv = new DateTime($s->vidliv, new DateTimeZone("Europe/Skopje"));
		$denes = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$dif = $denes->diff($kraj);
		if($dif->invert===0)
			$minuti = $dif->days * 24 * 60 + $dif->h * 60 + $dif->i;
		else
			$minuti = 0 - ($dif->days * 24 * 60 + $dif->h * 60 + $dif->i);
			
		if(!$s->koef && $denes < $pocetok)
			$status = "Naked";/*
		elseif(!$s->koef && $denes > $pocetok)
		$status = "Missed";*/
		elseif(is_numeric($s->domasni4) && is_numeric($s->gosti4) &&
				is_numeric($s->domasni2) && is_numeric($s->gosti2))
				$status = "Closed";
		elseif($denes > $kraj && !(is_numeric($s->domasni4) && is_numeric($s->gosti4)
				&& is_numeric($s->domasni2) && is_numeric($s->gosti2)))
				$status = "Finished";
		elseif($minuti <= 30)
		$status = "Finish in 30min";
		elseif($denes > $pocetok && $denes < $kraj)
		$status = "Live";
		elseif($s->koef)
		$status = "Open";
	
		if(!$broj)
			echo '{';
		else
			echo ',{';
		echo '"id":"'.$s->id.'",';
		echo '"sport":"';
		$filename = "images/sports/item_".$s->sport_id;
		if(file_exists("./".$filename.".png"))
		{
			echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".png").'\'>';
		}
		elseif(file_exists("./".$filename.".jpg"))
		{
			echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".jpg").'\'>';
		}
		echo '",';
		echo '"hometeam":"'.$s->domasni.'",';
		echo '"awayteam":"'.$s->gosti.'",';
		echo '"final":"';
		echo (is_numeric($s->domasni4) || is_numeric($s->gosti4))?
		$s->domasni4.":".$s->gosti4:'';
		echo '",';
		echo '"half":"';
		echo (is_numeric($s->domasni2) || is_numeric($s->gosti2))?
		$s->domasni2.":".$s->gosti2:'';
		echo '",';
		echo '"date":"'.$pocetok->format("d M Y").'",';
		echo '"start":"'.$pocetok->format("H:i").'",';
		echo '"end":"'.$kraj->format("H:i").'",';
		echo '"ending":"';
		echo ($minuti>0)?$minuti:"0";
		echo '",';
		echo '"championship":"'.$s->sampionat.'",';
		echo '"round":"'.$s->kolo.'",';
		echo '"status":"'.$status.'",';
		echo '"vis":"';
		echo ($vidliv < $denes && $s->koef)?'YES':'NO';
		echo '",';
		echo '"bets":"'.$s->oblozi.'",';
		echo '"delete":"<a class=\'delete\' href=\''.base_url('admin_natprevari/delete/'.$s->id).'\'>DEL</a>",';
		echo '"color": "';
		switch ($status) {
			case "Naked":
				echo "#FF00FF";
				break;
			case "Finish in 30min":
				echo "#ff8000";
				break;
			case "Finished":
				echo "#FF0000";
				break;
			case "Closed":
				echo "#999999";
				break;
			case "Live":
				echo "#458B00";
				break;
			default:
				echo "#000000";
				break;
		}
		echo '"';
		echo '}';
		$broj++;
		endforeach;
		echo ']}';
	}
	function natprevariNaked()
	{
		try
		{
			$sortColumn = $this->input->post('iSortCol_0');
			$sortDirection = $this->input->post('sSortDir_0');
			$pageNum = $this->input->post('iDisplayStart');
			$numberPerPage = $this->input->post('iDisplayLength');
	
			$startDate = $this->session->userdata("fStartDate");
			$endDate = $this->session->userdata("fEndDate");
			$selSampionat = $this->session->userdata("fSampionat");
			$selTim = $this->session->userdata("fTim");
			$selDays = $this->session->userdata("fDays");
			$selDrzava = $this->session->userdata("fDrzava");
			$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
			$uslov = " WHERE n.pocetok > '".$sega->format("Y-m-d H:i:s")."' 
					AND n.id NOT IN (SELECT natprevar_id FROM coeficienti) AND";
			if($selSampionat || $selTim || $startDate || $endDate)
			{
				$uslov = " WHERE ";
				if($selSampionat)
					$uslov .= " l.id=".$selSampionat." AND";
				if($selTim)
					$uslov .= " (n.domasni=".$selTim." OR n.gosti=".$selTim.") AND";
				if($startDate)
					$uslov .= " n.pocetok >= '".$startDate."' AND";
				if($endDate)
					$uslov .= " n.pocetok <='".$endDate."' AND";
			}
			$uslov = substr($uslov, 0, strlen($uslov)-4);
			//sortiranje i pagination
			$order = " ORDER BY ";
			switch ($sortColumn)
			{
				case 2:
					$order .= "l.sport_id ".$sortDirection;
					break;
				case 3:
					$order .= "d.ime ".$sortDirection;
					break;
				case 4:
					$order .= "g.ime ".$sortDirection;
					break;
				case 7:
					$order .= "n.pocetok ".$sortDirection;
					break;
				case 9:
					$order .= "n.kraj ".$sortDirection;
					break;
				case 11:
					$order .= "l.ime ".$sortDirection;
					break;
				case 12:
					$order .= "k.ime ".$sortDirection;
					break;
				case 14:
					$order .= "n.vidliv ".$sortDirection;
					break;
				case 15:
					$order .= "oblozi ".$sortDirection;
					break;
				default:
					$order .= "n.id ".$sortDirection;
					break;
			}
			$order .= " LIMIT ".$pageNum.",".$numberPerPage;
			$ukupno = 0;
			$sql = "SELECT COUNT(n.id) AS broj FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov;
			$rezz = $this->db->query($sql)->row();
			$vkupno = (int) $rezz->broj;
			$sql = "SELECT n.id, d.ime AS domasni, g.ime AS gosti, domasni1, gosti1, domasni2, gosti2,
			domasni3, gosti3, domasni4, gosti4, l.ime AS sampionat, n.pocetok, n.kraj, n.vnesen, n.vidliv,
			c.id AS koef, (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) AS oblozi, k.ime AS kolo,
			l.sport_id FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov.$order;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			return;
		}
		$lista = $this->db->query($sql)->result();
		echo '{ "iTotalRecords":'.$vkupno.',
     		"iTotalDisplayRecords":'.$vkupno.', "aaData":[';
		$broj = 0;
		foreach($lista as $s):
		$pocetok = new DateTime($s->pocetok, new DateTimeZone("Europe/Skopje"));
		$kraj = new DateTime($s->kraj, new DateTimeZone("Europe/Skopje"));
		$vnesen = new DateTime($s->vnesen, new DateTimeZone("Europe/Skopje"));
		$vidliv = new DateTime($s->vidliv, new DateTimeZone("Europe/Skopje"));
		$denes = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$dif = $denes->diff($kraj);
		if($dif->invert===0)
			$minuti = $dif->days * 24 * 60 + $dif->h * 60 + $dif->i;
		else
			$minuti = 0 - ($dif->days * 24 * 60 + $dif->h * 60 + $dif->i);
			
		if(!$s->koef && $denes < $pocetok)
			$status = "Naked";/*
		elseif(!$s->koef && $denes > $pocetok)
		$status = "Missed";*/
		elseif(is_numeric($s->domasni4) && is_numeric($s->gosti4) &&
				is_numeric($s->domasni2) && is_numeric($s->gosti2))
				$status = "Closed";
		elseif($denes > $kraj && !(is_numeric($s->domasni4) && is_numeric($s->gosti4)
				&& is_numeric($s->domasni2) && is_numeric($s->gosti2)))
				$status = "Finished";
		elseif($minuti <= 30)
		$status = "Finish in 30min";
		elseif($denes > $pocetok && $denes < $kraj)
		$status = "Live";
		elseif($s->koef)
		$status = "Open";
	
		if(!$broj)
			echo '{';
		else
			echo ',{';
		echo '"id":"'.$s->id.'",';
		echo '"sport":"';
		$filename = "images/sports/item_".$s->sport_id;
		if(file_exists("./".$filename.".png"))
		{
			echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".png").'\'>';
		}
		elseif(file_exists("./".$filename.".jpg"))
		{
			echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".jpg").'\'>';
		}
		echo '",';
		echo '"hometeam":"'.$s->domasni.'",';
		echo '"awayteam":"'.$s->gosti.'",';
		echo '"final":"';
		echo (is_numeric($s->domasni4) || is_numeric($s->gosti4))?
		$s->domasni4.":".$s->gosti4:'';
		echo '",';
		echo '"half":"';
		echo (is_numeric($s->domasni2) || is_numeric($s->gosti2))?
		$s->domasni2.":".$s->gosti2:'';
		echo '",';
		echo '"date":"'.$pocetok->format("d M Y").'",';
		echo '"start":"'.$pocetok->format("H:i").'",';
		echo '"end":"'.$kraj->format("H:i").'",';
		echo '"ending":"';
		echo ($minuti>0)?$minuti:"0";
		echo '",';
		echo '"championship":"'.$s->sampionat.'",';
		echo '"round":"'.$s->kolo.'",';
		echo '"status":"'.$status.'",';
		echo '"vis":"';
		echo ($vidliv < $denes && $s->koef)?'YES':'NO';
		echo '",';
		echo '"bets":"'.$s->oblozi.'",';
		echo '"delete":"<a class=\'delete\' href=\''.base_url('admin_natprevari/delete/'.$s->id).'\'>DEL</a>",';
		echo '"color": "';
		switch ($status) {
			case "Naked":
				echo "#FF00FF";
				break;
			case "Finish in 30min":
				echo "#ff8000";
				break;
			case "Finished":
				echo "#FF0000";
				break;
			case "Closed":
				echo "#999999";
				break;
			case "Live":
				echo "#458B00";
				break;
			default:
				echo "#000000";
				break;
		}
		echo '"';
		echo '}';
		$broj++;
		endforeach;
		echo ']}';
	}
	function natprevariNezatvoreni()
	{
		try
		{
			$sortColumn = $this->input->post('iSortCol_0');
			$sortDirection = $this->input->post('sSortDir_0');
			$pageNum = $this->input->post('iDisplayStart');
			$numberPerPage = $this->input->post('iDisplayLength');
	
			$startDate = $this->session->userdata("fStartDate");
			$endDate = $this->session->userdata("fEndDate");
			$selSampionat = $this->session->userdata("fSampionat");
			$selTim = $this->session->userdata("fTim");
			$selDays = $this->session->userdata("fDays");
			$selDrzava = $this->session->userdata("fDrzava");
			$uslov = " WHERE n.domasni4 IS NULL OR n.gosti4 IS NULL OR n.domasni2 IS NULL OR n.gosti2 IS NULL
				OR n.id NOT IN (SELECT natprevar_id FROM coeficienti) AND";
			if($selSampionat || $selTim || $startDate || $endDate)
			{
				if($selSampionat)
					$uslov .= " l.id=".$selSampionat." AND";
				if($selTim)
					$uslov .= " (n.domasni=".$selTim." OR n.gosti=".$selTim.") AND";
				if($startDate)
					$uslov .= " n.pocetok >= '".$startDate."' AND";
				if($endDate)
					$uslov .= " n.pocetok <='".$endDate."' AND";
			}
			$uslov = substr($uslov, 0, strlen($uslov)-4);
			//sortiranje i pagination
			$order = " ORDER BY ";
			switch ($sortColumn)
			{
				case 2:
					$order .= "l.sport_id ".$sortDirection;
					break;
				case 3:
					$order .= "d.ime ".$sortDirection;
					break;
				case 4:
					$order .= "g.ime ".$sortDirection;
					break;
				case 7:
					$order .= "n.pocetok ".$sortDirection;
					break;
				case 9:
					$order .= "n.kraj ".$sortDirection;
					break;
				case 11:
					$order .= "l.ime ".$sortDirection;
					break;
				case 12:
					$order .= "k.ime ".$sortDirection;
					break;
				case 14:
					$order .= "n.vidliv ".$sortDirection;
					break;
				case 15:
					$order .= "oblozi ".$sortDirection;
					break;
				default:
					$order .= "n.id ".$sortDirection;
					break;
			}
			$order .= " LIMIT ".$pageNum.",".$numberPerPage;
			$ukupno = 0;
			$sql = "SELECT COUNT(n.id) AS broj FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov;
			$rezz = $this->db->query($sql)->row();
			$vkupno = (int) $rezz->broj;
			$sql = "SELECT n.id, d.ime AS domasni, g.ime AS gosti, domasni1, gosti1, domasni2, gosti2,
			domasni3, gosti3, domasni4, gosti4, l.ime AS sampionat, n.pocetok, n.kraj, n.vnesen, n.vidliv,
			c.id AS koef, (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) AS oblozi, k.ime AS kolo,
			l.sport_id FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov.$order;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			return;
		}
		$lista = $this->db->query($sql)->result();
		echo '{ "iTotalRecords":'.$vkupno.',
     		"iTotalDisplayRecords":'.$vkupno.', "aaData":[';
		$broj = 0;
		foreach($lista as $s):
		$pocetok = new DateTime($s->pocetok, new DateTimeZone("Europe/Skopje"));
		$kraj = new DateTime($s->kraj, new DateTimeZone("Europe/Skopje"));
		$vnesen = new DateTime($s->vnesen, new DateTimeZone("Europe/Skopje"));
		$vidliv = new DateTime($s->vidliv, new DateTimeZone("Europe/Skopje"));
		$denes = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$dif = $denes->diff($kraj);
		if($dif->invert===0)
			$minuti = $dif->days * 24 * 60 + $dif->h * 60 + $dif->i;
		else
			$minuti = 0 - ($dif->days * 24 * 60 + $dif->h * 60 + $dif->i);
			
		if(!$s->koef && $denes < $pocetok)
			$status = "Naked";/*
		elseif(!$s->koef && $denes > $pocetok)
		$status = "Missed";*/
		elseif(is_numeric($s->domasni4) && is_numeric($s->gosti4) &&
				is_numeric($s->domasni2) && is_numeric($s->gosti2))
				$status = "Closed";
		elseif($denes > $kraj && !(is_numeric($s->domasni4) && is_numeric($s->gosti4)
				&& is_numeric($s->domasni2) && is_numeric($s->gosti2)))
				$status = "Finished";
		elseif($minuti <= 30)
		$status = "Finish in 30min";
		elseif($denes > $pocetok && $denes < $kraj)
		$status = "Live";
		elseif($s->koef)
		$status = "Open";
	
		if(!$broj)
			echo '{';
		else
			echo ',{';
		echo '"id":"'.$s->id.'",';
		echo '"sport":"';
		$filename = "images/sports/item_".$s->sport_id;
		if(file_exists("./".$filename.".png"))
		{
			echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".png").'\'>';
		}
		elseif(file_exists("./".$filename.".jpg"))
		{
			echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".jpg").'\'>';
		}
		echo '",';
		echo '"hometeam":"'.$s->domasni.'",';
		echo '"awayteam":"'.$s->gosti.'",';
		echo '"final":"';
		echo (is_numeric($s->domasni4) || is_numeric($s->gosti4))?
		$s->domasni4.":".$s->gosti4:'';
		echo '",';
		echo '"half":"';
		echo (is_numeric($s->domasni2) || is_numeric($s->gosti2))?
		$s->domasni2.":".$s->gosti2:'';
		echo '",';
		echo '"date":"'.$pocetok->format("d M Y").'",';
		echo '"start":"'.$pocetok->format("H:i").'",';
		echo '"end":"'.$kraj->format("H:i").'",';
		echo '"ending":"';
		echo ($minuti>0)?$minuti:"0";
		echo '",';
		echo '"championship":"'.$s->sampionat.'",';
		echo '"round":"'.$s->kolo.'",';
		echo '"status":"'.$status.'",';
		echo '"vis":"';
		echo ($vidliv < $denes && $s->koef)?'YES':'NO';
		echo '",';
		echo '"bets":"'.$s->oblozi.'",';
		echo '"delete":"<a class=\'delete\' href=\''.base_url('admin_natprevari/delete/'.$s->id).'\'>DEL</a>",';
		echo '"color": "';
		switch ($status) {
			case "Naked":
				echo "#FF00FF";
				break;
			case "Finish in 30min":
				echo "#ff8000";
				break;
			case "Finished":
				echo "#FF0000";
				break;
			case "Closed":
				echo "#999999";
				break;
			case "Live":
				echo "#458B00";
				break;
			default:
				echo "#000000";
				break;
		}
		echo '"';
		echo '}';
		$broj++;
		endforeach;
		echo ']}';
	}
	function natprevariOpen()
	{
		try
		{
			$sortColumn = $this->input->post('iSortCol_0');
			$sortDirection = $this->input->post('sSortDir_0');
			$pageNum = $this->input->post('iDisplayStart');
			$numberPerPage = $this->input->post('iDisplayLength');
	
			$startDate = $this->session->userdata("fStartDate");
			$endDate = $this->session->userdata("fEndDate");
			$selSampionat = $this->session->userdata("fSampionat");
			$selTim = $this->session->userdata("fTim");
			$selDays = $this->session->userdata("fDays");
			$selDrzava = $this->session->userdata("fDrzava");
			$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
			$uslov = " WHERE n.pocetok > '".$sega->format("Y-m-d H:i:s")."'
				AND n.id IN (SELECT natprevar_id FROM coeficienti) AND";
			if($selSampionat || $selTim || $startDate || $endDate)
			{
				if($selSampionat)
					$uslov .= " l.id=".$selSampionat." AND";
				if($selTim)
					$uslov .= " (n.domasni=".$selTim." OR n.gosti=".$selTim.") AND";
				if($startDate)
					$uslov .= " n.pocetok >= '".$startDate."' AND";
				if($endDate)
					$uslov .= " n.pocetok <='".$endDate."' AND";
			}
			$uslov = substr($uslov, 0, strlen($uslov)-4);
			//sortiranje i pagination
			$order = " ORDER BY ";
			switch ($sortColumn)
			{
				case 2:
					$order .= "l.sport_id ".$sortDirection;
					break;
				case 3:
					$order .= "d.ime ".$sortDirection;
					break;
				case 4:
					$order .= "g.ime ".$sortDirection;
					break;
				case 7:
					$order .= "n.pocetok ".$sortDirection;
					break;
				case 9:
					$order .= "n.kraj ".$sortDirection;
					break;
				case 11:
					$order .= "l.ime ".$sortDirection;
					break;
				case 12:
					$order .= "k.ime ".$sortDirection;
					break;
				case 14:
					$order .= "n.vidliv ".$sortDirection;
					break;
				case 15:
					$order .= "oblozi ".$sortDirection;
					break;
				default:
					$order .= "n.id ".$sortDirection;
					break;
			}
			$order .= " LIMIT ".$pageNum.",".$numberPerPage;
			$ukupno = 0;
			$sql = "SELECT COUNT(n.id) AS broj FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov;
			$rezz = $this->db->query($sql)->row();
			$vkupno = (int) $rezz->broj;
			$sql = "SELECT n.id, d.ime AS domasni, g.ime AS gosti, domasni1, gosti1, domasni2, gosti2,
			domasni3, gosti3, domasni4, gosti4, l.ime AS sampionat, n.pocetok, n.kraj, n.vnesen, n.vidliv,
			c.id AS koef, (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) AS oblozi, k.ime AS kolo,
			l.sport_id FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov.$order;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			return;
		}
		$lista = $this->db->query($sql)->result();
		echo '{ "iTotalRecords":'.$vkupno.',
     		"iTotalDisplayRecords":'.$vkupno.', "aaData":[';
		$broj = 0;
		foreach($lista as $s):
		$pocetok = new DateTime($s->pocetok, new DateTimeZone("Europe/Skopje"));
		$kraj = new DateTime($s->kraj, new DateTimeZone("Europe/Skopje"));
		$vnesen = new DateTime($s->vnesen, new DateTimeZone("Europe/Skopje"));
		$vidliv = new DateTime($s->vidliv, new DateTimeZone("Europe/Skopje"));
		$denes = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$dif = $denes->diff($kraj);
		if($dif->invert===0)
			$minuti = $dif->days * 24 * 60 + $dif->h * 60 + $dif->i;
		else
			$minuti = 0 - ($dif->days * 24 * 60 + $dif->h * 60 + $dif->i);
			
		if(!$s->koef && $denes < $pocetok)
			$status = "Naked";/*
		elseif(!$s->koef && $denes > $pocetok)
		$status = "Missed";*/
		elseif(is_numeric($s->domasni4) && is_numeric($s->gosti4) &&
				is_numeric($s->domasni2) && is_numeric($s->gosti2))
				$status = "Closed";
		elseif($denes > $kraj && !(is_numeric($s->domasni4) && is_numeric($s->gosti4)
				&& is_numeric($s->domasni2) && is_numeric($s->gosti2)))
				$status = "Finished";
		elseif($minuti <= 30)
		$status = "Finish in 30min";
		elseif($denes > $pocetok && $denes < $kraj)
		$status = "Live";
		elseif($s->koef)
		$status = "Open";
	
		if(!$broj)
			echo '{';
		else
			echo ',{';
		echo '"id":"'.$s->id.'",';
		echo '"sport":"';
		$filename = "images/sports/item_".$s->sport_id;
		if(file_exists("./".$filename.".png"))
		{
			echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".png").'\'>';
		}
		elseif(file_exists("./".$filename.".jpg"))
		{
			echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".jpg").'\'>';
		}
		echo '",';
		echo '"hometeam":"'.$s->domasni.'",';
		echo '"awayteam":"'.$s->gosti.'",';
		echo '"final":"';
		echo (is_numeric($s->domasni4) || is_numeric($s->gosti4))?
		$s->domasni4.":".$s->gosti4:'';
		echo '",';
		echo '"half":"';
		echo (is_numeric($s->domasni2) || is_numeric($s->gosti2))?
		$s->domasni2.":".$s->gosti2:'';
		echo '",';
		echo '"date":"'.$pocetok->format("d M Y").'",';
		echo '"start":"'.$pocetok->format("H:i").'",';
		echo '"end":"'.$kraj->format("H:i").'",';
		echo '"ending":"';
		echo ($minuti>0)?$minuti:"0";
		echo '",';
		echo '"championship":"'.$s->sampionat.'",';
		echo '"round":"'.$s->kolo.'",';
		echo '"status":"'.$status.'",';
		echo '"vis":"';
		echo ($vidliv < $denes && $s->koef)?'YES':'NO';
		echo '",';
		echo '"bets":"'.$s->oblozi.'",';
		echo '"delete":"<a class=\'delete\' href=\''.base_url('admin_natprevari/delete/'.$s->id).'\'>DEL</a>",';
		echo '"color": "';
		switch ($status) {
			case "Naked":
				echo "#FF00FF";
				break;
			case "Finish in 30min":
				echo "#ff8000";
				break;
			case "Finished":
				echo "#FF0000";
				break;
			case "Closed":
				echo "#999999";
				break;
			case "Live":
				echo "#458B00";
				break;
			default:
				echo "#000000";
				break;
		}
		echo '"';
		echo '}';
		$broj++;
		endforeach;
		echo ']}';
	}
	function natprevariPrikraj()
	{
		try
		{
			$sortColumn = $this->input->post('iSortCol_0');
			$sortDirection = $this->input->post('sSortDir_0');
			$pageNum = $this->input->post('iDisplayStart');
			$numberPerPage = $this->input->post('iDisplayLength');
	
			$startDate = $this->session->userdata("fStartDate");
			$endDate = $this->session->userdata("fEndDate");
			$selSampionat = $this->session->userdata("fSampionat");
			$selTim = $this->session->userdata("fTim");
			$selDays = $this->session->userdata("fDays");
			$selDrzava = $this->session->userdata("fDrzava");
			$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
			$posle30min = new DateTime("now", new DateTimeZone("Europe/Skopje"));
			$posle30min->modify("+30 minutes");
			$uslov = " WHERE n.kraj > '".$sega->format("Y-m-d H:i:s")."' 
					AND n.kraj <= '".$posle30min->format("Y-m-d H:i:s")."' AND";
			if($selSampionat || $selTim || $startDate || $endDate)
			{
				if($selSampionat)
					$uslov .= " l.id=".$selSampionat." AND";
				if($selTim)
					$uslov .= " (n.domasni=".$selTim." OR n.gosti=".$selTim.") AND";
				if($startDate)
					$uslov .= " n.pocetok >= '".$startDate."' AND";
				if($endDate)
					$uslov .= " n.pocetok <='".$endDate."' AND";
			}
			$uslov = substr($uslov, 0, strlen($uslov)-4);
			//sortiranje i pagination
			$order = " ORDER BY ";
			switch ($sortColumn)
			{
				case 2:
					$order .= "l.sport_id ".$sortDirection;
					break;
				case 3:
					$order .= "d.ime ".$sortDirection;
					break;
				case 4:
					$order .= "g.ime ".$sortDirection;
					break;
				case 7:
					$order .= "n.pocetok ".$sortDirection;
					break;
				case 9:
					$order .= "n.kraj ".$sortDirection;
					break;
				case 11:
					$order .= "l.ime ".$sortDirection;
					break;
				case 12:
					$order .= "k.ime ".$sortDirection;
					break;
				case 14:
					$order .= "n.vidliv ".$sortDirection;
					break;
				case 15:
					$order .= "oblozi ".$sortDirection;
					break;
				default:
					$order .= "n.id ".$sortDirection;
					break;
			}
			$order .= " LIMIT ".$pageNum.",".$numberPerPage;
			$ukupno = 0;
			$sql = "SELECT COUNT(n.id) AS broj FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov;
			$rezz = $this->db->query($sql)->row();
			$vkupno = (int) $rezz->broj;
			$sql = "SELECT n.id, d.ime AS domasni, g.ime AS gosti, domasni1, gosti1, domasni2, gosti2,
			domasni3, gosti3, domasni4, gosti4, l.ime AS sampionat, n.pocetok, n.kraj, n.vnesen, n.vidliv,
			c.id AS koef, (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) AS oblozi, k.ime AS kolo,
			l.sport_id FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov.$order;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			return;
		}
		$lista = $this->db->query($sql)->result();
		echo '{ "iTotalRecords":'.$vkupno.',
     		"iTotalDisplayRecords":'.$vkupno.', "aaData":[';
		$broj = 0;
		foreach($lista as $s):
		$pocetok = new DateTime($s->pocetok, new DateTimeZone("Europe/Skopje"));
		$kraj = new DateTime($s->kraj, new DateTimeZone("Europe/Skopje"));
		$vnesen = new DateTime($s->vnesen, new DateTimeZone("Europe/Skopje"));
		$vidliv = new DateTime($s->vidliv, new DateTimeZone("Europe/Skopje"));
		$denes = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$dif = $denes->diff($kraj);
		if($dif->invert===0)
			$minuti = $dif->days * 24 * 60 + $dif->h * 60 + $dif->i;
		else
			$minuti = 0 - ($dif->days * 24 * 60 + $dif->h * 60 + $dif->i);
			
		if(!$s->koef && $denes < $pocetok)
			$status = "Naked";/*
		elseif(!$s->koef && $denes > $pocetok)
		$status = "Missed";*/
		elseif(is_numeric($s->domasni4) && is_numeric($s->gosti4) &&
				is_numeric($s->domasni2) && is_numeric($s->gosti2))
				$status = "Closed";
		elseif($denes > $kraj && !(is_numeric($s->domasni4) && is_numeric($s->gosti4)
				&& is_numeric($s->domasni2) && is_numeric($s->gosti2)))
				$status = "Finished";
		elseif($minuti <= 30)
		$status = "Finish in 30min";
		elseif($denes > $pocetok && $denes < $kraj)
		$status = "Live";
		elseif($s->koef)
		$status = "Open";
	
		if(!$broj)
			echo '{';
		else
			echo ',{';
		echo '"id":"'.$s->id.'",';
		echo '"sport":"';
		$filename = "images/sports/item_".$s->sport_id;
		if(file_exists("./".$filename.".png"))
		{
			echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".png").'\'>';
		}
		elseif(file_exists("./".$filename.".jpg"))
		{
			echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".jpg").'\'>';
		}
		echo '",';
		echo '"hometeam":"'.$s->domasni.'",';
		echo '"awayteam":"'.$s->gosti.'",';
		echo '"final":"';
		echo (is_numeric($s->domasni4) || is_numeric($s->gosti4))?
		$s->domasni4.":".$s->gosti4:'';
		echo '",';
		echo '"half":"';
		echo (is_numeric($s->domasni2) || is_numeric($s->gosti2))?
		$s->domasni2.":".$s->gosti2:'';
		echo '",';
		echo '"date":"'.$pocetok->format("d M Y").'",';
		echo '"start":"'.$pocetok->format("H:i").'",';
		echo '"end":"'.$kraj->format("H:i").'",';
		echo '"ending":"';
		echo ($minuti>0)?$minuti:"0";
		echo '",';
		echo '"championship":"'.$s->sampionat.'",';
		echo '"round":"'.$s->kolo.'",';
		echo '"status":"'.$status.'",';
		echo '"vis":"';
		echo ($vidliv < $denes && $s->koef)?'YES':'NO';
		echo '",';
		echo '"bets":"'.$s->oblozi.'",';
		echo '"delete":"<a class=\'delete\' href=\''.base_url('admin_natprevari/delete/'.$s->id).'\'>DEL</a>",';
		echo '"color": "';
		switch ($status) {
			case "Naked":
				echo "#FF00FF";
				break;
			case "Finish in 30min":
				echo "#ff8000";
				break;
			case "Finished":
				echo "#FF0000";
				break;
			case "Closed":
				echo "#999999";
				break;
			case "Live":
				echo "#458B00";
				break;
			default:
				echo "#000000";
				break;
		}
		echo '"';
		echo '}';
		$broj++;
		endforeach;
		echo ']}';
	}
	function natprevariZatvoreni()
	{
		try
		{
			$sortColumn = $this->input->post('iSortCol_0');
			$sortDirection = $this->input->post('sSortDir_0');
			$pageNum = $this->input->post('iDisplayStart');
			$numberPerPage = $this->input->post('iDisplayLength');
	
			$startDate = $this->session->userdata("fStartDate");
			$endDate = $this->session->userdata("fEndDate");
			$selSampionat = $this->session->userdata("fSampionat");
			$selTim = $this->session->userdata("fTim");
			$selDays = $this->session->userdata("fDays");
			$selDrzava = $this->session->userdata("fDrzava");
			$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
			$uslov = " WHERE n.domasni4 IS NOT NULL AND n.gosti4 IS NOT NULL AND 
					n.domasni2 IS NOT NULL AND n.gosti2 IS NOT NULL AND";
			if($selSampionat || $selTim || $startDate || $endDate)
			{
				if($selSampionat)
					$uslov .= " l.id=".$selSampionat." AND";
				if($selTim)
					$uslov .= " (n.domasni=".$selTim." OR n.gosti=".$selTim.") AND";
				if($startDate)
					$uslov .= " n.pocetok >= '".$startDate."' AND";
				if($endDate)
					$uslov .= " n.pocetok <='".$endDate."' AND";
			}
			$uslov = substr($uslov, 0, strlen($uslov)-4);
			//sortiranje i pagination
			$order = " ORDER BY ";
			switch ($sortColumn)
			{
				case 2:
					$order .= "l.sport_id ".$sortDirection;
					break;
				case 3:
					$order .= "d.ime ".$sortDirection;
					break;
				case 4:
					$order .= "g.ime ".$sortDirection;
					break;
				case 7:
					$order .= "n.pocetok ".$sortDirection;
					break;
				case 9:
					$order .= "n.kraj ".$sortDirection;
					break;
				case 11:
					$order .= "l.ime ".$sortDirection;
					break;
				case 12:
					$order .= "k.ime ".$sortDirection;
					break;
				case 14:
					$order .= "n.vidliv ".$sortDirection;
					break;
				case 15:
					$order .= "oblozi ".$sortDirection;
					break;
				default:
					$order .= "n.id ".$sortDirection;
					break;
			}
			$order .= " LIMIT ".$pageNum.",".$numberPerPage;
			$ukupno = 0;
			$sql = "SELECT COUNT(n.id) AS broj FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov;
			$rezz = $this->db->query($sql)->row();
			$vkupno = (int) $rezz->broj;
			$sql = "SELECT n.id, d.ime AS domasni, g.ime AS gosti, domasni1, gosti1, domasni2, gosti2,
			domasni3, gosti3, domasni4, gosti4, l.ime AS sampionat, n.pocetok, n.kraj, n.vnesen, n.vidliv,
			c.id AS koef, (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) AS oblozi, k.ime AS kolo,
			l.sport_id FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov.$order;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			return;
		}
		$lista = $this->db->query($sql)->result();
		echo '{ "iTotalRecords":'.$vkupno.',
     		"iTotalDisplayRecords":'.$vkupno.', "aaData":[';
		$broj = 0;
		foreach($lista as $s):
		$pocetok = new DateTime($s->pocetok, new DateTimeZone("Europe/Skopje"));
		$kraj = new DateTime($s->kraj, new DateTimeZone("Europe/Skopje"));
		$vnesen = new DateTime($s->vnesen, new DateTimeZone("Europe/Skopje"));
		$vidliv = new DateTime($s->vidliv, new DateTimeZone("Europe/Skopje"));
		$denes = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$dif = $denes->diff($kraj);
		if($dif->invert===0)
			$minuti = $dif->days * 24 * 60 + $dif->h * 60 + $dif->i;
		else
			$minuti = 0 - ($dif->days * 24 * 60 + $dif->h * 60 + $dif->i);
			
		if(!$s->koef && $denes < $pocetok)
			$status = "Naked";/*
		elseif(!$s->koef && $denes > $pocetok)
		$status = "Missed";*/
		elseif(is_numeric($s->domasni4) && is_numeric($s->gosti4) &&
				is_numeric($s->domasni2) && is_numeric($s->gosti2))
				$status = "Closed";
		elseif($denes > $kraj && !(is_numeric($s->domasni4) && is_numeric($s->gosti4)
				&& is_numeric($s->domasni2) && is_numeric($s->gosti2)))
				$status = "Finished";
		elseif($minuti <= 30)
		$status = "Finish in 30min";
		elseif($denes > $pocetok && $denes < $kraj)
		$status = "Live";
		elseif($s->koef)
		$status = "Open";
	
		if(!$broj)
			echo '{';
		else
			echo ',{';
		echo '"id":"'.$s->id.'",';
		echo '"sport":"';
		$filename = "images/sports/item_".$s->sport_id;
		if(file_exists("./".$filename.".png"))
		{
			echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".png").'\'>';
		}
		elseif(file_exists("./".$filename.".jpg"))
		{
			echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".jpg").'\'>';
		}
		echo '",';
		echo '"hometeam":"'.$s->domasni.'",';
		echo '"awayteam":"'.$s->gosti.'",';
		echo '"final":"';
		echo (is_numeric($s->domasni4) || is_numeric($s->gosti4))?
		$s->domasni4.":".$s->gosti4:'';
		echo '",';
		echo '"half":"';
		echo (is_numeric($s->domasni2) || is_numeric($s->gosti2))?
		$s->domasni2.":".$s->gosti2:'';
		echo '",';
		echo '"date":"'.$pocetok->format("d M Y").'",';
		echo '"start":"'.$pocetok->format("H:i").'",';
		echo '"end":"'.$kraj->format("H:i").'",';
		echo '"ending":"';
		echo ($minuti>0)?$minuti:"0";
		echo '",';
		echo '"championship":"'.$s->sampionat.'",';
		echo '"round":"'.$s->kolo.'",';
		echo '"status":"'.$status.'",';
		echo '"vis":"';
		echo ($vidliv < $denes && $s->koef)?'YES':'NO';
		echo '",';
		echo '"bets":"'.$s->oblozi.'",';
		echo '"delete":"<a class=\'delete\' href=\''.base_url('admin_natprevari/delete/'.$s->id).'\'>DEL</a>",';
		echo '"color": "';
		switch ($status) {
			case "Naked":
				echo "#FF00FF";
				break;
			case "Finish in 30min":
				echo "#ff8000";
				break;
			case "Finished":
				echo "#FF0000";
				break;
			case "Closed":
				echo "#999999";
				break;
			case "Live":
				echo "#458B00";
				break;
			default:
				echo "#000000";
				break;
		}
		echo '"';
		echo '}';
		$broj++;
		endforeach;
		echo ']}';
	}
	function natprevariZavrseni()
	{
		try
		{
			$sortColumn = $this->input->post('iSortCol_0');
			$sortDirection = $this->input->post('sSortDir_0');
			$pageNum = $this->input->post('iDisplayStart');
			$numberPerPage = $this->input->post('iDisplayLength');
	
			$startDate = $this->session->userdata("fStartDate");
			$endDate = $this->session->userdata("fEndDate");
			$selSampionat = $this->session->userdata("fSampionat");
			$selTim = $this->session->userdata("fTim");
			$selDays = $this->session->userdata("fDays");
			$selDrzava = $this->session->userdata("fDrzava");
			$sega = new DateTime("now", new DateTimeZone("Europe/Skopje"));
			$uslov = " WHERE (n.domasni4 IS NULL AND n.gosti4 IS NULL AND 
					n.domasni2 IS NULL AND n.gosti2 IS NULL) AND n.kraj < '".
					$sega->format("Y-m-d H:i:s")."' AND";
			if($selSampionat || $selTim || $startDate || $endDate)
			{
				if($selSampionat)
					$uslov .= " l.id=".$selSampionat." AND";
				if($selTim)
					$uslov .= " (n.domasni=".$selTim." OR n.gosti=".$selTim.") AND";
				if($startDate)
					$uslov .= " n.pocetok >= '".$startDate."' AND";
				if($endDate)
					$uslov .= " n.pocetok <='".$endDate."' AND";
			}
			$uslov = substr($uslov, 0, strlen($uslov)-4);
			//sortiranje i pagination
			$order = " ORDER BY ";
			switch ($sortColumn)
			{
				case 2:
					$order .= "l.sport_id ".$sortDirection;
					break;
				case 3:
					$order .= "d.ime ".$sortDirection;
					break;
				case 4:
					$order .= "g.ime ".$sortDirection;
					break;
				case 7:
					$order .= "n.pocetok ".$sortDirection;
					break;
				case 9:
					$order .= "n.kraj ".$sortDirection;
					break;
				case 11:
					$order .= "l.ime ".$sortDirection;
					break;
				case 12:
					$order .= "k.ime ".$sortDirection;
					break;
				case 14:
					$order .= "n.vidliv ".$sortDirection;
					break;
				case 15:
					$order .= "oblozi ".$sortDirection;
					break;
				default:
					$order .= "n.id ".$sortDirection;
					break;
			}
			$order .= " LIMIT ".$pageNum.",".$numberPerPage;
			$ukupno = 0;
			$sql = "SELECT COUNT(n.id) AS broj FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov;
			$rezz = $this->db->query($sql)->row();
			$vkupno = (int) $rezz->broj;
			$sql = "SELECT n.id, d.ime AS domasni, g.ime AS gosti, domasni1, gosti1, domasni2, gosti2,
			domasni3, gosti3, domasni4, gosti4, l.ime AS sampionat, n.pocetok, n.kraj, n.vnesen, n.vidliv,
			c.id AS koef, (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) AS oblozi, k.ime AS kolo,
			l.sport_id FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov.$order;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			return;
		}
		$lista = $this->db->query($sql)->result();
		echo '{ "iTotalRecords":'.$vkupno.',
     		"iTotalDisplayRecords":'.$vkupno.', "aaData":[';
		$broj = 0;
		foreach($lista as $s):
		$pocetok = new DateTime($s->pocetok, new DateTimeZone("Europe/Skopje"));
		$kraj = new DateTime($s->kraj, new DateTimeZone("Europe/Skopje"));
		$vnesen = new DateTime($s->vnesen, new DateTimeZone("Europe/Skopje"));
		$vidliv = new DateTime($s->vidliv, new DateTimeZone("Europe/Skopje"));
		$denes = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$dif = $denes->diff($kraj);
		if($dif->invert===0)
			$minuti = $dif->days * 24 * 60 + $dif->h * 60 + $dif->i;
		else
			$minuti = 0 - ($dif->days * 24 * 60 + $dif->h * 60 + $dif->i);
			
		if(!$s->koef && $denes < $pocetok)
			$status = "Naked";/*
		elseif(!$s->koef && $denes > $pocetok)
		$status = "Missed";*/
		elseif(is_numeric($s->domasni4) && is_numeric($s->gosti4) &&
				is_numeric($s->domasni2) && is_numeric($s->gosti2))
				$status = "Closed";
		elseif($denes > $kraj && !(is_numeric($s->domasni4) && is_numeric($s->gosti4)
				&& is_numeric($s->domasni2) && is_numeric($s->gosti2)))
				$status = "Finished";
		elseif($minuti <= 30)
		$status = "Finish in 30min";
		elseif($denes > $pocetok && $denes < $kraj)
		$status = "Live";
		elseif($s->koef)
		$status = "Open";
	
		if(!$broj)
			echo '{';
		else
			echo ',{';
		echo '"id":"'.$s->id.'",';
		echo '"sport":"';
		$filename = "images/sports/item_".$s->sport_id;
		if(file_exists("./".$filename.".png"))
		{
			echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".png").'\'>';
		}
		elseif(file_exists("./".$filename.".jpg"))
		{
			echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".jpg").'\'>';
		}
		echo '",';
		echo '"hometeam":"'.$s->domasni.'",';
		echo '"awayteam":"'.$s->gosti.'",';
		echo '"final":"';
		echo (is_numeric($s->domasni4) || is_numeric($s->gosti4))?
		$s->domasni4.":".$s->gosti4:'';
		echo '",';
		echo '"half":"';
		echo (is_numeric($s->domasni2) || is_numeric($s->gosti2))?
		$s->domasni2.":".$s->gosti2:'';
		echo '",';
		echo '"date":"'.$pocetok->format("d M Y").'",';
		echo '"start":"'.$pocetok->format("H:i").'",';
		echo '"end":"'.$kraj->format("H:i").'",';
		echo '"ending":"';
		echo ($minuti>0)?$minuti:"0";
		echo '",';
		echo '"championship":"'.$s->sampionat.'",';
		echo '"round":"'.$s->kolo.'",';
		echo '"status":"'.$status.'",';
		echo '"vis":"';
		echo ($vidliv < $denes && $s->koef)?'YES':'NO';
		echo '",';
		echo '"bets":"'.$s->oblozi.'",';
		echo '"delete":"<a class=\'delete\' href=\''.base_url('admin_natprevari/delete/'.$s->id).'\'>DEL</a>",';
		echo '"color": "';
		switch ($status) {
			case "Naked":
				echo "#FF00FF";
				break;
			case "Finish in 30min":
				echo "#ff8000";
				break;
			case "Finished":
				echo "#FF0000";
				break;
			case "Closed":
				echo "#999999";
				break;
			case "Live":
				echo "#458B00";
				break;
			default:
				echo "#000000";
				break;
		}
		echo '"';
		echo '}';
		$broj++;
		endforeach;
		echo ']}';
	}
	function natprevariSite()
	{
		try
		{
			$sortColumn = $this->input->post('iSortCol_0');
			$sortDirection = $this->input->post('sSortDir_0');
			$pageNum = $this->input->post('iDisplayStart');
			$numberPerPage = $this->input->post('iDisplayLength');
	
			$startDate = $this->session->userdata("fStartDate");
			$endDate = $this->session->userdata("fEndDate");
			$selSampionat = $this->session->userdata("fSampionat");
			$selTim = $this->session->userdata("fTim");
			$selDays = $this->session->userdata("fDays");
			$selDrzava = $this->session->userdata("fDrzava");
			$uslov = "";
			if($selSampionat || $selTim || $startDate || $endDate)
			{
				$uslov = " WHERE ";
				if($selSampionat)
					$uslov .= " l.id=".$selSampionat." AND";
				if($selTim)
					$uslov .= " (n.domasni=".$selTim." OR n.gosti=".$selTim.") AND";
				if($startDate)
					$uslov .= " n.pocetok >= '".$startDate."' AND";
				if($endDate)
					$uslov .= " n.pocetok <='".$endDate."' AND";
				$uslov = substr($uslov, 0, strlen($uslov)-4);
			}
			//sortiranje i pagination
			$order = " ORDER BY ";
			switch ($sortColumn)
			{
				case 2:
					$order .= "l.sport_id ".$sortDirection;
					break;
				case 3:
					$order .= "d.ime ".$sortDirection;
					break;
				case 4:
					$order .= "g.ime ".$sortDirection;
					break;
				case 7:
					$order .= "n.pocetok ".$sortDirection;
					break;
				case 9:
					$order .= "n.kraj ".$sortDirection;
					break;
				case 11:
					$order .= "l.ime ".$sortDirection;
					break;
				case 12:
					$order .= "k.ime ".$sortDirection;
					break;
				case 14:
					$order .= "n.vidliv ".$sortDirection;
					break;
				case 15:
					$order .= "oblozi ".$sortDirection;
					break;
				default:
					$order .= "n.id ".$sortDirection;
					break;
			}
			$order .= " LIMIT ".$pageNum.",".$numberPerPage;
			$ukupno = 0;
			$sql = "SELECT COUNT(n.id) AS broj FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov;
			$rezz = $this->db->query($sql)->row();
			$vkupno = (int) $rezz->broj;
			$sql = "SELECT n.id, d.ime AS domasni, g.ime AS gosti, domasni1, gosti1, domasni2, gosti2,
			domasni3, gosti3, domasni4, gosti4, l.ime AS sampionat, n.pocetok, n.kraj, n.vnesen, n.vidliv,
			c.id AS koef, (SELECT COUNT(id) FROM oblozi WHERE natprevar_id=n.id) AS oblozi, k.ime AS kolo,
			l.sport_id FROM natprevari AS n INNER JOIN timovi AS d ON n.domasni=d.id
			INNER JOIN timovi AS g ON n.gosti=g.id INNER JOIN kolo AS k ON k.id=n.kolo_id
			INNER JOIN sezona as s ON s.id=k.sezona_id INNER JOIN sampionati AS l ON l.id=s.sampionat_id
			LEFT JOIN coeficienti AS c ON c.natprevar_id=n.id".$uslov.$order;
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
			return;
		}
		$lista = $this->db->query($sql)->result();
		echo '{ "iTotalRecords":'.$vkupno.',
     		"iTotalDisplayRecords":'.$vkupno.', "aaData":[';
		$broj = 0;
		foreach($lista as $s):
		$pocetok = new DateTime($s->pocetok, new DateTimeZone("Europe/Skopje"));
		$kraj = new DateTime($s->kraj, new DateTimeZone("Europe/Skopje"));
		$vnesen = new DateTime($s->vnesen, new DateTimeZone("Europe/Skopje"));
		$vidliv = new DateTime($s->vidliv, new DateTimeZone("Europe/Skopje"));
		$denes = new DateTime("now", new DateTimeZone("Europe/Skopje"));
		$dif = $denes->diff($kraj);
		if($dif->invert===0)
			$minuti = $dif->days * 24 * 60 + $dif->h * 60 + $dif->i;
		else
			$minuti = 0 - ($dif->days * 24 * 60 + $dif->h * 60 + $dif->i);
			
		if(!$s->koef && $denes < $pocetok)
			$status = "Naked";/*
		elseif(!$s->koef && $denes > $pocetok)
		$status = "Missed";*/
		elseif(is_numeric($s->domasni4) && is_numeric($s->gosti4) &&
				is_numeric($s->domasni2) && is_numeric($s->gosti2))
				$status = "Closed";
		elseif($denes > $kraj && !(is_numeric($s->domasni4) && is_numeric($s->gosti4)
				&& is_numeric($s->domasni2) && is_numeric($s->gosti2)))
				$status = "Finished";
		elseif($minuti <= 30)
		$status = "Finish in 30min";
		elseif($denes > $pocetok && $denes < $kraj)
		$status = "Live";
		elseif($s->koef)
		$status = "Open";
	
		if(!$broj)
			echo '{';
		else
			echo ',{';
		echo '"id":"'.$s->id.'",';
		echo '"sport":"';
		$filename = "images/sports/item_".$s->sport_id;
		if(file_exists("./".$filename.".png"))
		{
			echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".png").'\'>';
		}
		elseif(file_exists("./".$filename.".jpg"))
		{
			echo '<img width=\'25\' height=\'auto\' src=\''.base_url($filename.".jpg").'\'>';
		}
		echo '",';
		echo '"hometeam":"'.$s->domasni.'",';
		echo '"awayteam":"'.$s->gosti.'",';
		echo '"final":"';
		echo (is_numeric($s->domasni4) || is_numeric($s->gosti4))?
		$s->domasni4.":".$s->gosti4:'';
		echo '",';
		echo '"half":"';
		echo (is_numeric($s->domasni2) || is_numeric($s->gosti2))?
		$s->domasni2.":".$s->gosti2:'';
		echo '",';
		echo '"date":"'.$pocetok->format("d M Y").'",';
		echo '"start":"'.$pocetok->format("H:i").'",';
		echo '"end":"'.$kraj->format("H:i").'",';
		echo '"ending":"';
		echo ($minuti>0)?$minuti:"0";
		echo '",';
		echo '"championship":"'.$s->sampionat.'",';
		echo '"round":"'.$s->kolo.'",';
		echo '"status":"'.$status.'",';
		echo '"vis":"';
		echo ($vidliv < $denes && $s->koef)?'YES':'NO';
		echo '",';
		echo '"bets":"'.$s->oblozi.'",';
		echo '"delete":"<a class=\'delete\' href=\''.base_url('admin_natprevari/delete/'.$s->id).'\'>DEL</a>",';
		echo '"color": "';
		switch ($status) {
			case "Naked":
				echo "#FF00FF";
				break;
			case "Finish in 30min":
				echo "#ff8000";
				break;
			case "Finished":
				echo "#FF0000";
				break;
			case "Closed":
				echo "#999999";
				break;
			case "Live":
				echo "#458B00";
				break;
			default:
				echo "#000000";
				break;
		}
		echo '"';
		echo '}';
		$broj++;
		endforeach;
		echo ']}';
	}
	function tester()
	{
		print_r($_POST);
	}
	/*
	function nov_()
	{
	?>
	<div class="pole">
	<div class="labeler"></div>
	<div class="elements">
	<input name="[]">
	</div>
	</div>
	<div class="pole">
	<div class="labeler"></div>
	<div class="elements">
	<input type="file" name="picture">
	</div>
	</div>
	<div class="pole">
	<div class="labeler"></div>
	<div class="elements">
	<input type="submit" value="ADD ">
	</div>
	</div>
	<?php
	}
	function smeni_()
	{
	$this->load->model("drzava");
	$item = $this->drzava->oneObject($_POST['id']);
	?>
	<div class="pole">
	<div class="labeler"></div>
	<div class="elements">
	<input name="[]" value="<?php echo $item->aaaaaa;?>">
	</div>
	</div>
	<div class="pole">
	<div class="labeler"></div>
	<div class="elements">
	<input type="file" name="picture">
	</div>
	</div>
	<div class="pole">
	<div class="labeler"></div>
	<div class="elements">
	<input type="hidden" name="id" value="<?php echo $item->id;?>"> <input
	type="submit" value="EDIT ">
	</div>
	</div>
	<?php
	}*/
}
?>
