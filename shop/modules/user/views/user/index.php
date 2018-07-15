<!-- begin page-header -->
<h1 class="page-header">
	<?php echo $page_title?>
</h1>
<!-- en
<!-- begin row -->


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
				<h4 class="panel-title"><?php echo lang("Users")?></h4>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table id="mytable"
						class="table table-striped table-bordered nowrap" width="100%">
						<thead>
							<tr>
								<td></td>
								<td></td>
								<td><input class="form-control" type="text" id="search-user"
									name="search-user"></td>
								<td><input class="form-control" type="text" id="search-product"
									name="search-product"></td>
								<td><input class="form-control" type="text" id="search-brand"
									name="search-brand"></td>
								<td><input class="form-control" type="text" id="search-price"
									name="search-price"></td>
								<td><input class="form-control" type="text" id="search-discount"
									name="search-discount"></td>
								<td><input class="form-control" type="text" id="search-country"
									name="search-country"></td>
								<td><input class="form-control" type="text" id="search-city"
									name="search-city"></td>
								<td><input class="form-control" type="text" id="search-zip"
									name="search-zip"></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<th>#</th>
								<th><?php echo lang("Email")?></th>
								<th><?php echo lang("Name")?></th>
								<th><?php echo lang("Address")?></th>
								<th><?php echo lang("Country")?></th>
								<th><?php echo lang("City")?></th>
								<th><?php echo lang("Delivery Address")?></th>
								<th><?php echo lang("Veterenian")?></th>
								<th><?php echo lang("Delivery type")?></th>
								<th><?php echo lang("Total order")?></th>

							</tr>

						</thead>
						<tbody>
						<?php foreach ($users as $user) {?>
			       		<tr>
								<td><?php echo $user->getId()?></td>
								<td><?php echo $user->getEmail()?></td>
								<td><?php echo $user->getFirstName() . " " . $user->getLastName()?></td>
								<td>Address</td>
								<td><?php echo $user->getCountry()?></td>
								<td><?php echo $user->getCity()?></td>
								<td><?php echo "Address" ?></td>
								<td>veterinar</td>
								<td>delivery type</td>
								<td>100</td>
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

