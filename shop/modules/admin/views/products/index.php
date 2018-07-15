
<!-- begin page-header -->
<h1 class="page-header">
	<?php echo $page_title?>
</h1>
<!-- en

<!-- begin row -->
<div class="row">
	<div class="col-md-12" style="margin-bottom: 20px">
		<a href="<?php echo base_url()?>admin/products/insert"
			class="btn btn-primary-vetshop pull-right"><?php echo lang("Add new product")?></a>
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
				<h4 class="panel-title">Products</h4>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table id="mytable"
						class="table table-striped table-bordered nowrap" width="100%">
						<thead>
							<tr>
								<th>#</th>
								<th><?php echo lang("Name")?></th>
								<th><?php echo lang("Brand")?></th>
								<th><?php echo lang("Breed")?></th>
								<th><?php echo lang("Image")?></th>
								<th><?php echo lang("Stock")?></th>
								<th><?php echo lang("Price")?><br /><?php echo lang("EUR")?></th>
								<th><?php echo lang("Price")?><br /><?php echo lang("PLN")?></th>
								<th><?php echo lang("Price")?><br /><?php echo lang("GBP")?></th>
								<th><?php echo lang("Total")?><br /><?php echo lang("order")?></th>
								<th><?php echo lang("Modified")?></th>
								<th><?php echo lang("Actions")?></th>


							</tr>
						</thead>
						<tbody>
			       		<?php foreach ($products as $product) {?>
			       		<?php $date = preg_split('/\s+/', $product->getModified()); ?>
			       		<tr>
								<td><?php echo $product->getId()?></td>
								<td><a href="<?php echo base_url()?>shop/product/<?php echo $product->getId()?>" target="_blank"><?php echo $product->getName()?></a> </td>

								<td><?php echo ProductCategory::find(array('id' => $product->getProductCategoryId()))->getName()?></td>
								<td><?php echo ($product->getType() == 1) ? lang("Dog") : lang("Cat")?></td>
								<td><img
									src="<?php echo base_url()?><?php echo $product->getImage()?>"
									height="64" width="64" /></td>
								<td><?php echo Stock::getByProductId($product->getId(), true)->getCount()?></td>
								<td><?php echo $product->getEurPrice()?></td>
								<td><?php echo $product->getPlnPrice()?></td>
								<td><?php echo $product->getGbpPrice()?></td>
								<td>0</td>

								<td><?php echo date("d M Y",strtotime($date[0])) . "<br/>" . $date[1]?></td>
								<td><a style="margin-right: 5px"
									href="<?php echo base_url()?>admin/products/edit/<?php echo $product->getId()?>"><i
										title="<?php echo lang("Edit product")?>"
										class="fa fa-edit fa-2x"></i></a> <a href="#"
									onclick="deleteItem('products' , '<?php echo $product->getId()?>')"><i
										class="fa fa-trash fa-2x"></i></a> <a
									style="margin-right: 5px"
									href="<?php echo base_url()?>warehouse/insert"><i
										class="fa fa-database fa-2x"
										title="<?php echo lang("Add in storage")?>"></i></a></td>

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
		<a href="<?php echo base_url()?>admin/products/insert"
			class="btn btn-primary-vetshop pull-right"><?php echo lang("Add new product")?></a>
	</div>
</div>

<style>
th:nth-child(4) {
	width: 100px !important;
}
</style>