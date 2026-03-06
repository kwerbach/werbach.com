<?php
/*
Template Name: Portfolio
*/
?>
<?php get_header(); ?>
<?php global $woo_options; ?>
       
    <div id="content" class="col-full">

		<div id="main" class="fullwidth"> 
		           
			<?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div id="breadcrumb"><p>','</p></div>'); } ?>

		    <div id="portfolio" class="col-full">
		    
			<!-- Tags -->
			<?php if ( $woo_options['woo_portfolio_tags'] ) { ?>
		    	<div id="port-tags">
		            <div class="fl">
		            	<?php
						$tags = explode(',',$woo_options['woo_portfolio_tags']); // Tags to be shown
						foreach ($tags as $tag){
							$tag = trim($tag); 
							$displaytag = $tag;
							$tag = str_replace (" ", "-", $tag);	
							$tag = str_replace ("/", "-", $tag);
							$tag = strtolower ( $tag );
							$link_tags[] = '<a href="#'.$tag.'" rel="'.$tag.'">'.$displaytag.'</a>'; 
						}
						$new_tags = implode(' ',$link_tags);
						?>
		                <span class="port-cat"><?php _e('Select a category:', 'woothemes'); ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" rel="all"><?php _e('All','woothemes'); ?></a>&nbsp;<?php echo $new_tags; ?></span>
		            </div>
		      <div class="fix"></div>
		      </div>
		      
			<?php } ?>
			<!-- /Tags -->		    
		    
			    <?php //do_action('wp_dribbble'); ?>
		    
				<ol class="portfolio dribbbles">

		        <?php if ( get_query_var('paged') ) $paged = get_query_var('paged'); elseif ( get_query_var('page') ) $paged = get_query_var('page'); else $paged = 1; ?>
		        <?php 
		        $args = array(
								'post_type' => 'portfolio', 
								'paged' => $paged, 
								'meta_key' => 'portfolio-image', 
								'posts_per_page' => -1, 
								'suppress_filters' => 0
							);
				query_posts( $args );
		        ?>
		        <?php if (have_posts()) : $count = 0; while (have_posts()) : the_post(); $count++; ?>
		        
					<?php 
						// Portfolio tags class
						$porttag = ""; 
						$posttags = get_the_tags(); 
						if ($posttags) { 
							foreach($posttags as $tag) { 
								$tag = $tag->name;
								$tag = str_replace (" ", "-", $tag);	
								$tag = str_replace ("/", "-", $tag);
								$tag = strtolower ( $tag );
								$porttag .= $tag . ' '; 
							} 
						} 
					?>  		        
		        
					<li class="group <?php echo $porttag; ?>">
						<div class="dribbble">
							<div class="dribbble-shot">
								<div class="portfolio-img dribbble-img">
									<a href="<?php the_permalink(); ?>" class="dribbble-link"><?php woo_image('key=portfolio-image&width=200&height=150&link=img'); ?></a>
									<a href="<?php the_permalink(); ?>" class="dribbble-over"><strong><?php the_title(); ?></strong> 
										<!-- <span class="dim">Your Player Name</span>  -->
										<em><?php the_time( get_option( 'date_format' ) ); ?></em> 
									</a> 
								
															</div>
							</div>
						</div>
					</li>

		        <?php endwhile; else: ?>
	            <div class="post">
	                <p><?php _e('Sorry, no posts matched your criteria.', 'woothemes') ?></p>
	            </div><!-- /.post -->
		        <?php endif; ?>  
	    
				</ol>		        		        
			
		    </div><!-- /#portfolio -->
                                                            
            <?php woo_pagenav(); ?>
		</div><!-- /#main -->

    </div><!-- /#content -->
		
<?php get_footer(); ?>