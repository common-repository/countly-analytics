<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
delete_option('countlytracker_init');
delete_option('countlytracker_field');
delete_option('countlytracker_switch');
delete_option('countlytracker_isadminlogged');
delete_option('countlytracker_users');
?>