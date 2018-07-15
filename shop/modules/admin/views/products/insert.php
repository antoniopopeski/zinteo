
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
		<h4 class="panel-title"><?php echo lang("Add new product")?></h4>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" method="post"
			enctype="multipart/form-data">
			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Name")?></label>
				<div class="col-md-9">
					<input type="text" name="name"
						value="<?php echo set_value('name')?>" id="name"
						class="form-control">
                                         <?php echo form_error('name')?>
                                    </div>
			</div>


			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Brand")?></label>
				<div class="col-md-9">
					<select class="form-control" name="productcategoryid">
						<option value="">-</option>
                                         	<?php foreach ($categories as $category) {?>
                                         	<option
							value="<?php echo $category->getId()?>"><?php echo $category->getName()?></option>
                                         	<?php }?>
                                         </select>
                                         <?php echo form_error('productcategoryid')?>
                                    </div>
			</div>



			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Image")?></label>
				<div class="col-md-9">
					<input type="file" class="form-control" name="image">
                                         <?php echo form_error('image')?>
                                    </div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Price EUR")?></label>
				<div class="col-md-9">
					<input type="text" name="eurprice"
						value="<?php echo set_value('eurprice')?>" id="eurprice"
						class="form-control">
                                         <?php echo form_error('eurprice')?>
                                    </div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Price PLN")?></label>
				<div class="col-md-9">
					<input type="text" name="plnprice"
						value="<?php echo set_value('plnprice')?>" id="plnprice"
						class="form-control">
                                         <?php echo form_error('plnprice')?>
                                    </div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Price GBP")?></label>
				<div class="col-md-9">
					<input type="text" name="gbpprice"
						value="<?php echo set_value('gbpprice')?>" id="gbpprice"
						class="form-control">
                                         <?php echo form_error('gbpprice')?>
                                    </div>
			</div>


			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Active")?></label>
				<div class="col-md-9">
					<label class="radio-inline"> <input type="radio" checked=""
						value="1" name="active" id="active"> <span>Yes</span>
					</label> <label class="radio-inline"> <input type="radio" value="0"
						name="active" id="inactive"> <span>No</span>
					</label>
                                        <?php echo form_error('active')?>
                                    </div>
			</div>


			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Type")?></label>
				<div class="col-md-9">
					<label class="checkbox-inline"> <input type="checkbox" value="1"
						name="type[]" id="dog"> <span><?php echo lang("Dog")?></span>
					</label> <label class="checkbox-inline"> <input type="checkbox"
						value="2" name="type[]" id="cat"> <span><?php echo lang ("Cat")?></span>
					</label>
                                        <?php echo form_error('type')?>
                                    </div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label"><?php echo lang("Description")?></label>
				<div class="col-md-9">
					<textarea class="form-control" rows="" cols=""
						style="height: 250px" name="description"><?php echo set_value('description')?></textarea>
                                         <?php echo form_error('description')?>
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

