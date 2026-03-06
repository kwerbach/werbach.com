<?php global $woo_options; ?>

	<div class="fix"></div>

    <div id="footer">
    
		<div id="footer-wrap" class="col-full">    
            
            <div id="copyright" class="fl">
				<?php if($woo_options['woo_footer_left'] == 'true'){
				
						echo stripslashes($woo_options['woo_footer_left_text']);	
		
				} else { ?>
					<p>&copy; <?php echo date('Y'); ?> <?php bloginfo(); ?>. <?php _e('All Rights Reserved.', 'woothemes') ?></p>
				<?php } ?>
            </div><!-- /#copyright -->
            
            <div id="credit" class="fr">
		        <?php if($woo_options['woo_footer_right'] == 'true'){
				
		        	echo stripslashes($woo_options['woo_footer_right_text']);
		       	
				} else { ?>
					<p><?php _e('Powered by', 'woothemes') ?> <a href="http://www.wordpress.org">WordPress</a>. <?php _e('Designed by', 'woothemes') ?> <a href="<?php $aff = $woo_options['woo_footer_aff_link']; if(!empty($aff)) { echo $aff; } else { echo 'http://www.woothemes.com'; } ?>"><img src="<?php bloginfo('template_directory'); ?>/images/woothemes.png" width="74" height="19" alt="Woo Themes" /></a></p>
				<?php } ?>
            </div><!-- /#main -->
            
            <div class="fix"></div>
		</div><!-- /#footer-wrap -->

    </div><!-- /#footer -->

</div><!-- /#wrapper -->
<?php wp_footer(); ?>
<?php woo_foot(); ?>
</body>
</html>