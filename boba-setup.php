<?php
/**
 * Plugin Name:  BOBA Wordpress Starter
 * Plugin URI:   https://github.com/unofficialmatt/boba-wp-starter/
 * Description:  Removes clutter and unnecessary junk from Wordpress. Applies some minor security fixes. Adds white-label branding to admin areas and creates a "Client Admin" user role. For more info see the README file. Some code forked from https://github.com/chuckreynolds/Selfish-Fresh-Start.
 * Version:      1.0.0
 * Author:       Boba Studio
 * Author URI:   https://weareboba.com
 * License:      GPL-2.0+
 * License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:  boba-starter
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The core plugin class. Does all the things.
 *
 * @since       1.0.0
 * @package     Boba_Wordpress_Starter
 * @author      BOBA <matt@weareboba.com>
 */
class Boba_Wordpress_Starter {

	/**
	 * Construct for Boba_Wordpress_Starter class
	 *
	 * @return void
	 */
	public function __construct() {

    add_action( 'init', array( $this, 'boba_init' ) );
    add_action( 'after_setup_theme', array( $this, 'boba_after_theme_setup' ) );

	}

	/**
	 * Functions called at the init action
	 *
	 * @return void
	 */
	public function boba_init() {

    $this->boba_file_edit();
    $this->boba_restrict_post_revisions();
    $this->boba_trackbacks_smilies();
    $this->boba_client_role();
    $this->boba_login_white_label();
		$this->boba_admin_branding();

  }

	/**
	 * Removes theme and plugin editor links if not defined already
	 *
	 * @return void
	 */
	public function boba_file_edit() {

		if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
			define( 'DISALLOW_FILE_EDIT', 'true' );
		}

  }
  
	/**
	 * Restrict number of post revisions
	 *
	 * @return void
	 */
	public function boba_restrict_post_revisions() {
    // Restricts the amount of post revisions to 20, to reduce database bloat from trigger-happy editors
		if ( ! defined( 'WP_POST_REVISIONS' ) ) {
			define( 'WP_POST_REVISIONS', 20 );
		}

	}  

	/**
	 * Sets db options table flags
	 *
	 * @return string Closed: Disallow pingbacks and trackbacks from other blogs
	 * @return int    No: Attempt to notify any blogs linked to from the article
	 * @return int    No: Convert emoticons like :-) and :P to graphics when displayed
	 */
	public function boba_trackbacks_smilies() {

		$options = array(
			'default_ping_status'   => 'closed',
			'default_pingback_flag'	=> 0,
			'use_smilies'           => 0
		);

		foreach( $options as $key => $value ) {

			$current = get_option( $key );

			if ( $current != $value ) {
				update_option( $key, $value );
			}

		}

  }
  
  /**
   * Creates a client user role 'client-admin' with restricted admin capabilities. Use a plugin such as "User Role Editor" to manage capabilities further
   *
   * @return void
   */
  public function boba_client_role() {
    global $wp_roles;
    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();
        
    $wp_roles->add_role( 
        'client-admin', 
        'Client', 
        array(
					'assign_product_terms' => true,
					'assign_shop_coupon_terms' => true,
					'assign_shop_order_terms' => true,
					'create_posts' => true,
					'create_users' => true,
					'delete_others_pages' => true,
					'delete_others_posts' => true,
					'delete_others_products' => true,
					'delete_others_shop_coupons' => true,
					'delete_others_shop_orders' => true,
					'delete_pages' => true,
					'delete_posts' => true,
					'delete_private_pages' => true,
					'delete_private_posts' => true,
					'delete_private_products' => true,
					'delete_private_shop_coupons' => true,
					'delete_private_shop_orders' => true,
					'delete_product' => true,
					'delete_product_terms' => true,
					'delete_products' => true,
					'delete_published_pages' => true,
					'delete_published_posts' => true,
					'delete_published_products' => true,
					'delete_published_shop_coupons' => true,
					'delete_published_shop_orders' => true,
					'delete_shop_coupon' => true,
					'delete_shop_coupon_terms' => true,
					'delete_shop_coupons' => true,
					'delete_shop_order' => true,
					'delete_shop_order_terms' => true,
					'delete_shop_orders' => true,
					'delete_users' => true,
					'edit_dashboard' => true,
					'edit_others_pages' => true,
					'edit_others_posts' => true,
					'edit_others_products' => true,
					'edit_others_shop_coupons' => true,
					'edit_others_shop_orders' => true,
					'edit_pages' => true,
					'edit_posts' => true,
					'edit_private_pages' => true,
					'edit_private_posts' => true,
					'edit_private_products' => true,
					'edit_private_shop_coupons' => true,
					'edit_private_shop_orders' => true,
					'edit_product' => true,
					'edit_product_terms' => true,
					'edit_products' => true,
					'edit_published_pages' => true,
					'edit_published_posts' => true,
					'edit_published_products' => true,
					'edit_published_shop_coupons' => true,
					'edit_published_shop_orders' => true,
					'edit_shop_coupon' => true,
					'edit_shop_coupon_terms' => true,
					'edit_shop_coupons' => true,
					'edit_shop_order' => true,
					'edit_shop_order_terms' => true,
					'edit_shop_orders' => true,
					'edit_theme_options' => true,
					'edit_users' => true,
					'list_users' => true,
					'manage_categories' => true,
					'manage_links' => true,
					'manage_options' => true,
					'manage_product_terms' => true,
					'manage_shop_coupon_terms' => true,
					'manage_shop_order_terms' => true,
					'manage_woocommerce' => true,
					'moderate_comments' => true,
					'promote_users' => true,
					'publish_pages' => true,
					'publish_posts' => true,
					'publish_products' => true,
					'publish_shop_coupons' => true,
					'publish_shop_orders' => true,
					'read' => true,
					'read_private_pages' => true,
					'read_private_posts' => true,
					'read_private_products' => true,
					'read_private_shop_coupons' => true,
					'read_private_shop_orders' => true,
					'read_product' => true,
					'read_shop_coupon' => true,
					'read_shop_order' => true,
					'remove_users' => true,
					'unfiltered_html' => false,
					'update_core' => true,
					'update_plugins' => true,
					'update_themes' => true,
					'upload_files' => true,
					'view_woocommerce_reports' => true,
					'wf2fa_activate_2fa_self' => true,
        )
    );
  }

  /**
   * Applies White Label branding and enhancements to the login screen
   *
   * @return void
   */
  public function boba_login_white_label() {
    /* WHITE LABEL ADMIN DASHBOARD: Change Admin Logo and background image */
    function boba_login_logo() {
				echo '<style type="text/css">
				h1 a { background-image:url("'.esc_url( plugins_url( '/img/boba-logo-centered.svg', __FILE__ ) ).'") !important; background-size: 280px 143px !important;height: 143px !important; width: 280px !important; margin-bottom: 40px !important; padding-bottom: 0 !important; }
				.login form { margin-top: 0 !important; }
				</style>';
    }
    add_action( 'login_head', 'boba_login_logo' );

    /* SELECTS THE 'REMEMBER ME' OPTION BY DEFAULT */
    function boba_check_rememberme() {
      echo "<script>document.getElementById('rememberme').checked = true;</script>";
    } 
    add_filter( 'login_footer', 'boba_check_rememberme' );

    /* WHITE LABEL ADMIN DASHBOARD: Replace Link URL */
    function boba_login_url(){
      return 'https://www.weareboba.com';
    }
    add_filter( 'login_headerurl', 'boba_login_url' );
  
    /* WHITE LABEL ADMIN DASHBOARD: Change login logo hover text */
    function boba_login_logo_title() {
      return 'Website designed and developed by Boba Studio';
    }
    add_filter( 'login_headertext', 'boba_login_logo_title' );

    /* IF A USER LOGIN FAILS DON'T TELL THEM WHAT ITEM WAS INCORRECT (USERNAME/PASSWORD) */
    function boba_failed_login () {
      return 'Login failed because either your username or password was incorrect. Please try again.';
    }
    add_filter ( 'login_errors', 'boba_failed_login' );
  }

  /**
	 * Applies White Label branding and enhancements to the admin area
	 *
	 * @return void
	 */
	public function boba_admin_branding() {
    /* WHITE LABEL ADMIN DASHBOARD: Change Footer Thankyou Text */
    function boba_modify_admin_footer () {
			echo '<span id="footer-thankyou"><img style="width: 16px;position: relative;top: 5px;margin-right: 8px;" src="'.esc_url( plugins_url( '/img/boba-icon.svg', __FILE__ ) ).'"> Website designed and developed by <a href="https://www.weareboba.com" target="_blank">Boba Studio</a> | <a href="mailto:hello@weareboba.com">hello@weareboba.com</a></span>';
    }
    add_filter( 'admin_footer_text', 'boba_modify_admin_footer' );
  
    /* WHITE LABEL ADMIN DASHBOARD: Replace logo in admin bar */
    function boba_admin_bar_logo() {
			global $wp_admin_bar;
			echo '
			<style type="text/css">
				#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
				background-image:url('.esc_url( plugins_url( '/img/boba-icon.svg', __FILE__ ) ).') !important;
				background-position: center;
				background-repeat: no-repeat;
				color:rgba(0, 0, 0, 0);
				}
				#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
				background-position: 0 0;
				}
			</style>
			';
    }
    add_action('wp_before_admin_bar_render', 'boba_admin_bar_logo');

    /* WHITE LABEL ADMIN DASHBOARD: Add contact info box onto Dashboard */
    function boba_support_widget() {
      wp_add_dashboard_widget('wp_dashboard_widget', 'Support Information', 'boba_support_info');
    }
    function boba_support_info() {
			echo "
			<table>
			<tbody>
			<tr valign='bottom'>
			<td colspan='3'>
			<h1>Website support</h1>
			<p><strong>Boba Studio</strong> is a boutique design, branding and digital agency based in Hampshire, UK.</p><p>A dynamic duo with a mutual passion for creating highly-effective visual communication.
			</p><p>Combined, we have spent over 20 years working within the creative industry, and have a wealth of experience both together and individually across a vast array of digital and print media.</p></td>
			</tr>
			<tr><td>
			<p>For website support, maintenance or any other design requirement, contact <strong>Matt Weet</strong> at:</p><p>Email: <a href='mailto:hello@weareboba.com'>hello@weareboba.com</a><br>Call: <a href='tel:07707264566'>07707 264566</a></p>
			</td>
			<td style='width:15px;'>&nbsp;</td>
			<td><a href='https://www.weareboba.com'><img src='".esc_url( plugins_url( '/img/boba-studio-animated.gif', __FILE__ ) )."' class='alignright' style='height:120px;width:80px;' alt='Boba Studio: Branding, Creative, Design and Digital. Based in Hampshire, UK.'></a></td>
			</tr>
			</tbody>
			</table>
			";
    }
    add_action('wp_dashboard_setup', 'boba_support_widget' );

	}

	/**
	 * Functions called after the after_setup_theme action
	 *
	 * @return void
	 */
	public function boba_after_theme_setup() {

    /* Remove Emoji Junk from wp_head */
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );

    /* Remove Wordpress version from wp_head */
    remove_action( 'wp_head', 'wp_generator' );
    
    /* Remove XML-RPC Really Simple Discovery from wp_head */
    remove_action( 'wp_head', 'rsd_link' );
    
    /* Remove Windows Live Writer link from wp_head */
    remove_action( 'wp_head', 'wlwmanifest_link' );

    /* Remove Useless Post Relational links from wp_head */
    remove_action( 'wp_head', 'index_rel_link' ); // remove link to index page
    remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // remove random post link
    remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // remove parent post link
    remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // remove the next and previous post links
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );

    /* Remove Wordpress Welcome Panel */
		remove_action( 'welcome_panel', 'wp_welcome_panel' );

    /* Remove feed links from wp_head */
    remove_action( 'wp_head', 'feed_links', 2 );
    remove_action( 'wp_head', 'feed_links_extra', 3 );

    /* Metaboxes */
		add_action( 'wp_dashboard_setup',    array( $this, 'boba_dashboard_metaboxes' ) ); // Remove Wordpress widgets
		add_action( 'do_meta_boxes',         array( $this, 'boba_plugin_metaboxes' ) ); // Remove annoying plugin specific widgets
		add_action( 'admin_menu',            array( $this, 'boba_post_metaboxes' ) );
		add_action( 'admin_menu',            array( $this, 'boba_page_metaboxes' ) );

		/* Restricted Admin Menus */
		add_action( 'admin_menu', 					 array( $this, 'boba_remove_admin_pages'), 99 ); // Removes oft-used admin pages from the menu
		add_action( 'admin_init', 					 array( $this, 'boba_admin_redirect') ); // Redirects any access to restricted pages

    /* Prevents Non-Admins being nagged to update */
    add_action( 'admin_head',            array( $this, 'boba_update_notification_non_admins' ), 1 );

    /* Disables Self-Trackbacks */
    add_action( 'pre_ping',              array( $this, 'boba_self_pings' ) );

    /* Removes Hellodolly if it exists */
    add_action( 'admin_init',            array( $this, 'boba_hello_dolly' ) );
    
    /* Modifies #more link to not use hashtag anchor */
    add_filter( 'the_content_more_link', array( $this, 'boba_more_jump_link_anchor' ) );
    
    /* Fixes curly quotes and badly formatted characters */
		add_filter( 'content_save_pre',      array( $this, 'boba_curly_other_chars' ) );
		add_filter( 'title_save_pre',        array( $this, 'boba_curly_other_chars' ) );

    // Remove the REST API lines from the HTML Header
    remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );

    // Remove the REST API endpoint.
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );    
	}


	/**
	 * Removes some dashboard widgets
	 *
	 * @return void
	 */
	public function boba_dashboard_metaboxes() {

		#remove_meta_box( 'dashboard_right_now',      'dashboard', 'normal' );  // At a Glance
		#remove_meta_box( 'network_dashboard_right_now', 'dashboard', 'normal' ); // Network Right Now
		remove_meta_box( 'dashboard_activity',       'dashboard', 'normal' );  // Activity
		remove_meta_box( 'dashboard_quick_press',    'dashboard', 'side' );   // Quick Draft / Your Recent Drafts
		remove_meta_box( 'dashboard_primary',        'dashboard', 'side' );   // WordPress Events and News

	}

	/**
	 * Removes oft-used admin pages from the menu
	 *
	 * @return void
	 */
	public function boba_remove_admin_pages() {
		global $current_user;
    get_currentuserinfo();

    // If Administrator remove some unnecessary submenus
    if (current_user_can( 'administrator' ) ) {	
			remove_submenu_page( 'tools.php', 'export.php'  ); // Export 
			remove_submenu_page( 'tools.php', 'import.php'  ); // Import
			remove_submenu_page( 'tools.php', 'tools.php'  ); // Available Tools
			// Note: Pages still available at direct URLs
		}
		else {
			// Otherwise remove all of these...
			remove_menu_page('tools.php');
			remove_menu_page('options-general.php');
			remove_menu_page('edit.php?post_type=acf-field-group'); // ACF
		}
	}

	public function boba_admin_redirect() {
		global $pagenow;
		// Todo: $pagenow just returns the root and not any queries - so edit.php?post_type=acf-field-group does not work. Better to check against actual URL? Sub pages eg. options-media.php are also not captured below...
		$restricted_urls = array(
			'tools.php',
			'options-general.php',
			'edit.php?post_type=acf-field-group'
		);

		if(in_array($pagenow,$restricted_urls) && !current_user_can( 'administrator' ) ) {	
			// User not authorized to access page, redirect to dashboard
      wp_redirect( admin_url( 'index.php' ) ); 
		}

	}	

	/**
	 * Removes some plugin dashboard widgets.
	 * Yup I'm goin there. Sorry not sorry.
	 *
	 * @return void
	 */
	public function boba_plugin_metaboxes() {

		remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'normal' ); // yoast seo overview
		remove_meta_box( 'aw_dashboard',             'dashboard', 'normal' ); // wp socializer box
		remove_meta_box( 'w3tc_latest',              'dashboard', 'normal' ); // w3 total cache news box
		remove_meta_box( 'rg_forms_dashboard',       'dashboard', 'normal' ); // gravity forms
		remove_meta_box( 'bbp-dashboard-right-now',  'dashboard', 'normal' ); // bbpress right now in forums
		remove_meta_box( 'jetpack_summary_widget',   'dashboard', 'normal' ); // jetpack
		remove_meta_box( 'tribe_dashboard_widget',   'dashboard', 'normal' ); // modern tribe rss widget

	}

	/**
	 * Removes some meta boxes from default posts screen
	 *
	 * @return void
	 */
	public function boba_post_metaboxes() {

		remove_meta_box( 'trackbacksdiv',      'post', 'normal' ); // trackbacks metabox
		#remove_meta_box( 'postcustom',       'post', 'normal' ); // custom fields metabox
		#remove_meta_box( 'postexcerpt',      'post', 'normal' ); // excerpt metabox
		#remove_meta_box( 'commentstatusdiv', 'post', 'normal' ); // comments metabox
		#remove_meta_box( 'slugdiv',          'post', 'normal' ); // slug metabox (breaks edit permalink update)
		#remove_meta_box( 'authordiv',        'post', 'normal' ); // author metabox
		#remove_meta_box( 'revisionsdiv',     'post', 'normal' ); // revisions metabox
		#remove_meta_box( 'tagsdiv-post_tag', 'post', 'normal' ); // tags metabox
		#remove_meta_box( 'categorydiv',      'post', 'normal' ); // comments metabox

	}

	/**
	 * Removes some meta boxes from default pages screen
	 *
	 * @return void
	 */
	public function boba_page_metaboxes() {

		remove_meta_box( 'commentstatusdiv', 'page', 'normal' ); // discussion metabox
		remove_meta_box( 'commentsdiv',      'page', 'normal' ); // comments metabox
		#remove_meta_box( 'postcustom',     'page', 'normal' ); // custom fields metabox
		#remove_meta_box( 'slugdiv',        'page', 'normal' ); // slug metabox (breaks edit permalink update)
		#remove_meta_box( 'authordiv',      'page', 'normal' ); // author metabox
		#remove_meta_box( 'revisionsdiv',   'page', 'normal' ); // revisions metabox
		#remove_meta_box( 'postimagediv',   'page', 'side' );   // featured image metabox

	}

	/**
	 * Removes update notifications for everybody except admin users
	 *
	 * @return void
	 */
	public function boba_update_notification_non_admins() {

		if ( ! current_user_can( 'update_core' ) ) {
			remove_action( 'admin_notices', 'update_nag', 3 );
		}

	}

	/**
	 * Disables potential to self-trackback
	 *
	 * @return void
	 */
	public function boba_self_pings(&$links) {

		foreach ( $links as $l => $link ) {
			if ( 0 === strpos( $link, get_option( 'home' ) ) ) {
				unset( $links[$l] );
			}
		}

	}

	/**
	 * Removes hellodolly plugin if it exists. sorry @photomatt
	 *
	 * @return void
	 */
	public function boba_hello_dolly() {

		if ( file_exists( WP_PLUGIN_DIR . '/hello.php' ) ) {
			delete_plugins( array( 'hello.php' ) );
		}

	}

	/**
	 * Modifies #more link to not use hashtag anchor
	 *
	 * @return void
	 */
	public function boba_more_jump_link_anchor( $link ) {

		$offset = strpos( $link, '#more-' );

		if ( $offset ) {
			$end = strpos( $link, '"', $offset );
		}

		if ( $end ) {
			$link = substr_replace( $link, '', $offset, $end-$offset );
		}

		return $link;

	}

	/**
	 * Fixes curly quotes and badly formatted characters. One of my bigger pet peeves is curly quotes from word pastes
	 *
	 * @return string clean formated characters
	 */
	public function boba_curly_other_chars( $fixChars ) {

		$fixChars = str_replace(
			array("\xe2\x80\x98", "\xe2\x80\x99", "\xe2\x80\x9c", "\xe2\x80\x9d", "\xe2\x80\x93", "\xe2\x80\x94", "\xe2\x80\xa6"),
			array("'", "'", '"', '"', '-', '&mdash;', '&hellip;' ), $fixChars);

		$fixChars = str_replace(
			array(chr(145), chr(146), chr(147), chr(148), chr(150), chr(151), chr(133)),
			array("'", "'", '"', '"', '-', '&mdash;', '&hellip;' ), $fixChars);

		$fixChars = str_replace(
			array( 'â„¢', 'Â©', 'Â®' ),
			array( '&trade;', '&copy;', '&reg;' ), $fixChars);

		return $fixChars;

  }

}

/**
 * Begins execution of the plugin
 *
 * @since       1.1.0
 */
function run_Boba_Wordpress_Starter() {

	$plugin = new Boba_Wordpress_Starter();

}
run_Boba_Wordpress_Starter();
