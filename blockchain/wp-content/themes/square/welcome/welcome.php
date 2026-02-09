<?php
	if(!class_exists('Square_Welcome')) :

		class Square_Welcome {

			public $tab_sections = array();

			public $theme_name = ''; // For storing Theme Name
			public $theme_version = ''; // For Storing Theme Current Version Information
			public $free_plugins = array(); // For Storing the list of the Recommended Free Plugins
			public $pro_plugins = array(); // For Storing the list of the Recommended Pro Plugins

			/**
			 * Constructor for the Welcome Screen
			 */
			public function __construct() {
				
				/** Useful Variables **/
				$theme = wp_get_theme();
				$this->theme_name = $theme->Name;
				$this->theme_version = $theme->Version;

				/** Define Tabs Sections **/
				$this->tab_sections = array(
					'getting_started' => __('Getting Started', 'square'),
					'recommended_plugins' => __('Recommended Plugins', 'square'),
					'support' => __('Support', 'square'),
					'free_vs_pro' => __('Free Vs Pro', 'square'),
				);

				/** List of Recommended Free Plugins **/
				$this->free_plugins = array(
					'wpforms-lite' => array(
						'name' => 'Contact Form by WPForms',
						'slug' => 'wpforms-lite',
						'filename' => 'wpforms'
					),
					'elementor' => array(
						'name' => 'Elementor Page Builder',
						'slug' => 'elementor',
						'filename' => 'elementor'
					)
				);

				/** List of Recommended Pro Plugins **/
				$this->pro_plugins = array();

				/* Theme Activation Notice */
				add_action( 'admin_notices', array( $this, 'square_activation_admin_notice' ) );

				/* Create a Welcome Page */
				add_action( 'admin_menu', array( $this, 'square_welcome_register_menu' ) );

				/* Enqueue Styles & Scripts for Welcome Page */
				add_action( 'admin_enqueue_scripts', array( $this, 'square_welcome_styles_and_scripts' ) );

				add_action( 'wp_ajax_square_activate_plugin', array( $this, 'square_activate_plugin') );
			}

			/** Welcome Message Notification on Theme Activation **/
			public function square_activation_admin_notice() {
				global $pagenow;

				if( is_admin() && ('themes.php' == $pagenow) && (isset($_GET['activated'])) ) {
					?>
					<div class="notice notice-success is-dismissible"> 
						<p><?php echo esc_html__( 'Welcome! Thank you for choosing Square. Please make sure you visit Settings Page to get started with Square theme.', 'square' ); ?></p>
						<p><a class="button button-primary" href="<?php echo admin_url('/themes.php?page=square-welcome') ?>"><?php echo esc_html__( 'Let\'s Get Started', 'square' ); ?></a></p>
					</div>
					<?php
				}
			}

			/** Register Menu for Welcome Page **/
			public function square_welcome_register_menu() {
				add_theme_page( esc_html__( 'Welcome', 'square' ), esc_html__( 'Square Settings', 'square' ) , 'edit_theme_options', 'square-welcome', array( $this, 'square_welcome_screen' ));
			}

			/** Welcome Page **/
			public function square_welcome_screen() {
				$tabs = $this->tab_sections;
				?>
				<div class="wrap about-wrap access-wrap">
					<div class="abt-promo-wrap clearfix">
						<div class="abt-theme-wrap">
							<h1><?php printf( // WPCS: XSS OK.
								/* translators: 1-theme name, 2-theme version*/
								esc_html__( 'Welcome to %1$s - Version %2$s', 'square' ), $this->theme_name, $this->theme_version ); ?></h1>
							<div class="about-text"><?php echo esc_html__( 'Square is a flexible responsive multipurpose theme compatible with all browsers and devices, fully mobile friendly, loaded with lots of features. It is a minimal theme based on WordPress Customizer that allows you to customize with live preview. The theme can be used for business, corporate, digital agency, personal, portfolio, photography, parallax, blogs and magazines. Square is eCommerce (WooCommerce) Compatible, Polylang Compatible, WPML, RTL, Retina Ready, SEO Friendly and Support bbPress and BuddyPress. More over it is a complete theme.', 'square' ); ?></div>
						</div>

						<div class="promo-banner-wrap">
							<p><?php esc_html_e('Upgrade for $60', 'square'); ?></p>
							<a href="<?php echo esc_url('https://hashthemes.com/wordpress-theme/square-plus/'); ?>" target="_blank" class="button button-primary upgrade-btn"><?php echo esc_html__('Upgrade Now', 'square'); ?></a>
							<a class="promo-offer-text" href="<?php echo esc_url('https://hashthemes.com/wordpress-theme/square-plus/'); ?>" target="_blank"><?php echo esc_html__('Unlock all the possibitlies with Square Plus.', 'square'); ?></a>
						</div>
					</div>

					<div class="nav-tab-wrapper clearfix">
						<?php foreach($tabs as $id => $label) : ?>
							<?php
								$section = isset($_GET['section']) ? $_GET['section'] : 'getting_started'; // Input var okay.
								$nav_class = 'nav-tab';
								if($id == $section) {
									$nav_class .= ' nav-tab-active';
								}
							?>
							<a href="<?php echo esc_url(admin_url('themes.php?page=square-welcome&section='.$id)); ?>" class="<?php echo esc_attr($nav_class); ?>" >
								<?php echo esc_html( $label ); ?>
						   	</a>
						<?php endforeach; ?>
				   	</div>

			   		<div class="welcome-section-wrapper">
		   				<?php $section = isset($_GET['section']) ? $_GET['section'] : 'getting_started'; // Input var okay. ?>
	   					
	   					<div class="welcome-section <?php echo esc_attr($section); ?> clearfix">
	   						<?php require_once get_template_directory() . '/welcome/sections/'.$section.'.php'; ?>
						</div>
				   	</div>
			   	</div>
				<?php
			}

			/** Enqueue Necessary Styles and Scripts for the Welcome Page **/
			public function square_welcome_styles_and_scripts($hook) {
				if( 'appearance_page_square-welcome' == $hook ){
					$importer_params = array(
						'installing_text' => esc_html__('Installing Importer Plugin', 'square'),
						'activating_text' => esc_html__('Activating Importer Plugin', 'square'),
						'importer_page' => esc_html__('Go to Importer Page >>', 'square'),
						'importer_url' => admin_url('themes.php?page=pt-one-click-demo-import'),
						'error' => esc_html__('Error! Reload the page and try again.', 'square'),
					);
					wp_enqueue_style( 'square-welcome', get_template_directory_uri() . '/welcome/css/welcome.css' );
					wp_enqueue_style( 'plugin-install' );
					wp_enqueue_script( 'plugin-install' );
					wp_enqueue_script( 'updates' );
					wp_enqueue_script( 'square-welcome', get_template_directory_uri() . '/welcome/js/welcome.js', array(), '1.0' );
					wp_localize_script( 'square-welcome', 'importer_params', $importer_params);
				}
			}

			// Check if plugin is installed
			public function square_check_installed_plugin( $slug, $filename ) {
				return file_exists( ABSPATH . 'wp-content/plugins/' . $slug . '/' . $filename . '.php' ) ? true : false;
			}

			// Check if plugin is activated
			public function square_check_plugin_active_state( $slug, $filename ) {
				return is_plugin_active( $slug . '/' . $filename . '.php' ) ? true : false;
			}

			/** Generate Url for the Plugin Button **/
			public function square_plugin_generate_url($status, $slug, $file_name) {
				switch ( $status ) {
					case 'install':
						return wp_nonce_url(
							add_query_arg(
								array(
									'action' => 'install-plugin',
									'plugin' => esc_attr($slug)
								),
								network_admin_url( 'update.php' )
							),
							'install-plugin_' . esc_attr($slug)
						);
						break;

					case 'inactive':
						return add_query_arg( array(
		                      'action'        => 'deactivate',
		                      'plugin'        => rawurlencode( esc_attr($slug) . '/' . esc_attr($file_name) . '.php' ),
		                      'plugin_status' => 'all',
		                      'paged'         => '1',
		                      '_wpnonce'      => wp_create_nonce( 'deactivate-plugin_' . esc_attr($slug) . '/' . esc_attr($file_name) . '.php' ),
	                      ), network_admin_url( 'plugins.php' ) );
						break;

					case 'active':
						return add_query_arg( array(
		                      'action'        => 'activate',
		                      'plugin'        => rawurlencode( esc_attr($slug) . '/' . esc_attr($file_name) . '.php' ),
		                      'plugin_status' => 'all',
		                      'paged'         => '1',
		                      '_wpnonce'      => wp_create_nonce( 'activate-plugin_' . esc_attr($slug) . '/' . esc_attr($file_name) . '.php' ),
	                      ), network_admin_url( 'plugins.php' ) );
						break;
				}
			}

			public function square_activate_plugin(){
				$slug = isset($_POST['slug']) ? $_POST['slug'] : '';
				$file = isset($_POST['file']) ? $_POST['file'] : '';
				$success = false;

				if( !empty($slug) && !empty($file)){
					$result = activate_plugin( $slug.'/'.$file.'.php' );

					if ( !is_wp_error( $result ) ) {
						$success = true;
					}
				}
				echo wp_json_encode(array('success'=>$success));
				die();
			}

		}

		new Square_Welcome();

	endif;
