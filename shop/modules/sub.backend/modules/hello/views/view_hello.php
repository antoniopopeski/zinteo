
<?php
view_var('head', css('backend.css'));
view_var('meta', meta('keywords', 'obullo, php5, framework'));   // You should set some head tags in view files.       
?>

<?php  
echo view('../header') ?>

<!-- body content -->
<h1>Backend Sub Module !</h1> 

<div id="main">
    <div class="fieldset"> 
          <div class="fieldbox"> 
               <h3 class="legend">sub.backend / modules / hello</h3> 
               <div class="inner">
               
                    <p>If you would like to edit <b>Backend Hello Module</b> you'll find files located at</p>
                    
                    <?php echo br(); ?>
                    
                    <code><b>sub.backend / modules / </b><samp>views</samp>  / header.php <kbd>( Header View )</kbd></code> 
                    
                    <code><b>sub.backend / modules / </b><samp>views</samp> / footer.php <kbd>( Footer View )</kbd></code> 
                    
                    <code><b>sub.backend / modules / hello / </b><samp>views</samp> / view_hello.php <kbd>( View )</kbd></code>
                    
                    <code><b>sub.backend / modules / hello / </b><samp>controllers</samp> / hello.php <kbd>( Controller )</kbd></code>
                   
                      <?php echo br(2);  ?>
                    
                    <p><b>Note:</b> If you are new to Obullo, you should start by 
                reading the <a href="http://obullo.com/user_guide/en/1.0.1/index.html">User Guide</a>.</p>
           
              </div>
          </div> 
    </div> 

<p>
<?php echo br(); ?>Page rendered in {elapsed_time} seconds <?php echo $var; ?> 
<?php echo img('obullo.gif', ' border="0" '); ?>
</p>

</div> 

<?php echo br(); ?>
<!-- body content -->

<?php  echo view('../footer') ?>
