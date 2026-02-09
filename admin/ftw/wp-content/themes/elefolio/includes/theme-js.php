<?php
if (!is_admin()) add_action( 'wp_print_scripts', 'woothemes_add_javascript' );
if (!function_exists('woothemes_add_javascript')) {
	function woothemes_add_javascript( ) {
		wp_enqueue_script('jquery');    
		wp_enqueue_script( 'superfish', get_bloginfo('template_directory').'/includes/js/superfish.js', array( 'jquery' ) );
		wp_enqueue_script( 'general', get_bloginfo('template_directory').'/includes/js/general.js', array( 'jquery' ) );
		wp_enqueue_script( 'mp3', get_bloginfo('template_directory').'/includes/tumblog/swfobject.js');
		if (is_page_template('template-portfolio.php')) {				
			wp_enqueue_script( 'portfolio', get_bloginfo('template_directory').'/includes/js/portfolio.js', array( 'jquery' ) );
		}		
	}
}
?>