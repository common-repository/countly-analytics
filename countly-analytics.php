<?php
/*
 * Plugin Name: Analytics for Wordpress - by Countly
 * Description: This plugin helps you integrate Countly SDK easily in your Wordpress installation so you don't have to add the Countly Javascript snippet in your theme files. It also helps enable different <a href="http://count.ly/web-analytics">Countly web analytics</a> features. In order to use this plugin, you need at least: 1) Wordpress 4.0 or higher 2) PHP 5.4 or higher 3) Countly Community or Enterprise Edition 16.06 or higher (download <a href="http://count.ly/community-edition">Community Edition here</a>). For more information about Countly's features and comparison between Countly editions, see <a href="http://count.ly/compare">Countly comparison</a> and <a href="https://count.ly/enterprise-edition-features">Countly Enterprise Edition features</a>
* Author: Countly
* Version: 1.0.0
*/
/* If this file was called directly, abort. */
if (!defined('WPINC')) {
  die;
}
defined('ABSPATH') or die('No script kiddies please!');
/* = load scripts at frontend if plugin enable and configured
  ------------------------------------------------------------------- */
if (!function_exists('countlytracker_front_script')) {
  function countlytracker_front_script() {
    $trackerFileds = get_option('countlytracker_field');
    $initializeOptions = get_option('countlytracker_init');
    $countlyProfile = get_option('countlytracker_users');
    wp_enqueue_script('countly-min', 'https://cdnjs.cloudflare.com/ajax/libs/countly-sdk-web/16.12.1/countly.min.js');
    wp_register_script('countlytracker-general', plugins_url('countly-analytics/js/general.js'));
    $data = array('countlyString' => $initializeOptions, 'tracker' => $trackerFileds, 'countlyProfile' => $countlyProfile);
    wp_localize_script('countlytracker-general', 'data', $data);
    wp_enqueue_script('countlytracker-general');
  }
}
//check if user is eligible for countly tracking
if (!function_exists('countlytracker_login_check')) {
  function countlytracker_login_check() {
    $pluginList = get_option('active_plugins');
    $plugin = 'countly-analytics/countly-analytics.php';
    $pluginstatus = get_option('countlytracker_switch');
    if (!is_user_logged_in()) {
      if ((in_array($plugin, $pluginList)) && $pluginstatus == "1") {
        add_action('wp_footer', 'countlytracker_front_script');
      }
    } else {
      $adminloggedStatus = get_option('countlytracker_isadminlogged');
      if ((in_array($plugin, $pluginList)) && $pluginstatus == "1" && $adminloggedStatus == "0") {
        add_action('wp_footer', 'countlytracker_front_script');
      }
    }
  }
}
add_action('template_redirect', 'countlytracker_login_check');
add_action('profile_update', 'countlytracker_update_profile_information', 10, 2);

//update user data on profile edit
function countlytracker_update_profile_information($user_id, $old_user_data) {
  if (current_user_can('edit_user', $user_id)) {
    countlytracker_update_user();
  }
}

//update user
function countlytracker_update_user() {
  global $current_user;
  $countlyUser = [];
  if ((isset($current_user->user_firstname) && !empty($current_user->user_firstname)) ||
      (isset($current_user->user_lastname) && !empty($current_user->user_lastname))) {
    $countlyUser['name'] = $current_user->user_firstname . ' ' . $current_user->user_lastname;
  }
  if (isset($current_user->user_login) && !empty($current_user->user_login)) {
    $countlyUser['username'] = $current_user->user_login;
  }
  if (isset($current_user->user_email) && !empty($current_user->user_email)) {
    $countlyUser['email'] = $current_user->user_email;
  }
  update_option('countlytracker_users', $countlyUser);
}

/* = Setup initial countly analytics options in database
  ---------------------------------------------------- */
if (!function_exists('countlytracker_setup_fields')):
  function countlytracker_setup_fields() {
    $customArr = array(
        'countlytracker_init' =>
        array(
            'fail_timeout' => "",
            'interval' => "",
            'ignore_bots' => intval(0),
            'debug' => intval(0),
            'app_key' => "",
            'app_version' => "",
            'url' => ""
        ),
        'countlytracker_field' =>
        array(
            'countlytracker_sessions' => intval(1),
            'countlytracker_pageviews' => intval(1),
            'countlytracker_clicks' => intval(1),
            'countlytracker_links' => intval(1),
            'countlytracker_form_data' => intval(1),
            'countlytracker_conversions' => intval(1),
            'countlytracker_errors' => intval(1)
        ),
        'countlytracker_switch' => intval(1),
        'countlytracker_isadminlogged' => intval(1)
    );
    //save options
    foreach ($customArr as $key => $value) {
      update_option($key, $value);
    }
    countlytracker_update_user();
  }
endif;
register_activation_hook(__FILE__, 'countlytracker_setup_fields');
/* = Include scripts and styles in admin panel
  ---------------------------------------------------- */
add_action('admin_enqueue_scripts', 'countlytracker_load_scripts');
if (!function_exists('countlytracker_load_scripts')) {
  function countlytracker_load_scripts($hook) {
    if (is_admin() && 'settings_page_countlytracker_options' == $hook) {
      wp_enqueue_style('jquery-ui', plugins_url('countly-analytics/css/jquery-ui.css'));
      wp_enqueue_style('countlytracker-style', plugins_url('countly-analytics/css/tracker_style.css'));
      wp_enqueue_script('jquery');
      wp_enqueue_script('jquery-ui-tooltip');
      wp_enqueue_media();
      wp_enqueue_script('countlytracker-tooltip', plugins_url('countly-analytics/js/tooltip-init.js'));
    }
  }
}
/* = Add countly cnalytics menu page under settings menu
  ---------------------------------------------------- */
add_action('admin_menu', 'countlytracker_setupAnalyticsPage');
if (!function_exists('countlytracker_setupAnalyticsPage')):
  function countlytracker_setupAnalyticsPage() {
    add_options_page('Tracker setting', 'Countly Analytics', 'manage_options', 'countlytracker_options', 'countlytracker_options_list');
    require_once( plugin_dir_path(__FILE__) . 'tracker_setting.php');
  }
endif;
?>
