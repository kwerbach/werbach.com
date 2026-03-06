<div class="getting-started-top-wrap clearfix">
	<div class="theme-steps-list">
		<div class="theme-steps">
			<h3><?php echo esc_html__('Step 1 - Create a new page with "Home Page" Template', 'square'); ?></h3>
			<ol>
				<li><?php echo esc_html__('Create a new page (any title like Home )', 'square'); ?></li>
				<li><?php echo esc_html__('In right column, select "Home Page" for the option Page Attributes > Template', 'square'); ?> </li>
				<li><?php echo esc_html__('Click on Publish', 'square'); ?></li>
			</ol>
			<a class="button button-primary" target="_blank" href="<?php echo esc_url(admin_url('post-new.php?post_type=page')); ?>"><?php echo esc_html__('Create New Page', 'square'); ?></a>
		</div>

		<div class="theme-steps">
			<h3><?php echo esc_html__('Step 2 - Set "Your homepage displays" to "A Static Page"', 'square'); ?></h3>
			<ol>
				<li><?php echo esc_html__('Go to Appearance > Customize > General settings > Static Front Page', 'square'); ?></li>
				<li><?php echo esc_html__('Set "Your homepage displays" to "A Static Page"', 'square'); ?></li>
				<li><?php echo esc_html__('In "Homepage", select the page that you created in the step 1', 'square'); ?></li>
				<li><?php echo esc_html__('Save changes', 'square'); ?></li>
			</ol>
			<a class="button button-primary" target="_blank" href="<?php echo esc_url(admin_url('options-reading.php')); ?>"><?php echo esc_html__('Assign Static Page', 'square'); ?></a>
		</div>

		<div class="theme-steps">
			<h3><?php echo esc_html__('Step 3 - Customizer Options Panel', 'square'); ?></h3>
			<p><?php echo esc_html__('Now go to Customizer Page. Using the WordPress Customizer you can easily set up the home page and customize the theme.', 'square'); ?></p>
			<a class="button button-primary" href="<?php echo esc_url(admin_url('customize.php')); ?>"><?php echo esc_html__('Go to Customizer Panels', 'square'); ?></a>
		</div>

	</div>

	<div class="theme-image">
		<h3><?php echo esc_html__('Demo Import', 'square'); ?></h3>
		<img src="<?php echo esc_url(get_template_directory_uri(). '/screenshot.png'); ?>" alt="<?php echo esc_html__('Square Plus Demo', 'square'); ?>">

		<div class="theme-import-demo">
			<?php 
			$square_demo_importer_slug = 'one-click-demo-import';
			$square_demo_importer_filename ='one-click-demo-import';
			$square_import_url = '#';

			if ( $this->square_check_installed_plugin( $square_demo_importer_slug, $square_demo_importer_filename ) && !$this->square_check_plugin_active_state( $square_demo_importer_slug, $square_demo_importer_filename ) ) :
				$square_import_class = 'button button-primary square-activate-plugin';
				$square_import_button_text = esc_html__('Activate Importer Plugin', 'square');
			elseif( $this->square_check_installed_plugin( $square_demo_importer_slug, $square_demo_importer_filename ) ) :
				$square_import_class = '';
				$square_import_button_text = esc_html__('Go to Importer Page >>', 'square');
				$square_import_url = admin_url('themes.php?page=pt-one-click-demo-import');
			else :
				$square_import_class = 'button button-primary square-install-plugin';
				$square_import_button_text = esc_html__('Install Importer Plugin', 'square');
			endif;
			?>
			<p><?php echo sprintf(esc_html__('Or you can import the demo with just one click. It is recommended to import the demo on a fresh WordPress install. Or you can reset the website using %s plugin.', 'square'), '<a target="_blank" href="https://wordpress.org/plugins/wordpress-reset/">WordPress Reset</a>'); ?></p>
			<p><?php echo esc_html__('Click on the button below to install and activate demo importer plugin.', 'square'); ?></p>
			<a data-slug="<?php echo esc_attr($square_demo_importer_slug); ?>" data-filename="<?php echo esc_attr($square_demo_importer_filename); ?>" class="<?php echo esc_attr($square_import_class); ?>" href="<?php echo $square_import_url; ?>"><?php echo esc_html($square_import_button_text); ?></a>
		</div>
	</div>
</div>

<div class="getting-started-bottom-wrap">
	<h3><?php echo esc_html__('Square Plus Demos - Check the premium demos. You might be interested in purchasing premium version.', 'square'); ?></h3>
	<p><?php echo esc_html__('Check out the websites that you can create with the premium version of the Square Theme. These demos can be imported with just one click in the premium version.', 'square'); ?></p>

	<div class="recomended-plugin-wrap clearfix">
		<div class="recom-plugin-wrap">
			<div class="plugin-img-wrap">
				<img src="<?php echo esc_url(get_template_directory_uri() .'/welcome/css/main-demo.jpg'); ?>" alt="<?php echo esc_html__('Square Plus Demo', 'square'); ?>">
			</div>

			<div class="plugin-title-install clearfix">
				<span class="title">Main Demo</span>
				<span class="plugin-btn-wrapper">
					<a target="_blank" href="https://demo.hashthemes.com/square-plus/main-demo/" class="button button-primary"><?php echo esc_html__('Preview', 'square'); ?></a>
				</span>
			</div>
		</div>

		<div class="recom-plugin-wrap">
			<div class="plugin-img-wrap">
				<img src="<?php echo esc_url(get_template_directory_uri() .'/welcome/css/original.jpg'); ?>" alt="<?php echo esc_html__('Square Plus Demo', 'square'); ?>">
			</div>

			<div class="plugin-title-install clearfix">
				<span class="title">Original</span>
				<span class="plugin-btn-wrapper">
					<a target="_blank" href="https://demo.hashthemes.com/square-plus/original/" class="button button-primary"><?php echo esc_html__('Preview', 'square'); ?></a>
				</span>
			</div>
		</div>

	</div>
</div>

<div class="upgrade-box">
	<div class="upgrade-box-text">
		<h3><?php echo esc_html__('Upgrade To Premium Version (7 Day Money Back Guarantee)', 'square'); ?></h3>
		<p><?php echo esc_html__('With Square Theme you can create a beautiful website. But if you want to unlock more possibilites then upgrade to premium version.', 'square'); ?></p>
		<p><?php echo esc_html__('Try the Premium version and check if it fits to your need or not. If not, we have 7 day money back guarantee.', 'square'); ?></p>
	</div>

	<a class="upgrade-button" href="https://hashthemes.com/wordpress-theme/square-plus/" target="_blank"><?php esc_html_e('Upgrade Now', 'square'); ?></a>
</div>