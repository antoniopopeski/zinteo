<!-- begin page-header -->
<h1 class="page-header">
	<?php echo $page_title?>
</h1>
<!-- en
<!-- begin row -->


<div class="row">
	<!-- begin col-12 -->
	<div class="col-md-12 ui-sortable">
	<?php
	 if(sess_flash('new_user_added', $prefix = '' , $suffix = '')){?>
		<div id="fadeSuccess" class="alert alert-success fade in m-b-15">
			<strong><?php echo lang("Success!");?></strong>
			<?php echo lang("New user has been successfully added")?>
			<span data-dismiss="alert" class="close">×</span>
		</div>
	<?php }?>
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
					<table id="admin_table"
						class="table table-striped table-bordered nowrap" width="100%">
						<thead>
							<tr>
								
							</tr>
							<tr>
								<th>#</th>
								<th><?php echo lang("Email")?></th>
								<th><?php echo lang("Name")?></th>
						
								<th><?php echo lang("Delivery Address")?></th>
								
								<th><?php echo lang("Total order")?></th>
								<th><?php echo lang("Registred date")?></th>
								<th><?php echo lang("Last login")?></th>

							</tr>

						</thead>
						<tbody>
						<?php foreach ($users as $user) {?>
						<?php $da=DeliveryAddress::getForCurrentUser($user->getId());?>
			       		<tr>
								<td><?php echo $user->getId()?></td>
								<td><?php echo $user->getEmail()?></td>
								<td><?php echo $da ? $da[0]->firstname. " " . $da[0]->lastname : ""?></td>
							
								<td><?php echo $da ?  $da[0]->street." ".$da[0]->streetno.", ".$da[0]->city . ", " . $da[0]->zip. ", " . $da[0]->country : "/"?></td>
								
								<td><?php $totalOrders=Order::getCountOrdersForCurrentUser($user->getId());
								echo $totalOrders[0]->totalorder;?></td>

								<td><?php echo date("d M Y H:i:s",strtotime($user->getCreated()));?></td>
								<td><?php echo date("d M Y H:i:s",strtotime($user->getLastlogin()));?></td>
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
		<a href="<?php echo base_url()?>admin/users/insert"
			class="btn btn-primary-vetshop pull-right"><?php echo lang("Add new user")?></a>
	</div>
</div>