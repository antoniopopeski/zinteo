
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
		<h4 class="panel-title"><?php echo lang("Edit brand")?></h4>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" method="post"
			enctype="multipart/form-data">
			<input type="hidden" name="cid"
				value="<?php echo $category->getId()?>">
			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo  lang("Name")?></label>
				<div class="col-md-9">
					<input type="text" name="name"
						value="<?php echo $category->getName()?>" id="name"
						class="form-control">
                                         <?php echo form_error('name')?>
                                    </div>
			</div>



			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Image")?></label>
				<div class="col-md-9">
					<input type="file" class="form-control" name="image">
                                         <?php if ($category->getImage()) {?>
                                         <img
						src="<?php echo base_url()?><?php echo $category->getImage()?>"
						height="100" width="100" />
                                    	<?php }?>
                                    </div>

			</div>

			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Active")?></label>
				<div class="col-md-9">
					<label class="radio-inline"> <input type="radio"
						<?php echo $category->getActive() ? "checked='checked'" : ""?>
						value="1" name="active" id="active"> <span>Yes</span>
					</label> <label class="radio-inline"> <input type="radio"
						<?php echo !$category->getActive() ? "checked='checked'" : ""?>
						value="0" name="active" id="inactive"> <span>No</span>
					</label>
                                        <?php echo form_error('active')?>
                                    </div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Description")?></label>
				<div class="col-md-9">
					<textarea class="form-control" rows="" cols=""
						style="height: 250px;" name="description"><?php echo $category->getDescription()?></textarea>
                                         <?php echo form_error('description')?>
                                    </div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label"></label>
				<div class="col-md-9">
					<input type="submit" name="submit"
						value="<?php echo lang("Edit")?>" class="btn btn-sm btn-success" />
				</div>
			</div>
		</form>
	</div>
</div>
<!-- end panel -->
</div>

