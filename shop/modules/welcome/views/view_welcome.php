<?php
view_var('head', css('welcome.css'));
view_var('meta', meta('keywords', 'obullo, php5, framework'));   // You should set some head tags in view files. 
?>

<?php echo view('../header') ?>

<!-- body content -->
<h1>Welcome to Obullo !</h1> 

<div id="main">
    <div class="fieldset"> 
          <div class="fieldbox"> 
               <h3 class="legend">modules / welcome</h3> 
               <div class="inner">
               
                    <p>If you would like to edit <b>Welcome Module</b> you'll find files located at</p>
                    
                    <?php echo br(); ?>
                    
                    <code><b>modules / </b><samp>views</samp> / header.php <kbd>( View Header )</kbd></code> 
                    
                    <code><b>modules / </b><samp>views</samp> / footer.php <kbd>( View Footer )</kbd></code> 
                    
                    <code><b>modules / welcome / </b><samp>views</samp> / view_welcome.php <kbd>( View )</kbd></code>
                    
                    <code><b>modules / welcome / </b><samp>controllers</samp> / welcome.php <kbd>( Controller )</kbd></code>
                   
                    <?php echo br();  ?>
                    
                    <div class="test"><?php echo anchor('/welcome/hmvc', 'Try to New HMVC Feature'); ?></div>
                    <div class="test"><?php echo anchor('/welcome/start', 'Try to New Validation Model'); ?></div>
                    <div class="test"><?php echo anchor('/welcome/task', 'Try to New Task Feature'); ?></div>
                    <div class="test"><?php echo anchor('/backend', 'Try to New Sub Modules'); ?></div>
                    
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

<!-- end body content -->

<?php echo view('../footer') ?>
