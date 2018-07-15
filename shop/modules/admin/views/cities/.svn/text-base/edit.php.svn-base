
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
		<h4 class="panel-title"><?php echo lang("Edit city")?></h4>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" method="post"
			enctype="multipart/form-data">
			<?php //echo Countries::find(array('id'=>$this->uri->segment(4)));?>
			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Country")?></label>
				<div class="col-md-9">
					<select class="form-control" name="country" id="country">
						<option value="">-</option>
							<?php foreach ($countries as $c) {?>
							<option value="<?php echo $c->getId();?>" <?php if($c->getId()==$city->getCountryid()) echo "selected";?>><?php echo $c->getCountry()?></option>
							<?php }?>
					</select>
                    <?php echo form_error('country')?>
				</div>
			</div>
			<input type="hidden" name="cityid" value="<?php echo $city->getId();?> ">
			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("City")?></label>
				<div class="col-md-9">
					<input type="text" name="city"
						value="<?php echo $city->getCity()?>" id="city"
						class="form-control">
                                         <?php echo form_error('city')?>
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