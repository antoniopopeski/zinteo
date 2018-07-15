<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
</head>

<body>
<?php echo $output; ?>
    <script>
        var incremented=false;
    $(document).on('ready',function(){    
        parent.jQuery('#crud_table').height(10);
        window["mInt"]=setInterval(function(){
            if(!incremented){
                var docHeight=$(document).height()+40;
            }
            else{
                //var docHeight=$(document).height();
            }
            parent.jQuery('#crud_table').height(docHeight);
            incremented=true;
       },100);
    });
    </script>
<div class="position">&nbsp;</div>
</body>
</html>