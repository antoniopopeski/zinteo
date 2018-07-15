
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
				<h4 class="panel-title">Orders</h4>
			</div>
			<?php 
				foreach ($orders as $i => $order) {
					$user[$i]=User::find(array('id'=>$order->getUserId()))->getEmail();
					$product[$i]=Product::find(array('id' => $order->getProductId()))->getName();

					$pid= Product::find(array('id'=>$order->getProductId()));
					$brand[$i]=ProductCategory::find(array('id'=>$pid->getProductCategoryId()))->getName();
					$countries[$i]=Countries::find(array('id' => DeliveryAddress::find(array('id'=>$order->getdeliveryaddressid()))->getCountry()))->getCountry();
					//if(!empty(Cities::find(array('id' => DeliveryAddress::find(array('id'=>$order->getdeliveryaddressid()))->getCity()))->getCity())){
					//}
						$city=Cities::find(array('id' => DeliveryAddress::find(array('id'=>$order->getdeliveryaddressid()))->getCity()));
						// echo "<pre>";
						// print_r($city);
						// echo "</pre>";
						// echo "<pre>";
						// if($city->getId() instanceof Cities){
						// 	echo $city->getId();
						// }
						// print_r($city->getId());
						// echo "</pre>";
						$cities[$i]=$city->getCity();

					$zip[$i]=DeliveryAddress::find(array('id'=>$order->getdeliveryaddressid()))->getZip();
					$deliveryType[$i]=$order->getDeliveryType();
					$paymenttype[$i]=PaymentType::find(array('id' => $order->getPaymenttypeId()))->getType();

					if ($order->getVetName()) {
						$vet[$i] = $order->getVetname();
					} elseif ($order->getVetId()) {
						$vet[$i] = Veterinars::find(array('id'=> $order->getVetId()))->getName() . " " . Veterinars::find(array('id'=> $order->getVetId()))->getLastName();
					} else {
						$vet[$i] = '-';
					}

					$price[$i]=Product::find(array('id'=> $order->getProductId()))->getEurPrice();
					$discount[$i]=$order->getDiscount();
					$status[$i]=$order->getStatus();
					$paid[$i]=$order->getPaid();
				}

				// unique values arrays
				$user=array_unique($user);
				$product=array_unique($product);
				$brand=array_unique($brand);
				$countries=array_unique($countries);
				$cities=array_unique($cities);
				$zip=array_unique($zip);
				$deliveryType=array_unique($deliveryType);
				$paymenttype=array_unique($paymenttype);
				$vet=array_unique($vet);
				$price=array_unique($price);
				sort($price);
				$discount=array_unique($discount);
				$discount=array_filter($discount);
				$status=array_unique($status);
				$paid=array_unique($paid);
			 ?>
			<div class="panel-body">
				<div class="table-responsive">
					<table id="mytable"
						class="table table-striped table-bordered nowrap" width="100%">
						<thead>
							<tr>
								<td></td>
								<td></td>
								<td><select name="search-user" id="search-user">
									<option value="">-</option>
									<?php foreach ($user as $u) {?>
									<option value="<?php echo $u;?>"><?php echo $u;?></option>
									<?php }?>
								</select></td>

								<td><select name="search-product" id="search-product">
									<option value="">-</option>
									<?php foreach ($product as $p) {?>
									<option value="<?php echo $p;?>"><?php echo $p;?></option>
									<?php }?>
								</select></td>
								<td><select name="search-brand" id="search-brand">
									<option value="">-</option>
									<?php foreach ($brand as $b) {?>
									<option value="<?php echo $b;?>"><?php echo $b;?></option>
									<?php }?>
								</select></td>
								<td><select name="search-price" id="search-price">
									<option value="">-</option>
									<?php foreach ($price as $b) {?>
									<option value="<?php echo $b;?>"><?php echo $b;?></option>
									<?php }?>
								</select></td>
								<td><select name="search-discount" id="search-discount">
									<option value="">-</option>
									<?php foreach ($discount as $d) {?>
									<option value="<?php echo $d;?>"><?php echo $d;?></option>
									<?php }?>
								</select></td>
								<td><select name="search-country" id="search-country">
									<option value="">-</option>
									<?php foreach ($countries as $c) {?>
									<option value="<?php echo $c;?>"><?php echo $c;?></option>
									<?php }?>
								</select></td>
								<td><select name="search-city" id="search-city">
									<option value="">-</option>
									<?php foreach ($cities as $c) {?>
									<option value="<?php echo $c;?>"><?php echo $c;?></option>
									<?php }?>
								</select></td>
								<td><select name="search-zip" id="search-zip">
									<option value="">-</option>
									<?php foreach ($zip as $z) {?>
									<option value="<?php echo $z;?>"><?php echo $z;?></option>
									<?php }?>
								</select></td>
								<td><select name="search-deliverey-type" id="search-deliverey-type">
									<option value="">-</option>
									<?php foreach ($deliveryType as $dt) {?>
									<option value="<?php echo $dt;?>"><?php echo $dt;?></option>
									<?php }?>
								</select></td>
								<td><select name="search-payment-type" id="search-payment-type">
									<option value="">-</option>
									<?php foreach ($paymenttype as $pt) {?>
									<option value="<?php echo $pt;?>"><?php echo $pt;?></option>
									<?php }?>
								</select></td>
								<td><select name="search-vet" id="search-vet">
									<option value="">-</option>
									<?php foreach ($vet as $v) {?>
									<option value="<?php echo $v;?>"><?php echo $v;?></option>
									<?php }?>
								</select></td>
								<?php /*
								<td><select name="search-paid" id="search-paid">
									<option value="">-</option>
									<?php foreach ($paid as $p) {?>
									<option value="<?php if($p==1){echo lang("Yes");} else { if($p==0) echo lang("No");};?>"><?php if($p==1){echo lang("Yes");} else { if($p==0) echo lang("No");};?></option>
									<?php }?>
								</select></td><?php */?>
								<td>
									<select name="search-paid" id="search-paid">
										<option value="">-</option>
										<option value="<?php echo lang("Yes");?>"><?php echo lang("Yes");?></option>
										<option value="<?php echo lang("No");?>"><?php echo lang("No");?></option>
									</select>
								</td>
								<td><select name="search-delivered" id="search-delivered">
									<option value="">-</option>
									<?php foreach ($status as $s) {?>
									<option value="<?php if($s) echo lang("Yes"); else echo lang("No");?>"><?php if($s) echo lang("Yes"); else echo lang("No");?></option>
									<?php }?>
								</select></td>
							</tr>
							<tr>
								<th>#</th>
								<th><?php echo lang("Date")?></th>
								<th><?php echo lang("User")?></th>
								<th><?php echo lang("Product")?></th>
								<th><?php echo lang("Brand")?></th>
								<th><?php echo lang("Price")?></th>
								<th><?php echo lang("Disc")?></th>
								<th><?php echo lang("Country")?></th>
								<th><?php echo lang("City")?></th>
								<th><?php echo lang("Zip")?></th>
								<th><?php echo lang("Delivery type")?></th>
								<th><?php echo lang("Paym.")?><br /><?php echo ("Type")?></th>
								<th><?php echo lang("Veterenien")?></th>
								<th><?php echo lang("Paid")?></th>
								<th><?php echo lang("Delivered")?></th>
								<th><?php echo lang("Quantity")?></th>
								<th><?php echo lang("Subtotal")?></th>

							</tr>

						</thead>
						<tbody>
			       		<?php foreach ($orders as $order) {?>
			       		
			       		<?php $product= Product::find(array('id'=>$order->getProductId()))?>
			       		<?php $brand = ProductCategory::find(array('id'=>$product->getProductCategoryId()))?>
			       		<?php $date = preg_split('/\s+/', date("d M Y H:i:s",strtotime($order->getDate())));?>
			       		<?php $date=date("d M Y \n H:i:s",strtotime($order->getDate()));
			       		
			       		$vet = "";
			       		if ($order->getVetName()) {
			       		$vet = $order->getVetname();
			       		} elseif ($order->getVetId()) {
			       		$vet = Veterinars::find(array('id'=> $order->getVetId()))->getName() . " " . Veterinars::find(array('id'=> $order->getVetId()))->getLastName(). ", ". Veterinars::find(array('id'=> $order->getVetId()))->getCity();
			       		} else {
			       		$vet = '-';
			       		}
			       		
			       		?>
			       		<tr class="<?php echo (!$order->getPaid()) ? "danger" : "success";?>">
			       		<?php $site_url = $_SERVER['HTTP_HOST']?>
								<td><?php echo $order->getId()?></td>
								<td><?php echo $date;?></td>
								<td><?php echo User::find(array('id'=>$order->getUserId()))->getEmail()?></td>
								<td><?php echo Product::find(array('id' => $order->getProductId()))->getName()?></td>
								<td><?php echo $brand->getName()?></td>
								<td><?php echo $price=Product::find(array('id'=> $order->getProductId()))->getEurPrice()?> <?php echo strtoupper($order->getCurrency())?></td>
								<td><?php if($order->getDiscount()) { echo $order->getDiscount()."%";} else { echo "0";}?></td>
								<td><?php echo Countries::find(array('id' => DeliveryAddress::find(array('id'=>$order->getdeliveryaddressid()))->getCountry()))->getCountry(); ?></td>
								<td><?php ///echo Cities::find(array('id' => DeliveryAddress::find(array('id'=>$order->getdeliveryaddressid()))->getCity()))->getCity(); ?></td>
								<td><?php echo DeliveryAddress::find(array('id'=>$order->getdeliveryaddressid()))->getZip()?></td>
								<td><?php echo $order->getDeliveryType()?></td>
								<td><?php echo PaymentType::find(array('id' => $order->getPaymenttypeId()))->getType()?>
								<?php //if ($order->getPaymenttypeId() == 2) {?>
									<a href="http://FreeHTMLtoPDF.com/?convert=<?php echo base_url()?>shop/pdf/<?php echo $order->getId()?>"><i class="fa fa-file-pdf-o" ></i></a>
								<?php //}?>
								</td>
								<td><?php echo $vet?></td>
								<td class="paidresponsetd<?php echo $order->getId();?>"><?php if($order->getPaid()) {?>
									<a class="btn btn-success paidclass paidresponse<?php echo $order->getId();?>" data-paidinvoice="<?php echo $order->getId();?>"><?php echo lang("Yes")?></a>
								 <?php } else {?>
								 	<a class="btn btn-danger paidclass paidresponse<?php echo $order->getId();?>" data-paidinvoice="<?php echo $order->getId();?>"><?php echo lang("No")?></a>
								 <?php }?></td>

								<td class="statusresponsetd<?php echo $order->getId();?>" data-status="<?php echo $order->getId();?>">
								<?php if($order->getStatus()) {?>
									<a class="btn btn-success paidclass statusclass statusresponse<?php echo $order->getId();?>" data-status="<?php echo $order->getId();?>"><?php echo lang("Yes")?></a>
								 <?php } else {?>
								 	<a class="btn btn-danger paidclass statusclass statusresponse<?php echo $order->getId();?>" data-status="<?php echo $order->getId();?>"><?php echo lang("No")?></a>
								 <?php }?>
								</td>
								<td><?php echo $order->getQuantity();?></td>
								<td><?php 
									$dsc=$order->getQuantity()*$price*$order->getDiscount()/100;
									$pricedsc=$order->getQuantity()*$price;
									if($order->getDiscount()){echo number_format($pricedsc-$dsc,2,',','.')." "; echo strtoupper($order->getCurrency());} else {echo number_format($pricedsc,2,',','.')." "; echo strtoupper($order->getCurrency());}?></td>
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
.paidclass,.statusclass{
	cursor: pointer;
}
tr th:nth-child(4) {
	width: 100px !important;
}
tr td{
	color: black!important;
}
</style>