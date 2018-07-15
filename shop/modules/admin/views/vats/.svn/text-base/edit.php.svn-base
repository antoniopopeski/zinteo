
<!-- begin page-header -->
<h1 class="page-header">
	<?php echo $page_title?>
</h1>
<!-- en
<div class="col-md-12 ui-sortable">
			        <!-- begin panel -->
<div data-sortable-id="form-stuff-1" class="panel panel-inverse"
	style="">
	<div class="panel-heading">
		<div class="panel-heading-btn">
			<a data-click="panel-expand"
				class="btn btn-xs btn-icon btn-circle btn-default"
				href="javascript:;"><i class="fa fa-expand"></i></a> <a
				data-click="panel-reload"
				class="btn btn-xs btn-icon btn-circle btn-success"
				href="javascript:;"><i class="fa fa-repeat"></i></a> <a
				data-click="panel-collapse"
				class="btn btn-xs btn-icon btn-circle btn-warning"
				href="javascript:;"><i class="fa fa-minus"></i></a> <a
				data-click="panel-remove"
				class="btn btn-xs btn-icon btn-circle btn-danger"
				href="javascript:;"><i class="fa fa-times"></i></a>
		</div>
		<h4 class="panel-title"><?php echo lang("Edit vat")?></h4>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" method="post"
			enctype="multipart/form-data">
			<input type="hidden" name="vatid" value="<?php echo $vat->getId()?>">
			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Country")?></label>
				<div class="col-md-9">
					<input type="text" value="<?php echo  Countries::find(array('id'=>$vat->getCountryid()))->getCountry();?>" class="form-control" disabled>
						<input type="hidden" name="country" id="country" value="<?php echo $vat->getCountryid();?>">
                                         <?php echo form_error('country')?>
                                    </div>
			</div>


			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Value")?></label>
				<div class="col-md-9">
					<input type="text" name="value"
						value="<?php echo $vat->getValue() ?>" id="value"
						class="form-control">
                                         <?php echo form_error('value')?>
                                    </div>
			</div>



			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Date from")?></label>
				<div class="col-md-9">
					<input type="text" name="from"
						value="<?php echo $vat->getFrom_Date()?>" id="from"
						class="form-control">
                                         <?php echo form_error('from')?>
                                         <?php if(isset($error_min_date)){
                                         	echo '<b style="color:red;">'.$error_min_date.'</b>';
                                         	} ?>
					</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Date to")?></label>
					<div class="col-md-9">
					<input type="text" name="to"
						value="<?php echo $vat->getTo_Date() ?>" id="to"
						class="form-control">
                                         <?php echo form_error('to')?>
                                         <?php if(isset($error_max_date)){
                                         	echo '<b style="color:red;">'.$error_max_date.'</b>';
                                         	} ?>
                                    </div>
			</div>




			<div class="form-group">
				<label class="col-md-3 control-label"></label>
				<div class="col-md-9">
					<input type="submit" name="submit"
						value="<?php echo lang("Submit")?>" class="btn btn-sm btn-success" />
				</div>
			</div>
		</form>
	</div>
</div>
<!-- end panel -->
</div>
	<?php
	$min_date = $vat->getTo_Date();
	$min_date= date("Y-m-d",strtotime($min_date . '+1 day'));
	?>
	<script type="text/javascript" src="http://vetshop.maloto.pw//assets/plugins/jquery/jquery-1.9.1.min.js"></script>
	<script src="http://vetshop.maloto.pw//assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/js/bootstrap-datepicker.js"></script>

	<script type="text/javascript">
	$("#from").datepicker({
	    minDate: '<?php echo $min_date;?>'
	});
	</script>
