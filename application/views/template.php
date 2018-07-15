<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>
	<?php
	if(isset($title))
		echo $title;
	?>
	</title>
	<link type="text/css" href="<?php echo base_url();?>css/vader/jquery-ui.min.css" rel="stylesheet" />
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery-ui.min.js"></script>
	<link type="text/css" href="<?php echo base_url();?>css/admin.css" rel="Stylesheet" >
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.datetimepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/ckfinder/ckfinder.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.form.js"></script>
	<?php
	if(isset($style))
	{
		echo '<link type="text/css" href="'.base_url()."css/".$style.'" rel="Stylesheet" >';
	}
	if(isset($js))
	{
		if($js == "tablesorter")
		{
		?>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.dataTables.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/jquery.dataTables.css">
		<?php
		}
		elseif($js == "colorpicker")
		{
		?>
		<script type="text/javascript" src="<?php echo base_url();?>js/colorpicker/js/colorpicker.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>js/colorpicker/css/colorpicker.css">
		<?php
		} 
		else
		{
			?>
		<script type="text/javascript" src="<?php echo base_url();?>js/<?php echo $js;?>"></script>
		<?php
		}
	}
	?>
</head>
<body>
	<div id="main">
		<?php include "navigacija.php";?>
		<div id="content"><?php include $content.EXT; ?></div>
	</div>
	<div class="footer">
		Page rendered in <strong>{elapsed_time}</strong> seconds
	</div>
	<script type="text/javascript">
	if($('#info').text().length > 0)
	{
		$('#info').delay(5000).slideUp(500);
	}
	$(".dataTable").dataTable({
	    "bPaginate": true,
	    "sPaginationType": "full_numbers",
	    "bLengthChange": true,
	    "iDisplayLength" : 10,
	    "bFilter": false,
	    "bSort": true,
	    "bDestroy" : true,
	    "bInfo": false,
	    "bAutoWidth": false,
	    "aaSorting": [[ <?php switch ($content) {
	    	case "a_koeficienti":
	    		echo '9, "asc"';
	    	break;
	    	case "a_rezultat":
	    		echo '9, "asc"';
	    	break;
	    	case "a_tipperi":
	    		echo '3, "asc"';
	    	break;
	    	
	    	default:
	    		echo '1, "desc"';
	    	break;
	    }?> ]],
		"fnRowCallback": function( nRow, aData, iDisplayIndex) {
			var table = $.fn.dataTable.fnTables(true);
			var oSettings = $(table).dataTable().fnSettings();
			//var strana = Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength) + 1;
			if ( table.length > 0 ) {
				strana = $(table).dataTable().fnGetPosition(nRow);
			}
			var index = oSettings._iDisplayStart + iDisplayIndex + 1;//strana + 1;
			$('td:eq(0)',nRow).html(index);
		<?php if($content=="a_natprevari"):?>
			var boja = aData.color;
			$(nRow).css("color", boja);
		<?php endif;?>
			return nRow;
		},
		<?php if($content=="a_natprevari"):
		$lokacija = $this->uri->segment(2);
		?>
		"bServerSide": true,
        "sAjaxSource": '<?php switch ($lokacija)
        {
        	case "nezatvoreni":
        		echo base_url('ajax/natprevariNezatvoreni');
        		break;
        	case "naked":
        		echo base_url('ajax/natprevariNaked');
        		break;
        	case "missed":
        		echo base_url('ajax/natprevariMissed');
        		break;
        	case "open":
        		echo base_url('ajax/natprevariOpen');
        		break;
        	case "live":
        		echo base_url('ajax/natprevariLive');
        		break;
        	case "prikraj":
        		echo base_url('ajax/natprevariPrikraj');
        		break;
        	case "zavrseni":
        		echo base_url('ajax/natprevariZavrseni');
        		break;
        	case "zatvoreni":
        		echo base_url('ajax/natprevariZatvoreni');
        		break;
        	default:
        		echo base_url('ajax/natprevariSite');
        		break;
		}?>',
        "fnServerData": function (sSource, aoData, fnCallback) {
            $.ajax({
                "dataType": 'json',
                "type": "POST",
                "url": sSource,
                "data": aoData,
                "success": fnCallback/*function(data)
        		{
        			$('tbody').html(data);
        		}
                    //*/
            });
        },
		"fnDrawCallback": function( oSettings ) {
			efekti();
		},
        "aoColumns": [
                      { "mData": null },
                      { "mData": "id" },
                      { "mData": "sport" },
                      { "mData": "hometeam" },
                      { "mData": "awayteam" },
                      { "mData": "final" },
                      { "mData": "half" },
                      { "mData": "date" },
                      { "mData": "start" },
                      { "mData": "end" },
                      { "mData": "ending" },
                      { "mData": "championship" },
                      { "mData": "round" },
                      { "mData": "status" },
                      { "mData": "vis" },
                      { "mData": "bets" },
                      { "mData": "delete" },
                      { "mData": "color" }
                  ],
		"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0 ] },
		                 { "bSortable": false, "aTargets": [ 5 ] },
		                 { "bSortable": false, "aTargets": [ 6 ] },
		                 { "bSortable": false, "aTargets": [ 8 ] },
		                 { "bSortable": false, "aTargets": [ 9 ] },
		                 { "bSortable": false, "aTargets": [ 10 ] },
		                 { "bSortable": false, "aTargets": [ 16 ] },
		                 { "bVisible": false, "aTargets": [17] }],
		<?php else:?>
		"aoColumnDefs": [{ "bSortable": false, "aTargets": [ 0 ] }],
        <?php endif;?>
	    "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "ALL"]],
	    "oLanguage": { "sEmptyTable": "No data" }
	});
	</script>
</body>
</html>