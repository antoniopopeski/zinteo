
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
		<h4 class="panel-title"><?php echo lang("Add new vat")?></h4>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" method="post"
			enctype="multipart/form-data">
			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Country")?></label>
				<div class="col-md-9">
				<?php 
				// $vats_array='';
				// foreach ($vats as $key) {
				// 	$vats_array.=$key->getCountryid().",";
				// 	// echo $key;
				// }
				// $vats_array=rtrim($vats_array,',');
				// $vats_array=explode(',', $vats_array);?>
					<select class="form-control" name="country" id="country">
						<option value="">-</option>
							<?php foreach ($countries as $c) {?>
							<option value="<?php echo $c->getId();?>" <?php if($c->getId()==set_value('country')) echo "selected";?>><?php echo $c->getCountry()?></option>
							<?php }?>
					</select>
                    <?php echo form_error('country')?>
				</div>
			</div>


			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Value")?></label>
				<div class="col-md-9">
					<input type="text" name="value"
						value="<?php echo set_value('value')?>" id="value"
						class="form-control">
                                         <?php echo form_error('value')?>
                                    </div>
			</div>



			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Date from")?></label>
					<div class="col-md-9">
					<input type="text" name="from"
						value="<?php echo set_value('from')?>" id="from"
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
						value="<?php echo set_value('to')?>" id="to"
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
				<label class="col-md-8 control-label" style="font-size:12px;"><?php echo lang("Note: If you do not see the country in the select menu, that is becase the VAT is already added.") ?></label>
		</form>
	</div>
</div>
<!-- end panel -->
</div>

