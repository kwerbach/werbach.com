<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">

<title><?php woo_title(); ?></title>
<?php woo_meta(); ?>
<?php global $woo_options; ?>

<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php if ( $woo_options['woo_feed_url'] ) { echo $woo_options['woo_feed_url']; } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
      
<?php wp_head(); ?>
<?php woo_head(); ?>

</head>

<body <?php body_class(); ?>>
<?php woo_top(); ?>

<div id="wrapper">

	<div id="header-wrap" class="col-full">

		<div id="header">		
    		<div id="logo" class="fl">
    			
				<?php if ($woo_options['woo_texttitle'] <> "true") : $logo = $woo_options['woo_logo']; ?>
		            <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>">
		                <img src="<?php if ($logo) echo $logo; else { bloginfo('template_directory'); ?>/images/logo.png<?php } ?>" alt="<?php bloginfo('name'); ?>" />
		            </a>
		        <?php endif; ?> 
		        
		        <?php if( is_singular() && !is_front_page() ) : ?>
		            <span class="site-title"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></span>
		        <?php else : ?>
		            <h1 class="site-title"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
		        <?php endif; ?>
		            <span class="site-description"><?php bloginfo('description'); ?></span>
    	    	
    	    </div><!-- /#logo -->
		
			<div id="top-right" class="fr"> 
				<div class="nav">
				<?php
				if ( function_exists('has_nav_menu') && has_nav_menu('primary-menu') ) {
					wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'theme_location' => 'primary-menu' ) );
				} else {
				?>
		        <ul>
					<?php 
		        	if ( isset($woo_options['woo_custom_nav_menu']) AND $woo_options['woo_custom_nav_menu'] == 'true' ) {
		        		if ( function_exists('woo_custom_navigation_output') )
							woo_custom_navigation_output();
		
					} else { ?>
		            	
			            <?php if ( is_page() ) $highlight = "page_item"; else $highlight = "page_item current_page_item"; ?>
			            <li class="<?php echo $highlight; ?>"><a href="<?php bloginfo('url'); ?>"><?php _e('Home', 'woothemes') ?></a></li>
			            <?php 
			    			wp_list_pages('sort_column=menu_order&depth=6&title_li=&exclude='); 
		
					}
					?>
		        </ul>
		        <?php } ?>
		      	</div><!-- /.nav -->
    	    
    	    </div><!-- /#top-right -->  
			<div class="socialNav">
					  <ul>
					    <li><a href="http://twitter.com/gamifyforthewin" target="_blank"><img src="http://gamifyforthewin.com/images/twitter.png" title="twitter" alt="twitter"></a></li>
		           <li><a href="https://www.facebook.com/pages/For-the-Win-Serious-Gamification/230828906955679" target="_blank"><img src="http://gamifyforthewin.com/images/facebook.png" title="facebook" alt="facebook"></a></li>
					    <li><a href="http://www.flickr.com/photos/gamifyforthewin/" target="_blank"><img src="http://gamifyforthewin.com/images/flickr.png" title="flickr" alt="flickr"></a></li>
					<li><a href="http://gplus.to/gamifyforthewin" target="_blank"><img src="http://gamifyforthewin.com/images/google-plus.png" title="google-plus" alt="google plus"></a></li>
		      <li><a href="http://www.slideshare.net/gamifyforthewin" target="_blank"><img src="http://gamifyforthewin.com/images/slideshare.png" title="slideshare" alt="slideshare"></a></li>
		      </ul>
					</div>

    	    <div class="fix"></div>  
    	    	
    	</div><!-- /#header -->
    	
    </div><!-- /#header-wrap -->
    
	<?php if ($woo_options['woo_about'] == 'true' && is_home() && !is_paged()): ?>
    <div id="about" class="col-full">
    	
    	<div class="bio fl">
    	    		
    		<?php if ($woo_options['woo_header_bio'] != ''): ?>
   				<p><?php echo stripslashes($woo_options['woo_header_bio']); ?></p>
    		<?php endif; ?>
    	
    	</div><!-- /.bio -->
    	
    	<div id="icons" class="fr">
    		
    		<h3><?php echo _e('Connect','woothemes'); ?></h3>
    		
    		<?php if ($woo_options['woo_social_facebook']): ?><a href="<?php echo $woo_options['woo_social_facebook']; ?>" title="Facebook"><img src="<?php bloginfo('template_directory'); ?>/images/ico-facebook.png" alt="" /></a><?php endif; ?>
    		<?php if ($woo_options['woo_social_linkedin']): ?><a href="<?php echo $woo_options['woo_social_linkedin']; ?>" title="Linkedin"><img src="<?php bloginfo('template_directory'); ?>/images/ico-linkedin.png" alt="" /></a><?php endif; ?>
        	<?php if ($woo_options['woo_social_twitter']): ?><a href="<?php echo $woo_options['woo_social_twitter']; ?>" title="Twitter"><img src="<?php bloginfo('template_directory'); ?>/images/ico-twitter.png" alt="" /></a><?php endif; ?>
        	<a href="<?php if ( $woo_options['woo_feed_url'] ) { echo $woo_options['woo_feed_url']; } else { echo get_bloginfo_rss('rss2_url'); } ?>" title="Subscribe"><img src="<?php bloginfo('template_directory'); ?>/images/ico-rss.png" alt="" /></a>

        </div><!-- /#icons -->      
    	<div class="fix"></div>
    	
    </div><!-- /#about -->
    <?php endif; ?>    
        
	<?php if ($woo_options['woo_portfolio'] == 'true' && is_home() && !is_paged()): ?>
    <div id="portfolio" class="col-full">
    
	    <?php do_action('wp_dribbble'); ?>
    
		<?php $portfolio = get_posts('suppress_filters=0&post_type=portfolio&showposts='.$woo_options['woo_portfolio_number']); ?>  
		<?php if (!empty($portfolio)) : ?>
		<ol class="portfolio dribbbles">
		<?php foreach($portfolio as $post) : setup_postdata($post); ?>
			<li class="group">
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
		<?php if ($count == 4): ?><div class="fix"></div><?php $count = 0; endif; ?>
		<?php endforeach; endif; ?>
		</ol>
	
    </div><!-- /#portfolio -->
    <?php endif; ?>
    