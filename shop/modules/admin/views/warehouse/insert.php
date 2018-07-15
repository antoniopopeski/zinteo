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
			<h4 class="panel-title"><?php echo lang("Add products in stock")?></h4>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" method="post">
				<div class="form-group">
					<label class="col-md-3 control-label"><?php echo lang("Brand")?></label>
					<div class="col-md-9">
						<select name="productcategoryid" id="productcategoryid"
							class="form-control">
							<option>-</option>
                                        <?php foreach ($categories as $category) {?>
                                        	<option
								value="<?php echo $category->getId()?>"><?php echo $category->getName()?></options>
                                        <?php }?>
                                        
						
						
						
						
						
						</select>
                                         <?php echo form_error('productcategoryid')?>
                                    </div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label"><?php echo lang("Product")?></label>
					<div class="col-md-9">
						<select name="productid" id="productid" class="form-control"></select>
                                       
                                         <?php echo form_error('productid')?>
                                    </div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label"><?php echo lang("How much pieces you add?")?></label>
					<div class="col-md-9">
						<label><?php echo lang("Current items in stock:")?> <b id="instockcount">/</b></label>
						<input type="text" name="count" value="" id="count"
							class="form-control">
				                              <?php echo form_error('count')?>
				                        </div>
				</div>


				<div class="form-group">
					<label class="col-md-3 control-label"></label>
					<div class="col-md-9">
						<input type="submit" name="submit"
							value="<?php echo lang("Submit")?>"
							class="btn btn-sm btn-success" />
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- end panel -->
</div>

