
<!-- begin page-header -->
<h1 class="page-header">
	<?php echo $page_title?>
</h1>
<!-- en

<!-- begin row -->
<div class="row">
	<div class="col-md-12" style="margin-bottom: 20px">
		<!-- <a href="<?php echo base_url()?>admin/vats/insert" class="btn btn-primary-vetshop pull-right"><?php echo lang("Add new")?></a> -->
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
				<h4 class="panel-title"><?php echo lang("Vats")?></h4>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table id="mytable"
						class="table table-striped table-bordered nowrap" width="100%">
						<thead>
							<tr>
								<th>#</th>
								<th><?php echo lang("Vet")?></th>
								<th><?php echo lang("City")?></th>
								<th><?php echo lang("Country")?></th>
								<th><?php echo lang("Submited from user")?></th>
								<th><?php echo lang("Date")?></th>
								<!-- <th></th> -->


							</tr>
						</thead>
						<tbody>
			       		<?php foreach ($vets as $vet) {?>
			       		
			       		<tr>
								<td><?php echo $vet->getId()?></td>
								<td><?php echo $vet->getVet_Name()?></td>
								<td><?php echo Cities::find(array('id'=>$vet->getVet_City()))->getCity();?></td>
								<td><?php echo Countries::find(array('id'=>$vet->getVet_Country()))->getCountry();?></td>
								<td><?php echo User::find(array('id'=>$vet->getVet_user_id()))->getEmail();?></td>
								<td><?php echo date("d M Y, H:i",strtotime($vet->getVet_datum_submited()));?></td>
								<!-- <td>
									<a style="margin-right: 5px" href="<?php echo base_url()?>admin/vats/edit/<?php //echo $vat->getId()?>"><i title="<?php echo lang("Edit vat")?>"
								 		class="fa fa-edit fa-2x"></i></a> 
								   <a href="#"
									onclick="deleteItem('vats' , '<?php //echo $vat->getId()?>')"><i
										class="fa fa-trash fa-2x"></i></a>		
								</td> -->
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
		<!-- <a href="<?php echo base_url()?>admin/vats/insert" class="btn btn-primary-vetshop pull-right"><?php echo lang("Add new vat")?></a> -->
	</div>
</div>

<style>
th:nth-child(4) {
	width: 100px !important;
}
</style>