<?php
/**
 * Plugin Name: Login bbPress
 * Plugin URI:  http://athanasiadis.me
 * Description: Add bbPress login, register, links on forum pages or topic pages so users can use our forums more easier.
 * Author:      Athanasiadis Evangelos
 * Author URI:  http://athanasiadis.me
 * Version:     0.2
 * Domain Path: /languages
 * Text Domain: bbpress-login
 * License: GPLv2
 */


// exit if files is called directly
if ( !defined('ABSPATH') ) {
    exit;
}

 /* Search for translations */
if (!load_plugin_textdomain('bbpress-login', false, dirname(plugin_basename(__FILE__)) . '/../../languages/')) {
  load_plugin_textdomain('bbpress-login', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

register_activation_hook(__FILE__,'bbpress_login_install');

function bbpress_login_install() {
	if(!class_exists('bbPress')) {
	  deactivate_plugins(plugin_basename(__FILE__));
				wp_die( __('Sorry, you need to activate bbPress first.', 'bbpress-login'));
	  }

}

//Styling plugin

	function bbpress_login_css() {
  wp_enqueue_style('bbpress-style',
					   plugins_url('bbpress-login.css', __FILE__));
}

add_action('wp_enqueue_scripts','bbpress_login_css');

function bbpress_Login_main() {
	if ( !is_user_logged_in() )
	{
?>
        <a href="<?php echo wp_login_url(get_permalink()); ?>" title='<?php _e('Login'); ?>' class='bblogin'><?php _e('Login'); ?></a>

        <a href="<?php echo wp_registration_url(); ?>" title='<?php _e('Register'); ?>' class='bblogin'><?php _e('Register'); ?></a>
<?php
} else {
		$logout_url = wp_logout_url( get_permalink() );
		echo "<a href='$logout_url' class='bblogout'>".__('Log Out').'</a> ';

}

}

add_action('bbp_template_after_forums_loop','bbpress_Login_main');
add_action('bbp_template_before_pagination_loop','bbpress_Login_main');
add_action('bbp_template_after_single_forum','bbpress_Login_main');
/* add_action('bbp_template_before_forums_loop','bbpress_Login_main'); */

