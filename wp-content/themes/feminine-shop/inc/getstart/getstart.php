<?php
//about theme info
add_action( 'admin_menu', 'feminine_shop_gettingstarted' );
function feminine_shop_gettingstarted() {
	add_theme_page( esc_html__('About Feminine Shop', 'feminine-shop'), esc_html__('About Feminine Shop', 'feminine-shop'), 'edit_theme_options', 'feminine_shop_guide', 'feminine_shop_mostrar_guide');
}

// Add a Custom CSS file to WP Admin Area
function feminine_shop_admin_theme_style() {
	wp_enqueue_style('feminine-shop-custom-admin-style', get_template_directory_uri() . '/inc/getstart/getstart.css');
	wp_enqueue_script('feminine-shop-tabs', get_template_directory_uri() . '/inc/getstart/js/tab.js');
}
add_action('admin_enqueue_scripts', 'feminine_shop_admin_theme_style');

//guidline for about theme
function feminine_shop_mostrar_guide() { 
	//custom function about theme customizer
	$feminine_shop_return = add_query_arg( array()) ;
	$feminine_shop_theme = wp_get_theme( 'feminine-shop' );
?>

<div class="wrapper-info">
    <div class="col-left">
    	<h2><?php esc_html_e( 'Welcome to Feminine Shop', 'feminine-shop' ); ?> <span class="version"><?php esc_html_e( 'Version', 'feminine-shop' ); ?>: <?php echo esc_html($feminine_shop_theme['Version']);?></span></h2>
    	<p><?php esc_html_e('All our WordPress themes are modern, minimalist, 100% responsive, seo-friendly,feature-rich, and multipurpose that best suit designers, bloggers and other professionals who are working in the creative fields.','feminine-shop'); ?></p>
    </div>
    <div class="tab-sec">
    	<div class="tab">
			<button class="tablinks" onclick="feminine_shop_open_tab(event, 'lite_theme')"><?php esc_html_e( 'Setup With Customizer', 'feminine-shop' ); ?></button>
			<button class="tablinks" onclick="feminine_shop_open_tab(event, 'block_pattern')"><?php esc_html_e( 'Setup With Block Pattern', 'feminine-shop' ); ?></button>
			<button class="tablinks" onclick="feminine_shop_open_tab(event, 'gutenberg_editor')"><?php esc_html_e( 'Setup With Gutunberg Block', 'feminine-shop' ); ?></button>
		</div>

		<?php
			$feminine_shop_plugin_custom_css = '';
			if(class_exists('Ibtana_Visual_Editor_Menu_Class')){
				$feminine_shop_plugin_custom_css ='display: block';
			}
		?>
		<div id="lite_theme" class="tabcontent open">
			<?php if(!class_exists('Ibtana_Visual_Editor_Menu_Class')){ 
				$plugin_ins = Feminine_Shop_Plugin_Activation_Settings::get_instance();
				$feminine_shop_actions = $plugin_ins->recommended_actions;
				?>
				<div class="feminine-shop-recommended-plugins">
				    <div class="feminine-shop-action-list">
				    	<div class="feminine-shop-activation-note">
							<?php esc_html_e('Your filesystem not have write permission, please give writable access to your filesystem','feminine-shop'); ?>
						</div>
				        <?php if ($feminine_shop_actions): foreach ($feminine_shop_actions as $key => $feminine_shop_actionValue): ?>
				                <div class="feminine-shop-action" id="<?php echo esc_attr($feminine_shop_actionValue['id']);?>">
			                        <div class="action-inner">
			                            <h3 class="action-title"><?php echo esc_html($feminine_shop_actionValue['title']); ?></h3>
			                            <div class="action-desc"><?php echo esc_html($feminine_shop_actionValue['desc']); ?></div>
			                            <?php echo wp_kses_post($feminine_shop_actionValue['link']); ?>
			                            <a class="ibtana-skip-btn" get-start-tab-id="lite-theme-tab" href="javascript:void(0);"><?php esc_html_e('Skip','feminine-shop'); ?></a>
			                        </div>
				                </div>
				            <?php endforeach;
				        endif; ?>
				    </div>
				</div>
			<?php } ?>
			<div class="lite-theme-tab" style="<?php echo esc_attr($feminine_shop_plugin_custom_css); ?>">
				<h3><?php esc_html_e( 'Lite Theme Information', 'feminine-shop' ); ?></h3>
				<hr class="h3hr">			  	
			  	<div class="col-left-inner">
			  		<h4><?php esc_html_e( 'Theme Documentation', 'feminine-shop' ); ?></h4>
					<p><?php esc_html_e( 'If you need any assistance regarding setting up and configuring the Theme, our documentation is there.', 'feminine-shop' ); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( FEMININE_SHOP_FREE_THEME_DOC ); ?>" target="_blank"> <?php esc_html_e( 'Documentation', 'feminine-shop' ); ?></a>
					</div>
					<hr>
					<h4><?php esc_html_e('Theme Customizer', 'feminine-shop'); ?></h4>
					<p> <?php esc_html_e('To begin customizing your website, start by clicking "Customize".', 'feminine-shop'); ?></p>
					<div class="info-link">
						<a target="_blank" href="<?php echo esc_url( admin_url('customize.php') ); ?>"><?php esc_html_e('Customizing', 'feminine-shop'); ?></a>
					</div>
					<hr>				
					<h4><?php esc_html_e('Having Trouble, Need Support?', 'feminine-shop'); ?></h4>
					<p> <?php esc_html_e('Our dedicated team is well prepared to help you out in case of queries and doubts regarding our theme.', 'feminine-shop'); ?></p>
					<div class="info-link">
						<a href="<?php echo esc_url( FEMININE_SHOP_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Support Forum', 'feminine-shop'); ?></a>
					</div>
					<hr>
					<h4><?php esc_html_e('Reviews & Testimonials', 'feminine-shop'); ?></h4>
					<p> <?php esc_html_e('All the features and aspects of this WordPress Theme are phenomenal. I\'d recommend this theme to all.', 'feminine-shop'); ?>  </p>
					<div class="info-link">
						<a href="<?php echo esc_url( FEMININE_SHOP_REVIEW ); ?>" target="_blank"><?php esc_html_e('Reviews', 'feminine-shop'); ?></a>
					</div>
			  	</div>
				<div class="col-right-inner">
					<h3 class="page-template"><?php esc_html_e('How to set up Home Page Template','feminine-shop'); ?></h3>
				  	<hr class="h3hr">
					<p><?php esc_html_e('Follow these instructions to setup Home page.','feminine-shop'); ?></p>
                  	<p><span class="strong"><?php esc_html_e('1. Create a new page :','feminine-shop'); ?></span><?php esc_html_e(' Go to ','feminine-shop'); ?>
					  	<b><?php esc_html_e(' Dashboard >> Pages >> Add New Page','feminine-shop'); ?></b></p>
                  	<p><?php esc_html_e('Name it as "Home" then select the template "Custom Home Page".','feminine-shop'); ?></p>
                  	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/home-page-template.png" alt="" />
                  	<p><span class="strong"><?php esc_html_e('2. Set the front page:','feminine-shop'); ?></span><?php esc_html_e(' Go to ','feminine-shop'); ?>
					  	<b><?php esc_html_e(' Settings >> Reading ','feminine-shop'); ?></b></p>
				  	<p><?php esc_html_e('Select the option of Static Page, now select the page you created to be the homepage, while another page to be your default page.','feminine-shop'); ?></p>
                  	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/set-front-page.png" alt="" />
                  	<p><?php esc_html_e(' Once you are done with setup, then follow the','feminine-shop'); ?> <a class="doc-links" href="<?php echo esc_url( FEMININE_SHOP_FREE_THEME_DOC ); ?>" target="_blank"><?php esc_html_e('Documentation','feminine-shop'); ?></a></p>
			  	</div>
			</div>
		</div>	
		<div id="block_pattern" class="tabcontent">
			<?php if(!class_exists('Ibtana_Visual_Editor_Menu_Class')){ 
			$plugin_ins = Feminine_Shop_Plugin_Activation_Settings::get_instance();
			$feminine_shop_actions = $plugin_ins->recommended_actions;
			?>
				<div class="feminine-shop-recommended-plugins">
				    <div class="feminine-shop-action-list">
				    	<div class="feminine-shop-activation-note">
							<?php esc_html_e('Your filesystem not have write permission, please give writable access to your filesystem','feminine-shop'); ?>
						</div>
				        <?php if ($feminine_shop_actions): foreach ($feminine_shop_actions as $key => $feminine_shop_actionValue): ?>
				                <div class="feminine-shop-action" id="<?php echo esc_attr($feminine_shop_actionValue['id']);?>">
			                        <div class="action-inner">
			                            <h3 class="action-title"><?php echo esc_html($feminine_shop_actionValue['title']); ?></h3>
			                            <div class="action-desc"><?php echo esc_html($feminine_shop_actionValue['desc']); ?></div>
			                            <?php echo wp_kses_post($feminine_shop_actionValue['link']); ?>
			                            <a class="ibtana-skip-btn" href="javascript:void(0);" get-start-tab-id="gutenberg-editor-tab"><?php esc_html_e('Skip','feminine-shop'); ?></a>
			                        </div>
				                </div>
				            <?php endforeach;
				        endif; ?>
				    </div>
				</div>
			<?php } ?>
			<div class="gutenberg-editor-tab" style="<?php echo esc_attr($feminine_shop_plugin_custom_css); ?>">
			  	<h3><?php esc_html_e( 'Block Patterns', 'feminine-shop' ); ?></h3>
				<hr class="h3hr">
				<p><?php esc_html_e('Follow the below instructions to setup Home page with Block Patterns.','feminine-shop'); ?></p>
              	<p><b><?php esc_html_e('Click on Below Add new page button >> Click on "+" Icon >> Click Pattern Tab >> Click on homepage sections >> Publish.','feminine-shop'); ?></span></b></p>
              	<div class="feminine-shop-pattern-page">
			    	<a href="javascript:void(0)" class="vw-pattern-page-btn button-primary button"><?php esc_html_e('Add New Page','feminine-shop'); ?></a>
			    </div>
              	<img src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/getstart/images/block-pattern.png" alt="" />				
	        </div>
		</div>
		<div id="gutenberg_editor" class="tabcontent">
			<?php if(!class_exists('Ibtana_Visual_Editor_Menu_Class')){ 
			$plugin_ins = Feminine_Shop_Plugin_Activation_Settings::get_instance();
			$feminine_shop_actions = $plugin_ins->recommended_actions;
			?>
				<div class="feminine-shop-recommended-plugins">
				    <div class="feminine-shop-action-list">
				    	<div class="feminine-shop-activation-note">
							<?php esc_html_e('Your filesystem not have write permission, please give writable access to your filesystem','feminine-shop'); ?>
						</div>
				        <?php if ($feminine_shop_actions): foreach ($feminine_shop_actions as $key => $feminine_shop_actionValue): ?>
				                <div class="feminine-shop-action" id="<?php echo esc_attr($feminine_shop_actionValue['id']);?>">
			                        <div class="action-inner plugin-activation-redirect">
			                            <h3 class="action-title"><?php echo esc_html($feminine_shop_actionValue['title']); ?></h3>
			                            <div class="action-desc"><?php echo esc_html($feminine_shop_actionValue['desc']); ?></div>
			                            <?php echo wp_kses_post($feminine_shop_actionValue['link']); ?>
			                        </div>
				                </div>
				            <?php endforeach;
				        endif; ?>
				    </div>
				</div>
			<?php }else{ ?>
				<h3><?php esc_html_e( 'Gutunberg Blocks', 'feminine-shop' ); ?></h3>
				<hr class="h3hr">
				<div class="feminine-shop-pattern-page">
			    	<a href="<?php echo esc_url( admin_url( 'admin.php?page=ibtana-visual-editor-templates' ) ); ?>" class="vw-pattern-page-btn ibtana-dashboard-page-btn button-primary button"><?php esc_html_e('Ibtana Settings','feminine-shop'); ?></a>
			    </div>
			<?php } ?>
		</div>
	</div>
</div>

<?php } ?>