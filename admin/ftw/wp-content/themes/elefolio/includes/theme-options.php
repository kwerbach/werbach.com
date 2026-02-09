<?php

//Enable WooSEO on these custom Post types
$seo_post_types = array('post','page');
define("SEOPOSTTYPES", serialize($seo_post_types));

//Global options setup
add_action('init','woo_global_options');
function woo_global_options(){
	// Populate WooThemes option in array for use in theme
	global $woo_options;
	$woo_options = get_option('woo_options');
}

add_action( 'admin_head','woo_options' );  
if (!function_exists('woo_options')) {
function woo_options() {
	
// VARIABLES
$themename = "Elefolio";
$manualurl = 'http://www.woothemes.com/support/theme-documentation/elefolio/';
$shortname = "woo";

$GLOBALS['template_path'] = get_bloginfo('template_directory');

//Access the WordPress Categories via an Array
$woo_categories = array();  
$woo_categories_obj = get_categories('hide_empty=0');
foreach ($woo_categories_obj as $woo_cat) {
    $woo_categories[$woo_cat->cat_ID] = $woo_cat->cat_name;}
$categories_tmp = array_unshift($woo_categories, "Select a category:");    
       
//Access the WordPress Pages via an Array
$woo_pages = array();
$woo_pages_obj = get_pages('sort_column=post_parent,menu_order');    
foreach ($woo_pages_obj as $woo_page) {
    $woo_pages[$woo_page->ID] = $woo_page->post_name; }
$woo_pages_tmp = array_unshift($woo_pages, "Select a page:");       

// Image Alignment radio box
$options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 

// Image Links to Options
$options_image_link_to = array("image" => "The Image","post" => "The Post"); 

//Testing 
$options_select = array("one","two","three","four","five"); 
$options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five"); 

//URL Shorteners
if (_iscurlinstalled()) {
	$options_select = array("Off","TinyURL","Bit.ly");
	$short_url_msg = 'Select the URL shortening service you would like to use.'; 
} else {
	$options_select = array("Off");
	$short_url_msg = '<strong>cURL was not detected on your server, and is required in order to use the URL shortening services.</strong>'; 
}

//Stylesheets Reader
$alt_stylesheet_path = TEMPLATEPATH . '/styles/';
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

//More Options


$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");

// THIS IS THE DIFFERENT FIELDS
$options = array();   


$options[] = array( "name" => "General Settings",
					"type" => "heading",
					"icon" => "general");
                        
$options[] = array( "name" => "Theme Stylesheet",
					"desc" => "Select your themes alternative color scheme.",
					"id" => $shortname."_alt_stylesheet",
					"std" => "default.css",
					"type" => "select",
					"options" => $alt_stylesheets);

$options[] = array( "name" => "Custom Logo",
					"desc" => "Upload a logo for your theme, or specify an image URL directly.",
					"id" => $shortname."_logo",
					"std" => "",
					"type" => "upload");    
                                                                                     
$options[] = array( "name" => "Text Title",
					"desc" => "Enable text-based Site Title and Tagline. Setup title & tagline in Settings->General.",
					"id" => $shortname."_texttitle",
					"std" => "false",
					"class" => "collapsed",
					"type" => "checkbox");

$options[] = array( "name" => "Site Title",
					"desc" => "Change the site title (must have 'Text Title' option enabled).",
					"id" => $shortname."_font_site_title",
					"std" => array('size' => '40','unit' => 'px','face' => 'Impact','style' => '','color' => '#222222'),
					"class" => "hidden",
					"type" => "typography");  

$options[] = array( "name" => "Site Description",
					"desc" => "Change the site description (must have 'Text Title' option enabled).",
					"id" => $shortname."_font_tagline",
					"std" => array('size' => '14','unit' => 'px','face' => 'Georgia','style' => 'italic','color' => '#999999'),
					"class" => "hidden last",
					"type" => "typography");  
					          
$options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload a 16px x 16px <a href='http://www.faviconr.com/'>ico image</a> that will represent your website's favicon.",
					"id" => $shortname."_custom_favicon",
					"std" => "",
					"type" => "upload"); 
                                               
$options[] = array( "name" => "Tracking Code",
					"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
					"id" => $shortname."_google_analytics",
					"std" => "",
					"type" => "textarea");        

$options[] = array( "name" => "RSS URL",
					"desc" => "Enter your preferred RSS URL. (Feedburner or other)",
					"id" => $shortname."_feed_url",
					"std" => "",
					"type" => "text");
                    
$options[] = array( "name" => "E-Mail URL",
					"desc" => "Enter your preferred E-mail subscription URL. (Feedburner or other)",
					"id" => $shortname."_subscribe_email",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Contact Form E-Mail",
					"desc" => "Enter your E-mail address to use on the Contact Form Page Template. Add the contact form by adding a new page and selecting 'Contact Form' as page template.",
					"id" => $shortname."_contactform_email",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Custom CSS",
                    "desc" => "Quickly add some CSS to your theme by adding it to this block.",
                    "id" => $shortname."_custom_css",
                    "std" => "",
                    "type" => "textarea");

$options[] = array( "name" => "Post/Page Comments",
					"desc" => "Select if you want to enable/disable comments on posts and/or pages. ",
					"id" => $shortname."_comments",
					"type" => "select2",
					"options" => array("post" => "Posts Only", "page" => "Pages Only", "both" => "Pages / Posts", "none" => "None") );                                                          
    
$options[] = array( "name" => "Post Content",
					"desc" => "Select if you want to show the full content or the excerpt on posts. ",
					"id" => $shortname."_post_content",
					"type" => "select2",
					"options" => array("excerpt" => "The Excerpt", "content" => "Full Content" ) );                                                          

$options[] = array( "name" => "Styling Options",
					"type" => "heading",
					"icon" => "styling");   
					
$options[] = array( "name" =>  "Body Background Color",
					"desc" => "Pick a custom color for background color of the theme e.g. #697e09",
					"id" => "woo_body_color",
					"std" => "",
					"type" => "color");
					
$options[] = array( "name" => "Body background image",
					"desc" => "Upload an image for the theme's background",
					"id" => $shortname."_body_img",
					"std" => "",
					"type" => "upload");
					
$options[] = array( "name" => "Background image repeat",
                    "desc" => "Select how you would like to repeat the background-image",
                    "id" => $shortname."_body_repeat",
                    "std" => "no-repeat",
                    "type" => "select",
                    "options" => $body_repeat);

$options[] = array( "name" => "Background image position",
                    "desc" => "Select how you would like to position the background",
                    "id" => $shortname."_body_pos",
                    "std" => "top",
                    "type" => "select",
                    "options" => $body_pos);

$options[] = array( "name" =>  "Link Color",
					"desc" => "Pick a custom color for links or add a hex color code e.g. #697e09",
					"id" => "woo_link_color",
					"std" => "",
					"type" => "color");   

$options[] = array( "name" =>  "Link Hover Color",
					"desc" => "Pick a custom color for links hover or add a hex color code e.g. #697e09",
					"id" => "woo_link_hover_color",
					"std" => "",
					"type" => "color");                    

$options[] = array( "name" =>  "Button Color",
					"desc" => "Pick a custom color for buttons or add a hex color code e.g. #697e09",
					"id" => "woo_button_color",
					"std" => "",
					"type" => "color");          
					
$options[] = array( "name" => "Typography",
					"type" => "heading",
					"icon" => "typography");   

$options[] = array( "name" => "Enable Custom Typography",
					"desc" => "Enable the use of custom typography for your site. Custom styling will be output in your sites HEAD.",
					"id" => $shortname."_typography",
					"std" => "false",
					"type" => "checkbox"); 									   

$options[] = array( "name" => "General Typography",
					"desc" => "Change the general font.",
					"id" => $shortname."_font_body",
					"std" => array('size' => '12','unit' => 'px','face' => 'Arial','style' => '','color' => '#555555'),
					"type" => "typography");  

$options[] = array( "name" => "About (Homepage)",
					"desc" => "Change the about text font.",
					"id" => $shortname."_font_about",
					"std" => array('size' => '32','unit' => 'px','face' => 'Georgia','style' => '','color' => '#126661'),
					"type" => "typography");  

$options[] = array( "name" => "Navigation",
					"desc" => "Change the navigation font.",
					"id" => $shortname."_font_nav",
					"std" => array('size' => '15','unit' => 'px','face' => 'Georgia','style' => '','color' => '#151515'),
					"type" => "typography");  

$options[] = array( "name" => "Post Title",
					"desc" => "Change the post title.",
					"id" => $shortname."_font_post_title",
					"std" => array('size' => '24','unit' => 'px','face' => 'Georgia','style' => 'bold','color' => '#222222'),
					"type" => "typography");  

$options[] = array( "name" => "Post Meta",
					"desc" => "Change the post meta.",
					"id" => $shortname."_font_post_meta",
					"std" => array('size' => '14','unit' => 'px','face' => 'Georgia','style' => '','color' => '#999999'),
					"type" => "typography");  
					          
$options[] = array( "name" => "Post Entry",
					"desc" => "Change the post entry.",
					"id" => $shortname."_font_post_entry",
					"std" => array('size' => '13','unit' => 'px','face' => 'Arial','style' => '','color' => '#555555'),
					"type" => "typography");  

$options[] = array( "name" => "Widget Titles",
					"desc" => "Change the widget titles.",
					"id" => $shortname."_font_widget_titles",
					"std" => array('size' => '16','unit' => 'px','face' => 'Georgia','style' => 'bold','color' => '#555555'),
					"type" => "typography");   

//Header
$options[] = array( "name" => "Homepage",
					"type" => "heading",
					"icon" => "homepage");

$options[] = array( "name" => "Enable About Section",
					"desc" => "Show a welcome message in your header and add social media icons.",
					"id" => $shortname."_about",
					"std" => "true",
					"type" => "checkbox");
					    
$options[] = array( "name" => "About Message",
					"desc" => "Enter an about message that will show just below the logo",
					"id" => $shortname."_header_bio",
					"std" => "Edit this welcome message in your options panel",
					"type" => "textarea");
					
$options[] = array( "name" => "Facebook",
					"desc" => "Enter your profile url",
					"id" => $shortname."_social_facebook",
					"std" => "",
					"type" => "text");
										 					
$options[] = array( "name" => "Linkedin",
					"desc" => "Enter your profile url",
					"id" => $shortname."_social_linkedin",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Twitter",
					"desc" => "Enter your profile url",
					"id" => $shortname."_social_twitter",
					"std" => "",
					"type" => "text");														

$options[] = array( "name" => "Portfolio",
                    "icon" => "portfolio",
					"type" => "heading");    
					
$options[] = array( "name" => "Enable Portfolio",
					"desc" => "Enable the portfolio section below the about section. Add portfolio posts using the 'Portfolio' custom post type.",
					"id" => $shortname."_portfolio",
					"std" => "true",
					"type" => "checkbox");
					
$options[] = array( "name" => "Number of portfolio items",
					"id" => $shortname."_portfolio_number",
					"std" => "4",
					"type" => "select",
					"options" => $other_entries);
					
$options[] = array( "name" => "Portfolio Tags",
					"desc" => "Enter comma seperated tags for portfolio sorting (e.g. web, print, icons). You must add these tags to the portfolio items you want to sort.",
					"id" => $shortname."_portfolio_tags",
					"std" => "",
					"type" => "text");										

$options[] = array( "name" => "Tumblog Setup",
                    "icon" => "tumblog",
				    "type" => "heading");  

$content_option_array = array( 	'taxonomy' 	=> 'Taxonomy',
								'post_format' => 'Post Formats'			
									);

$options[] = array( "name" => "Tumblog Content Method",
					"desc" => "Select if you would like to use a Taxonomy of Post Formats to categorize your Tumblog content.",
					"id" => $shortname."_tumblog_content_method",
					"std" => "post_format",
					"type" => "select2",
					"options" => $content_option_array); 
					
$options[] = array( "name" => "Use Custom Tumblog RSS Feed",
					"desc" => "Replaces the default WordPress RSS feed output with Tumblog RSS output.",
					"id" => $shortname."_custom_rss",
					"std" => "true",
					"type" => "checkbox"); 
					
$options[] = array( "name" => "Full Content Home",
					"desc" => "Show the full content in posts on homepage instead of the excerpt.",
					"id" => $shortname."_home_content",
					"std" => "false",
					"type" => "checkbox");    

$options[] = array( "name" => "Full Content Archive",
					"desc" => "Show the full content in posts on archive pages instead of the excerpt.",
					"id" => $shortname."_archive_content",
					"std" => "false",
					"type" => "checkbox");
 				     					

$options[] = array( "name" => "Images Link to",
					"desc" => "Select where your Tumblog Images will link to when clicked.",
					"id" => $shortname."_image_link_to",
					"std" => "post",
					"type" => "radio",
					"options" => $options_image_link_to); 	
				

$options[] = array( "name" => "URL Shortening Service",
					"desc" => $short_url_msg,
					"id" => $shortname."_url_shorten",
					"std" => "Select a Service:",
					"type" => "select",
					"options" => $options_select);

$options[] = array( "name" => "Bit.ly Login Name",
					"desc" => "Your Bit.ly login name - get this here <a href='http://bit.ly/account/' target='_blank'>http://bit.ly/account/</a>",
					"id" => $shortname."_bitly_api_login",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Bit.ly API Key",
					"desc" => "Your Bit.ly API Key - get this here <a href='http://bit.ly/account/' target='_blank'>http://bit.ly/account/</a>",
					"id" => $shortname."_bitly_api_key",
					"std" => "",
					"type" => "text");
 					                   
$options[] = array( "name" => "Dynamic Images",
					"type" => "heading",
					"icon" => "image");    
				    				   
$options[] = array( "name" => 'Dynamic Image Resizing',
					"desc" => "",
					"id" => $shortname."_wpthumb_notice",
					"std" => 'There are two alternative methods of dynamically resizing the thumbnails in the theme, <strong>WP Post Thumbnail</strong> or <strong>TimThumb - Custom Settings panel</strong>. We recommend using WP Post Thumbnail option.',
					"type" => "info");					

$options[] = array( "name" => "WP Post Thumbnail",
					"desc" => "Use WordPress post thumbnail to assign a post thumbnail. Will enable the <strong>Featured Image panel</strong> in your post sidebar where you can assign a post thumbnail.",
					"id" => $shortname."_post_image_support",
					"std" => "true",
					"class" => "collapsed",
					"type" => "checkbox" );

$options[] = array( "name" => "WP Post Thumbnail - Dynamic Image Resizing",
					"desc" => "The post thumbnail will be dynamically resized using native WP resize functionality. <em>(Requires PHP 5.2+)</em>",
					"id" => $shortname."_pis_resize",
					"std" => "true",
					"class" => "hidden",
					"type" => "checkbox" );

$options[] = array( "name" => "WP Post Thumbnail - Hard Crop",
					"desc" => "The post thumbnail will be cropped to match the target aspect ratio (only used if 'Dynamic Image Resizing' is enabled).",
					"id" => $shortname."_pis_hard_crop",
					"std" => "true",
					"class" => "hidden last",
					"type" => "checkbox" );

$options[] = array( "name" => "TimThumb - Custom Settings Panel",
					"desc" => "This will enable the <a href='http://code.google.com/p/timthumb/'>TimThumb</a> (thumb.php) script which dynamically resizes images added through the <strong>custom settings panel below the post</strong>. Make sure your themes <em>cache</em> folder is writeable. <a href='http://www.woothemes.com/2008/10/troubleshooting-image-resizer-thumbphp/'>Need help?</a>",
					"id" => $shortname."_resize",
					"std" => "true",
					"type" => "checkbox" );

$options[] = array( "name" => "TimThumb - Automatic Image Thumbnail",
					"desc" => "If no thumbnail is specifified then the first uploaded image in the post is used (TimThumb must be enabled).",
					"id" => $shortname."_auto_img",
					"std" => "false",
					"type" => "checkbox" );
					                    
$options[] = array( "name" => "Dynamic Image Height",
					"desc" => "If this is enabled, the height of your images will be dynamically calculated based on the width's as set below.",
					"id" => $shortname."_dynamic_img_height",
					"std" => "true",
					"type" => "checkbox");  

$options[] = array( "name" => "Thumbnail Image Dimensions",
					"desc" => "Enter an integer value i.e. 250 for the desired size which will be used when dynamically creating the images.",
					"id" => $shortname."_image_dimensions",
					"std" => "",
					"type" => array( 
									array(  'id' => $shortname. '_thumb_w',
											'type' => 'text',
											'std' => 550,
											'meta' => 'Width'),
									array(  'id' => $shortname. '_thumb_h',
											'type' => 'text',
											'std' => 412,
											'meta' => 'Height')
								  ));
                                                                                                
$options[] = array( "name" => "Thumbnail Image alignment",
					"desc" => "Select how to align your thumbnails with posts.",
					"id" => $shortname."_thumb_align",
					"std" => "aligncenter",
					"type" => "radio",
					"options" => $options_thumb_align); 

$options[] = array( "name" => "Show thumbnail in Single Posts",
					"desc" => "Show the attached image in the single post page.",
					"id" => $shortname."_thumb_single",
					"class" => "collapsed",
					"std" => "true",
					"type" => "checkbox");    

$options[] = array( "name" => "Single Image Dimensions",
					"desc" => "Enter an integer value i.e. 250 for the image size. Max width is 576.",
					"id" => $shortname."_image_dimensions",
					"std" => "",
					"class" => "hidden last",
					"type" => array( 
									array(  'id' => $shortname. '_single_w',
											'type' => 'text',
											'std' => 550,
											'meta' => 'Width'),
									array(  'id' => $shortname. '_single_h',
											'type' => 'text',
											'std' => 412,
											'meta' => 'Height')
								  ));

$options[] = array( "name" => "Single Post Image alignment",
					"desc" => "Select how to align your thumbnail with single posts.",
					"id" => $shortname."_thumb_single_align",
					"std" => "aligncenter",
					"type" => "radio",
					"class" => "hidden",
					"options" => $options_thumb_align); 

//Footer
$options[] = array( "name" => "Footer Customization",
					"type" => "heading",
					"icon" => "footer");    
					
					
$options[] = array( "name" => "Custom Affiliate Link",
					"desc" => "Add an affiliate link to the WooThemes logo in the footer of the theme.",
					"id" => $shortname."_footer_aff_link",
					"std" => "",
					"type" => "text");	
									
$options[] = array( "name" => "Enable Custom Footer (Left)",
					"desc" => "Activate to add the custom text below to the theme footer.",
					"id" => $shortname."_footer_left",
					"class" => "collapsed",
					"std" => "false",
					"type" => "checkbox");    

$options[] = array( "name" => "Custom Text (Left)",
					"desc" => "Custom HTML and Text that will appear in the footer of your theme.",
					"id" => $shortname."_footer_left_text",
					"class" => "hidden last",
					"std" => "<p></p>",
					"type" => "textarea");
						
$options[] = array( "name" => "Enable Custom Footer (Right)",
					"desc" => "Activate to add the custom text below to the theme footer.",
					"id" => $shortname."_footer_right",
					"class" => "collapsed",
					"std" => "false",
					"type" => "checkbox");    

$options[] = array( "name" => "Custom Text (Right)",
					"desc" => "Custom HTML and Text that will appear in the footer of your theme.",
					"id" => $shortname."_footer_right_text",
					"class" => "hidden last",
					"std" => "<p></p>",
					"type" => "textarea");

                                              
// Add extra options through function
if ( function_exists("woo_options_add") )
	$options = woo_options_add($options);

if ( get_option('woo_template') != $options) update_option('woo_template',$options);      
if ( get_option('woo_themename') != $themename) update_option('woo_themename',$themename);   
if ( get_option('woo_shortname') != $shortname) update_option('woo_shortname',$shortname);
if ( get_option('woo_manual') != $manualurl) update_option('woo_manual',$manualurl);


// Woo Metabox Options
// Start name with underscore to hide custom key from the user
$woo_metaboxes = array();

global $post;

if ( get_post_type() == 'post' || !get_post_type() ) {

$woo_metaboxes[] = array (	
            "name" => "image",
            "label" => "Image",
            "type" => "upload",
            "desc" => "Upload file here..."
        );
$woo_metaboxes[] = array (	
            "name" => "video-embed",
            "label" => "Embed Code (Videos)",
            "type" => "textarea",
            "desc" => "Add embed code for video services like Youtube or Vimeo"
        );
$woo_metaboxes[] = array (	
            "name"  => "quote-author",
            "std"  => "Unknown",
            "label" => "Quote Author",
            "type" => "text",
            "desc" => "Enter the name of the Quote Author."
        );
$woo_metaboxes[] = array (	
            "name"  => "quote-url",
            "std"  => "http://",
            "label" => "Link to Quote",
            "type" => "text",
            "desc" => "Enter the url/web address of the Quote if available."
        );
$woo_metaboxes[] = array (	
            "name"  => "quote-copy",
            "std"  => "Unknown",
            "label" => "Quote",
            "type" => "textarea",
            "desc" => "Enter the Quote."
        );
$woo_metaboxes[] = array (	
            "name"  => "audio",
            "std"  => "http://",
            "label" => "Audio URL",
            "type" => "text",
            "desc" => "Enter the url/web address of the Audio file."
        );
$woo_metaboxes[] = array (	
            "name"  => "link-url",
            "std"  => "http://",
            "label" => "Link URL",
            "type" => "text",
            "desc" => "Enter the url/web address of the Link."
        );
					            
} // End post

if ( get_post_type() == 'portfolio' || !get_post_type() ) {

	$woo_metaboxes[] = array (	"name" => "portfolio-image",
								"label" => "Portfolio Image",
								"type" => "upload",
								"desc" => "Upload an image or enter an URL to your portfolio image");
								
	if ( get_option('woo_resize') == "true" ) {						
		$woo_metaboxes[] = array (	"name" => "_image_alignment",
									"std" => "Center",
									"label" => "Image Crop Alignment",
									"type" => "select2",
									"desc" => "Select crop alignment for resized image",
									"options" => array(	"c" => "Center",
														"t" => "Top",
														"b" => "Bottom",
														"l" => "Left",
														"r" => "Right"));
}

	$woo_metaboxes[] = array (  "name"  => "embed",
					            "std"  => "",
					            "label" => "Video Embed Code",
					            "type" => "textarea",
					            "desc" => "Enter the video embed code for your video (YouTube, Vimeo or similar). Will show instead of your image.");
}

// Add extra metaboxes through function
if ( function_exists("woo_metaboxes_add") )
	$woo_metaboxes = woo_metaboxes_add($woo_metaboxes);
    
if ( get_option('woo_custom_template') != $woo_metaboxes) update_option('woo_custom_template',$woo_metaboxes);      

}
}



?>