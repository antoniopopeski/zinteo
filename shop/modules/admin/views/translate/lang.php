
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

				<h4 class="panel-title"><?php lang("Language management")?></h4>
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<form action="" method="post">
					
					<input type="hidden" name="current_language" id="current_language" value="<?php print $current_language?>"> 
					
					  <?php 
						  $i=0;
						foreach($translate as $k=>$v){   
						  $k=stripslashes($k);
						  $v=stripslashes($v);
						  $i++;
						  ?>
						  
						  
						<div class="form-group">
						<!-- original string -->
							<div class="col-md-1"><?php echo $i;?></div>
							<div class="col-md-5">
								<input type="text" readonly="readonly" name="lang_original_<?php print $i ?>" value="<?php print htmlentities($k,ENT_COMPAT,"utf-8")?>"  class="form-control">
                            </div>
                         <!-- translated string -->           
							<div class="col-md-6" >
								<input type="text"  name="lang_translated_<?php print $i?>" value="<?php print htmlentities($v,ENT_COMPAT,"utf-8")?>"  class="form-control" <?php if($k==$v) echo 'style="border: 1px solid red;"';?>>
                            </div>
						</div>
						  
						<?php }	?>
			
								<div class="form-group" style="margin-top:10px">
				<label class="col-md-3 control-label"></label>
				<div class="col-md-9">
					<input type="submit" name="submit"
						value="<?php echo lang("Submit")?>" class="btn btn-sm btn-success" />
				</div>
			</div>
					</form>
				</div>
			</div>
		</div>
		<!-- end panel -->
	</div>
	<!-- end col-12 -->
</div>
<style type="text/css">
	.form-control{font-size: 14px;}
</style>