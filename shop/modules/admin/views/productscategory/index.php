

<!-- begin page-header -->
<h1 class="page-header">
	<?php echo $page_title?>
</h1>
<!-- en
<!-- begin row -->
<div class="row">
	<div class="col-md-12">
		<a href="<?php echo base_url()?>admin/productscategory/insert"
			style="margin-bottom: 20px;"
			class="btn btn-primary-vetshop pull-right"><?php echo lang("Add new brand")?></a>
	</div>
</div>
<div class="row">
	<!-- begin col-12 -->
	<div class="col-md-12 ui-sortable">
		<!-- begin panel -->
		<div class="panel panel-inverse">
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
				<h4 class="panel-title">Brands</h4>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table id="mytable"
						class="table table-striped table-bordered nowrap" width="100%">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th><?php echo lang("Image")?></th>
								<th>Active</th>
								<th><?php echo lang("Created")?></th>
								<th><?php echo lang("Modified")?></th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
			       		<?php foreach ($categories as $category) {?>
			       		<tr>
								<td><?php echo $category->getId()?></td>
								<td><?php echo $category->getName()?></td>
								<td><img
									src="<?php echo base_url()?><?php echo $category->getImage()?>"
									width="65" height="65" /></td>
								<td><?php echo $category->getActive() ? lang("Yes") : lang("No") ?></td>
								<td><?php echo $category->getCreated()?></td>
								<td><?php echo date("d M Y H:i:s",strtotime($category->getModified()))?></td>
								<td><a style="margin-right: 5px"
									href="<?php echo base_url()?>admin/productscategory/edit/<?php echo $category->getId()?>"><i
										class="fa fa-edit fa-2x"></i></a> <a href="#"
									onclick="deleteItem('productscategory' , '<?php echo $category->getId()?>')"><i
										class="fa fa-trash fa-2x"></i></a></td>

							</tr>
			       		<?php }?>
			       	</tbody>

					</table>
				</div>
			</div>
		</div>
		<!-- end panel -->
	</div>
	<!-- end col-12 -->
</div>

<div class="row">
	<div class="col-md-12">
		<a href="<?php echo base_url()?>admin/productscategory/insert"
			class="btn btn-primary-vetshop pull-right"><?php echo lang("Add new brand")?></a>
	</div>
</div>

