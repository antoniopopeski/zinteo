<h1><?php echo $title;?></h1>
<?php if(isset($poraka) && $poraka):?>
<div id="info" <?php echo (strpos($poraka, 'success')===false)?'style="background-color: #F00;"':
		'style="background-color: #0F0;"';?>><?php echo "<label>".$poraka."</label>"; ?></div>
<?php endif;?>
<table id="adminTabela" class="dataTable" style="width: 100%;">
<thead>
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Username</th>
	<th>Role</th>
	<th>Delete</th>
</tr>
</thead>
<tbody>
<?php foreach($lista as $item):?>
<tr>
	<td></td>
	<td><?php echo $item->id;?></td>
	<td class="tabelaNaslov">
		<a href="<?php echo base_url()."admin_users/promeni/".$item->id;?>"><?php echo $item->username;?></a>
	</td>
	<td><?php
	switch($item->uloga)
	{
		case 3:
			echo "Super administrator";
			break;
		case 2:
			echo "Administrator";
			break;
		default:
			echo "User";
			break;
	}
	?></td>
	<td>
		<?php if($item->username!="admin"):?>
		<a class="delete" href="<?php echo base_url()."admin_users/izbrisi/".$item->id;?>">Delete</a>
		<?php endif;?>
	</td>
</tr>
<?php endforeach;?>
</tbody>
</table>
<br>
<button id="new">New user</button>
<div id="potvrdi-dialog"><h3>Are you sure that you want to delete this user?</h3></div>
<script type="text/javascript">
if($('#info').text().length > 10)
{
	$('#info').delay(3000).slideUp(500);
}
$('.delete').click(function(e){
    e.preventDefault();
    $("#potvrdi-dialog").dialog('option', 'href',$(this).attr('href')).dialog('open');
    return false;
});
$("#new").click(function(){
	window.location.replace("<?php echo base_url();?>admin_users/dodadi");
});
$("#potvrdi-dialog").dialog({
    resizable: false,
    modal: true,
    buttons: {
		'Откажи': function() {
		    $(this).dialog('close');
		},
		'Избриши': function() {
		    window.location.href = $(this).dialog('option', 'href');
		}
    },
    autoOpen: false
});
</script>
