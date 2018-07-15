
<!-- begin page-header -->
<h1 class="page-header">
	<?php echo $page_title?>
</h1>
<!-- end page-header -->
<!-- begin row -->
<div class="row">
	<!-- begin col-12 -->
	<div class="col-md-12 ui-sortable">
	<div class="row">
		<div class="col-md-12">
			<a href="<?php echo base_url()?>admin/warehouse/insert" class="btn btn-primary"><?php echo lang("Add Variant in Warehouse")?></a>
		</div>
	</div>	
<ul class="timeline">

<?php foreach ($stockhistory as $history) {?>
<?php 

$date = preg_split('/\s+/', $history->getDate());


?>
			    <li>
			        <!-- begin timeline-time -->
			        <div class="timeline-time">
			            <span class="date"><?php echo $date[0]?></span>
			            <span class="time"><?php echo $date[1]?></span>
			        </div>
			        <!-- end timeline-time -->
			        <!-- begin timeline-icon -->
			        <div class="timeline-icon">
			            <a href="javascript:;"><i class="fa fa-paper-plane"></i></a>
			        </div>
			        <!-- end timeline-icon -->
			        <!-- begin timeline-body -->
			        <div class="timeline-body">
			            <div class="timeline-header">
			                <span class="userimage"><img alt="" src="assets/img/user-1.jpg"></span>
			                <span class="username"><a href="javascript:;">John Smith</a> <small></small></span>
			                <span class="pull-right text-muted"></span>
			            </div>
			            <div class="timeline-content">
                            <p>
                            	<?php 
                            		$oldcount = $history->getOldCount();
                            		$newcount = $history->getNewCount();
                            		$diff = $newcount - $oldcount;
                            	?>
                                User Admin put <?php echo $diff ?> of product <b><?php echo Product::find(array('id' => $history->getProductId()))->getName()?></b>
                                <br/>
                                <strong><?php echo lang("Before")?>: <?php echo $oldcount?></strong>
                                <br/>
                                <strong><?php echo lang("After")?>: <?php echo $newcount?></strong>
                            </p>
			            </div>
	
			        </div>
			        <!-- end timeline-body -->
			    </li>
<?php  }?>
			    <li>
			        <!-- begin timeline-icon -->
			        <div class="timeline-icon">
			            <a href="javascript:;"><i class="fa fa-spinner"></i></a>
			        </div>
			        <!-- end timeline-icon -->
			        <!-- begin timeline-body -->
			        <div class="timeline-body">
			            Loading...
			        </div>
			        <!-- begin timeline-body -->
			    </li>
			</ul>
			

	</div>
	<!-- end col-12 -->
</div>



